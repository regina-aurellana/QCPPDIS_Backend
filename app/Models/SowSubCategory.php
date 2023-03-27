<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\SowCategory;
use App\Models\Dupa;
use App\Models\SubCatReference;

class SowSubCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'item_code',
        'name',
        'sow_cat_id',
    ];

    public function sowCategory(){
        return $this->belongsTo(SowCategory::class);
    }
    public function dupa(){
        return $this->hasMany(Dupa::class, 'subcategory_id', 'id');
    }
    public function subCatReference(){
        return $this->hasMany(SubCatReference::class, 'sow_subcat_id', 'id');
    }
    public function subCatReferenceParent(){
        return $this->hasMany(SubCatReference::class, 'parent', 'id');
    }


}
