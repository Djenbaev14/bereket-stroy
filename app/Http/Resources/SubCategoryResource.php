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
            'products_count'=>$this->getProductsCountAttribute(),
            'product' => ProductResource::collection($this->whenLoaded('product')),
            'seo' => [
                'title' => $this->name,
                'meta_description' => '',
                'meta_keywords' => 'online',
                'canonical_url' => env('frontend_url')."/catalogs/{$this->category->slug}/{$this->slug}",               
                'og:title' => $this->name,
                'og:description' => '',
                'og:image' => $this->photo,
                'og:url' =>env('frontend_url')."/catalogs/{$this->category->slug}/{$this->slug}", 
                'twitter:title' => $this->name,
                'twitter:description' =>'',
                'twitter:image' => $this->photo,
            ],
        ];
    }
}
