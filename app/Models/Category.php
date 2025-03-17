<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory,HasTranslations,SoftDeletes;

    protected $guarded=['id'];
    public $translatable = ['name'];

    protected $casts = [
        'name' => 'array',
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            $baseSlug = Str::slug($category->getTranslation('name', 'ru'));
            $slug = $baseSlug;
            $count = 1;

            // Agar slug takrorlangan bo‘lsa, yangisini yaratamiz
            while (static::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }

            $category->slug = $slug;
            
            if (!$category->photo) {
                $category->photo = "categories/01JPFKGV7A6021BBTWQK7GPQHP.jpg"; // Standart rasm URL
            }
        });
    }

    
    // category_translatable relationship
    public function products(){
        return $this->hasMany(Product::class);
    }
    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }
    public function sub_category(){
        return $this->hasMany(SubCategory::class);
    }
}
