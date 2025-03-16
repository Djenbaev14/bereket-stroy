<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountProduct extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'discount_id',
        'product_id',
        'price',
        'discounted_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
