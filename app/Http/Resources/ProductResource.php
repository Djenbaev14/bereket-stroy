<?php

namespace App\Http\Resources;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class ProductResource extends JsonResource
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
            'category_id'=>$this->category_id,
            'sub_category_id'=>$this->sub_category_id,
            'sub_sub_category_id'=>$this->sub_sub_category_id,
            'name'=>$this->name,
            'description'=>$this->description,
            "slug"=>$this->slug,
            "photos"=>$this->photos ,
            "price"=>$this->price,
            'brand' => $this->brand->name ??null,
            'country' => $this->country->name??null,
            'status'=>$this->created_at->diffInDays(Carbon::now()) <= 7 ?'yangi':null,
            'avg_rating'=>$this->getAverageRatingAttribute(),
            'count_rating'=>$this->commentProducts->count(),
            'is_sale'=>$this->is_active ,
            'sales_count'=>$this->sales_count ,
            'discounted_price' => $this->discounted_price,
            'discount' => $this->discount
            // 'discount_type' => $this->activeDiscount->isNotEmpty() 
            //     ? $this->activeDiscount->first()->discount_type->discount_type
            //     : null,
        ];
    }
}
