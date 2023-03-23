<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\DupaMaterial;

class Material extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'item_code',
        'name',
        'unit',
        'unit_cost',
    ];

    public function dupaMaterial(){
        return $this->hasMany(DupaMAterilal::class, 'material_id', 'id');
    }
}
