<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubCategoryResource;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category_slug= $request->input("category_slug");
        $sub_categories=SubCategory::whereHas('category', function ($query) use($category_slug) {
                    $query->where('slug', $category_slug);
                })->orderBy('priority','desc')->get();
        return $this->responsePagination($sub_categories, SubCategoryResource::collection($sub_categories));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show($slug,Request $request)
    {
        $category_slug = $request->input('category_slug');
        $sub_category= SubCategory::where('slug',$slug)->whereHas('category', function ($query) use($category_slug) {
            $query->where('slug', $category_slug);
        })->firstOrFail();
        return $this->responsePagination($sub_category, new SubCategoryResource($sub_category));
        // return new SubCategoryResource(SubCategory::whereHas('category', function ($query) use($category_slug) {
        //     return $query->where('slug', '=', $category_slug);
        // })->where('slug',$slug)->firstOrFail());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
