<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            "slug"=>$this->slug,
            "photo"=>$this->photo ,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'sub_sub_category' => SubSubCategoryResource::collection($this->whenLoaded('sub_sub_category')),
            'product' => ProductResource::collection($this->whenLoaded('product')),
        ];
    }
}
