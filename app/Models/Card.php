<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Card extends Model
{
    use HasFactory,HasTranslations,SoftDeletes;

    protected $guarded=['id'];
    public $translatable = ['name'];

    public $casts=[
        'name'=>'array'
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'card_products', 'card_id', 'product_id');
    }
}
