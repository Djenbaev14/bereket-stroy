<?php

namespace App\Http\Controllers;

use App\Http\Resources\BottomBannerResource;
use App\Http\Resources\TopBannerResource;
use App\Models\BottomBanner;
use App\Models\TopBanner;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    public function bigBanner(){
        $big_banner = TopBanner::where('banner_type','big_banner')->orderBy('id','desc')->first();
        return $this->responsePagination($big_banner, new TopBannerResource($big_banner));
    }
    public function smallBanner(){
        $small_banner = TopBanner::where('banner_type','small_banner')->orderBy('id','desc')->take(2)->get();
        return $this->responsePagination($small_banner, TopBannerResource::collection($small_banner));
    }
}
