<?php

namespace App\Http\Resources;

use App\Models\OrderItem;
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
            'delivery_method' => $this->delivery_method->name,
            'branch'=>$this->branch_id ? $this->branch->branch_name : null,
            'region' => $this->region,
            'district' => $this->district,
            'address' => $this->address,
            'latitude' => $this->location[0],
            'longitude' => $this->location[1],
            'total_amount' => $this->total_amount,
            'status' => $this->status->name,
            'products_count'=>$this->OrderItems->count(),
            'order_status_id'=>$this->order_status_id,
            'products'=>OrderItemResource::collection(OrderItem::where('order_id',$this->id)->get()),
            'created_at'=>$this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
