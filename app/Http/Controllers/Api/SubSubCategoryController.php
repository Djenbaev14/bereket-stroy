<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubSubCategoryResource;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;

class SubSubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $sub_category_slug= $request->input("sub_category_slug");
        $category_slug= $request->input("category_slug");
        $sub_sub_categories=SubSubCategory::whereHas('category', function ($query) use($category_slug) {
            $query->where('slug', $category_slug);
        })->whereHas('sub_category', function ($query) use($sub_category_slug) {
            $query->where('slug', $sub_category_slug);
        })->orderBy('priority','desc')->get();
        return $this->responsePagination($sub_sub_categories, SubSubCategoryResource::collection($sub_sub_categories));
    }
}
