<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\SowSubCategory;

class SubCatReference extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'sow_subcat_id',
        'parent_id',
    ];

    public function sowSubCategory(){
        return $this->belongsTo(SowSubCategory::class);
    }

    public function parent(){
        return $this->sowSubCategory()->with('parent');
    }
}
