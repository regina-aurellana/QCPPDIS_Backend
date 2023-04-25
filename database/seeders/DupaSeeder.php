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
                'unit_id' => '1',
                'category_dupa_id' => 1,
                'output_per_hour' => '500.00',
            ],
            [

                'subcategory_id' => '2',
                'item_number' => '803|(1)a',
                'description' => 'Structure Excavation (Common Soil)',
                'unit_id' => '2',
                'category_dupa_id' => 2,
                'output_per_hour' => '300.00',
            ],
        ];

        foreach($dupa as $dupas){
            Dupa::create([
                'subcategory_id' => $dupas['subcategory_id'],
                'item_number' => $dupas['item_number'],
                'description' => $dupas['description'],
                'unit_id' => $dupas['unit_id'],
                'category_dupa_id' => $dupas['category_dupa_id'],
                'output_per_hour' => $dupas['output_per_hour'],
            ]);
        }
    }
}
