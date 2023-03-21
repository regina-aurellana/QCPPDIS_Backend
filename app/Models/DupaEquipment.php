<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Equipment;
use App\Models\DupaContent;

class DupaEquipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'dupa_content_id',
        'equipment_id',
        'no_of_unit',
        'no_of_hour',
    ];

    public function equipment() {
        return $this->belongsTo(Equipment::class);
    }

    public function dupaContent() {
        return $this->belongsTo(DupaContent::class);
    }
}
