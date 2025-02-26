<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountProduct extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded=['id'];

    public function product()
    {
        return $this->belongsTo(Product::class,'products_id');
    }
    public function discount()
    {
        return $this->belongsTo(Discount::class,'discount_id');
    }
}
