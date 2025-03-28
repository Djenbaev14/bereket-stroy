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
            'id' => $this->id,
            'search' => mb_convert_encoding($name, 'UTF-8', 'auto'),
            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'sub_sub_category_id' => $this->sub_sub_category_id,
            'name' => mb_convert_encoding($this->name, 'UTF-8', 'auto'),
            'description' => mb_convert_encoding($this->description, 'UTF-8', 'auto'),
            "slug" => $this->slug,
            "photos" => array_map(fn($photo) => mb_convert_encoding($photo, 'UTF-8', 'auto'), $this->photos ?? []),
            "price" => $this->price,
            'brand' => mb_convert_encoding($this->brand->name ?? null, 'UTF-8', 'auto'),
            'country' => mb_convert_encoding($this->country->name ?? null, 'UTF-8', 'auto'),
            'status' => $this->status,
            'avg_rating' => $this->getAverageRatingAttribute(),
            'count_rating' => $this->commentProducts->count(),
            'is_sale' => $this->is_active,
            'sales_count' => $this->sales_count,
            'discounted_price' => $this->discounted_price,
            'discount' => $this->discount,
            'installment_month' => 12,
            'monthly_payment' => $this->monthly_payment,
            'seo' => [
                'title' => mb_convert_encoding($this->name, 'UTF-8', 'auto'),
                'meta_description' => mb_convert_encoding(substr($this->description, 0, 160), 'UTF-8', 'auto'),
                'meta_keywords' => 'online',
                'canonical_url' => env('frontend_url') . "/details/{$this->slug}",               
                'og:title' => mb_convert_encoding($this->name, 'UTF-8', 'auto'),
                'og:description' => mb_convert_encoding(substr($this->description, 0, 160), 'UTF-8', 'auto'),
                'og:image' => $this->photos[0] ?? null,
                'og:url' => env('frontend_url') . "/details/{$this->slug}", 
                'twitter:title' => mb_convert_encoding($this->name, 'UTF-8', 'auto'),
                'twitter:description' => mb_convert_encoding(substr($this->description, 0, 160), 'UTF-8', 'auto'),
                'twitter:image' => $this->photos[0] ?? null,
            ],
        ];
        
    }
}
