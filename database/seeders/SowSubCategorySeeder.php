<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SowSubCategory;

class SowSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $subcat = [
            [
                'item_code' => 'CSW01',
                'name' => 'Earthworks',
                'sow_cat_id' => '4',
            ],
            [
                'item_code' => 'OGR03',
                'name' => 'Temporary Facilities (including bunkhouse, sanitation facilities, electric meter/sub-meter, water meter/sub-meter, etc.)',
                'sow_cat_id' => '2',
            ],
            [
                'item_code' => 'OGR0301',
                'name' => 'electric meter/sub-meter, water meter/sub-meter, etc.',
                'sow_cat_id' => '2',
            ],
            [
                'item_code' => 'OGR030101',
                'name' => 'Temporary Facilities ',
                'sow_cat_id' => '2',
            ],
            [
                'item_code' => 'AW01',
                'name' => 'Temporary',
                'sow_cat_id' => '3',
            ],
            [
                'item_code' => 'CSW0101',
                'name' => 'Facilities ',
                'sow_cat_id' => '4',
            ],
        ];

        foreach($subcat as $subcats){
            SowSubCategory::create([
                'item_code' => $subcats['item_code'],
                'name' => $subcats['name'],
                'sow_cat_id' => $subcats['sow_cat_id'],
            ]);
        }
    }
}
