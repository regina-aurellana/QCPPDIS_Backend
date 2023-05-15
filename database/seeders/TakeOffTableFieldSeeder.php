<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TakeOffTableFields;

class TakeOffTableFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $take_off_table_fields = [
            [
                'take_off_table_id' => '1',
                'measurement_id' => '2'
            ],
            [
                'take_off_table_id' => '1',
                'measurement_id' => '1'
            ],
            [
                'take_off_table_id' => '1',
                'measurement_id' => '3'
            ],
            [
                'take_off_table_id' => '1',
                'measurement_id' => '4'
            ],
        ];

        TakeOffTableFields::insert($take_off_table_fields);
    }
}
