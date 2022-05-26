<?php namespace App\Modules\Integrations\Tezsum\Services;


use Illuminate\Support\Facades\Http;
use Log;

class MerchantTezsum
{

    public function createMerchant(array $data): array
    {
        $url = config('services.tezsum.api_merchant_url');
        $payload = [
            "cmd" => "create.merchant",
            "version" => 1005,
            "lang" => "ru",
            "sid" => config('services.tezsum.merchant_sid'),
            "json" => [
                "mobile" => $data['phone_number'],
                "name" => $data['name']
            ]
        ];
        $response = Http::timeout(4)
            ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
            ->post($url, $this->payloadWithHash($payload));

        return $response->json();
    }

    public function getBalance(string $siteId): array
    {
        $url = config('services.tezsum.api_merchant_url');
        $payload = [
            "cmd" => "get.balance",
            "version" => 1005,
            "sid" => $siteId,
            "lang" => "ru",
            "json" => [
                "currency" => "TJS"
            ]
        ];
        $response = Http::timeout(4)
            ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
            ->post($url, $this->payloadWithHash($payload));

        return $response->json();
    }

    public function createInvoice(array $data): array
    {
        $url = config('services.tezsum.api_merchant_url');
        $payload = [
            "cmd" => "create.invoice",
            "version" => 1005,
            "sid" => (string) $data['siteId'],
            "lang" => "ru",
            "json" => [
                "order_id" => $data['orderId'],
                'amount' => (int) $data['amount'],
                'desc' => $data['desc'],
                "commission" => (int) $data['commission']
            ]
        ];
        $payloadWithHash = $this->payloadWithHash($payload);
        $response = Http::timeout(4)
            ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
            ->post($url, $payloadWithHash);
        Log::channel('payment')->info(print_r($payloadWithHash, true));
        return $response->json();
    }

    public function statusPayment(array $data): array
    {
        $url = config('services.tezsum.api_merchant_url');
        $payload = [
            "cmd" => "statusPayment",
            "version" => 1005,
            "sid" => 2879872968,
            "lang" => "ru",
            "json" => [
                "invoice_id" => $data['invoiceId']
            ]
        ];

        $response = Http::timeout(4)
            ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
            ->post($url, $this->payloadWithHash($payload));

        return $response->json();
    }

    public function confirmHold(string $transactionId, string $sid): array
    {
        $url = config('services.tezsum.api_merchant_url');
        $payload = [
            "cmd" => "confirm.hold.payment",
            "version" => 1005,
            "sid" => $sid,
            "lang" => "ru",
            "json" => [
                "trans_id" => (string) $transactionId
            ]
        ];
        $payloadWithHash = $this->payloadWithHash($payload);
        $response = Http::timeout(4)
            ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
            ->post($url, $payloadWithHash);
        Log::channel('payment')->info('Request to confirm payment', $payloadWithHash);
        Log::channel('payment')->info('Response to confirm payment', $response->json());
        return $response->json();
    }

    public function voidPayment(string $transactionId, string $sid): array
    {
        $url = config('services.tezsum.api_merchant_url');
        $payload = [
            "cmd" => "void.payment",
            "version" => 1005,
            "sid" => $sid,
            "lang" => "ru",
            "json" => [
                "trans_id" => (string) $transactionId
            ]
        ];
        $payloadWithHash = $this->payloadWithHash($payload);
        Log::channel('payment')->info('Request to void payment', $payloadWithHash);
        $response = Http::timeout(4)
            ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
            ->post($url, $payloadWithHash);
        Log::channel('payment')->info('Response to void payment', $response->json());
        return $response->json();
    }

    public function withDrawToCard(string $sid, int $amount, string $card): array
    {
        $url = config('services.tezsum.api_merchant_url');
        $payload = [
            "cmd" => "withdraw.to.card",
            "version" => 1005,
            "sid" => $sid,
            "lang" => "ru",
            "json" => [
                "user_to" => $card,
                "amount" => $amount
            ]
        ];

        $response = Http::timeout(4)
            ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
            ->post($url, $this->payloadWithHash($payload));

        return $response->json();
    }

    public function withdrawToBankAccount(string $sid, array $bankData): array
    {
        $url = config('services.tezsum.api_merchant_url');
        $payload = [
            "cmd" => "withdraw.to.account",
            "version" => 1005,
            "sid" => $sid,
            "lang" => "ru",
            "json" => $bankData
        ];

        $response = Http::timeout(4)
            ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
            ->post($url, $this->payloadWithHash($payload));

        return $response->json();
    }

    public function createTransaction(string $invoiceId, $tezsumSiteId): array
    {
        $url = config('services.tezsum.api_merchant_url');

        $payload = [
            "cmd" => "payment.qr",
            "lang" => "ru",
            "sid" => (string) $tezsumSiteId,
            "version" => 1005,
            "json" => [
                "invoice_id" => (string) $invoiceId
            ]
        ];

        $response = Http::timeout(8)
            ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
            ->post($url, $this->payloadWithHash($payload));

        return $response->json();
    }

    public function createPayment(string $transId, $tezsumSiteId): array
    {
        $url = config('services.tezsum.api_merchant_url');

        $payload = [
            "cmd" => "payment.pay",
            "lang" => "ru",
            "sid" => (string) $tezsumSiteId,
            "version" => 1005,
            "json" => [
                "trans_id" => (string) $transId
            ]
        ];

        \Log::channel('payment')->info(print_r($payload, true));
        $response = Http::timeout(8)
            ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
            ->post($url, $this->payloadWithHash($payload));

        return $response->json();
    }

    /**
     * @param array $payload
     * @return array
     */
    private function payloadWithHash(array $payload): array
    {
        $hashKey = config('services.tezsum.hash_hmac_key');
        $json = json_encode($payload);
        $hash = hash_hmac('md5', $json, $hashKey);
        $payload['hash'] = $hash;
        return $payload;
    }

}
