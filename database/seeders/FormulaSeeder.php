<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Formula;

class FormulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formula = [
            [
                'unit_of_measurement_id' => '4',
                'result' => 'Area',
                'formula' => 'Length*Width',

            ],
            [
                'unit_of_measurement_id' => '5',
                'result' => 'Volume',
                'formula' => 'Length*Width*Depth',

            ],

        ];

        foreach($formula as $formulas){
            Formula::create([
                'unit_of_measurement_id' => $formulas['unit_of_measurement_id'],
                'result' => $formulas['result'],
                'formula' => $formulas['formula'],
            ]);
        }
    }
}
