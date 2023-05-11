<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakeOff extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function b3Projects(){
        return $this->belongsTo(B3Projects::class, 'id');
    }

    public function takeOffTable(){
        return $this->hasMany(TakeOffTable::class, 'take_off_id', 'id');
    }
}
