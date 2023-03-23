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
        return $this->hasOne(ProjectNature::class, 'project_nature_id', 'id');
    }
    public function projectNatureType(){
        return $this->hasOne(ProjectNatureType::class, 'project_nature_type_id', 'id');
    }
}
