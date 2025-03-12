<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecommendedSubCategory extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    protected $table = 'recommended_sub_categories';

    public function parentSubcategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'parent_id');
    }

    public function childSubcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'child_id');
    }
}
