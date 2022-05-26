<?php namespace App\Modules\Integrations\myTcell\Services;


use Illuminate\Support\Facades\Http;

class MyTcell
{
    /**
     * @param $authToken
     * @return array
     */
    public static function getHome($authToken)
    {
        $url = config('services.mytcell.api_url') . '/home/';
        $response = Http::withHeaders(['Auth-token' => $authToken])->get($url);
        $responseArray = $response->json();

        return ['data' => $responseArray, 'code' => $response->status()];
    }

}
