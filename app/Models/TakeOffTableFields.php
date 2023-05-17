<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\TakeOffTable;
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
        return $this->belongsTo(UnitOfMeasurement::class, 'id');
    }

    public function takeOffTableFieldInput(){
        return $this->belongsTo(TakeOffTableFieldsInput::class);
    }
}
