<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UnitOfMeasurement;

class UnitOfMeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $measurement = [
            [
                'name' => 'Height',
                'abbreviation' => 'h',
            ],
            [
                'name' => 'Length',
                'abbreviation' => 'l',
            ],
            [
                'name' => 'Volume',
                'abbreviation' => 'v',
            ],
            [
                'name' => 'Square',
                'abbreviation' => 'sq.',
            ],
            [
                'name' => 'Square Meter',
                'abbreviation' => 'sq.m.',
            ],
            [
                'name' => 'Cubic',
                'abbreviation' => 'cu.',
            ],
            [
                'name' => 'yard',
                'abbreviation' => 'yd.',
            ],
            [
                'name' => 'Hectare',
                'abbreviation' => 'ha.',
            ],
            [
                'name' => 'Meter',
                'abbreviation' => 'm',
            ],

        ];

        foreach($measurement as $measurements){
            UnitOfMeasurement::create([
                'name' => $measurements['name'],
                'abbreviation' => $measurements['abbreviation'],
            ]);
        }
    }
}
