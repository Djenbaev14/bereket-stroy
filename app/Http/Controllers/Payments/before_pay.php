<?php
        $model->order_status_id = 2;
        $model->save();
        $orderItems = App\Models\OrderItem::where('order_id', $model->id)->get();

        foreach ($orderItems as $item) {
            App\Models\Product::where('id', $item->product_id)
                ->increment('sales_count', $item->quantity);
        }