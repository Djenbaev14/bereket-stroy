<?php

namespace App\Http\Controllers;

use App\Http\Resources\BottomBannerResource;
use App\Http\Resources\TopBannerResource;
use App\Models\BottomBanner;
use App\Models\TopBanner;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    public function topBanner(){
        $top_banners = TopBanner::orderBy('id','desc')->get();
        return $this->responsePagination($top_banners, TopBannerResource::collection($top_banners));
    }
    public function bottomBanner(){
        $bottom_banners = BottomBanner::orderBy('id','desc')->get();
        return $this->responsePagination($bottom_banners, BottomBannerResource::collection($bottom_banners));
    }
}
