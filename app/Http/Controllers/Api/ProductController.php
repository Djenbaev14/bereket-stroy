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
        $query = Product::with(['brand','activeDiscount','country']);

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
        if ($request->has('brand_ids')) {
            $brandIds = $request->input('brand_ids'); // Array formatda kelishi kerak
            $query->whereIn('brand_id', $brandIds);
        }
        if ($request->has('country_ids')) {
            $countryIds = $request->input('country_ids'); // Array formatda kelishi kerak
            $query->whereIn('country_id', $countryIds);
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

        
        if ($request->has('pagination')) {
            $pagination = $request->input('pagination'); // Array formatda kelishi kerak
            $products=$query->paginate($pagination);
        }else{
            $products=$query->paginate(12);
        }
        
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

        $products=$query->take(10)->get();
        return $this->responsePagination($products, ProductSearchResource::collection($products));
        
    }

    public function similarProducts($slug){
        $product = Product::where('slug','=',$slug)->firstOrFail();
        return $this->responsePagination($product->recommendedProducts(), ProductResource::collection($product->recommendedProducts()));
    }

    public function bestOffers(){
        $products = Product::with(['brand','activeDiscount']) // Eager load qilish
            ->where('is_active', true)
            ->get();
            
            
        $bestOffers = $products->sortByDesc(function ($product) {
            $discount = $product->discount_percentage; // Discountni olish
            $rating = $product->average_rating; // O'rtacha reytingni olish

            return ($product->sales_count * 2) + 
                ($product->views * 1.5) + 
                ($discount * 3) + 
                ($rating * 5);
        })->take(20);
        
        return $this->responsePagination($bestOffers, ProductResource::collection($bestOffers));
    }
}
