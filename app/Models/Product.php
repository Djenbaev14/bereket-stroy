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
    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_products', 'products_id', 'discount_id');
    }
    public function cards()
    {
        return $this->belongsToMany(Card::class, 'card_products', 'product_id', 'card_id');
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
    public function recommendedProducts()
    {
        return Product::whereIn('sub_category_id', function ($query) {
            $query->select('child_id')
                ->from('recommended_sub_categories')
                ->where('parent_id', $this->sub_category_id)
                ->where('child_id','!=',$this->sub_category_id);
        })
        ->orderBy('views','desc')
        ->get()
        ->groupBy('sub_category_id') // Har bir sub_category bo‘yicha guruhlash
        ->map(function ($products) {
            return $products->take(2); // Har bir sub_category uchun faqat 2 tadan olish
        })
        ->collapse()
        ->take(10); // Guruhlangan natijalarni tekis (flatten) qilish;
    }
    public function getAverageRatingAttribute()
    {
        $rating= $this->commentProducts()->avg('rating') ?? 0;
        return round($rating,1);
    } 
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
    public function discounted_price()
    {
        return $this->hasOne(Discount::class);
    }
    public function getDiscountedPriceAttribute()
    {
        $activeDiscount = $this->activeDiscount()->first(); // Funksiya chaqirish kerak
        if ($activeDiscount) {
            $discountType = $activeDiscount->discount_type;
            $discountAmount = $activeDiscount->discount_amount;
            if ($discountType && $discountType->discount_type == 'UZS') {
                return $this->price - $discountAmount;
            } else {
                return round((100 - $discountAmount) * $this->price / 100);
            }
        }
        return $this->price;
    }
    public function getDiscountPercentageAttribute()
    {
        $discount = $this->activeDiscount->first();

        if (!$discount) {
            return 0; // Agar chegirma yo‘q bo‘lsa, 0%
        }

        if ($discount->discount_type_id == 1) {
            return $discount->discount_amount; // Agar foiz bo‘lsa, to‘g‘ridan-to‘g‘ri qaytaramiz
        }

        if ($discount->discount_type_id == 2 && $this->price > 0) {
            return ($discount->discount_amount / $this->price) * 100; // Fiksatsiyalangan chegirmani foizga aylantiramiz
        }
        return 0; // Aks holda 0 qaytaramiz
    }
}
