<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
// use Spatie\Translatable\HasTranslations;

class Brand extends Model
{
    use HasFactory,HasTranslations,SoftDeletes;

    protected $guarded=['id'];

    public $translatable = ['name'];

    protected $casts = [
        'name' => 'array',
    ];
}
