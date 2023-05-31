<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\DupaContent;
use App\Models\UnitOfMeasurement;
use App\Models\DupaCategory;
use App\Models\ProjectNature;
use App\Models\TakeOffTable;
use App\Models\Formula;

class Dupa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'subcategory_id',
        'item_number',
        'description',
        'unit_id',
        'category_dupa_id',
        'output_per_hour',
    ];

    public function dupaContent(){
        return $this->hasOne(DupaContent::class);
    }

    public function measures(){
        return $this->belongsTo(UnitOfMeasurement::class);
    }

    public function takeOffTable(){
        return $this->hasMany(TakeOffTable::class, 'id');
    }

    public function dupaFormula(){
        return $this->hasManyThrough(
            Formula::class,
            UnitOfMeasurement::class,

        );
    }



}
