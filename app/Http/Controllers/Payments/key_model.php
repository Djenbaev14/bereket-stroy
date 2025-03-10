<?php
    $order = \App\Models\Order::find($key);
if (!$order) {
    Log::warning('Order topilmadi', ['key' => $key]);
    return null;
}
return $order;