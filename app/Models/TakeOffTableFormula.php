<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\TakeOffTable;

class TakeOffTableFormula extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function takeOffTable(){
        return $this->belongsTo(TakeOffTable::class, 'id');
    }
}
