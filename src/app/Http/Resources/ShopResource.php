<?php namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'city' => $this->city->name,
            'logo_link' => $this->logoLink,
            'estimated_delivery_time' => $this->estimated_delivery_time,
            'delivery_price' => $this->delivery_price
        ];
    }
}
