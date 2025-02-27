<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeliveryMethodResource;
use App\Models\DeliveryMethod;
use Illuminate\Http\Request;

class DeliveyMethodController extends Controller
{
    public function index(){
        $deliveries = DeliveryMethod::orderBy('id','desc')->get();
        return $this->responsePagination($deliveries, DeliveryMethodResource::collection($deliveries));
    }
}
