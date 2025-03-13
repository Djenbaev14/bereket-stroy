<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductSearchResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mahsulotlarni olish va filtrlash
        $query = Product::with(['brand','activeDiscount']);

        if($request->has('category_slug')){
            $category_slug= $request->category_slug;
            $query->whereHas('category', function ($q) use($category_slug) {
            $q->where('slug', $category_slug);
            });
        }
        if($request->has('sub_category_slug')){
            $sub_category_slug= $request->sub_category_slug;
            $query->whereHas('sub_category', function ($q) use($sub_category_slug) {
            $q->where('slug', $sub_category_slug);
            });
        }
        if($request->has('sub_sub_category_slug')){
            $sub_sub_category_slug= $request->sub_sub_category_slug;
            $query->whereHas('sub_sub_category', function ($q) use($sub_sub_category_slug) {
            $q->where('slug', $sub_sub_category_slug);
            });
        }


        // ✅ Name bo‘yicha izlash (3 tilda)
        if ($request->has('slug')) {
            $slug = $request->input('slug');
            $product = Product::where('slug', $slug)->firstOrFail();
            $product->increment('views');
            $query->where('slug', $slug);
        }

        // ✅ Minimal va maksimal narx bo‘yicha filtrlash
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }
        // ✅ Brend bo‘yicha filtrlash
        if ($request->has('brand_id')) {
            $query->where('brand_id', $request->input('brand_id'));
        }

        // ✅ Ustunlar bo‘yicha tartiblash (default: `id desc`)
        if ($request->has('sort_by')) {
            if($request->input('sort_by') == 'popular'){
                $query->orderBy('sales_count', 'desc');
            }else if($request->input('sort_by') == 'rating'){
                $query->withAvg('commentProducts', 'rating')->orderBy('comment_products_avg_rating', 'desc');
            }else if($request->input('sort_by') == 'price'){
                $query->orderBy('price', 'asc');
            }else if($request->input('sort_by') == '-price'){
                $query->orderBy('price', 'desc');
            }
        } else {
            $query->orderBy('id', 'desc');
        }
        $products=$query->paginate(12);
        
        return $this->responsePagination($products, ProductResource::collection($products));

    }

    public function search(Request $request){
        $query = Product::query();
        if ($request->has('name')) {
            $search = $request->input('name');
            $query->where(function ($q) use ($search) {
                $q->where(DB::raw("CAST(name->>'$.uz' AS CHAR)"), 'like', "%{$search}%")
                  ->orWhere(DB::raw("CAST(name->>'$.qr' AS CHAR)"), 'like', "%{$search}%")
                  ->orWhere(DB::raw("CAST(name->>'$.ru' AS CHAR)"), 'like', "%{$search}%")
                  ->orWhere(DB::raw("CAST(name->>'$.en' AS CHAR)"), 'like', "%{$search}%");
            });
        }

        $products=$query->paginate(12);
        return $this->responsePagination($products, ProductSearchResource::collection($products));
        
    }

    public function similarProducts($slug){
        $product = Product::where('slug','=',$slug)->firstOrFail();
        return $this->responsePagination($product->recommendedProducts(), ProductResource::collection($product->recommendedProducts()));
    }
}
