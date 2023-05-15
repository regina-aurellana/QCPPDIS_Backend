<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TakeOffTableFields;

class TakeOffTableFieldsInput extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function takeOffTableField(){
        return $this->belongsTo(TakeOffTableFields::class);
    }
}
