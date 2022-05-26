<?php namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $productMedia = ProductMediaResource::collection($this->product->productMedia);
        if ($productMedia->isEmpty()) {
            $productMedia = [[
                'id' => 0,
                'file_uri' =>  url("/assets/images/no-image.svg"),
                'is_default' => 0,
                'position' => 0
            ]];
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'product_media' => $productMedia
            ],
        ];
    }
}
