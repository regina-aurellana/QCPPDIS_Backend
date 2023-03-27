<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ProjectNatureType;
use App\Models\B3Projects;


class ProjectNature extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function projectNatureType(){
        return $this->hasMany(ProjectNatureType::class, 'project_nature_id', 'id');
    }
    public function b3Project(){
        return $this->haMany(B3Projects::class, 'project_nature_id', 'id');
    }
}
