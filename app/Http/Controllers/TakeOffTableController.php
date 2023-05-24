<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\TakeOff\TakeOffTableRequest;
use App\Http\Requests\TakeOff\TakeOffTableFieldsRequest;
use App\Http\Requests\TakeOff\UpdateTakeOffTableRequest;
use App\Http\Requests\TakeOff\UpdateTakeOffTableFieldsRequest;
use App\Models\TakeOff;
use App\Models\TakeOffTable;
use App\Models\TakeOffTableFields;

class TakeOffTableController extends Controller
{

    public function index()
    {

        $table_field = TakeOffTable::with(['dupa:id,description',
        'sowCategory:id,item_code,name',
        'takeOffTableField.measurement:id,name,abbreviation',
        'measurementResult:id,name,abbreviation'
        ])->get();

        return $table_field;

        // // Split string formula
        // $test = "L*W=H";

        // $data = explode('=', $test);

        // return $data[0];

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function store(TakeOffTableRequest $tableRequest, TakeOffTableFieldsRequest $fieldRequest)
    {

        try {

            $take_off_table = [
                'take_off_id' => $tableRequest['take_off_id'],
                'sow_category_id' => $tableRequest['sow_category_id'],
                'dupa_id' => $tableRequest['dupa_id'],
                'table_row_result_field_id' => $tableRequest['table_row_result_field_id'],
                'created_at' => now()
            ];

            $take_off_table_id = TakeOffTable::insertGetId($take_off_table);

            $measure = [];
            foreach ($fieldRequest->unit_of_measurements as $measurement) {
                $measure[] = [
                    'take_off_table_id' => $take_off_table_id,
                    'measurement_id' => $measurement,
                    'created_at' => now()
                ];

            }
            TakeOffTableFields::insert($measure);

            return response()->json([
                'status' => 'Success',
                'message' => 'Take-Off Table Created'
            ]);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ]);
        }
    }


    public function show(TakeOffTable $take_off_table)
    {
        $table_field = TakeOffTable::where('id', $take_off_table->id)
        ->with([
            'dupa:id,description',
            'sowCategory:id,item_code,name',
            'takeOffTableField.measurement',
            'measurementResult:id,name,abbreviation'
            ])
        ->first();

        return $table_field;
    }


    public function edit(string $id)
    {
        //
    }


    public function update(TakeOffTableRequest $tableRequest, TakeOffTable $take_off_table)
    {
        try {

           $take_off_table->update([
                'take_off_id' => $tableRequest['take_off_id'],
                'sow_category_id' => $tableRequest['sow_category_id'],
                'dupa_id' => $tableRequest['dupa_id'],
                'table_row_result_field_id' => $tableRequest['table_row_result_field_id'],
           ]);


            return response()->json([
                'status' => 'Success',
                'Message' => 'Take-Off Table Updated'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'Message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TakeOffTable $take_off_table)
    {
        try {

            $fields = $take_off_table->takeOffTableField;

        foreach ($fields as $field) {
            $field->takeOffTableFieldInput()->delete();
            $field->delete();
        }

        $take_off_table->takeOffTableFormula()->delete();
        $take_off_table->delete();

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


    public function getAllTakeOffTable(TakeOff $take_off_table)
    {
        $table_field = TakeOffTable::where('take_off_id', $take_off_table->id)
        ->with([
            'dupa:id,description',
            'sowCategory:id,item_code,name',
            'measurementResult:id,name,abbreviation',
            'takeOffTableField' => function($q){
                $q->join('unit_of_measurements', 'unit_of_measurements.id', 'take_off_table_fields.measurement_id')
                ->join('take_off_table_fields_inputs', 'take_off_table_fields.id', 'take_off_table_fields_inputs.take_off_table_field_id')
                ->select('take_off_table_fields_inputs.row_no', 'take_off_table_fields.take_off_table_id', 'take_off_table_fields.measurement_id', 'unit_of_measurements.name',  'take_off_table_fields_inputs.value');
            }

            ])
        ->get();

        return $table_field;
    }

    // public function getAllTakeOffTableSow(TakeOff $take_off_table)
    // {
    //     $table_field = TakeOffTable::where('take_off_id', $take_off_table->id)->pluck('id');

    //     foreach ($table_field as $table_fields) {
    //         $table_field_sow = TakeOffTable::where('sow_category_id', $table_fields)
    //         ->with([
    //             'dupa:id,description',
    //             'sowCategory:id,item_code,name',
    //             'takeOffTableField.measurement',
    //             'measurementResult:id,name,abbreviation'
    //             ])
    //         ->get();

    //         return $table_field_sow;

    //     }


    // }



}
