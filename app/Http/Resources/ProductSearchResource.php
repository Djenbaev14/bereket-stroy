<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProductSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        $search = mb_strtolower($request->input('name'));
        $name = null;

        if ($search) {
            foreach (config('app.available_locales') as $locale) {
                $translatedName = mb_strtolower($this->getTranslation('name', $locale));
                if (str_contains(strtolower($translatedName), $search)) {
                    $name = $translatedName;
                    break;
                }
            }
        }
        return [
            'id'=> $this->id,
            'search'=>$name,
            'slug'=>$this->slug,
            'category_id'=>$this->category_id,
            'sub_category_id'=>$this->sub_category_id,
            'sub_sub_category_id'=>$this->sub_sub_category_id,
            'name'=>$this->name,
            'description'=>$this->description,
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
        ];
    }
}
