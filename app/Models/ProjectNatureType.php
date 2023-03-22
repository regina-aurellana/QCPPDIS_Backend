<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ProjectNature;
use App\Models\B3Projects;

class ProjectNatureType extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_nature_id',
        'name',
    ];

    public function projectNature(){
        return $this->belongsTo(ProjectNature::class);
    }
    public function b3Project(){
        return $this->belongsTo(B3Projects::class);
    }
}
