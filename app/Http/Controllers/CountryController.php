<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(){
        $countries = Country::orderBy('id','desc')->get();
        return $this->responsePagination($countries, CountryResource::collection($countries));
    }
}
