<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Dupa;
use App\Models\TakeOffTableFields;

class UnitOfMeasurement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function dupa(){
        return $this->belongsTo(Dupa::class);
    }

    public function tableField(){
        return $this->hasMany(TakeOffTableFields::class, 'measurement_id', 'id');
    }
}
