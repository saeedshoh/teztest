<?php namespace App\Modules\Payments\UseCases;


use App\Modules\Integrations\Tezsum\Services\BalanceConverter;
use App\Modules\Integrations\Tezsum\Services\MerchantTezsum;
use App\Modules\Payments\Models\Transaction;
use App\Modules\Payments\Models\WithdrawTransaction;
use Exception;
use Log;

class InvoiceCreate
{

    public function createMerchantInvoice($order): array
    {
        $merchantTezsum = new MerchantTezsum();
        $amount = $order['delivery_price'] + $order['total_product_price'];
        $amountConvertToDiram = BalanceConverter::convertToDiram($amount);
        $commissionConvertToDiram = BalanceConverter::convertToDiram($order['commission']);

        $getInvoice = $merchantTezsum->createInvoice([
            'siteId' => $order['site_id'],
            'orderId' => $order['order_id'],
            'amount' => $amountConvertToDiram,
            'desc' => $order['desc'],
            'commission' => $commissionConvertToDiram
        ]);

        if (!isset($getInvoice['json']['invoice_id'])){
            Log::channel('payment')->error(print_r($getInvoice, true));
            throw new Exception($getInvoice['json']['error']);
        }
        Log::channel('payment')->info(print_r($getInvoice, true));

        $invoice = new Transaction();
        $invoice->create([
            'order_id' => $order['order_id'],
            'amount' => $amountConvertToDiram - $commissionConvertToDiram,
            'commission' => $commissionConvertToDiram,
            'invoice_id' => $getInvoice['json']['invoice_id'],
            'invoice_response' => json_encode($getInvoice),
        ]);

        return $getInvoice;
    }

    public function createWithDrawnInvoice($shop, $amount, $creditCard): array
    {
        $merchantTezsum = new MerchantTezsum();
        $amountConvertToDiram = BalanceConverter::convertToDiram($amount);
        $createInvoice = $merchantTezsum->withDrawToCard($shop->tezsum_site_id, $amountConvertToDiram, $creditCard);

        if (!isset($createInvoice['json']['invoice_id'])){
            Log::channel('payment')->error(print_r($createInvoice, true));
            throw new Exception($createInvoice['json']['error']);
        }
        Log::channel('payment')->info(print_r($createInvoice, true));

        $invoice = new WithdrawTransaction();
        $invoice->create([
            'shop_id' => $shop->id,
            'user_id' => auth()->id(),
            'credit_card' => $creditCard,
            'amount' => $amountConvertToDiram,
            'invoice_id' => $createInvoice['json']['invoice_id'],
            'invoice_response' => $createInvoice,
        ]);

        return $createInvoice;
    }

    public function createWithDrawnBankAccountInvoice($shop, $amount): array
    {
        $merchantTezsum = new MerchantTezsum();
        $amountConvertToDiram = BalanceConverter::convertToDiram($amount);

        $bankData = [
            'amount' => $amountConvertToDiram,
            'currency' => 'TJS',
            'INN_MERCHANT' => $shop->tin,
            'AMOUNT' => $amountConvertToDiram,
            'LEGAL_NAME_MERCHANT' => $shop->company_name,
            'INVOICE_ABC' => '26202972900000099538',
            'BANK_NAME_MERCHANT' => $shop->bank_name,
            'BANK_BIK_MERCHANT' => $shop->bik,
            'BANK_INVOICE_MERCHANT' => $shop->bank_account_number,
            'INN_MERCHANT_2' => $shop->tin,
            'INVOICE_MERCHANT' => $shop->bank_account_number,
            'NAME_MERCHANT' => $shop->name,
            'PURSE_NUMBER' => $shop->phone_number
        ];
        $createInvoice = $merchantTezsum->withdrawToBankAccount($shop->tezsum_site_id, $bankData);

        if (!isset($createInvoice['json']['invoice_id'])){
            Log::channel('payment')->error(print_r($createInvoice, true));
            throw new Exception($createInvoice['json']['error']);
        }
        Log::channel('payment')->info(print_r($createInvoice, true));

        $invoice = new WithdrawTransaction();
        $invoice->create([
            'type' => 2,
            'shop_id' => $shop->id,
            'user_id' => auth()->id(),
            'amount' => $amountConvertToDiram,
            'invoice_id' => $createInvoice['json']['invoice_id'],
            'invoice_response' => $createInvoice,
        ]);

        return $createInvoice;
    }
}
