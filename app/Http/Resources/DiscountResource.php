<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'name'=>$this->name,
            'text'=>$this->text,
            'type'=>new DiscountTypeResource($this->discount_type),
            'discount_amount'=>$this->discount_amount,
            'photo'=>$this->photo,
            'slug'=>$this->slug,
            'deadline'=>$this->deadline
        ];
    }
}
