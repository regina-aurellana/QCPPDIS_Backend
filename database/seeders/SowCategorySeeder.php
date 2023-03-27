<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SowCategory;

class SowCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $sow_cat = [
            [
                'item_code' => 'GR',
                'name' => 'General Requirements'
            ],
            [
                'item_code' => 'OGR',
                'name' => 'Other General Requirements'
            ],
            [
                'item_code' => 'AW',
                'name' => 'Architectural Works'
            ],
            [
                'item_code' => 'C/SW',
                'name' => 'Civil/Structural Works'
            ],
        ];

        foreach($sow_cat as $sow_cats){
            SowCategory::create([
                'item_code' => $sow_cats['item_code'],
                'name' => $sow_cats['name'],
            ]);
        }
    }
}
