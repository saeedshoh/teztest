<?php namespace App\Modules\Auth\Services;


use App\Modules\Auth\Models\Client;
use App\Modules\Auth\UseCases\ClientCrud;
use App\Modules\Integrations\myTcell\Services\MyTcell;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccessTokenGuard implements Guard
{
    use GuardHelpers;

    private $request;
    const TOKEN_LENGTH = 64;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        $getValidationData = $this->validate(['Authorization' => $this->bearerToken()]);

        if ($getValidationData === false) {
            return $this->user = null;
        }

        return $this->user = $getValidationData;
    }


    public function validate(array $credentials = [])
    {
        $token = $credentials['Authorization'];

        if ($token === false) {
            return false;
        }

        return $this->cachedClient($token);
    }


    private function cachedClient($token)
    {
        $checkCache = \Cache::get('clientToken:' . $token);

        if ($checkCache) {
            return $checkCache;
        }

        $checkCache = Client::where(['token' => $token, 'status' => Client::STATUS_ACTIVE])->first();
        if ($checkCache === null) {
            $checkCache = $this->checkTokenUpdateClient($token);
        }

        \Cache::put('clientToken:' . $token, $checkCache, now()->addDay());

        return \Cache::get('clientToken:' . $token);
    }

    private function checkTokenUpdateClient($token)
    {
        $myTcellData = MyTcell::getHome($token);
        \Log::channel('auth')->info(print_r($myTcellData, true));
        if ($myTcellData['code'] == 200 && isset($myTcellData['data']['msisdn'])) {
            $columnData = [
                'name' => $myTcellData['data']['name'],
                'phone_number' => $myTcellData['data']['msisdn'],
                'status' => Client::STATUS_ACTIVE,
                'subscriber_id' => $myTcellData['data']['subscriber_id'],
                'token' => $token
            ];

            return (new ClientCrud())->insertOrUpdateClientToken($columnData);
        }

        return false;
    }

    public function bearerToken()
    {
        $header = $this->request->header('Authorization', '');

        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }

        return false;
    }


}
