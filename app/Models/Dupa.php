<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\DupaContent;
use App\Models\UnitOfMeasurement;
use App\Models\DupaCategory;

class Dupa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'subcategory_id',
        'item_number',
        'description',
        'unit_id',
        'direct_unit_cost',
        'output_per_hour',
    ];

    public function dupaContent(){
        return $this->hasOne(DupaContent::class);
    }

    public function measures(){
        return $this->hasOne(UnitOfMeasurement::class, 'id');
    }

    public function dupaCategory(){
        return $this->belongsToMany(DupaCategory::class, 'dupa_categories', 'dupa_id', 'nature_id');
    }

    public function isBothVerticalAndHorizontal()
    {
        $categoryNames = $this->dupaCategory()->pluck('name')->toArray();

        return in_array('Vertical', $categoryNames) && in_array('Horizontal', $categoryNames);
    }
}
