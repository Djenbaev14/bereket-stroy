<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopBannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'banner_type'=>$this->banner_type,
            'url' => $this->url,
            'photo' => $this->photo,
            'header' => $this->header,
            'text' => $this->text,
        ];
    }
}
