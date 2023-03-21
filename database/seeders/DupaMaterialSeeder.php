<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\DupaMaterial;

class DupaMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dupaMaterial = [
            [
                'dupa_content_id' => '1',
                'material_id' => '1',
                'quantity' => '2',
            ],
            [
                'dupa_content_id' => '1',
                'material_id' => '5',
                'quantity' => '2',
            ],
            [
                'dupa_content_id' => '1',
                'material_id' => '7',
                'quantity' => '1',
            ],
            [
                'dupa_content_id' => '1',
                'material_id' => '8',
                'quantity' => '3',
            ],
        ];

        foreach($dupaMaterial as $dupaMaterials){
            DupaMaterial::create([
                'dupa_content_id' => $dupaMaterials['dupa_content_id'],
                'material_id' => $dupaMaterials['material_id'],
                'quantity' => $dupaMaterials['quantity'],
            ]);
        }
    }
}
