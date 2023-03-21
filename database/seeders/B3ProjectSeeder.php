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
                'registry_no' => 'DED0001',
                'project_title' => 'Proposed Rehabilitation of Road and Drainage',
                'project_nature' => 'Horizontal',
                'project_nature_type' => 'Road',
                'location' => 'Quezon City',
                'status' => 'Pending',
            ],
            [
                'registry_no' => 'DED0002',
                'project_title' => 'Proposed Rehabilitation of Public Library',
                'project_nature' => 'Vertical',
                'project_nature_type' => 'Library',
                'location' => 'Quezon City',
                'status' => 'On-going',
            ],
            [
                'registry_no' => 'DED0003',
                'project_title' => 'Proposed Construction of Swimming Pool at Amoranto',
                'project_nature' => 'Horizontal',
                'project_nature_type' => 'Swimming Pool',
                'location' => 'Quezon City',
                'status' => 'Pending',
            ],
            [
                'registry_no' => 'DED0004',
                'project_title' => 'Proposed Construction of Parking Building at Amoranto',
                'project_nature' => 'Vertical',
                'project_nature_type' => 'Building',
                'location' => 'Quezon City',
                'status' => 'Completed',
            ],
        ];

        foreach($b3Project as $b3Projects){
            B3Projects::create([
                'registry_no' => $b3Projects['registry_no'],
                'project_title' => $b3Projects['project_title'],
                'project_nature' => $b3Projects['project_nature'],
                'project_nature_type' => $b3Projects['project_nature_type'],
                'location' => $b3Projects['location'],
                'status' => $b3Projects['status'],
            ]);
        }
    }
}
