<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'location' => 'array', // Important for Array type
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function delivery_method()
    {
        return $this->belongsTo(DeliveryMethod::class);
    }
    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }
    public function payment_status()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }
    public function OrderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    public function calculateTotalAmount()
    {
        return $this->OrderItems->sum(function ($OrderItem) {
            return $OrderItem->quantity * $OrderItem->price;
        });
    }
    // Statuslarni enum sifatida belgilash (ixtiyoriy)
    public function getNextStatusId(): ?int
    {
        $statusOrder = [
            1 => 2, // pending -> confirmed
            2 => 3, // confirmed -> delivered
            3 => null, // delivered -> oxirgi status
            4 => null, // cancelled -> oxirgi status
        ];

        return $statusOrder[$this->order_status_id] ?? null;
    }
    public function getNextPaymentStatusId(): ?int
    {
        $statusPayment = [
            1 => 3, 
            2 => 3, 
            3 => null, // paid -> oxirgi status
            4 => null, // failed -> oxirgi status
            5 => null, // refunded -> oxirgi status
        ];

        return $statusPayment[$this->payment_status_id] ?? null;
    }
    
}
