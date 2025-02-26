<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Log;

class Customer extends Authenticatable
{
    use HasFactory,SoftDeletes,HasApiTokens,Notifiable;

    protected $guarded=['id'];

    // Jismoniy shaxslar
    public function scopeIndividuals($query)
    {
        return $query->where('is_legal', false);
    }

    // Yuridik shaxslar
    public function scopeLegals($query)
    {
        return $query->where('is_legal', true);
    }

}
