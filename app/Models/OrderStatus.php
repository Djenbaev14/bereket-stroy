<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class OrderStatus extends Model
{
    use HasFactory,HasTranslations;

    protected $guarded = ['id'];
    protected $translatable = ['name'];

    // casts
    protected $casts = [
        'name' => 'array',
    ];
}
