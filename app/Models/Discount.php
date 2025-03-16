<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Discount extends Model
{
    use HasFactory,HasTranslations,SoftDeletes;
    protected $fillable = ['name', 'photo', 'deadline'];
    public $translatable = ['name'];

    protected $casts = [
        'name' => 'array',
    ];

    // discountr_product
    public function discountProducts()
    {
        return $this->hasMany(DiscountProduct::class);
    }
    // active discount
    public function scopeActive($query)
    {
        return $query->where('deadline', '>', now()); // Deadline muddati o'tmagan chegirmalar
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'discount_products', 'discount_id', 'product_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($discount) {
            $baseSlug = Str::slug($discount->getTranslation('name', 'ru'));
            $slug = $baseSlug;
            $count = 1;

            // Agar slug takrorlangan bo‘lsa, yangisini yaratamiz
            while (static::where('slug', $slug)->where('id', '!=', $discount->id)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }

            $discount->slug = $slug;
        });
    }
}
