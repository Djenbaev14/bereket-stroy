<?php
try {
    if ($model->total_amount * 100 == $amount) {
        return true;
    }

    return false;
} catch (\Exception $e) {
    return false;
}