<?php


namespace App\Modules\Common\Services;


use Illuminate\Support\Facades\Http;

class SMSCenter
{
    public static function send($phone, $message)
    {
       $sms = Http::timeout(10)->contentType('text/plain')->post(config('services.sms.url'), [
            "msisdn" => $phone,
            'text' => $message,
            'login' => config('services.sms.login'),
            'pass' => config('services.sms.pass')
        ])->json();

        \Log::channel('message')->info(print_r($sms, true));

       if (isset($sms['err_code']) && $sms['err_code'] !== 0){
           \Log::channel('message')->error(print_r($sms, true));
           return false;
       }

        return true;
    }

}
