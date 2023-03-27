<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ProjectNature;
use App\Models\B3Projects;

class ProjectNatureType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'project_nature_id',
        'name',
    ];

    public function projectNature(){
        return $this->belongsTo(ProjectNature::class);
    }
    public function b3Project(){
        return $this->hasMany(B3Projects::class, 'project_nature_type_id', 'id');
    }
}
