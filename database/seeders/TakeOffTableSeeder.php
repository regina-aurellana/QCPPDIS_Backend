<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\TakeOffTable;

class TakeOffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $take_off_table = [
            [
                'take_off_id' => '1',
                'sow_category_id' => '1',
                'dupa_id' => '2',
                'table_row_result_field_id' => '2',
            ],
            [
                'take_off_id' => '1',
                'sow_category_id' => '2',
                'dupa_id' => '1',
                'table_row_result_field_id' => '7',
            ],
        ];

        TakeOffTable::insert($take_off_table);
    }
}
