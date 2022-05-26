<?php


namespace App\Http\Controllers\API\v0\WebServices;


use App\Http\Controllers\API\Controller;
use App\Modules\Auth\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class MyTcellController extends Controller
{
    public function destroyClientToken(Request $request)
    {
        $this->validate($request, [
            'token' => [
                'required',
                'string'
            ]
        ]);

        Client::where('token', $request->token)->update(['status' => Client::STATUS_TOKEN_DESTROYED]);
        \Cache::forget('clientToken:' . $request->token);

        return response()->json([
            "meta" => [
                "error"=> false,
                "message" => "",
                "statusCode" => Response::HTTP_OK
            ],
            "response" => []
        ]);
    }

}
