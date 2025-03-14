<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CountryResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Country;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    //
    public function index(Request $request){

        $query = Brand::orderBy('id','desc');
        if($request->has('category_slug')){
            $category = Category::where('slug', $request->input('category_slug'))->first();
            if ($category) {
                $query->whereIn('id', function ($subQuery) use ($category) {
                    $subQuery->select('brand_id')
                        ->from('products')
                        ->where('category_id', $category->id);
                });
            }
        }else if($request->has('sub_category_slug')){
            $sub_category = SubCategory::where('slug', $request->input('sub_category_slug'))->first();
            if ($sub_category) {
                $query->whereIn('id', function ($subQuery) use ($sub_category) {
                    $subQuery->select('brand_id')
                        ->from('products')
                        ->where('sub_category_id', $sub_category->id);
                });
            }
        }
        $brands=$query->get();
        return $this->responsePagination($brands, BrandResource::collection($brands));
    }
    
}
