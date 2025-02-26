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
            'name'=>$this->getTranslations('name'),
            "slug"=>$this->slug,
            "photos"=>$this->photos ,
            "price"=>$this->price,
            'brand' => $this->brand->getTranslations('name'),
            'status'=>$this->created_at->diffInDays(Carbon::now()) <= 7 ?'yangi':'eski',
            'discounted_price' => $this->activeDiscount->isNotEmpty() 
                ? ($this->activeDiscount->first()->discount_type->discount_type == 'UZS' 
                    ? $this->price - $this->activeDiscount->first()->discount_amount 
                    : round((100 - $this->activeDiscount->first()->discount_amount) * $this->price / 100))
                : $this->price,
        ];
    }
}
