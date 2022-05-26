<?php


namespace App\Modules\Payments\UseCases;


use App\Modules\Integrations\Tezsum\Services\MerchantTezsum;
use App\Modules\Integrations\Tezsum\Services\UserTezsum;
use App\Modules\Payments\Models\Transaction;
use App\Modules\Payments\Models\WithdrawTransaction;
use Exception;

class TransactionCreate
{
    public function createClientTransaction(string $invoiceId): array
    {
        $userTezsum = new UserTezsum();
        $clientTrans = $userTezsum->createTransaction($invoiceId, auth()->user()->phone_number);
        \Log::info(print_r($clientTrans, true));

        if (!isset($clientTrans['json']['trans_id'])){
            \Log::channel('payment')->error(print_r($clientTrans, true));
            Transaction::where('invoice_id', $invoiceId)->update([
                'transaction_response' => json_encode($clientTrans),
            ]);
            throw new Exception($clientTrans['json']['error']);
        }

        \Log::channel('payment')->info(print_r($clientTrans, true));

        Transaction::where('invoice_id', $invoiceId)->update([
            'transaction_id' => $clientTrans['json']['trans_id'],
            'transaction_response' => json_encode($clientTrans),
        ]);

        return $clientTrans;
    }

    public function createWithDrawnTransaction($shop, $invoiceId): array
    {
        $merchantTezsum = new MerchantTezsum();
        $withDrawToCardTransactions = $merchantTezsum->createTransaction($invoiceId, $shop->tezsum_site_id);
        \Log::info(print_r($withDrawToCardTransactions, true));

        if (!isset($withDrawToCardTransactions['json']['trans_id'])){
            \Log::channel('payment')->error(print_r($withDrawToCardTransactions, true));
            WithdrawTransaction::where('invoice_id', $invoiceId)->update([
                'transaction_response' => $withDrawToCardTransactions
            ]);
            throw new Exception($withDrawToCardTransactions['json']['error']);
        }

        \Log::channel('payment')->info(print_r($withDrawToCardTransactions, true));

        WithdrawTransaction::where('invoice_id', $invoiceId)->update([
            'transaction_id' => $withDrawToCardTransactions['json']['trans_id'],
            'transaction_response' => $withDrawToCardTransactions,
        ]);

        return $withDrawToCardTransactions;
    }

}
