<?php

        use App\Models\PaymentStatus;
        use App\Models\Order;
        
        $model->payment_status_id = PaymentStatus::where('type','=','paid')->first()->id;
        $model->order_status_id = Order::where('status','=','confirmed')->first()->id;
        $model->save();