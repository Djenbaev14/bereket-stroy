<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentProduct extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function getPhotoAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}
