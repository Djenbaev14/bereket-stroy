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
        $comments=$comments->get();         
        return $this->responsePagination($comments, CommentResource::collection($comments));

    }

    public function store(Request $request){
        $user = auth()->user();
        $comment = CommentProduct::create([
            "customer_id"=> $user->id,
            "product_id"=> $request->input("product_id"),
            "comment"=> $request->input("comment"),
            'rating' => $request->input('rating')
        ]);
        return response()->json([
            "message"=> "Comment created successfully",
            "comment"=> $comment
        ]);
    }
   

}
