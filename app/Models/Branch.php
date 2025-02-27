<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Branch extends Model
{
    use HasFactory,HasTranslations;
    protected $guarded=['id'];
    
    public $translatable = ['branch_name','street'];
    protected $casts = [
        'point_array' => 'array', // Important for Array type
        'branch_name' => 'array', // Important for Array type
        'street' => 'array', // Important for Array type
    ];

    public function days()
    {
        return $this->belongsToMany(Day::class, 'branch_days');
    }
    
}
