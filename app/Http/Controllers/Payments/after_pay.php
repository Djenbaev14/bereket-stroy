<?php

        use App\Models\PaymentStatus;
        use App\Models\Order;
        use App\Models\Product;
        foreach($model->items as $item){
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('sales_count', $item->quantity);
            }
        }
        
        $model->payment_status_id = PaymentStatus::where('type','=','paid')->first()->id;
        $model->order_status_id = Order::where('status','=','confirmed')->first()->id;
        $model->save();