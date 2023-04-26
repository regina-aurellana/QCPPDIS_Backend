<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\DupaContent;
use App\Models\UnitOfMeasurement;
use App\Models\DupaCategory;
use App\Models\ProjectNature;

class Dupa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'subcategory_id',
        'item_number',
        'description',
        'unit',
        'category_dupa_id',
        'output_per_hour',
    ];

    public function dupaContent(){
        return $this->hasOne(DupaContent::class);
    }

    public function measures(){
        return $this->hasOne(UnitOfMeasurement::class, 'id');
    }

}
