<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            "photo"=>$this->photo,
            "icon"=>$this->icon,
            'products_count'=>$this->getProductsCountAttribute(),
            'sub_category' => SubCategoryResource::collection($this->whenLoaded('sub_category')),
            'seo' => [
                'title' => $this->name,
                'meta_description' => '',
                'meta_keywords' => 'online',
                'canonical_url' => env('frontend_url')."/catalogs/{$this->slug}",               
                'og:title' => $this->name,
                'og:description' => '',
                'og:image' => $this->photo,
                'og:url' =>env('frontend_url')."/catalogs/{$this->slug}", 
                'twitter:title' => $this->name,
                'twitter:description' =>'',
                'twitter:image' => $this->photo,
            ],
        ];
    }
}
