<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CardResource;
use App\Http\Resources\ProductResource;
use App\Models\Card;
use App\Models\CardProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class CardController extends Controller
{

    public function index(){
        $cards=Card::with('products')->where('active','=',1)->orderBy('id','desc')->get();
        
        return $this->responsePagination($cards, CardResource::collection($cards));
    }
}
