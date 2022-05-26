<?php namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $productMedia = ProductMediaResource::collection($this->productMedia);
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
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'is_sale' => $this->is_sale,
            'sale' => $this->sale,
            'created_at' => $this->created_at,
            'wishlist' => $this->wishlist->where('product_id', $this->id)->where('client_id', auth()->id())->isNotEmpty(),
            'shop' => (new ShopResource($this->shop)),
            'brand' => (new BrandResource($this->brand)),
            'product_media' => $productMedia,
            'product_category' => (new ProductCategoryResource($this->productCategory)),
            'rank' => $this->rank
        ];
    }
}
