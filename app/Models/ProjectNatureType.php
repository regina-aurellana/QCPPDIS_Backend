<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ProjectNature;

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
}
