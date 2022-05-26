<?php namespace App\Modules\Cart\UseCases;


use Cart;

use App\Modules\Products\Models\Product;
use App\Modules\Cart\Services\CartResponse;

class CartCrud
{
    private $cartResponse;

    public function __construct(CartResponse $cartResponse)
    {
        $this->cartResponse = $cartResponse;
    }

    public function add(array $cartData): void
    {
        $product = Product::with(['shop'])->find($cartData['product_id']);
        $product->cart_add_count = $product->cart_add_count+1;
        $product->save();
        Cart::add([
            'id' => $product->id,
            'name' => $product->title,
            'price' => round($product->price, 2),
            'attributes' => [],
            'associatedModel' => $product,
            'quantity' => (int) $cartData['quantity']
        ]);
    }
}
