<?php namespace App\Modules\Cart\Services;


use App\Http\Resources\ProductResource;

class CartResponse
{
    public function responseCart($cartSession): array
    {
        $cartContent = [];
        foreach ($cartSession->getContent() as $content)
        {
            $cartContent[] = [
                'id' => $content->id,
                'name'=> $content->name,
                'price' => number_format($content->price, 2),
                'quantity' => $content->quantity,
                'product' => new ProductResource($content->associatedModel),
                'attributes' => $content->attributes,
                'totalPrice' => number_format($content->price * $content->quantity,2)
            ];
        }

        return [
            'cartContent' => $cartContent,
            'totalCount' => $cartSession->getTotalQuantity(),
            'totalSum' => round($cartSession->getTotal(),2, PHP_ROUND_HALF_DOWN)
        ];
    }

}
