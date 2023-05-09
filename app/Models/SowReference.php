<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\SowSubCategory;

class SowReference extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subCategory()
    {
        return $this->belongsTo(SowSubCategory::class, 'sow_sub_category_id', 'id');
    }

    public function parentSubCategory()
    {
        return $this->belongsTo(SowSubCategory::class, 'parent_sow_sub_category_id', 'id');
    }
}
