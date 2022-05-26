<?php namespace App\Http\Controllers\Admin\Shops;


use App\Modules\Integrations\Tezsum\Services\BalanceConverter;
use App\Modules\Integrations\Tezsum\Services\MerchantTezsum;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Repositories\OrderRepository;
use App\Modules\Payments\Models\WithdrawTransaction;
use App\Modules\Payments\UseCases\InvoiceCreate;
use App\Modules\Payments\UseCases\PaymentCreate;
use App\Modules\Payments\UseCases\TransactionCreate;
use App\Modules\Products\Models\Product;
use App\Modules\Shops\Requests\ShopUpdateRequest;
use App\Modules\Users\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Modules\Shops\Models\Shop;
use App\Modules\Common\Models\City;
use App\Http\Controllers\Controller;
use App\Modules\Shops\Models\ShopMedia;
use App\Modules\Shops\UseCases\ShopCrud;
use App\Modules\Shops\Models\ShopCategory;
use App\Modules\Shops\Requests\ShopCreateRequest;
use Illuminate\Validation\Rule;


class ShopController extends Controller
{

    private ShopCrud $shopCrud;
    private OrderRepository $orderRepository;

    public function __construct(ShopCrud $shopCrud, OrderRepository $orderRepository)
    {
        $this->shopCrud = $shopCrud;
        $this->orderRepository = $orderRepository;
        $this->middleware(['perm:view_shops'])->only(['index']);
        $this->middleware(['perm:add_shops'])->only(['store', 'create']);
        $this->middleware(['perm:edit_shops'])->only(['update', 'edit', 'addTezsumSiteId']);
        $this->middleware(['perm:view_my_shops'])->only(['myShop']);
        $this->middleware(['perm:remove_files_shops'])->only(['deleteFiles']);
        $this->middleware(['perm:upload_files_shops'])->only(['uploadFiles']);
        $this->middleware(['perm:change_status_shops'])->only(['blockHideActive']);
    }

    public function index(Request $request)
    {
        $query = Shop::with(['shopCategory'])->withCount(['products', 'orders', 'productsWithSale', 'clientShopsSubscriptions', 'shopCategory']);

        if ($request->search_text) {
            $query = $query->where('name', 'like', "%$request->search_text%");
        }

        if ($request->shop_status_id){
            $query = $query->where('status', $request->shop_status_id);
        }

        $getFilters['shopStatuses'] = Shop::STATUSES_ARRAY;

        return view('shop.index', ['shops' => $query->paginate()->withQueryString(),  'filters' => $getFilters]);
    }

    public function create()
    {
        $shopCategories = ShopCategory::get()->pluck('name', 'id')->toArray();
        $cities = City::get()->pluck('name', 'id')->toArray();

        return view('shop.create', [
            'shopCategories' => $shopCategories,
            'cities' => $cities
        ]);
    }

    public function store(ShopCreateRequest $request)
    {
        $shopArray = $request->except('full_name', 'email', 'password');
        $userArray = $request->only('full_name', 'email', 'password');
        $logo = $request->file('logo') ?? $request->file('logo');

        $shop = $this->shopCrud->create($shopArray, $userArray, $logo);
        flash()->success('Магазин созданно.');

        return redirect("/shops/{$shop->id}");
    }

    public function edit($shop)
    {
        $shop = Shop::with(['user'])->find($shop);
        $shopCategories = ShopCategory::get()->pluck('name', 'id')->toArray();
        $cities = City::get()->pluck('name', 'id')->toArray();

        return view('shop.edit', [
            'shopCategories' => $shopCategories,
            'shop' => $shop,
            'cities' => $cities
        ]);
    }

    public function addTezsumSiteId(Shop $shop)
    {
        /** Create Tezsum account for Merchant */
        $tezsum = new MerchantTezsum();
        $merchant = $tezsum->createMerchant([
            'name' => $shop->name,
            'phone_number' => $shop->phone_number
        ]);
        $shop->update(['tezsum_site_id' => $merchant['json']['site_id']]);

        flash()->success('Успешно обновлен тезсум мерчант id.');
        return redirect("/shops/{$shop->id}");

    }

    public function update(ShopUpdateRequest $request, Shop $shop)
    {
        $logo = $request->file('logo') ?? $request->file('logo');

        $this->shopCrud->edit($shop, $logo);
        flash()->success('Магазин обновлен.');

        return redirect("/shops/{$shop->id}");
    }

    public function show(Shop $shop, Request $request)
    {
        $tezsumBalance = 0;
        $orders = Order::with(['orderProduct', 'orderProduct.product', 'orderStatus', 'city', 'client'])
            ->where('shop_id', $shop->id);

        if ($request->id) {
            $orders->where('id', $request->id);
        }

        if ($request->order_status_id) {
            $orders->where('order_status_id', $request->order_status_id);
        }

        if ($request->city_id) {
            $orders->where('city_id', $request->city_id);
        }

        if ($request->client_fullname) {
            $orders->whereHas('client', function ($query) use ($request){
                $query->where('name', 'like', "%{$request->client_fullname}%");
            });
        }

        if ($request->phone_number_delivery) {
            $orders->where('phone_number_delivery', $request->phone_number_delivery);
        }

        if ($request->delivery_date) {
            $deliveryDate = Carbon::parse($request->delivery_date);
            $orders->whereDate('delivery_date', $deliveryDate);
        }

        $getFilters = $this->orderRepository->getOrderFilters();
        $productsCount = Product::where('shop_id', $shop->id)->count();
        $merchantBalance = (new MerchantTezsum())->getBalance($shop->tezsum_site_id);
        if(isset($merchantBalance['json']['balance'])){
           $tezsumBalance = BalanceConverter::convertMerchantBalance($merchantBalance['json']['balance']);
        }
        $getFilters['shopStatuses'] = Shop::STATUSES_ARRAY;
        return view('shop.show', [
            'filters' => $getFilters,
            'orders' => $orders->paginate(12)->withQueryString(),
            'productCount' => $productsCount,
            'tezsumBalance' => $tezsumBalance,
            'shop' => $shop
        ]);
    }

    public function destroy(Shop $shop)
    {
        $shop->delete();
        flash()->success("Магазин удален!");
        return redirect()->route('shops.index');
    }

    public function uploadFiles(Request $request)
    {
        $request->validate([
            'shop_id' => 'required',
            'shop_files.*' => 'required|mimes:jpg,jpeg,png,bmp|max:10000'
        ]);
        $this->shopCrud->uploadFiles($request->file('shop_files'), $request->shop_id);

        flash()->success("Новые файлы были добавлены успешно!");

        return redirect("/shops/{$request->shop_id}");
    }

    public function deleteFile(ShopMedia $shopMedia)
    {
        $this->shopCrud->deleteFile($shopMedia);

        flash()->success("Файл успешно удален!");

        return redirect("/shops/{$shopMedia->shop_id}");
    }

    public function myShop(Request $request)
    {
        $shop = Shop::find(auth()->user()->shop_id);

        if (! $shop){
            flash()->error('Что то пошло не так, скорее всего у вас нету магазина :(');
            auth()->logout();
            return redirect('/login');
        }

        $orders = Order::with(['orderProduct', 'orderProduct.product', 'orderStatus', 'city', 'client']);
        $orders->whereHas('orderProduct.product', function ($query){
            $query->where('shop_id', auth()->user()->shop_id);
        });

        if ($request->id) {
            $orders->where('id', $request->id);
        }

        if ($request->order_status_id) {
            $orders->where('order_status_id', $request->order_status_id);
        }

        if ($request->city_id) {
            $orders->where('city_id', $request->city_id);
        }

        if ($request->client_fullname) {
            $orders->whereHas('client', function ($query) use ($request){
                $query->where('name', 'like', "%{$request->client_fullname}%");
            });
        }

        if ($request->delivery_date) {
            $deliveryDate = Carbon::parse($request->delivery_date);
            $orders->whereDate('delivery_date', $deliveryDate);
        }

        $getFilters = $this->orderRepository->getOrderFilters();
        $productsCount = Product::where('shop_id', auth()->user()->shop_id)->count();

        $merchantBalance = (new MerchantTezsum())->getBalance($shop->tezsum_site_id);
        $getFilters['shopStatuses'] = Shop::STATUSES_ARRAY;
        $tezsumBalance = 0;
        if(isset($merchantBalance['json']['balance'])){
            $tezsumBalance = BalanceConverter::convertMerchantBalance($merchantBalance['json']['balance']);
        }
        $getFilters['shopStatuses'] = Shop::STATUSES_ARRAY;
        return view('shop.my_shop', [
            'filters' => $getFilters,
            'orders' => $orders->paginate(12)->withQueryString(),
            'productCount' => $productsCount,
            'tezsumBalance' => $tezsumBalance,
            'shop' => $shop
        ]);
    }

    public function transferToCard(Request $request)
    {
        $request->validate([
            'credit_card' => 'required|numeric|digits:16',
            'amount' => 'required|integer'
        ]);

        $shop = Shop::findOrFail(auth()->user()->shop_id);

        $invoice = new InvoiceCreate();
        $createInvoice = $invoice->createWithDrawnInvoice($shop, $request->amount, $request->credit_card);

        $trans = new TransactionCreate();
        $createTrans = $trans->createWithDrawnTransaction($shop, $createInvoice['json']['invoice_id']);

        $payment = new PaymentCreate();
        $paymentStatus = $payment->createWithDrawPayment($shop, $createTrans['json']['trans_id']);

        if($paymentStatus){
            flash()->success('Операция прошла успешно.');
            return redirect("/shops/transfers");
        }

        flash()->error('Что то пошло не так :(');
        return redirect("/shops/transfers");

    }

    public function transferToBankAccount(Request $request)
    {
        $request->validate([
            'amount_bank_account' => 'required|integer'
        ]);

        $shop = Shop::findOrFail(auth()->user()->shop_id);

        $invoice = new InvoiceCreate();
        $createInvoice = $invoice->createWithDrawnBankAccountInvoice($shop, $request->amount_bank_account);

        $trans = new TransactionCreate();
        $createTrans = $trans->createWithDrawnTransaction($shop, $createInvoice['json']['invoice_id']);

        $payment = new PaymentCreate();
        $paymentStatus = $payment->createWithDrawPayment($shop, $createTrans['json']['trans_id']);

        if($paymentStatus){
            flash()->success('Операция прошла успешно.');
            return redirect("/shops/transfers");
        }

        flash()->error('Что то пошло не так :(');
        return redirect("/shops/transfers");

    }

    public function getShopTransfers()
    {
        $shop = Shop::findOrFail(auth()->user()->shop_id);
        $transactions = WithdrawTransaction::where('shop_id', auth()->user()->shop_id)
            ->orderBy('id', 'DESC')->paginate();

        $merchantBalance = (new MerchantTezsum())->getBalance($shop->tezsum_site_id);
        if(isset($merchantBalance['json']['balance'])){
            $tezsumBalance = BalanceConverter::convertMerchantBalance($merchantBalance['json']['balance']);
        }

        return view('shop.transfer', [
            'transactions' => $transactions,
            'shop' => $shop
        ]);

    }

    public function blockHideActive(Request $request, Shop $shop)
    {
        $request->validate([
            'status' => [
                'required',
                Rule::in(array_keys(Shop::STATUSES_ARRAY)),
                "not_in:{$shop->status}"
            ]
        ]);

        switch ($request->status){
            case Shop::STATUS_ACTIVE:
                $flashText = 'Статус магазина Активный';
                $shopStatus = Shop::STATUS_ACTIVE;
                $productStatus = Product::STATUS_ACTIVE;
                $userStatus = User::STATUS_ACTIVE;
                break;
            case Shop::STATUS_INVISIBLE:
                $flashText = 'Статус магазина Скрыть';
                $shopStatus = Shop::STATUS_INVISIBLE;
                $productStatus = Product::STATUS_INVISIBLE;
                $userStatus = User::STATUS_INVISIBLE;
                break;
            case Shop::STATUS_INACTIVE:
                $flashText = 'Статус магазина Заблочен';
                $shopStatus = Shop::STATUS_INACTIVE;
                $productStatus = Product::STATUS_INACTIVE;
                $userStatus = User::STATUS_INACTIVE;
                break;
        }

        $block = \DB::transaction(function () use ($shop, $shopStatus, $productStatus, $userStatus) {
            $shop->status = $shopStatus;
            $shop->save();
            Product::where('shop_id', $shop->id)->update([
                'status' => $productStatus
            ]);
            User::where('shop_id', $shop->id)->update(['status' => $userStatus]);
            return true;
        });

        if ($block){
            flash()->success($flashText);
            return redirect("/shops/{$shop->id}");
        }

        flash()->error('что-то пошло не так(');
        return redirect("/shops/{$shop->id}");
    }

    public function audit(Shop $shop)
    {
        $audits = $shop->audits()->with(['user'])->paginate();
        return view('shop.audit', ['audits' => $audits]);
    }

}
