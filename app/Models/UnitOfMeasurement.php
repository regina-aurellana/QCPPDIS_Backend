<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Dupa;

class UnitOfMeasurement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function dupa(){
        return $this->belongsTo(Dupa::class);
    }
}
