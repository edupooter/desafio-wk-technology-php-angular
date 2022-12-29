<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SellingOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);

        return [
            'id' => $this->id,
            'sold_at' => $this->sold_at,
            'total' => (float) $this->total,
            'customer' => CustomerResource::collection($this->customer),
            'products' => ProductResource::collection($this->products),
        ];
    }
}
