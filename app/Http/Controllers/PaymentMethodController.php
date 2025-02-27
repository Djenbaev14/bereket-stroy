<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Stripe\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index(){
        $payment_methods = PaymentType::all();
        return $this->responsePagination($payment_methods, PaymentMethodResource::collection($payment_methods));
    }

}
