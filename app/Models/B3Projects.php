<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ProjectNature;
use App\Models\ProjectNatureType;

class B3Projects extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function projectNature(){
        return $this->belongsTo(ProjectNature::class);
    }
    public function projectNatureType(){
        return $this->belongsTo(ProjectNatureType::class);
    }
}
