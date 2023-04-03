<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\TemporaryFile;
use App\Http\Requests\Equipment\AddEquipmentRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\LazyCollection;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $equipment = Equipment::get();

       return response()->json($equipment);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddEquipmentRequest $request)
    {
        try {
           $equip = Equipment::updateOrCreate(
                ['id' => $request['equipment_id']],
                [
                    'item_code' => $request['item_code'],
                    'name' => $request['name'],
                    'hourly_rate' => $request['hourly_rate']

                ]
            );
            if ($equip->wasRecentlyCreated) {
                return response()->json([
                    'status' => 'Created',
                    'message' => 'Equipment Successfully Created'
                ]);
            }else{
                return response()->json([
                    'status' => 'Updated',
                    'message' => 'Equipment Successfully Updated'
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'erroe',
                'message' => $th->getMessage
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        $equipments = Equipment::where('id', $equipment->id)
        ->select('id', 'item_code', 'name', 'hourly_rate')
        ->first();

       return response()->json($equipments);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        try {
            $equipment->delete();

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

    public function uploadEquipment(Request $request) {

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

    public function revertEquipment(){

        $folder = request()->getContent();

        TemporaryFile::where('folder', $folder)->delete();
        Storage::deleteDirectory('temp/'.$folder);
        return '';
    }

    public function importEquipment(Request $request) {
        try {

            $file = $request->file('filepond');
            $folder = uniqid(). '-' .now()->timestamp;

            $filepath = $file->store('temp');

            $rows = SimpleExcelReader::create(storage_path('app/'.$filepath))->getRows();
            $collection = collect($rows->toArray());

            $item_code = $collection->pluck('Equipment Code');
            $name = $collection->pluck('Equipment Description');
            $hourly_rate = $collection->pluck('Hourly Rate');

            for ($equip = 0; $equip < count($item_code); $equip++) {

                $item_codes [] = $item_code[$equip];
                $data [] = [
                    'item_code' => $item_code[$equip],
                    'name' => $name[$equip],
                    'hourly_rate' => $hourly_rate[$equip]
                ];
            }

            $existing_item_code = Equipment::select('item_code')->whereIn('item_code', $item_codes)->pluck('item_code');

            foreach ($data as $insert) {
                if (in_array($insert['item_code'], $existing_item_code->toArray())) {
                    Equipment::where('item_code', $insert['item_code'])->update([
                        'item_code' => $insert['item_code'],
                        'name' => $insert['name'],
                        'hourly_rate' => $insert['hourly_rate'],
                    ]);
                }else{
                    $data_to_insert[] = [
                        'item_code' => $insert['item_code'],
                        'name' => $insert['name'],
                        'hourly_rate' => $insert['hourly_rate'],
                        'created_at' => now(),
                    ];
                }
            }

            foreach (array_chunk($data_to_insert, 1000) as $data) {
                Equipment::insert($data);
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
