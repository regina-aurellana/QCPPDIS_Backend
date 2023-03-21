<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\DupaLabor;

class DupaLaborSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dupaLAbor = [
            [
                'dupa_content_id' => '1',
                'labor_id' => '1',
                'no_of_person' => '2',
                'no_of_hour' => '5',                
            ],
            [
                'dupa_content_id' => '1',
                'labor_id' => '2',
                'no_of_person' => '1',
                'no_of_hour' => '3',                
            ],
        ];

        foreach($dupaLAbor as $dupaLAbors){
            DupaLabor::create([
                'dupa_content_id' => $dupaLAbors['dupa_content_id'],
                'labor_id' => $dupaLAbors['labor_id'],
                'no_of_person' => $dupaLAbors['no_of_person'],
                'no_of_hour' => $dupaLAbors['no_of_hour'],
            ]);
        }

    }
}
