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
use App\Models\UnitOfMeasurement;

class TakeOffTableController extends Controller
{

    public function index()
    {
        $table = TakeOffTable::with(['dupa'])
        ->get();

        return $table;

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function store(TakeOffTableRequest $tableRequest)
    {

        try {

            $table = [
                'take_off_id' => $tableRequest['take_off_id'],
                'sow_category_id' => $tableRequest['sow_category_id'],
                'dupa_id' => $tableRequest['dupa_id'],
                'created_at' => now()
            ];

            $take_off_table =TakeOffTable::insertGetId($table);

            $this->saveTakeOffTableField($take_off_table);


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


            $take_off_table->mark()->delete();
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

    public function getAllTakeOffTables(TakeOff $take_off_table){

        $tables = TakeOffTable::where('take_off_id', $take_off_table->id)
        ->with([
            'dupa' => function($q) {
                $q->leftJoin('unit_of_measurements', 'unit_of_measurements.id', 'dupas.unit_id')
                ->leftJoin('formulas', 'unit_of_measurements.id', 'formulas.unit_of_measurement_id')
                ->select('dupas.id', 'dupas.item_number', 'dupas.description', 'dupas.unit_id', 'unit_of_measurements.abbreviation as unit_abbreviation', 'formulas.result', 'formulas.formula');
            },
            'takeOffTableField' => function($q){
                $q->leftJoin('unit_of_measurements', 'unit_of_measurements.id', 'take_off_table_fields.measurement_id')
                ->select('take_off_table_fields.id', 'take_off_table_fields.take_off_table_id', 'take_off_table_fields.measurement_id', 'unit_of_measurements.name', 'unit_of_measurements.abbreviation',);
            },
            'mark:take_off_table_id,row_no,mark_description',
            'takeOffTableField.takeOffTableFieldInput:id,take_off_table_field_id,row_no,value'
            ])
            ->get();

            foreach($tables as $table){
                $fieldNames = [];
                $fieldValues = [];
                $tableFormulas = [];
                $table_compute = [];

                $fields = $table->takeOffTableField;
                $tableID = $table->id;

                info($fields);

                $formula = $table->dupa->formula;

                foreach($fields as $table_field){
                    $measurement_name = $table_field->name;
                    $fieldNames[] = $measurement_name;

                    foreach($table_field->takeOffTableFieldInput as $key => $table_field)
                    {

                            $column_value = $table_field->value;
                            if ($measurement_name === 'Considered') {
                                // Convert the percentage value to decimal
                                $column_value = $column_value / 100;
                            }
                            $fieldValues[$key][] = $column_value;

                    }
                }

                $result = [
                    'fieldName' => $fieldNames,
                    'fieldValue' => $fieldValues
                ];

                $fieldName = $result['fieldName'];
                $fieldValue = $result['fieldValue'];

                $results = [];

                foreach ($fieldValue as $input)
                {
                    $tableFormulaString = $formula;


                    foreach ($fieldName as $nameIndex => $name) {
                        $tableFormulaString = str_replace($name, $input[$nameIndex], $tableFormulaString);
                    }

                    // Add multiplication operator where necessary
                    $tableFormulaString = preg_replace('/([a-zA-Z0-9)])(\()/', '$1*$2', $tableFormulaString);
                    $tableFormulaString = preg_replace('/(\))([a-zA-Z0-9(])/', '$1*$2', $tableFormulaString);

                    // Evaluate the formula using eval() function
                    $result = eval("return $tableFormulaString;");
                    $results[] = $result;
                }

                $table_row_sum = array_sum($results);

                $table_compute = [
                    'row_result' => $results,
                    'table_total' => $table_row_sum,
                    'take_off_table_id' => $tableID
                ];

                $final_result[] = [
                     $table,
                     $table_compute,
                ];


            }

            return $final_result;


    }


    public function saveTakeOffTableField($take_off_table)
    {

        $tables = TakeOffTable::where('id', $take_off_table)
        ->with([
            'dupa' => function($q) {
                $q->leftJoin('unit_of_measurements', 'unit_of_measurements.id', 'dupas.unit_id')
                ->leftJoin('formulas', 'unit_of_measurements.id', 'formulas.unit_of_measurement_id')
                ->select('dupas.id', 'dupas.item_number', 'dupas.description', 'unit_of_measurements.abbreviation as unit_abbreviation', 'formulas.result', 'formulas.formula');
            }
            ])
            ->first();


            $tableID = $tables->id;
            $test = $tables->dupa;
            $formula = $test->formula;

            $components = preg_split('/[+\-*\/]/', $formula, -1, PREG_SPLIT_NO_EMPTY);


            $allMeasures = UnitOfMeasurement::select('name')->get();

            foreach($components as $key => $component){
            $existingMeasure = UnitOfMeasurement::where('name', $component)->get();
            $measure_id = collect($existingMeasure)->pluck('id')->first();

            $field = [
                'take_off_table_id' => $tableID,
                'measurement_id' => $measure_id,
                'created_at' => now()
            ];

            TakeOffTableFields::insert($field);

            }





    }



}
