<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\B3Projects;

class B3ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $b3Project = [
            [
                'registry_no' => 'DED2023_0001',
                'project_title' => 'Proposed Rehabilitation of Road and Drainage',
                'project_nature_id' => '1',
                'project_nature_type_id' => '1',
                'location' => 'Quezon City',
                'status' => 'Pending',
            ],
            [
                'registry_no' => 'DED2023_0002',
                'project_title' => 'Proposed Rehabilitation of Public Library',
                'project_nature_id' => '2',
                'project_nature_type_id' => '6',
                'location' => 'Quezon City',
                'status' => 'On-going',
            ],
            [
                'registry_no' => 'DED2023_0003',
                'project_title' => 'Proposed Construction of Swimming Pool at Amoranto',
                'project_nature_id' => '1',
                'project_nature_type_id' => '3',
                'location' => 'Quezon City',
                'status' => 'Pending',
            ],
            [
                'registry_no' => 'DED2023_0004',
                'project_title' => 'Proposed Construction of Parking Building at Amoranto',
                'project_nature_id' => '2',
                'project_nature_type_id' => '5',
                'location' => 'Quezon City',
                'status' => 'Completed',
            ],
        ];

        foreach($b3Project as $b3Projects){
            B3Projects::create([
                'registry_no' => $b3Projects['registry_no'],
                'project_title' => $b3Projects['project_title'],
                'project_nature_id' => $b3Projects['project_nature_id'],
                'project_nature_type_id' => $b3Projects['project_nature_type_id'],
                'location' => $b3Projects['location'],
                'status' => $b3Projects['status'],
            ]);
        }
    }
}
