<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\B3Projects;

class TakeOffTable extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function takeOff(){
        return $this->belongsTo(TakeOff::class, 'id');
    }

    public function takeOffTableField(){
        return $this->hasMany(TakeOffTableFields::class, 'take_off_table_id', 'id');
    }


}
