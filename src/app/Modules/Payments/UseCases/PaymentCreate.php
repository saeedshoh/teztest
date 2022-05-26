<?php namespace App\Modules\Payments\UseCases;


use App\Modules\Integrations\Tezsum\Services\MerchantTezsum;
use App\Modules\Integrations\Tezsum\Services\UserTezsum;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Services\OrderStatusService;
use App\Modules\Payments\Models\Transaction;
use App\Modules\Payments\Models\WithdrawTransaction;
use Exception;

class PaymentCreate
{
    public function createClientPayment(string $transactionId, string $paymentId = "1", string $cardId = null): bool
    {
        $userTezsum = new UserTezsum();
        if($cardId !== null && $paymentId === Transaction::PAYMENT_CREDIT_CARD){
            $paymentId .= ':' . $cardId;
        }

        $payment = $userTezsum->createPayment($transactionId, auth()->user()->phone_number, $paymentId);

        $transaction = Transaction::where('transaction_id', $transactionId)->first();
        if (!isset($payment['json']['success'])){
            \Log::channel('payment')->error(print_r($payment, true));

            Order::where('id', $transaction->order_id)->update(['order_status_id' => OrderStatusService::ORDER_STATUS_ERROR_PAYMENT]);

            $transaction->status = false;
            $transaction->payment_response = json_encode($payment);
            $transaction->payment_id = $paymentId;
            $transaction->save();

            throw new Exception($payment['json']['desc']);
        }
        \Log::channel('payment')->info(print_r($payment, true));

        if($cardId !== null) {
            $transaction->card_id = $cardId;
        }
        $transaction->status = true;
        $transaction->payment_response = json_encode($payment);
        $transaction->payment_id = $paymentId;
        $transaction->save();
        Order::where('id', $transaction->order_id)->update(['order_status_id' => OrderStatusService::ORDER_STATUS_IN_PROCESS]);
        return true;
    }


    public function createWithDrawPayment($shop, string $transactionId): bool
    {
        $merchantTezsum = new MerchantTezsum();
        $payment = $merchantTezsum->createPayment($transactionId, $shop->tezsum_site_id);

        if (!isset($payment['json']['success'])){
            \Log::channel('payment')->error(print_r($payment, true));

            WithdrawTransaction::where('transaction_id', $transactionId)
                ->update(['status' => false, 'payment_response' => $payment]);

            return false;
            //throw new Exception($payment['json']['error']);
        }
        \Log::channel('payment')->info(print_r($payment, true));

        WithdrawTransaction::where('transaction_id', $transactionId)
            ->update(['status' => true, 'payment_response' => $payment]);


        return true;
    }
}
