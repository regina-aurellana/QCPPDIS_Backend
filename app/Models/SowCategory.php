<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\SowSubCategory;
use App\Models\TakeOffTable;

class SowCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'item_code',
        'name',
    ];

    public function sowSubCategory(){
        return $this->hasMany(SowSubCategory::class, 'sow_category_id', 'id');
    }

    public function takeOffTable(){
        return $this->hasMany(TakeOffTable::class, 'id');
    }


}
