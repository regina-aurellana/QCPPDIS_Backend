<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\TakeOff\TakeOffTableFieldsInputsRequest;
use App\Http\Requests\TakeOff\UpdateTakeOffTableFieldInputRequest;
use App\Models\TakeOffTableFieldsInput;
use App\Models\TakeOffTableFields;
use App\Models\TakeOffTable;


class TakeOffTableFieldInputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $take_off_table_input = TakeOffTableFieldsInput::with(['takeOffTableField' => function($q){
            $q->join('unit_of_measurements', 'unit_of_measurements.id', '=', 'take_off_table_fields.measurement_id')
            ->select('take_off_table_fields.*', 'unit_of_measurements.name as measurement_name');
         }])->get();

        return response()->json($take_off_table_input);


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
    public function store(TakeOffTableFieldsInputsRequest $request)
    {
        try {

            $data = $request;

            $sets = [];

            // Loop through each set of data
            for ($i = 0; $i < count($request['row_no']); $i++) {
                $set = [
                    'row_no' => $data['row_no'][$i],
                    'take_off_table_field_id' => $data['take_off_table_field_id'][$i],
                    'value' => $data['value'][$i],
                ];

                $sets[] = $set; // Add the set to the array
            }

            TakeOffTableFieldsInput::insert($sets);

            return response()->json([
                'status' => "Success",
                'message' => "Inputs Saved",
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Success",
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TakeOffTableFieldsInput $take_off_table_field_input)
    {
        $take_off_table_input = TakeOffTableFieldsInput::where('id', $take_off_table_field_input->id)
        ->with(['takeOffTableField' => function($q){
            $q->join('unit_of_measurements', 'unit_of_measurements.id', '=', 'take_off_table_fields.measurement_id')
            ->select('take_off_table_fields.*', 'unit_of_measurements.name as measurement_name');
         }
           ])->first();

           return response()->json($take_off_table_input);
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
    public function update(UpdateTakeOffTableFieldInputRequest $request, TakeOffTable $take_off_table)
    {
        try {





        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Error",
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
