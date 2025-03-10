<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentType;
use DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(){
        $orders = Order::where('customer_id',auth()->user()->id)->orderBy("created_at","desc")->paginate(10);
        
        return $this->responsePagination($orders, OrderResource::collection($orders));
    }
    public function store(Request $orderRequest){

        $order=Order::create([
            'customer_id'=>auth()->user()->id,
            'receiver_name' => $orderRequest->receiver_name,
            'receiver_phone' => $orderRequest->receiver_phone,
            'receiver_comment' => $orderRequest->receiver_comment,
    
            'delivery_method_id' => $orderRequest->delivery_method_id,
            'branch_id' => $orderRequest->branch_id,
    
            'region' => $orderRequest->region,
            'district' => $orderRequest->district,
            'address' => $orderRequest->address,
            'latitude' => $orderRequest->latitude,
            'longitude' => $orderRequest->longitude,
    
            'payment_type_id'=>PaymentType::where('key',$orderRequest->payment_type)->first()->id,
            'order_status_id'=>1,
            'total_amount' => 0, // vaqtincha
    
            'comment'=>$orderRequest->comment
        ]);
        

        // order items
        foreach ($orderRequest->products as $item) {
            $order->OrderItems()->create([
                "customer_id"=>auth()->user()->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        
        $order->update(['total_amount' => $order->calculateTotalAmount()]);
        if($orderRequest->payment_type=='payme'){
            $url="https://bereket.webclub.uz/pay/{$orderRequest->payment_type}/{$order->id}/{$order->total_amount}";
            return response()->json(['message' => 'Order created successfully','url'=>$url], 201);
        }
        return response()->json(['message' => 'Order created successfully'], 201);

    }

    // public function pay(Request $request){
    //     $request->validate([
    //         'order_id' => 'required|exists:orders,id',
    //         'pay_system'=>'required|in:payme',
    //     ]);
    //     $order=Order::find($request->order_id);
    //     if($order->order_status_id=3){
    //         return response()->json(['message' => 'Order already paid'], 400);
    //     }

    //     $url = "https://bereket.webclub.uz/pay/{$request->pay_system}/{$order->id}/{$order->total_amount}";

    //     $data = [
    //         'status'=>'success',
    //         'message'=>'Operation successful',
    //         'data'=>[
    //             'url'=>$url
    //         ],
    //         'pagination'=>null
    //     ];

    //     return response()->json($data);
    // }
}
