<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\UnitOfMeasurement;

class Formula extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function measurement() {
        return $this->belongsTo(UnitOfMeasurement::class, 'unit_of_measurement_id');
    }



}
