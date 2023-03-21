<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\DupaContent;

class DupaContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dupaContent = [
            [
                'dupa_id' => '1',
            ],
            [
                'dupa_id' => '2',
            ],
        ];


        foreach($dupaContent as $dupaContents){
            DupaContent::create([
                'dupa_id' => $dupaContents['dupa_id'],
            ]);
        }
    }
}
