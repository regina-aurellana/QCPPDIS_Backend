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
                'name' => 'Square Meter',
                'abbreviation' => 'sq.m.',
            ],
            [
                'name' => 'Cubic Meter',
                'abbreviation' => 'cu.m.',
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
            [
                'name' => 'Width',
                'abbreviation' => 'w',
            ],
            [
                'name' => 'Area',
                'abbreviation' => 'A',
            ],
            [
                'name' => 'Depth',
                'abbreviation' => 'd',
            ],
            [
                'name' => 'Quantity',
                'abbreviation' => 'qty.',
            ],
            [
                'name' => 'Deduction',
                'abbreviation' => 'deduct',
            ],
            [
                'name' => 'Addition',
                'abbreviation' => 'add',
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
