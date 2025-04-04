<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            "last_name"=>$this->customer->last_name,
            "first_name"=>$this->customer->first_name,
            "comment"=>$this->comment,
            "rating"=>$this->rating,
            "photo"=>$this->photo,
            'created_at'=>$this->created_at
        ];
    }
}
