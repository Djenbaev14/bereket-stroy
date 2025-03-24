<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PaymentType extends Model
{
    use HasFactory,HasTranslations;
    protected $guarded=["id"];
    
    
    public $translatable=['name','text'];
    protected $casts = [
        'name' => 'array',
        'text' => 'array',
    ];
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
