<?php namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'delivery_date' => $this->delivery_date,
            'phone_number_delivery' => $this->phone_number_delivery,
            'address' => $this->address,
            'city' => $this->city,
            'order_status' => $this->orderStatus,
            'delivery_price' => $this->delivery_price,
            'comment' => $this->comment,
            'shop' => (new ShopResource($this->shop)),
            'order_product' => OrderProductResource::collection($this->orderProduct),
            'created_at' => $this->created_at,
            'transaction' => (new TransactionResource($this->transaction)),
            'total_products_sum' => $this->total_products_price,
            'total_sum' => $this->delivery_price + $this->total_products_price,
        ];
    }
}
