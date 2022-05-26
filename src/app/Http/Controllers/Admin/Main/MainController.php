<?php


namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Controller;
use App\Mail\ComplaintMail;
use App\Modules\Auth\Models\Client;
use App\Modules\Common\Models\Complaint;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderProduct;
use App\Modules\Orders\Repositories\OrderRepository;
use App\Modules\Orders\Services\OrderStatusService;
use App\Modules\Products\Models\Product;
use App\Modules\Shops\Models\Shop;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{

    private $orderRepository;

    /**
     * Create a new controller instance.
     *
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->middleware('auth');
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request)
    {
        //Mail::to("husaynov888@gmail.com")->send(new ComplaintMail(Complaint::find(1)));
        if (auth()->user()->hasRole('merchant')){
            return redirect('/shops/my_shop');
        }

        $statics = Cache::remember('users', 60, function () {
            $getOrderTaxSum = OrderProduct::with(['order'])->select('product_tax')
                ->whereHas('order', function ($q){
                    $q->where('order_status_id', OrderStatusService::ORDER_STATUS_ACCEPTED);
                })->sum('product_tax');

            $getShopsCount = Shop::where('status', Shop::STATUS_ACTIVE)->count();
            $getProductsCount = Product::where('status', Product::STATUS_ACTIVE)->count();
            $getClientsCount = Client::where('status', Client::STATUS_ACTIVE)->count();
            $getOrdersCount = Order::where('order_status_id', OrderStatusService::ORDER_STATUS_IN_PROCESS)->count();
            $getOrdersReturnedSum = Order::where('order_status_id', OrderStatusService::ORDER_STATUS_RETURNED)->sum('total_products_price');
            $getOrderSum = Order::where('order_status_id', OrderStatusService::ORDER_STATUS_ACCEPTED)->sum('total_products_price');

            $getMerchantTax = OrderProduct::with(['order'])->selectRaw('sum(price - product_tax) as aggregate')
                ->whereHas('order', function ($q){
                    $q->where('order_status_id', OrderStatusService::ORDER_STATUS_ACCEPTED);
                })->first()->toArray()['aggregate'];

            return [
                'orderTaxSum' => $getOrderTaxSum,
                'shopsCount'  => $getShopsCount,
                'productsCount' => $getProductsCount,
                'clientsCount'  => $getClientsCount,
                'ordersCount'  => $getOrdersCount,
                'ordersReturnedSum' => $getOrdersReturnedSum,
                'ordersSum' => $getOrderSum,
                'merchantsTax' => $getMerchantTax
            ];
        });

        $orders = $this->orderRepository->getAll($request);
        $getFilters = $this->orderRepository->getOrderFilters();

        return view('main.index', ['statics' => $statics, 'orders' => $orders, 'filters' => $getFilters]);
    }

}
