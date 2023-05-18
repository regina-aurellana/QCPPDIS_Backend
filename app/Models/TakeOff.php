<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\B3Projects;
use App\Models\TakeOffTable;
use App\Models\TakeOffTableFormula;

class TakeOff extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function b3Projects(){
        return $this->belongsTo(B3Projects::class, 'id');
    }

    public function takeOffTable(){
        return $this->hasMany(TakeOffTable::class, 'take_off_id', 'id');
    }

    public function takeOffTableFormula(){
        return $this->hasMany(TakeOffTableFormula::class, 'take_off_table_id');
    }
}
