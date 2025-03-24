<?php

namespace App\Models;

use Carbon\Carbon;
use GalleryJsonMedia\JsonMedia\Concerns\InteractWithMedia;
use GalleryJsonMedia\JsonMedia\Contracts\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
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
        return $this->belongsToMany(Discount::class, 'discount_products', 'product_id', 'discount_id');
    }
    public function discountProducts()
    {
        return $this->hasMany(DiscountProduct::class);
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
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class); // OrderItem modeliga moslashtiring
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
    protected $appends = ['status'];

    public function getStatusAttribute()
    {
        $isNew = $this->created_at->diffInDays(Carbon::now()) <= 7;
        if (!$isNew) {
            return null;
        }

        $locale = App::getLocale(); // Joriy tilni olish
        $translations = [
            'uz' => 'yangi',
            'en' => 'new',
            'ru' => 'новый',
            'qr' => 'jańa',
        ];

        return $translations[$locale] ?? $translations['ru']; // Agar til topilmasa, 'en' qaytadi
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
                if (!$product->photos) {
                    $product->photos = ["products/01JPCZEH4R94QK6JB5TAMTQBWG.png"]; // Standart rasm URL
                }
        });
    }
    public function activeDiscount()
    {
        return $this->hasOne(DiscountProduct::class, 'product_id', 'id')
            ->whereHas('discount', function ($query) {
                $query->where('deadline', '>=', now()); // ⏳ Muddati o‘tmagan
            });
    }
    public function getDiscountedPriceAttribute()
    {
        if ($this->activeDiscount) {
            return $this->activeDiscount->discounted_price;
        }
        return $this->price;
    }
    public function getDiscountAttribute()
    {
        if ($this->activeDiscount) {
            return $this->price-$this->activeDiscount->discounted_price;
        }
        return 0;
    }
    public function getDiscountPercentageAttribute()
    {
        if ($this->activeDiscount) {
            return ($this->price - $this->activeDiscount->discounted_price / $this->price) * 100; 
        }
        return 0;
        
    }
}
