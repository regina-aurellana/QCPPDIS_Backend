<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DupaContent;

class Dupa extends Model
{
    use HasFactory;

    protected $fillable = [
        'subcategory_id',
        'item_number',
        'description',
        'unit',
        'unit_cost',
    ];

    public function dupaContent(){
        return $this->hasOne(DupaContent::class);
    }
}
