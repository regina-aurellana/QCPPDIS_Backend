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




    public function subCatReference()
    {
        return $this->hasMany(SubCatReference::class, 'subcat_id', 'id');
    }

    public function descendants()
    {
        return $this->subCatReference()->with('parentSubCategory')->with('descendants');
    }

    public function references(){
        return $this->hasMany(SubCatReference::class, 'sow_subcat_id', 'id');
    }

    // public function parentSubcategory(){
    //     return $this->belongsTo(SowSubCategory::class, 'parent_id', 'id');
    // }

    // public function childSubcategories(){
    //     return $this->hasMany(SowSubCategory::class, 'parent_id', 'id');
    // }

    // public function subcatDescendantsss(){
    //     return $this->hasOne(SubCatReference::class, 'sow_subcat_id', 'id')->with(SowSubCategory::class);
    // }



//     public function subCatReference()
// {
//     return $this->hasOne(SubCatReference::class, 'sow_subcat_id', 'id');
// }

// public function subcatDescendants()
// {
//     return $this->hasManyThrough(
//         SowSubCategory::class,
//         SubCatReference::class,
//         'parent_id', // Foreign key on the SubCatReference table
//         'id', // Local key on the SowSubCategory table
//         'id', // Primary key on the SubCatReference table
//         'sow_subcat_id' // Foreign key on the SowSubCategory table
//     )->with('subCatReference');
// }



    public function dupa(){
        return $this->hasMany(Dupa::class, 'subcategory_id', 'id');
    }



}
