<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\B3Projects;
use App\Models\TakeOff;
use App\Models\TakeOffTableFields;
use App\Models\TakeOffTableFormula;
use App\Models\Dupa;
use App\Models\SowCategory;
use App\Models\UnitOfMeasurement;
use App\Models\Mark;

class TakeOffTable extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function takeOff(){
        return $this->belongsTo(TakeOff::class, 'id');
    }

    public function takeOffTableField(){
        return $this->hasMany(TakeOffTableFields::class, 'take_off_table_id', 'id');
    }

    public function dupa(){
        return $this->belongsTo(Dupa::class);
    }

    public function sowCategory(){
        return $this->belongsTo(SowCategory::class);
    }

    public function measurementResult(){
        return $this->belongsTo(UnitOfMeasurement::class, 'table_row_result_field_id');
    }

    public function takeOffTableFormula(){
        return $this->hasMany(TakeOffTableFormula::class);
    }

    public function mark(){
        return $this->hasMany(Mark::class, 'take_off_table_id');
    }




}
