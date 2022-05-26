<?php namespace App\Modules\Shops\UseCases;


use App\Modules\Shops\Models\Shop;


class ShopSubscription
{
    public function subscribe(array $validateData)
    {

        $statusCode = 200;
        $shop = Shop::find($validateData['shop_id']);
        $shop->clientSubscriptions()->attach(auth()->id());

        return ['subscribe' => 'Subscribed', 'statusCode' => $statusCode];
    }

    public function unsubscribe(array $validateData)
    {
        $statusCode = 200;
        $shop = Shop::find($validateData['shop_id']);
        $shop->clientSubscriptions()->detach(auth()->id());

        return ['subscribe' => 'Unsubscribed', 'statusCode' => $statusCode];
    }

}
