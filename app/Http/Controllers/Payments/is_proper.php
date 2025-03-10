<?php
try {
    if ($model->total_amount == $amount) {
        return true;
    }


    return false;
} catch (\Exception $e) {

    return false;
}