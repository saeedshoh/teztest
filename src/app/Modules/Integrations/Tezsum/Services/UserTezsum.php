<?php


namespace App\Modules\Integrations\Tezsum\Services;


use Illuminate\Support\Facades\Http;
use Log;

class UserTezsum
{
    public function myBalance()
    {
        $url = config('services.tezsum.api_user_url');


        $payload = [
            "wl" => "tezsum",
            "lang" => "ru",
            "version" => "1004",
            "cmd" => "my.balance",
            "imei" => "f27vj376f4",
            "json" => [
                "phoneNumber" => auth()->user()->phone_number,
                "currency" => "TJS",
                "paysys" => "1"
            ]
        ];

        try {
            $response = Http::timeout(4)
                ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
                ->post($url, $this->payloadWithHash($payload));
        } catch (\Exception $e) {
            Log::error($e);
            $clientBalance['json'] = [
                'cardtype' => false,
                'balance' => false,
                'currency' => false,
                'mobile' => false
            ];
            return $clientBalance;
        }

        $clientBalance = $response->json();

        if (!isset($clientBalance['json']['balance'])) {
            Log::channel('payment')->error(print_r($clientBalance, true));

            throw new \Exception('Tezsum User balance');
        }

        return $response->json();
    }

    public function createTransaction(string $invoiceId, $phoneNumber): array
    {
        $url = config('services.tezsum.api_user_url');

        $payload = [
            "wl" => "tezsum",
            "lang" => "ru",
            "version" => "1004",
            "cmd" => "payment.qr",
            "imei" => "f27vj376f4",
            "os" => "android",
            "vermob" => "1.1.0.2868",
            "json" => [
                "phoneNumber" => $phoneNumber,
                "invoice_id" => $invoiceId
            ]
        ];

        $payloadWithHash = $this->payloadWithHash($payload);
        $response = Http::timeout(8)
            ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
            ->post($url, $payloadWithHash);
        Log::channel('payment')->info(print_r($payloadWithHash, true));
        return $response->json();
    }

    public function createPayment(string $transId, string $phoneNumber, string $paymentId = "1"): array
    {
        $url = config('services.tezsum.api_user_url');

        $payload = [
            "wl" => "tezsum",
            "lang" => "ru",
            "version" => "1004",
            "cmd" => "payment.pay",
            "imei" => "f27vj376f4",
            "os" => "android",
            "vermob" => "1.1.0.2869",
            "json" => [
                "phoneNumber" => $phoneNumber,
                "trans_id" => $transId,
                "payment_id" => $paymentId
            ]
        ];
        $payloadWithHash = $this->payloadWithHash($payload);

        $response = Http::timeout(8)
            ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
            ->post($url, $payloadWithHash);
        Log::channel('payment')->info(print_r($payloadWithHash, true));
        return $response->json();
    }

    /**
     * @return array
     */
    public function myCards(): array
    {
        $url = config('services.tezsum.api_user_url');

        $payload = [
            "wl" => "tezsum",
            "lang" => "ru",
            "version" => "1004",
            "cmd" => "my.cards",
            "imei" => "f27vj376f4",
            "vermob" => "1.1.0.2869",
            "json" => [
                "phoneNumber" => auth()->user()->phone_number,
            ]
        ];

        Log::channel('payment')->info(print_r($payload, true));
        $response = Http::timeout(8)
            ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
            ->post($url, $this->payloadWithHash($payload));

        return $response->json();
    }


    /**
     * @return array
     */
    public function startApp(): array
    {
        $url = config('services.tezsum.api_user_url');

        $payload = [
            "wl" => "tezsum",
            "lang" => "ru",
            "version" => "1004",
            "cmd" => "start.app",
            "imei" => "f27vj376f4",
            "json" => [
                "phoneNumber" => auth()->user()->phone_number,
            ]
        ];

        Log::channel('payment')->info(print_r($payload, true));
        $response = Http::timeout(8)
            ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
            ->post($url, $this->payloadWithHash($payload));

        return $response->json();
    }

    public function addCard(string $session, array $cardData): array
    {
        $url = config('services.tezsum.api_user_url');

        $payload = [
            "wl" => "tezsum",
            "lang" => "ru",
            "version" => "1004",
            "cmd" => "my.card.add",
            "imei" => "f27vj376f4",
            "os" => "android",
            "vermob" => "1.1.0.2869",
            "json" => [
                "session" => $session,
                "payment_id" => 33,
                "card_name" => $cardData['card_name'],
                "card_pan" => $cardData['card_pan'],
                "card_exp" => $cardData['card_exp'],
                "card_cvv" => $cardData['card_cvv']
            ]
        ];

        Log::channel('payment')->info(print_r($payload, true));
        $response = Http::timeout(8)
            ->withHeaders(['X-API-SECURE-KEY' => config('services.tezsum.secure_key')])
            ->post($url, $this->payloadWithHash($payload));

        return $response->json();
    }

    public function removeCard(string $session, string $cardId): array
    {
        $url = config('services.tezsum.api_user_url');

        $payload = [
            "wl" => "tezsum",
            "lang" => "ru",
            "version" => "1004",
            "cmd" => "my.card.del",
            "imei" => "f27vj376f4",
            "os" => "android",
            "vermob" => "1.1.0.2869",
            "json" => [
                "session" => $session,
                "card_id" => $cardId,
            ]
        ];

        Log::channel('payment')->info(print_r($payload, true));
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
