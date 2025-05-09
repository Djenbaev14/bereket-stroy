<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class DeliveryMethod extends Model
{
    use HasFactory,HasTranslations;

    protected $guarded=["id"];
    
    protected $translatable=['name'];

    protected $casts = [
        'name' => 'array',
    ];
}
