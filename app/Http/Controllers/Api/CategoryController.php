<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SubCategoryResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::with('sub_category.sub_sub_category')->orderBy('priority','desc')->get();
        return $this->responsePagination($categories, CategoryResource::collection($categories));
    }
    public function show(string $slug)
    {
        $category = Category::where('slug',$slug)->firstOrFail();
        return $this->responsePagination($category, new CategoryResource($category));
    }
}
