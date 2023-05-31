<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            MaterialSeeder::class,
            LaborSeeder::class,
            EquipmentSeeder::class,
            SowCategorySeeder::class,
            SowSubCategorySeeder::class,
            UnitOfMeasurementSeeder::class,
            CategoryDupaSeeder::class,
            DupaSeeder::class,
            DupaContentSeeder::class,
            DupaLaborSeeder::class,
            DupaEquipmentSeeder::class,
            DupaMaterialSeeder::class,
            ProjectNatureSeeder::class,
            ProjectNatureTypeSeeder::class,
            B3ProjectSeeder::class,
            SubCatReferenceSeeder::class,
            TakeOffSeeder::class,
            FormulaSeede::class,
            // TakeOffTableSeeder::class,
            // TakeOffTableFieldSeeder::class,
            // TakeOffTableFieldInputSeeder::class,
        ]);
    }
}
