<?php

        use App\Models\PaymentStatus;
        use App\Models\Order;
        
        $model->payment_status_id = PaymentStatus::where('type','=','refunded')->first()->id;
        $model->order_status_id = Order::where('status','=','cancelled')->first()->id;
        $model->save();