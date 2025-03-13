<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'phone'=>$this->phone,
            'email'=>$this->email,
            'instagram'=>$this->instagram,
            'facebook'=>$this->facebook,
            'telegram'=>$this->telegram,
            'youtube'=>$this->youtube,
        ];
    }
}
