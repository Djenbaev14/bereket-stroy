<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class SubSubCategory extends Model
{
    use HasFactory,HasTranslations,SoftDeletes;

    protected $guarded=['id'];
    public $translatable = ['name'];
    protected $casts = [
        'name' => 'array',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function sub_category(){
        return $this->belongsTo(SubCategory::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($sub_sub_category) {
            $baseSlug = Str::slug($sub_sub_category->getTranslation('name', 'ru'));
            $slug = $baseSlug;
            $count = 1;

            // Agar slug takrorlangan bo‘lsa, yangisini yaratamiz
            while (static::where('slug', $slug)->where('id', '!=', $sub_sub_category->id)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }

            $sub_sub_category->slug = $slug;
        });
    }
}
