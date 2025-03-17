<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\CommentProduct;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request){
        $comments = CommentProduct::query();

        if($request->has("product_id")){
            $comments->where("product_id", $request->input("product_id"));
        }
        $comments=$comments->orderBy('created_at','desc')->get();         
        return $this->responsePagination($comments, CommentResource::collection($comments));
    }

    public function store(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        if($request->has('photo')){$request->validate([
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);
        }
        $user = auth()->user();
        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('comments', 'public');
        }
        $comment = CommentProduct::create([
            "customer_id"=> $user->id,
            "product_id"=> $request->input("product_id"),
            "comment"=> $request->input("comment"),
            'rating' => $request->input('rating'),
            'photo' => $photoPath,
        ]);
        return response()->json([
            "message"=> "Comment created successfully",
            "data"=> $comment
        ]);
    }
   

}
