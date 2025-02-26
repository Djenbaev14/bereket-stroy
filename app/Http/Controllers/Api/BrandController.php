<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CountryResource;
use App\Models\Brand;
use App\Models\Country;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    //
    public function index(){
        $brands = Brand::orderBy('id','desc')->get();
        return $this->responsePagination($brands, BrandResource::collection($brands));
    }
    public function country(){
        $countries = Country::orderBy('id','desc')->get();
        return $this->responsePagination($countries, CountryResource::collection($countries));
    }
}
