<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($order) {
    //         $latestOrder = Order::latest()->first();
    //         $nextId = $latestOrder ? intval(substr($latestOrder->order_id, -6)) + 1 : 1;
    //         $order->order_id = str_pad($nextId, 6, '0', STR_PAD_LEFT);
    //     });
    // }
}
