<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentTypeResource extends JsonResource
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
            'key'=>$this->key,
            'name'=>$this->name,
            'text'=>$this->text,
            'photo'=>$this->photo,
            'is_active'=>$this->is_active,
        ];
    }
}
