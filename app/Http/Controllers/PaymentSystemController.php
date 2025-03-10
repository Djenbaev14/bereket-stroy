<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymeResource;
use Goodoneuz\PayUz\Models\PaymentSystemParam;
use Illuminate\Http\Request;

class PaymentSystemController extends Controller
{
    public function payme(){
        $merchant_id=PaymentSystemParam::where('system','payme')->where('name','merchant_id')->first()->value;
        $password=PaymentSystemParam::where('system','payme')->where('name','password')->first()->value;
        $key=PaymentSystemParam::where('system','payme')->where('name','key')->first()->value;
        return response()->json([
            'status'=>'success',
            'message'=>'Operation successful',
            'data'=>[
                'merchant_id'=>$merchant_id,
                'password'=>$password,
                'key'=>$key
            ],
            'pagination'=>null
        ]);
    }
}
