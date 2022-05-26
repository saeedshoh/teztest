<?php namespace App\Modules\Cart\Repositories;


use Cart;
use App\Modules\Cart\Services\CartResponse;

class CartRepository
{
    private $cartResponse;

    public function __construct(CartResponse $cartResponse)
    {
        $this->cartResponse = $cartResponse;
    }

    public function getBySubscriberId(int $subscriberId): array
    {
        $cartSession = Cart::session($subscriberId);

        return $this->cartResponse->responseCart($cartSession);
    }

}
