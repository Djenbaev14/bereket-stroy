<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentTypeResource;
use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    public function index()
    {
        $paymentTypes = PaymentType::orderBy("id","desc")->get();
        
        return $this->responsePagination($paymentTypes, PaymentTypeResource::collection($paymentTypes));
    }
}
