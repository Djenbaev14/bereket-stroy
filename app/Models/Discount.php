<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Discount extends Model
{
    use HasFactory,HasTranslations,SoftDeletes;
    protected $guarded=['id'];
    public $translatable = ['name'];

    protected $casts = [
        'name' => 'array',
    ];

    // discountr_product
    public function discount_product()
    {
        return $this->hasMany(DiscountProduct::class);
    }
    // active discount
    
    
    public function discount_type()
    {
        return $this->belongsTo(DiscountType::class, 'discount_type_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'discount_products', 'discount_id', 'products_id');
    }
}
