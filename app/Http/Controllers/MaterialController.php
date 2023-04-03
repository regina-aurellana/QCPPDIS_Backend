<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\TemporaryFile;
use App\Http\Requests\Material\AddMaterialRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\LazyCollection;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $material = Material::get();

        return response()->json($material);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddMaterialRequest $request)
    {

        try {


           $mat =  Material::updateOrCreate(
                ['id' => $request['material_id']],

                [
                    'item_code' => $request['item_code'],
                    'name' => $request['name'],
                    'unit' => $request['unit'],
                    'unit_cost' => $request['unit_cost'],
                ]
            );
            if ($mat->wasRecentlyCreated) {
                return response()->json([
                    'status' => "Created",
                    'message' => "Material Successfully Created"
                ]);
            }else{
                return response()->json([
                    'status' => "Updated",
                    'message' => "Material Successfully Updated "
                ]);
            }


        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Error",
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        $mat = Material::where('id', $material->id)
        ->select('id', 'item_code', 'name', 'unit', 'unit_cost')
        ->first();

        return response()->json($mat);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddMaterialRequest $request, Material $material)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        try {
            $material->delete();

            return response()->json([
                'status' => "Deleted",
                'message' => "Deleted Successfully"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Error",
                'message' => $th->getMessage
            ]);
        }
    }

    public function uploadMaterial(Request $request){

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
            info('Temporary file upload error: ' . $th->getMessage());
            return '';
        }

    }
    public function revertMaterial(){

        $folder = request()->getContent();

        TemporaryFile::where('folder', $folder)->delete();
        Storage::deleteDirectory('temp/'.$folder);

        return '';

    }

    public function import(Request $request){
        info($request);

        try {
            $file = $request->file('filepond');
            $folder = uniqid(). '-' .now()->timestamp;

            $filePath = $file->store('temp');

            $rows = SimpleExcelReader::create(storage_path('app/'.$filePath))->getRows();
            $collection = collect($rows->toArray());


            $item_code = $collection->pluck('Material Code');
            $name = $collection->pluck('Material Description');
            $unit = $collection->pluck('Unit');
            $unit_cost = $collection->pluck('Average');

            $data = [];
            $item_codes = [];
            $data_to_insert = [];

            //STORE TO TEMP VARIABLE
            for ($mat = 0; $mat < count($item_code); $mat++) {

                $item_codes [] = $item_code[$mat];
                $data[] = [
                    'item_code' => $item_code[$mat],
                    'name' => $name[$mat],
                    'unit' => $unit[$mat],
                    'unit_cost' => $unit_cost[$mat],
                ];
            }

            //GET EXISTING ITEM CODES
            $existing_item_codes = Material::select('item_code')->whereIn('item_code', $item_codes)->pluck('item_code');

            //UPDATE EXISTING THEN PREPARE DATA TO INSERT
            foreach($data as $insert){

                if(in_array($insert['item_code'], $existing_item_codes->toArray())){
                    Material::where('item_code', $insert['item_code'])->update([
                        'name' => $insert['name'],
                        'unit' => $insert['unit'],
                        'unit_cost' => $insert['unit_cost'],
                    ]);
                }
                else {
                    $data_to_insert[] = [
                        'item_code' => $insert['item_code'],
                        'name' => $insert['name'],
                        'unit' => $insert['unit'],
                        'unit_cost' => $insert['unit_cost'],
                        'created_at' => now()
                    ];
                }

            }

            foreach(array_chunk($data_to_insert, 1000) as $data) {
                Material::insert($data);
            }

            return response()->json([
                'status' => "Success",
                'message' => "Imported Successfully"
            ]);
        } catch (\Throwable $th) {
            info($th->getMessage());
        }

    }




}
