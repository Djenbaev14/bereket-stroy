<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscountResource;
use App\Http\Resources\ProductResource;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{

    public function discounts(Request $request){
        
        $query=Discount::active();

        if($request->has('slug')){
            $query->where('slug','=',$request->input('slug'));
        }

        $discounts=$query->get();
        return $this->responsePagination($discounts, DiscountResource::collection($discounts));
        
    }
    public function discountProducts(Request $request){
        
        $query=Product::whereHas('activeDiscount')->with('activeDiscount');

        if($request->has('slug')){
            $query->where('slug','=',$request->input('slug'));
        }

        $products=$query->paginate(12);
        return $this->responsePagination($products, ProductResource::collection($products));
        
    }
}
