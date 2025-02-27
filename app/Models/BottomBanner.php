<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class BottomBanner extends Model
{
    use HasFactory,HasTranslations,SoftDeletes;

    protected $guarded=['id'];
    public $translatable = ['header','text'];
    protected $casts = [
        'header' => 'array',
        'text' => 'array',
    ];
}
