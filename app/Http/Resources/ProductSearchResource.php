<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        $search = $request->input('name');
        $locales = ['uz', 'qr', 'ru', 'en'];
        $name = null;

        if ($search) {
            foreach (config('app.available_locales') as $locale) {
                $translatedName = $this->getTranslation('name', $locale);
                if (str_contains(strtolower($translatedName), strtolower($search))) {
                    $name = $translatedName;
                    break;
                }
            }
        }
        return [
            'id'=> $this->id,
            'name'=>$name,
            'slug'=>$this->slug
        ];
    }
}
