<?php namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name'=> $this->name,
            'price' => (float) $this->price,
            'quantity' => $this->quantity,
            'product' => new ProductResource($this->associatedModel),
            'attributes' => $this->attributes,
            'totalPrice' => (float) $this->price * $this->quantity
        ];
    }
}
