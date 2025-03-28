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

        $search = mb_strtolower($request->input('search'));
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
            'id'=>$this->id,
            'search'=>$name,
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
            'status'=>$this->status,
            // 'status'=>$this->created_at->diffInDays(Carbon::now()) <= 7 ?'yangi':null,
            'avg_rating'=>$this->getAverageRatingAttribute(),
            'count_rating'=>$this->commentProducts->count(),
            'is_sale'=>$this->is_active ,
            'sales_count'=>$this->sales_count ,
            'discounted_price' => $this->discounted_price,
            'discount' => $this->discount,
            'installment_month'=>12,
            'monthly_payment'=>$this->monthly_payment,
            'seo' => [
                'title' => $this->name,
                'meta_description' => substr($this->description, 0, 160),
                'meta_keywords' => 'online',
                'canonical_url' => env('frontend_url')."/details/{$this->slug}",               
                'og:title' => $this->name,
                'og:description' => substr($this->description, 0, 160),
                'og:image' => $this->photos[0],
                'og:url' =>env('frontend_url')."/details/{$this->slug}", 
                'twitter:title' => $this->name,
                'twitter:description' =>substr($this->description, 0, 160),
                'twitter:image' => $this->photos[0],
            ],
            // 'discount_type' => $this->activeDiscount->isNotEmpty() 
            //     ? $this->activeDiscount->first()->discount_type->discount_type
            //     : null,
        ];
    }
}
