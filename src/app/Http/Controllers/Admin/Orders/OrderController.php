<?php namespace App\Http\Controllers\Admin\Orders;



use App\Modules\Integrations\Tezsum\Services\MerchantTezsum;
use App\Modules\Orders\Jobs\SendSMSToClientSent;
use App\Modules\Orders\Models\Order;
use App\Http\Controllers\Controller;
use App\Modules\Orders\Models\OrderProduct;
use App\Modules\Orders\Repositories\OrderRepository;

use App\Modules\Orders\Services\OrderStatusService;
use App\Modules\Orders\Services\SmsOrder;
use App\Modules\Orders\UseCases\OrderStatusModifications;
use App\Modules\Shops\Models\Shop;
use DB;
use Illuminate\View\View;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    private OrderRepository $orderRepository;
    private OrderStatusModifications $orderStatusMod;

    public function __construct(OrderRepository $orderRepository, OrderStatusModifications $orderStatusMod)
    {
        $this->orderRepository = $orderRepository;
        $this->orderStatusMod = $orderStatusMod;
        $this->middleware(['perm:status_sent_orders'])->only(['changeStatusToSent']);
        $this->middleware(['perm:status_performed_orders'])->only(['changeStatusToPerformed']);
        $this->middleware(['perm:status_any_orders'])->only(['changeStatusById']);
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $orders = $this->orderRepository->getAll($request);
        $getFilters = $this->orderRepository->getOrderFilters();
        $shops = Shop::where('status', Shop::STATUS_ACTIVE)->get();

        return view('order.index', [
            'orders' => $orders,
            'filters' => $getFilters,
            'shops' => $shops
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return View
     */
    public function show($id)
    {
        $order = Order::with(['transaction'])->findOrFail($id);

        $orderProducts = OrderProduct::where('order_id', $order->id)->paginate(15);
        return view('order.show', ['order' => $order, 'orderProducts' => $orderProducts]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeStatusToSent($id)
    {
        if(auth()->user()->hasRole(['admin', 'moderator'])) {
            $order = Order::find($id);
        }else{
            $order = Order::where('shop_id', auth()->user()->shop_id)->find($id);
            if(($order === null && !auth()->user()->hasRole(['admin', 'moderator']))  ){
                flash()->warning('Статус заказа "Perform" может менять только владелец магазина');
                return redirect("/orders/{$id}");
            }
        }
        $order->order_status_id = OrderStatusService::ORDER_STATUS_SENT;
        $order->save();
        SendSMSToClientSent::dispatch($order)->delay(now());
        flash()->success('Статус заказа изменен на Отправлено');

        return redirect("/orders/{$id}");
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeStatusToPerformed($id)
    {
        if(auth()->user()->hasRole(['admin', 'moderator'])) {
            $order = Order::find($id);
        }else{
            $order = Order::where('shop_id', auth()->user()->shop_id)->find($id);
            if(($order === null && !auth()->user()->hasRole(['admin', 'moderator']))  ){
                flash()->warning('Статус заказа "Perform" может менять только владелец магазина');
                return redirect("/orders/{$id}");
            }
        }

        $order->order_status_id = OrderStatusService::ORDER_STATUS_PERFORMED;
        $order->save();

        // SendSMSToClientSent::dispatch($id)->delay(now()->addMinute());
        SmsOrder::clientPerformed($order);
        flash()->success('Статус заказа изменен на Perform');

        return redirect("/orders/{$id}");
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function changeStatusToDenied($id)
    {
        if(auth()->user()->hasRole(['admin', 'moderator'])) {
            $order = Order::find($id);
        }else{
            $order = Order::where('shop_id', auth()->user()->shop_id)->find($id);
            if(($order === null && !auth()->user()->hasRole(['admin', 'moderator']))  ){
                flash()->warning('Статус заказа "Perform" может менять только владелец магазина');
                return redirect("/orders/{$id}");
            }
        }

        DB::beginTransaction();

        try {
            $response = (new MerchantTezsum)->voidPayment($order->transaction->transaction_id, $order->shop->tezsum_site_id);
            if(isset($response['json']['success'])){
                $order->order_status_id = OrderStatusService::ORDER_STATUS_CANCELED;
                $order->save();
                SmsOrder::clientCanceled($order);
                flash()->success('Статус заказа изменен');
                DB::commit();
            }else{
                DB::rollback();
                flash()->error($response['json']['desc']);
                \Log::channel('payment')->error(print_r($response, true));
            }
            return redirect("/orders/{$id}");
        } catch (\Exception $e) {
            \Log::channel('payment')->error($e);
            DB::rollback();
        }
        flash()->error('что-то пошло не так(');
        return redirect("/orders/{$id}");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function changeStatusById(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'exists:orders,id',
            'order_status_id' => 'exists:order_statuses,id',
        ]);

        switch ($request->order_status_id){
            case OrderStatusService::ORDER_STATUS_SENT:
                $this->changeStatusToSent($request->order_id);
                break;
            case OrderStatusService::ORDER_STATUS_PERFORMED:
                $this->changeStatusToPerformed($request->order_id);
                break;
            case OrderStatusService::ORDER_STATUS_ACCEPTED:
                $confirm = $this->orderStatusMod->confirmOrder($request);
                if ($confirm === false){
                    flash()->error('Что-то пошло не так((.');
                    return redirect("/orders/{$request->order_id}");
                }
                break;
            case OrderStatusService::ORDER_STATUS_CANCELED:
                $this->changeStatusToDenied($request->order_id);
                break;
            case OrderStatusService::ORDER_STATUS_RETURNED:
                $this->orderStatusMod->returnOrder($request);
                break;
            case OrderStatusService::ORDER_STATUS_ERROR_PAYMENT:
                $this->orderStatusMod->errorOnPayment($request);
                break;
        }

        flash()->success('Успешно.');
        return redirect("/orders/{$request->order_id}");

    }


}
