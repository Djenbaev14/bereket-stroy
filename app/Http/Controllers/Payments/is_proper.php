<?php
try {
    if ($model->total_amount == $amount) {
        Log::info('To‘lov miqdori mos keldi', [
            'model_id' => $model->id,
            'amount' => $amount
        ]);
        return true;
    }

    Log::warning('To‘lov miqdori mos kelmadi', [
        'model_id' => $model->id,
        'order_amount' => $model->total_amount,
        'request_amount' => $amount
    ]);

    return false;
} catch (\Exception $e) {
    Log::error('To‘lovni tekshirishda xatolik yuz berdi', [
        'message' => $e->getMessage(),
        'model_id' => $model->id ?? null,
        'amount' => $amount
    ]);

    return false;
}