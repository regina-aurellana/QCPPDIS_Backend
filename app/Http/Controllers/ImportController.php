<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporaryFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;

use App\Models\SowCategory;
use App\Models\SowSubCategory;
use App\Models\SowReference;
use App\Models\UnitOfMeasurement;
use App\Models\DupaContent;
use App\Models\Dupa;
use App\Models\DupaLabor;
use App\Models\Labor;
use App\Models\DupaMaterial;
use App\Models\Material;
use App\Models\DupaEquipment;
use App\Models\Equipment;


class ImportController extends Controller
{
    public function upload(Request $request) {

        info($request);

         try {

             if ($request->hasFile('filepond')) {

             $file = $request->file('filepond');
             $folder = uniqid(). '-' .now()->timestamp;
             $filename = $file->getClientOriginalName();

             $file->storeAs('temp/'.$folder, $filename);

             TemporaryFile::create([
                 'filename' => $filename,
                 'folder' => $folder
             ]);

             return $folder;
             }

             return '';


         } catch (\Throwable $th) {
             info($th->getMessage());
         }
     }

     public function revert(){

         $folder = request()->getContent();

         TemporaryFile::where('folder', $folder)->delete();
         Storage::deleteDirectory('temp/'.$folder);
         return '';
     }

     public function importSubcatFirstLvl(Request $request){

        try {

            $file = $request->file('filepond');
            $folder = uniqid(). '-' .now()->timestamp;

            $filepath = $file->store('temp');

            $rows = SimpleExcelReader::create(storage_path('app/'.$filepath))->getRows();
            $collection = collect($rows->toArray());

            $sow_cats = $collection->pluck('Sow Cat Name');
            $parent_item_codes = $collection->pluck('Parent Sub Category Item_code');
            $item_code = $collection->pluck('Item Code');
            $description = $collection->pluck('Description');

            foreach ($sow_cats as $sow_cat) {
                $sow_cats_id[] = SowCategory::where('name', $sow_cat)->select('id')->first();
            }

            $sowcat_id = collect($sow_cats_id)->pluck('id')->toArray();

            for($sowcat = 0; $sowcat < count($item_code); $sowcat++){

                $item_codes [] = $item_code[$sowcat];
                $data [] = [
                    'sow_category_id' => $sowcat_id[$sowcat],
                    'item_code' => $item_code[$sowcat],
                    'name' => $description[$sowcat]
                ];
            }

            $existing_item_code = SowSubCategory::select('item_code')->whereIn('item_code', $item_codes)->pluck('item_code');

            foreach ($data as $insert) {
                if (in_array($insert['item_code'], $existing_item_code->toArray())) {
                    SowSubCategory::where('item_code', $insert['item_code'])->update([
                        'sow_category_id' => $insert['sow_category_id'],
                        'item_code' => $insert['item_code'],
                        'name' => $insert['name'],
                    ]);

                }else{
                    $data_to_insert[] = [
                        'sow_category_id' => $insert['sow_category_id'],
                        'item_code' => $insert['item_code'],
                        'name' => $insert['name'],
                        'created_at' => now(),
                    ];
                }
            }

            $insertedIds = [];
            $parent_subcat_ids = [];


            foreach (array_chunk($data_to_insert, 1000) as $data) {
                $parent_subcat_ids = [];

                foreach ($data as $row) {
                    $parent_subcat_ids = [];
                    $insertedIds [] = SowSubCategory::insertGetId($row);
                }

         }

        foreach ($parent_item_codes as $parent_item_code) {
            $parent_subcat_ids[] = SowSubCategory::where('item_code', $parent_item_code)->select('id')->first();
        }

        $parent_subcat_id = collect($parent_subcat_ids)->pluck('id')->toArray();

            foreach ($insertedIds as $key => $insertedId) {
                SowReference::updateOrCreate(
                    ['sow_sub_category_id' => $insertedId,
                    'parent_sow_sub_category_id' => $parent_subcat_id[$key]],
                );

            }

            return response()->json([
                'status' => "Success",
                'message' => "Import Successful"
            ]);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Error",
                'message' => $th->getMessage()
            ]);
        }

     }

     public function importDupa(Request $request){

        try {

            $file = $request->file('filepond');
            $folder = uniqid(). '-' .now()->timestamp;

            $filepath = $file->store('temp');

            $row = SimpleExcelReader::create(storage_path('app/'.$filepath))->noHeaderRow();
            $rows = $row->getRows();
            $collection = collect($rows->toArray());

            $item_number = $collection[5][3];
            $dupa_name = $collection[5][4];
            $dupa_unit = $collection[6][3];
            $output_per_hour = $collection[7][3];


            // Get Parent Sub Category itemCode
            // Extract SubCat item_code from Dupa Item Code
            $extractedSubcatItemCode = Str::before($item_number, '(');

            // Get Subcategory ID
            $subCat = SowSubCategory::where('item_code', $extractedSubcatItemCode)->get();
            $subCatID = collect($subCat)->pluck('id')->first();

            // Get Measurement ID
            $measurement = UnitOfMeasurement::where('abbreviation', $dupa_unit)->get();
            $measurementID = collect($measurement)->pluck('id')->first();

            $dupa_to_insert = [
                'subcategory_id' => $subCatID,
                'item_number' => $item_number,
                'description' => $dupa_name,
                'unit_id' => $measurementID,
                'output_per_hour' => $output_per_hour,
                'created_at' => now(),
            ];

            // Insert data to Dupa database
            // Get Id of newly inserted Dupa
            $newlyInsertedDupaID = Dupa::insertGetId($dupa_to_insert);

            // Create Dupa Content
            $dupa_content = [
                'dupa_id' => $newlyInsertedDupaID,
                'created_at' => now(),
            ];

            // Get Dupa Content ID
            $dupaContentID = DupaContent::insertGetId($dupa_content);


    // // SAVE LABOR AND DUPA LABOR
            $fileContents = $collection;

            // LOCATE THE START AND END FOR LABOR ITEMS
            // Locate the start
            $laborWordToSearchStart = 'Designation';

            $laborRowStart = 0;

            foreach ($fileContents as $line) {
                if (in_array($laborWordToSearchStart, $line)) {
                    break;
                }
                $laborRowStart++;
        }

            // Locate the end
            $laborWordToSearchEnd = 'Sub - Total for A.1 - As Submitted';

            $laborRowEnd = 0;

            foreach ($fileContents as $line) {
                if (in_array($laborWordToSearchEnd, $line)) {
                    break;
                }
                $laborRowEnd++;
            }

            $laborRow = $laborRowStart + 2;


        for ($laborRows = $laborRow; $laborRows < $laborRowEnd; $laborRows++) {

            $laborName = $collection[$laborRows][1];


            // Check if Labor item doesn't exist in database
            $doesntExists = Labor::where('designation', $laborName)->doesntExist();

            if ($doesntExists) {
                $saveLabor = [
                    'designation' => $laborName,
                    'hourly_rate' => $collection[$laborRows][7],
                    'created_at' => now(),
                ];

                $labor_id = Labor::insertGetId($saveLabor);

                $dupaLaborToInsert = [
                    'dupa_content_id' => $dupaContentID,
                    'labor_id' => $labor_id,
                    'no_of_person' => $collection[$laborRows][5],
                    'no_of_hour' => $collection[$laborRows][6],
                    'created_at' => now(),
                ];

                DupaLabor::insert($dupaLaborToInsert);

            }else {

                $labor = Labor::where('designation', $laborName)->get();
                $laborID = collect($labor)->pluck('id')->first();

                $dupaLaborToInsert = [
                    'dupa_content_id' => $dupaContentID,
                    'labor_id' => $laborID,
                    'no_of_person' => $collection[$laborRows][5],
                    'no_of_hour' => $collection[$laborRows][6],
                    'created_at' => now(),
                ];

                DupaLabor::insert($dupaLaborToInsert);
            }

        }

         // // SAVE EQUIPMENT AND DUPA EQUIPMENT
            $fileContents = $collection;

            // LOCATE THE START AND END FOR EQUIPMENT ITEMS
            // Locate the start
            $equipmentWordToSearchStart = 'Name and Capacity';

            $equipmentRowStart = 0;

            foreach ($fileContents as $line) {
                if (in_array($equipmentWordToSearchStart, $line)) {
                    break;
                }
                $equipmentRowStart++;
        }

            // Locate the end
            $equipmentWordToSearchEnd = 'Sub - Total for B.1 - As Submitted';

            $equipmentRowEnd = 0;

            foreach ($fileContents as $line) {
                if (in_array($equipmentWordToSearchEnd, $line)) {
                    break;
                }
                $equipmentRowEnd++;
            }

            // Minor Tool

            $minorToolsSearch = 'Minor Tools';

            $minorToolRow = 0;

            foreach ($fileContents as $rowIndex => $row) {
                foreach ($row as $column) {
                    if (strpos($column, $minorToolsSearch) !== false) {
                        $minorToolRowIndex = $rowIndex;
                        $columnValue = $column;
                        break;
                    }
                }
                $minorToolRow++;
            }

            info($column);


            // Equipment Note:

            $equipNoteSearch = 'Note:';

            $equipNoteRow = 0;

            foreach ($fileContents as $equipRowIndex => $row) {
                foreach ($row as $perColumn) {
                    if (strpos($perColumn, $equipNoteSearch) !== false) {
                        $equipNoteRowIndex = $equipRowIndex;
                        $equipNoteColumnValue = $perColumn;
                        break;
                    }
                }
                $equipNoteRow++;
            }




            $equipmentRow = $equipmentRowStart + 2;

        for ($equipmentRows = $equipmentRow; $equipmentRows < $equipmentRowEnd; $equipmentRows++) {

            $equipmentName = $collection[$equipmentRows][1];


            // Check if Equipment item doesn't exist in database
            $equipDoesntExists = Equipment::where('name', $equipmentName)->doesntExist();

            if ($equipDoesntExists) {

                if (empty($columnValue)) {
                    continue;
                }elseif ($columnValue == $equipmentName) {
                    $minortoolPercentage = Str::between($columnValue, '(', '%');

                    // SAVE MINOR TOOL PERCENTAGE
                    Dupa::where('id', $newlyInsertedDupaID)->update(['minor_tool_percentage' => $minortoolPercentage]);

                }
                elseif (empty($equipNoteColumnValue)) {
                    continue;

                }elseif ($equipNoteColumnValue == $equipmentName) {

                    // SAVE EQUIPMENT NOTE
                    Dupa::where('id', $newlyInsertedDupaID)->update(['note' => $equipNoteColumnValue]);
                }
                else {
                    $saveEquipment = [
                        'name' => $equipmentName,
                        'hourly_rate' => $collection[$equipmentRows][7],
                        'created_at' => now(),
                    ];

                    // SAVE NEW EQUIPMENT
                    $equipment_id = Equipment::insertGetId($saveEquipment);

                    $dupaEquipmentToInsert = [
                        'dupa_content_id' => $dupaContentID,
                        'equipment_id' => $equipment_id,
                        'no_of_unit' => $collection[$equipmentRows][5],
                        'no_of_hour' => $collection[$equipmentRows][6],
                        'created_at' => now(),
                    ];

                    DupaEquipment::insert($dupaEquipmentToInsert);
                }

            }else {

                $equipment = Labor::where('designation', $equipmentName)->get();
                $equipmentID = collect($equipment)->pluck('id')->first();

                $dupaEquipmentToInsert = [
                    'dupa_content_id' => $dupaContentID,
                    'labor_id' => $equipment_id,
                    'no_of_unit' => $collection[$equipmentRow][5],
                    'no_of_hour' => $collection[$equipmentRow][6],
                    'created_at' => now(),
                ];

                DupaEquipment::insert($dupaEquipmentToInsert);
                // info($dupaEquipmentToInsert);
            }

        }

        // // SAVE MATERIAL AND DUPA MATERIAL
        $fileContents = $collection;

        // LOCATE THE START AND END FOR MATERIAL ITEMS
        // Locate the start
        $materialWordToSearchStart = 'Name and Specification';

        $materialRowStart = 0;

        foreach ($fileContents as $line) {
            if (in_array($materialWordToSearchStart, $line)) {
                break;
            }
            $materialRowStart++;
    }

        // Locate the end
        $materialWordToSearchEnd = 'Sub - Total for F.1 - As Submitted';

        $materialRowEnd = 0;

        foreach ($fileContents as $line) {
            if (in_array($materialWordToSearchEnd, $line)) {
                break;
            }
            $materialRowEnd++;
        }

        $materialRow = $materialRowStart + 2;


    for ($materialRows = $materialRow; $materialRows < $materialRowEnd; $materialRows++) {

        $materialName = $collection[$materialRows][1];


        // Check if Material item doesn't exist in database
        $doesntExists = Material::where('name', $materialName)->doesntExist();

        if ($doesntExists) {
            $saveMaterial = [
                'name' => $materialName,
                'unit' => $collection[$materialRows][5],
                'unit_cost' => $collection[$materialRows][7],
                'created_at' => now(),
            ];

            $material_id = Material::insertGetId($saveMaterial);

            $dupaMaterialToInsert = [
                'dupa_content_id' => $dupaContentID,
                'material_id' => $material_id,
                'quantity' => $collection[$materialRows][6],
                'created_at' => now(),
            ];

            DupaMaterial::insert($dupaMaterialToInsert);

        }else {

            $material = Material::where('name', $materialName)->get();
            $materialID = collect($material)->pluck('id')->first();

            $dupaMaterialToInsert = [
                'dupa_content_id' => $dupaContentID,
                'material_id' => $materialID,
                'quantity' => $collection[$materialRows][6],
                'created_at' => now(),
            ];

            DupaMaterial::insert($dupaMaterialToInsert);
        }

    }





        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'erroe',
                'message' => $th->getMessage()
            ]);
        }
     }
}
