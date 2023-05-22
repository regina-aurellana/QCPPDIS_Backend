<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TakeOff\TakeOffTableFieldsRequest;
use App\Http\Requests\TakeOff\UpdateTakeOffTableFieldsRequest;
use App\Models\TakeOffTableFieldsInput;
use App\Models\TakeOffTableFields;
use App\Models\TakeOffTable;

class TakeOffTableFieldController extends Controller
{

    public function index()
    {
        $table_field = TakeOffTableFields::with('measurement', 'takeOffTable')->get();

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
        $table_field = TakeOffTableFields::with('measurement', 'takeOffTable')->get();

        return $table_field;
    }


    public function edit(string $id)
    {
        //
    }

    public function update(UpdateTakeOffTableFieldsRequest $request, TakeOffTable $take_off_table)
    {
        try {

            $takeOffTableFields = TakeOffTableFields::where('take_off_table_id', $take_off_table->id)->get();
            $existingMeasurements = $takeOffTableFields->pluck('measurement_id')->toArray();

            $newMeasurements = array_diff($request->unit_of_measurements, $existingMeasurements);

            foreach ($newMeasurements as $measurement) {
            $measure[] = [
                'take_off_table_id' => $request['take_off_table_id'],
                'measurement_id' => $measurement,
                'created_at' => now()
            ];

            }
            $relatedFieldIds = TakeOffTableFields::where('take_off_table_id', $request->take_off_table_id)->pluck('id');

                // Delete related records from take_off_table_fields_inputs
                TakeOffTableFieldsInput::whereIn('take_off_table_field_id', $relatedFieldIds)->delete();

                TakeOffTableFields::where('take_off_table_id', $request->take_off_table_id)->delete();
                TakeOffTableFields::insert($measure);


            return response()->json([
                'status' => 'Success',
                'Message' => 'Table Fields Updated'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'Message' => $th->getMessage()
            ]);
        }
    }


    public function destroy(TakeOffTable $take_off_table_field)
    {
        try {

            $fields = $take_off_table_field->takeOffTableField;

        foreach ($fields as $field) {
            $field->takeOffTableFieldInput()->delete();
            $field->delete();
        }

            return response()->json([
                'status' => "Deleted",
                'message' => "Deleted Successfully"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Error",
                'message' => $th->getMessage()
            ]);
        }
    }
}
