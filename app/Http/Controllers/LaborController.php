<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Labor\AddLaborRequest;
use App\Http\Requests\Labor\UpdateLaborRequest;
use App\Models\Labor;
use Carbon\Carbon;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\LazyCollection;

class LaborController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labor = Labor::get();

        return response()->json($labor);
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
    public function store(AddLaborRequest $request)
    {

        try {
           $labor = Labor::updateOrCreate(
                ['id' => $request['labor_id']],
                    [
                      'item_code' => $request['item_code'],
                      'designation' => $request['designation'],
                      'hourly_rate' => $request['hourly_rate'],
                    ]
            );
            if ($labor->wasRecentlyCreated) {
                return response()->json([
                    'status' => 'Created',
                    'message' => 'Labor Successfully Created'
                ]);
            }else{
                return response()->json([
                    'status' => 'Updated',
                    'message' => 'Labor Successfully Updated'
                ]);
            }


        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Labor $labor)
    {
        $labors = Labor::where('id', $labor->id)
        ->select('id', 'item_code', 'designation', 'hourly_rate')
        ->first();

		return response()->json($labors);
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
    public function update(UpdateLaborRequest $request, Labor $labor)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Labor $labor)
    {
        try {
					$labor->delete();

					return response()->json([
						'status' => "Deleted",
						'message' => 'Deleted Successfully'
					]);

				} catch (\Throwable $th) {
					return response()->json([
						'status' => "Error",
						'message' => $th->getMessage()
					]);
				}
    }

    public function uploadLabor(Request $request){
        info('yey');
        try {
            if($request->hasFile('filepond')) {

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

    public function revertLabor(){

        $folder = request()->getContent();

        TemporaryFile::where('folder', $folder)->delete();
        Storage::deleteDirectory('temp/'.$folder);

        return '';

    }

    public function importLabor(Request $request){
        try {
            $file = request()->file('filepond');
            $folder = uniqid(). '-' .now()->timestamp;

            $filepath = $file->store('temp');

            $rows = SimpleExcelReader::create(storage_path('app/'.$filepath))->getRows();
            $collection = collect($rows->toArray());

            $item_code = $collection->pluck('Labor Code');
            $designation = $collection->pluck('Designation');
            $hourly_rate = $collection->pluck('Hourly Rate');


            for ($labor = 0; $labor < count($item_code); $labor++) {

                $item_codes [] = $item_code[$labor];
                $data [] = [
                    'item_code' => $item_code[$labor],
                    'designation' => $designation[$labor],
                    'hourly_rate' => $hourly_rate[$labor]
                ];
            }

            $existing_item_code = Labor::select('item_code')->whereIn('item_code', $item_code)->pluck('item_code');

            foreach ($data as $insert) {

                if (in_array($insert['item_code'], $existing_item_code->toArray())) {
                    Labor::where('item_code', $insert['item_code'])->update([
                        'item_code' => $insert['item_code'],
                        'designation' => $insert['designation'],
                        'hourly_rate' => $insert['hourly_rate'],
                    ]);
                }else{
                    $data_to_insert[] = [
                        'item_code' => $insert['item_code'],
                        'designation' => $insert['designation'],
                        'hourly_rate' => $insert['hourly_rate'],
                        'created_at' => now(),
                    ];
                }
            }

            foreach (array_chunk($data_to_insert, 1000) as $data) {
                Labor::insert($data);
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
