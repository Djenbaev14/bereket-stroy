<?php
        use App\Models\PaymentStatus;
        
        $model->payment_status_id = PaymentStatus::where('type','=','processing')->first()->id;
        $model->save();