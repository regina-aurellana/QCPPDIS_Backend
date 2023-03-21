<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DupaEquipment;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_code',
        'name',
        'hourly_rate',
    ];

    public function dupaEquipment() {
        return $this->hasMany(DupaEquipment::class, 'equipment_id', 'id');
    }
}
