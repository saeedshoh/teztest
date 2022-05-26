<?php


namespace App\Modules\Orders\UseCases;


use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Services\SmsOrder;
use App\Modules\Payments\Models\Transaction;
use App\Modules\Orders\Services\OrderStatusService;
use App\Modules\Integrations\Tezsum\Services\MerchantTezsum;

class OrderStatusModifications
{

    public function confirmOrder($request)
    {
        $transaction = Transaction::with(['order.shop'])->where(['order_id' => $request->order_id, 'status' => true])->first();
        if($transaction === null){
            \Log::channel('payment')->error(print_r('Transaction status on false', true));
            return false;
        }
        $merchant = new MerchantTezsum();
        $confirmHold = $merchant->confirmHold($transaction->transaction_id, $transaction->order->shop->tezsum_site_id);

        if (isset($confirmHold['json']['error'])){
            \Log::channel('payment')->error(print_r($confirmHold, true));

            return $confirmHold;
        }

        $order = Order::find($request->order_id);
        $order->order_status_id = OrderStatusService::ORDER_STATUS_ACCEPTED;
        $order->save();

        //SendSMSToClientPerformed::dispatch($request->order_id)->delay(now()->addMinute());
        SmsOrder::clientAccepted($order);

        \Log::channel('payment')->info(print_r($confirmHold, true));

        return $confirmHold;
    }

    public function errorOnPayment($request): bool
    {
        $order = Order::find($request->order_id);
        $order->order_status_id = OrderStatusService::ORDER_STATUS_ERROR_PAYMENT;
        return $order->save();
    }

    public function returnOrder($request)
    {
        $order = Order::find($request->order_id);

        try {
            $response = (new MerchantTezsum)->voidPayment($order->transaction->transaction_id, $order->shop->tezsum_site_id);
            if(isset($response['json']['success'])){

                if($order->order_status_id == OrderStatusService::ORDER_STATUS_PERFORMED){
                    SmsOrder::clientReturned($order);
                    $order->order_status_id = OrderStatusService::ORDER_STATUS_RETURNED;
                }else{
                    SmsOrder::clientDenied($order);
                    $order->order_status_id = OrderStatusService::ORDER_STATUS_DENIED;
                }
                $order->save();

                \DB::commit();

                return $response;
            }else{
                \DB::rollback();
                \Log::channel('payment')->error(print_r($response, true));
                return $response;
            }
        } catch (\Exception $e) {
            \Log::channel('payment')->error($e);
            \DB::rollback();
        }

        return $response;
    }

}
