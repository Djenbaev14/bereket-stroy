<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Day extends Model
{
    use HasFactory,HasTranslations;
    protected $guarded=['id'];
    public $translatable = ['name'];
    
    protected $casts = [
        'name' => 'array', // Important for Array type
    ];
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_days');
    }
    
}
