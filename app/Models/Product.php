<?php

namespace App\Models;

use GalleryJsonMedia\JsonMedia\Concerns\InteractWithMedia;
use GalleryJsonMedia\JsonMedia\Contracts\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Product extends Model 
{
    
    use HasFactory,HasFactory,HasTranslations,SoftDeletes;

    protected $guarded=['id'];
    protected $casts =[
        'photos' => 'array',
        'name' => 'array',
        'description' => 'array',
    ];
    public $translatable=['name','description'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function commentProducts()
    {
        return $this->hasMany(CommentProduct::class);
    }

    public function getAverageRatingAttribute()
    {
        $rating= $this->commentProducts()->avg('rating') ?? 0;
        return round($rating,1);
    } 

    protected $appends = ['average_rating'];
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            $baseSlug = Str::slug($product->getTranslation('name', 'ru'));
            $slug = $baseSlug;
            $count = 1;

            // Agar slug takrorlangan bo‘lsa, yangisini yaratamiz
            while (static::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }

            $product->slug = $slug;
        });
    }
    public function activeDiscount()
    {
        return $this->belongsToMany(Discount::class, 'discount_products', 'products_id', 'discount_id')
            ->where('deadline', '>', now());
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_products', 'products_id', 'discount_id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function sub_sub_category()
    {
        return $this->belongsTo(SubSubCategory::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function product_attribute()
    {
        return $this->hasMany(ProductAttribute::class);
    }
    public function product_color_photo()
    {
        return $this->hasMany(ProductColorPhoto::class);
    }

    
}
