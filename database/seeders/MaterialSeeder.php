<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Material;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $material = [
            [
                'item_code' => '001',
                'name' => 'Sand',
                'unit' => 'cu.m',
                'unit_cost' => 615.00,
            ],
            [
                'item_code' => '002',
                'name' => 'Cement (Portland)',
                'unit' => 'bag',
                'unit_cost' => 230.00,
            ],
            [
                'item_code' => '003',
                'name' => 'Gravel, G1',
                'unit' => 'cu.m',
                'unit_cost' => 1300.00,
            ],
            [		
                'item_code' => '004',
                'name' => 'Ready Mix Concrete Class A, 3000 PSI @, 28 Days',
                'unit' => 'cu.m.',
                'unit_cost' => 5,915.00,
            ],
            [	
                'item_code' => '005',
                'name' => 'Ready Mix Concrete Class A, 3500 PSI @, 28 Days',
                'unit' => 'cu.m.',
                'unit_cost' => 6,103.00,
            ],
            [	
                'item_code' => '006',
                'name' => 'Ready Mix Concrete Class A, 4000 PSI @, 28 Days',
                'unit' => 'cu.m.',
                'unit_cost' => 6,323.00,
            ],
            [	
                'item_code' => '007',
                'name' => 'Ready Mix Concrete Class A, 4500 PSI @, 28 Days',
                'unit' => 'cu.m.',
                'unit_cost' => 6,605.00,
            ],
            [
                'item_code' => '008',
                'name' => 'Ready Mix Concrete Class A, 5000 PSI @, 28 Days',
                'unit' => 'cu.m.',
                'unit_cost' => 6,637.00,
            ],
            [
                'item_code' => '009',
                'name' => 'Ready Mix Concrete Class A, 3000 PSI @, 14 Days',
                'unit' => 'cu.m.',
                'unit_cost' => 6,090.00,
            ],
            [	
                'item_code' => '010',
                'name' => 'Ready Mix Concrete Class A, 3500 PSI @, 14 Days',
                'unit' => 'cu.m.',
                'unit_cost' => 6,246.00,
            ],
            [	
                'item_code' => '011',
                'name' => 'Ready Mix Concrete Class A, 4000 PSI @, 14 Days',
                'unit' => 'cu.m.',
                'unit_cost' => 6,526.00,
            ],
            [	
                'item_code' => '012',
                'name' => 'Ready Mix Concrete Class A, 3000 PSI @, 7 Days',
                'unit' => 'cu.m.',
                'unit_cost' => 6,430.00,
            ],
            [	
                'item_code' => '013',
                'name' => 'Ready Mix Concrete Class A, 3500 PSI @, 7 Days',
                'unit' => 'cu.m.',
                'unit_cost' => 6,632.00,
            ],
            [	
                'item_code' => '014',
                'name' => 'On-Site Mix Concrete Class A, 1500 PSI @, 28 Days',
                'unit' => 'cu.m.',
                'unit_cost' => 1,500.00,
            ],
            [	
                'item_code' => '015',
                'name' => 'On-Site Mix Concrete Class A, 2000 PSI @, 28 Days',
                'unit' => 'cu.m.',
                'unit_cost' => 3,000.00,
            ],
            [	
                'item_code' => '016',
                'name' => 'On-Site Mix Concrete Class A, 2500 PSI @, 28 Days',
                'unit' => 'cu.m.',
                'unit_cost' => 3,750.00,
            ],
            [	
                'item_code' => '017',
                'name' => 'On-Site Mix Concrete Class A, 3000 PSI @, 28 Days',
                'unit' => 'cu.m.',
                'unit_cost' => 4,500.00,
            ],
            [	
                'item_code' => '018',
                'name' => 'On-Site Mix Concrete Class A, 4000 PSI @, 28 Days',
                'unit' => 'cu.m.',
                'unit_cost' => 4,700.00,
            ],
            [	
                'item_code' => '019',
                'name' => 'Deformed Reinforcing Steel, Grade 40',
                'unit' => 'kg',
                'unit_cost' => 49.23,
            ],
            [	
                'item_code' => '020',
                'name' => 'Deformed Reinforcing Steel, Grade 60',
                'unit' => 'kg',
                'unit_cost' => 50.49,
            ],
            [	
                'item_code' => '021',
                'name' => '#16 G.I. Tie Wire',
                'unit' => 'kg',
                'unit_cost' => 110.00,
            ],
            [	
                'item_code' => '022',
                'name' => 'Good Lumber',
                'unit' => 'bd.ft.',
                'unit_cost' => 57.00,
            ],
            [		  
                'item_code' => '023',
                'name' => 'Marine Plywood, 4.5mm & 6mm',
                'unit' => 'pc',
                'unit_cost' => 814.44,
            ],
            [	
                'item_code' => '024',
                'name' => 'Ordinary Plywood, 1/2"',
                'unit' => 'pc',
                'unit_cost' => 400.00,
            ],
            [	
                'item_code' => '025',
                'name' => 'Ordinary Plywood, 1/4"',
                'unit' => 'pc',
                'unit_cost' => 367.50,
            ],
            [ 	
                'item_code' => '026',
                'name' => 'Gypsum Board,12mm thk',
                'unit' => 'pc',
                'unit_cost' => 686.75,
            ],
            [		  
                'item_code' => '027',
                'name' => 'Metal Stud, 3m Length',
                'unit' => 'pc',
                'unit_cost' => 254.00,
            ],
            [	
                'item_code' => '028',
                'name' => 'Hard Hat',
                'unit' => 'man-days',
                'unit_cost' => 0.25,
            ],
            [	
                'item_code' => '029',
                'name' => 'Gloves',
                'unit' => 'man-days',
                'unit_cost' => 7.67,
            ],
            [	'item_code' => '030',
                'name' => 'Boots',
                'unit' => 'man-days',
                'unit_cost' => 2.77,
            ],
            [	
                'item_code' => '031',
                'name' => 'Tarpaulin (1.2m x 2.4m)',
                'unit' => 'sq.ft.',
                'unit_cost' => 35.00,
            ],
            [	
                'item_code' => '032',
                'name' => 'Tarpaulin (2.4m x 2.4m)',
                'unit' => 'sq.ft.',
                'unit_cost' => 35.00,
            ],
            [		  
                'item_code' => '033',
                'name' => 'Assorted Common Wire Nail',
                'unit' => 'kg',
                'unit_cost' => 80.00,
            ],
            [	
                'item_code' => '034',
                'name' => 'Medicine Cabinet',
                'unit' => 'set',
                'unit_cost' => 3,000.00,
            ],
            [	
                'item_code' => '035',
                'name' => 'Rope, 1" Ø - 5 uses',
                'unit' => 'lm',
                'unit_cost' => 3.50,
            ],
            [	
                'item_code' => '036',
                'name' => 'Embankment Materials',
                'unit' => 'cu.m',
                'unit_cost' => 505.00,
            ],
            [	
                'item_code' => '037',
                'name' => 'Phenolic Plywood',
                'unit' => 'pc',
                'unit_cost' => 1,450.00,
            ],
            [	
                'item_code' => '038',
                'name' => 'Fibercement Board, 4.5mm thk',
                'unit' => 'pc',
                'unit_cost' => 450.00,
            ],
            [ 	
                'item_code' => '039',
                'name' => 'Fibercement Board, 6mm thk',
                'unit' => 'pc',
                'unit_cost' => 550.00,
            ], 
            [ 	
                'item_code' => '040',
                'name' => 'Metal Furring, 12mm x 38mm x 0.8mm th x 3m Length',
                'unit' => 'pc',
                'unit_cost' => 130.00,
            ],          

        ];

        foreach($material as $materials){
            Material::create([
                'item_code' => $materials['item_code'],
                'name' => $materials['name'],
                'unit' => $materials['unit'],
                'unit_cost' => $materials['unit_cost'],
            ]);
        }
    }
}
