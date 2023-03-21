<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Dupa;

class DupaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dupa = [
            [
                'subcategory_id' => '1',
                'item_number' => '800(3)a1',
                'description' => 'Individual Removal of Trees (Small, 150mm Ø up to 300mm Ø)',
                'unit' => 'each',
                'unit_cost' => '1003.34',
            ],
            [	  	  	

                'subcategory_id' => '2',
                'item_number' => '803|(1)a',
                'description' => 'Structure Excavation (Common Soil)',
                'unit' => 'cum',
                'unit_cost' => '269.98',
            ],
        ];

        foreach($dupa as $dupas){
            Dupa::create([
                'subcategory_id' => $dupas['subcategory_id'],
                'item_number' => $dupas['item_number'],
                'description' => $dupas['description'],
                'unit' => $dupas['unit'],
                'unit_cost' => $dupas['unit_cost'],
            ]);
        }
    }
}
