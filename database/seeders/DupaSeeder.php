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
                'item_number' => '101(3)c1',
                'description' => 'Removal of Actual Structured Obstruction, 0.05m thick, Asphalt',
                'unit_id' => '4',
                'category_dupa_id' => '2',
                'output_per_hour' => '500.00',
            ],
            [

                'subcategory_id' => '2',
                'item_number' => '102(2) ',
                'description' => 'Roadway Excavation',
                'unit_id' => '5',
                'category_dupa_id' => '2',
                'output_per_hour' => '120.00',
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
