<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DupaLabor;

class Labor extends Model
{
    protected $fillable = [
        'item_code',
        'designation',        
        'hourly_rate',
    ];

    public function dupaLabor(){
        return $this->hasMany(DupaLabor::class, 'labor_id', 'id');
    }
}
