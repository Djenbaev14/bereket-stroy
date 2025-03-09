<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_id'=>$this->order_id,
            'receiver_name' => $this->receiver_name,
            'receiver_phone' => $this->receiver_phone,
            'receiver_comment' => $this->receiver_comment,
            'delivery_method' => $this->delivery_method->getTranslations('name'),
            'branch_id'=>$this->branch_id ? $this->branch->name : null,
            'region' => $this->region,
            'district' => $this->district,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'total_amount' => $this->total_amount,
            'status' => $this->status->getTranslations('name'),
        ];
    }
}
