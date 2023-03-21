<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DupaEquipment;
use App\Models\Dupa;

class DupaContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'dupa_id',
    ];

    public function dupaEquipment() {
        return $this->hasMany(DupaEquipment::class, 'dupa_content_id', 'id');
    }

    public function dupa() {
        return $this->hasMany(Dupa::class);
    }
}
