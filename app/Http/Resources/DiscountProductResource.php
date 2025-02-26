<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                "id"=> $this->id,
                "discount_amount"=> $this->discount_amount,
                "discount_type"=> $this->discount_type->discount_type,
                "discount_type_name"=> $this->discount_type->name,
        ];
    }
}
