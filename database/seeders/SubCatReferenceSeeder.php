<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SubCatReference;

class SubCatReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $subcat_ref = [
            [
                'sow_subcat_id' => '3',
                'parent_id' => '2',
            ],
            [
                'sow_subcat_id' => '4',
                'parent_id' => '3',
            ],
            [
                'sow_subcat_id' => '6',
                'parent_id' => '1',
            ],
        ];

        foreach ($subcat_ref as $subcat_refs) {
            SubCatReference::create([
                'sow_subcat_id' => $subcat_refs['sow_subcat_id'],
                'parent_id' => $subcat_refs['parent_id'],
            ]);
        }
    }
}
