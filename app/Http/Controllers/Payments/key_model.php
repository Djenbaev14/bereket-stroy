<?php
    $order = \App\Models\Order::find($key);
if (!$order) {
    return null;
}
return $order;