<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TakeOffTable;
use App\Models\TakeOffTableField;
use App\Models\TakeOffTableFieldsInput;
use App\Models\UnitOfMeasurement;

class TakeOffTableFields extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function takeOffTable(){
        return $this->belongsTo(TakeOffTable::class);
    }

    public function measurement(){
        return $this->belongsTo(UnitOfMeasurement::class);
    }

    public function takeOffTableFieldInput(){
        return $this->hasMany(TakeOffTableFieldsInput::class);
    }
}
