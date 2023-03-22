<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ProjectNatureType;


class ProjectNature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function projectNatureType(){
        return $this->hasMany(ProjectNatureType::class, 'project_nature_id', 'id');
    }
}
