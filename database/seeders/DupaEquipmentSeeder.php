<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\DupaEquipment;

class DupaEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dupaEquipment = [
            [
                'dupa_content_id' => '1',
                'equipment_id' => '1',
                'no_of_unit' => '2',
                'no_of_hour' => '5',
            ],
            [
                'dupa_content_id' => '1',
                'equipment_id' => '2',
                'no_of_unit' => '2',
                'no_of_hour' => '3',
            ],
            [
                'dupa_content_id' => '1',
                'equipment_id' => '3',
                'no_of_unit' => '6',
                'no_of_hour' => '2',
            ],
            
        ];

        foreach($dupaEquipment as $dupaEquipments){
            DupaEquipment::create([
                'dupa_content_id' => $dupaEquipments['dupa_content_id'],
                'equipment_id' => $dupaEquipments['equipment_id'],
                'no_of_unit' => $dupaEquipments['no_of_unit'],
                'no_of_hour' => $dupaEquipments['no_of_hour'],
            ]);
        }
    }
}
