<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderStatusResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\PaymentType;
use App\Models\Product;
use DB;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request){
        $query=Order::where('customer_id',auth()->user()->id);
        if($request->has('order_status_id')){
            $query=$query->where('order_status_id',$request->order_status_id);
        }
        $orders=$query->paginate(10);
        return $this->responsePagination($orders, OrderResource::collection($orders));
    }
    public function store(Request $orderRequest){

        try {
            $orderRequest->validate([
                'receiver_name' => 'required|string',
                'receiver_phone' => 'required|string',
                'receiver_comment' => 'nullable|string',
                'payment_type'=>'required',
                'products'=>'required|array',
                'products.*.product_id'=>'required|exists:products,id',
                'products.*.quantity'=>'required|integer',
                'delivery_method_id'=>'required|exists:delivery_methods,id',
            ]);
            if($orderRequest->has('delivery_method_id') && $orderRequest->delivery_method_id == 1){
                $orderRequest->validate([
                    'branch_id'=>'required|exists:branches,id'
                ]);
            }else if($orderRequest->has('delivery_method_id') && $orderRequest->delivery_method_id == 2){
                $orderRequest->validate([
                    'region'=>'required|string',
                    'district'=>'required|string',
                    'address'=>'required|string',
                    'latitude'=>'required|string',
                    'longitude'=>'required|string',
                ]);
            }
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
                'location' => [$orderRequest->latitude,$orderRequest->longitude],
        
                'payment_type_id'=>PaymentType::where('key',$orderRequest->payment_type)->first()->id,
                'order_status_id'=>1,
                'payment_status_id'=>1,
                'total_amount' => 0, // vaqtincha
        
                'comment'=>$orderRequest->comment
            ]);
            

            // order items
            foreach ($orderRequest->products as $item) {
                $order->OrderItems()->create([
                    "customer_id"=>auth()->user()->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => Product::find($item['product_id'])->getDiscountedPriceAttribute(),
                ]);
            }

            $message=[
                'en'=>'Order created successfully',
                'uz'=>'Buyurtma muvaffaqiyatli yaratildi',
                'ru'=>'Заказ успешно создан',
                'qr'=>'Buyırtpa tabıslı jaratıldı'
            ];
            
            $order->update(['total_amount' => $order->calculateTotalAmount()]);
            
            if($orderRequest->payment_type=='payme'){
                $url="https://bereket.webclub.uz/pay/{$orderRequest->payment_type}/{$order->id}/{$order->total_amount}";
                return response()->json(['message' => $message,'url'=>$url], 201);
            }else if($orderRequest->payment_type=='click'){
                $url="https://bereket.webclub.uz/pay/{$orderRequest->payment_type}/{$order->id}/{$order->total_amount}";
                return response()->json(['message' => $message,'url'=>$url], 201);
            }else{
                return response()->json(['message' => $message,'url'=>''], 201);
            }
        } catch (Exception  $e) {

            return response()->json([
                'success' => false,
                'message' => [
                    'uz'=>'Buyurtma yaratishda xatolik!',
                    'en'=>'Error creating order!',
                    'ru'=>'Ошибка создания заказа!',
                    'qr'=>'Buyırtpa jaratıwda qátelik!'
                ],
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function orderStatus()  {
        $orderStatuses = OrderStatus::get();
        
        return $this->responsePagination($orderStatuses, OrderStatusResource::collection($orderStatuses));
    }

    public function orderCancelled(Request $request,$id){
        $order = Order::find($id);
        if ($order) {
            if($order->order_status_id==1){
                $order->update([
                    'order_status_id'=>Order::where('status','=','cancelled')->first()->id,
                    'payment_status_id'=>PaymentStatus::where('type','=','failed')->first()->id,
                ]);

                return response()->json(['message' => [
                    'uz'=>'№'.$order->id.' buyurtma bekor qilindi',
                    'en'=>'Orde №'.$order->id.' canceled',
                    'ru'=>'Заказ №'.$order->id.' отменен',
                    'qr'=>'№'.$order->id.' buyırtpa biykarlandı'
                ]], 200);
            }else{
                return response()->json(['message' => [
                    'en'=>'Cannot cancel order',
                    'uz'=>'Buyurtmani bekor qilish imkonsiz',
                    'ru'=>'Невозможно отменить заказ',
                    'qr'=>'Buyırtpanı biykarlawǵa bolmaydı'
                ]], 404);
            }
        }
        
        return response()->json(['message' => [
            'en'=>'Order not found',
            'uz'=>'Buyurtma topilmadi',
            'ru'=>'Заказ не найден',
            'qr'=>'Buyırtpa tabılmadı'
        ]], 404);
    }
}
