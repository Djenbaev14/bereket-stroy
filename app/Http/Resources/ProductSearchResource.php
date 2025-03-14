<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

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
            'name'=>$name,
            'slug'=>$this->slug
        ];
    }
}
