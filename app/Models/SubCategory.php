<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    use HasFactory,HasTranslations,SoftDeletes;

    protected $guarded=['id'];
    public $translatable = ['name'];
    protected $table = 'sub_categories'; // Agar jadval nomi `subcategories` bo‘lmasa

    public function recommendedSubcategories(): BelongsToMany
    {
        return $this->belongsToMany(
            Subcategory::class,
            'recommended_sub_categories',
            'parent_id',
            'child_id'
        )->where('sub_categories.id', '!=', $this->id);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function sub_sub_category(){
        return $this->hasMany(SubSubCategory::class);
    }
    public function product(){
        return $this->hasMany(Product::class,'sub_category_id','id');
    }
    public function getProductsCountAttribute()
    {
        return $this->product()->count();
    }
    protected $casts = [
        'name' => 'array',
    ];
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($sub_category) {
            $baseSlug = Str::slug($sub_category->getTranslation('name', 'ru'));
            $slug = $baseSlug;
            $count = 1;

            // Agar slug takrorlangan bo‘lsa, yangisini yaratamiz
            while (static::where('slug', $slug)->where('id', '!=', $sub_category->id)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }

            $sub_category->slug = $slug;
        });
    }
}
