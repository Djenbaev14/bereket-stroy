<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            "name"=> $this->branch_name,
            "street"=> $this->street,
            "start_date"=> $this->start_date,
            "end_date"=> $this->end_date,
            "point_array"=> $this->point_array,
            "days"=> DayResource::collection($this->days),
        ];
    }
}
