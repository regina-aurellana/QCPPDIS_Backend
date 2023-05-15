<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\TakeOff\TakeOffTableFieldsInputsRequest;
use App\Models\TakeOffTableFieldsInput;
use App\Models\TakeOffTableFields;


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
            TakeOffTableFieldsInput::updateOrCreate([
                'row_no' => $request['row_no'],
                'take_off_table_field_id' => $request['take_off_table_field_id'],
                'value' => $request['value'],
            ]);

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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
