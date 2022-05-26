<?php namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProductMediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'file_uri' => $this->file_uri,
            'is_default' => $this->is_default,
            'position' => $this->position,
        ];
    }
}
