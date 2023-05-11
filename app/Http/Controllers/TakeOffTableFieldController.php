<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TakeOff\TakeOffTableFieldsRequest;
use App\Models\TakeOffTableFields;
use App\Models\TakeOffTable;

class TakeOffTableFieldController extends Controller
{

    public function index()
    {
        $table_field = TakeOffTable::with(['takeOffTable'])->get();

        return $table_field;
    }


    public function create()
    {
        //
    }


    public function store(TakeOffTableFieldsRequest $request )
    {
        try {

            foreach ($request->unit_of_measurements as $measurement) {
                $measure[] = [
                    'take_off_table_id' => $request['take_off_table_id'],
                    'measurement_id' => $measurement,
                    'created_at' => now()
                ];
            }

            TakeOffTableFields::insert($measure);

            return response()->json([
                'status' => 'Success',
                'Message' => 'New Table Field Created'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'Message' => $th->getMessage()
            ]);
        }
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
