<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    
    protected $casts = [
        'name' => 'array', // Important for Array type
    ];
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_days');
    }
    
}
