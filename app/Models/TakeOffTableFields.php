<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TakeOffTable;

class TakeOffTableFields extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function takeOffTable(){
        return $this->belongsTo(TakeOffTable::class, 'id');
    }
}
