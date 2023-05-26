<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\TakeOff\TakeOffTableFieldsInputsRequest;
use App\Http\Requests\TakeOff\UpdateTakeOffTableFieldInputRequest;
use App\Http\Requests\Mark\MarkRequest;
use App\Http\Requests\Mark\UpdateMarkRequest;
use App\Models\TakeOffTableFieldsInput;
use App\Models\TakeOffTableFields;
use App\Models\TakeOffTableFormula;
use App\Models\TakeOffTable;
use App\Models\TakeOff;
use App\Models\Mark;


class TakeOffTableFieldInputController extends Controller
{

    public function index()
    {
        $take_off_table_input = TakeOffTableFieldsInput::with(['takeOffTableField' => function($q){
            $q->join('unit_of_measurements', 'unit_of_measurements.id', '=', 'take_off_table_fields.measurement_id')
            ->select('take_off_table_fields.*', 'unit_of_measurements.name as measurement_name');
         }])->get();

        return response()->json($take_off_table_input);


    }

    public function create()
    {

    }

    public function store(TakeOffTableFieldsInputsRequest $inputRequest, MarkRequest $markRequest)
    {
        try {

            $maxRowNo = TakeOffTableFieldsInput::max('row_no');
            $nextRowNo = $maxRowNo + 1;

            $data = $inputRequest;

            $sets = [];

            // Loop through each set of data
            foreach ($inputRequest['take_off_table_field_id'] as $key => $value) {
                $sets[] = [
                    'row_no' => $nextRowNo,
                    'take_off_table_field_id' => $inputRequest['take_off_table_field_id'][$key],
                    'value' => $inputRequest['value'][$key],
                ];
            }

            $mark = [
                'take_off_table_id' => $markRequest['take_off_table_id'],
                'row_no' => $nextRowNo,
                'description' => $markRequest['description'],
            ];

            Mark::insert($mark);
            TakeOffTableFieldsInput::insert($sets);

            return response()->json([
                'status' => "Success",
                'message' => "Inputs Saved",
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Error",
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show(TakeOffTable $take_off_table_field_input)
    {
        // $take_off_table_input = TakeOffTableFieldsInput::where('id', $take_off_table_field_input->id)
        // ->with(['takeOffTableField' => function($q){
        //     $q->join('unit_of_measurements', 'unit_of_measurements.id', '=', 'take_off_table_fields.measurement_id')
        //     ->select('take_off_table_fields.*', 'unit_of_measurements.name as measurement_name');
        //  }
        //    ])->first();

        //    return response()->json($take_off_table_input);

        $fields = $take_off_table_field_input->takeOffTableField;

        $rows = [];

        foreach ($fields as $field) {

            $measurement_name = $field->measurement->name;

            foreach ($field->takeOffTableFieldInput as $input) {
                $rowNo = $input->row_no;

                if (!isset($rows[$rowNo])) {
                    $rows[$rowNo] = [];
                }

                $rows[$rowNo][] = [
                    'field_id' => $field->id,
                    'field_name' => $measurement_name,
                    'field_value' => $input->value
                ];
            }}
         return $rows;
    }

    public function edit(string $id)
    {
        //
    }


    public function update(UpdateTakeOffTableFieldInputRequest $request, MarkRequest $markRequest, TakeOffTable $take_off_table_field_input)
    {
        try {
            $fields = $take_off_table_field_input->takeOffTableField;

            $rows = [];

            foreach ($fields as $field) {

                foreach ($field->takeOffTableFieldInput as $input) {

                    $rows[] = [
                        'row_no' => $input->row_no,
                        'take_off_table_field_id' => $input->take_off_table_field_id,
                        'value' => $input->value
                    ];
                }}

                $existingValue = collect($rows)->pluck('value')->toArray();
                $newValue = array_diff($request->value, $existingValue);

                $input_value = [];

                foreach ($newValue as $key => $value) {
                    $input_value[] = [
                        'row_no' => $request['row_no'],
                        'take_off_table_field_id' => $request['take_off_table_field_id'][$key],
                        'value' => $value,
                        'created_at' => now()
                    ];
                    }

                    $mark_desc = [
                        'take_off_table_id' => $markRequest['take_off_table_id'],
                        'row_no' => $request->row_no,
                        'description' => $markRequest['description'],
                    ];

                    $mark_query = Mark::where('row_no', $request->row_no)
                    ->join('take_off_tables', 'take_off_tables.id', 'marks.take_off_table_id')
                    ->delete();

                    // return $input_value;

                    Mark::insert($mark_desc);

                    $takeOffTableFieldInputs = TakeOffTableFieldsInput::where('take_off_table_id', $take_off_table_field_input->id)
                    ->join('take_off_table_fields', 'take_off_table_fields.id', 'take_off_table_fields_inputs.take_off_table_field_id')
                    ->where('take_off_table_fields_inputs.row_no', $request->row_no)
                    ->delete();

                    TakeOffTableFieldsInput::insert($input_value);


                    return response()->json([
                        'status' => "Success",
                        'message' => "Inputs Updated"
                    ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Error",
                'message' => $th->getMessage()
            ]);
        }
    }


    public function destroy(string $id)
    {
        //
    }

    public function inputsByTakeOffIdAndTable(TakeOff $take_off_table_field_input)
    {

        $tables = $take_off_table_field_input->takeOffTable;

        foreach ($tables as  $table) {
            $table_fields = $table->takeOffTableField;

            foreach ($table->takeOffTableField as $table_field) {
                $table_ids = $table_field->take_off_table_id;
                $measurement_name = $table_field->measurement->name;

                    foreach ($table_field->takeOffTableFieldInput as $value) {

                        $table_no[$table_ids][$value->row_no]= [

                                'input_value' => $value->value,
                                'input_field_name' => $measurement_name
                        ];
                }
            }
            $test[] = [
                'table' . $table_ids => $table_no
            ];
        }

         return $test;
    }


    // public function calculateFormula(TakeOffTable $take_off_table_field_input)
    //     {
    //         $fields = $take_off_table_field_input->takeOffTableField;
    //         $fieldNames = [];
    //         $fieldValues = [];
    //         $tableFormulas = [];

    //         foreach ($fields as $field) {
    //             $formula_table = $field->takeOffTable;
    //             $formula = $formula_table->takeOffTableFormula;
    //             $measurement_name = $field->measurement->name;

    //             // Store field name
    //             $fieldNames[] = $measurement_name;

    //             // Store field values
    //             foreach ($field->takeOffTableFieldInput as $index => $input) {
    //                 $column_value = $input->value;
    //                 if ($measurement_name === 'Considered') {
    //                     // Convert the percentage value to decimal
    //                     $column_value = $column_value / 100;
    //                 }
    //                 $fieldValues[$index][] = $column_value;
    //             }
    //         }

    //         $result = [
    //             'fieldName' => $fieldNames,
    //             'fieldValue' => $fieldValues,
    //             // 'tableFormula' => $formula
    //         ];

    //         $fieldName = $result['fieldName'];
    //         $fieldValue = $result['fieldValue'];
    //         $tableFormula = collect($formula)->pluck('formula')->toArray();

    //         $results = [];

    //         foreach ($fieldValue as $set) {
    //             $tableFormulaString = $tableFormula[0]; // Assuming only one formula is provided

    //             foreach ($fieldName as $nameIndex => $name) {
    //                 $tableFormulaString = str_replace($name, $set[$nameIndex], $tableFormulaString);
    //             }

    //         // Add multiplication operator where necessary
    //         $tableFormulaString = preg_replace('/([a-zA-Z0-9)])(\()/', '$1*$2', $tableFormulaString);
    //         $tableFormulaString = preg_replace('/(\))([a-zA-Z0-9(])/', '$1*$2', $tableFormulaString);

    //             // Evaluate the formula using eval() function
    //             $result = eval("return $tableFormulaString;");


    //             $results[] = $result; // Result of each row
    //         }

    //         $sum = array_sum($results); // Get the total sum of the table

    //         return $results;
    //     }


    public function calculateFormula(TakeOff $take_off_table_field_input)
    {
       $tables = $take_off_table_field_input->takeOffTable;
        $fieldNames = [];
        $fieldValues = [];
        $tableFormulas = [];



        foreach($tables as $table){
            $fields = $table->takeOffTableField;
            $formula = $table->takeOffTableFormula;
            $tableID = $table->id;

            foreach($fields as $table_field){
                $table_fields[] = $table_field;
                $measurement_name = $table_field->measurement->name;


                $fieldNames[] = $measurement_name;

                foreach($table_field->takeOffTableFieldInput as $key => $table_field){
                        $field_value = $table_field->value;
                        $fieldValues[$key][] = $field_value;

                }
            }

            $result = [
                'fieldName' => $fieldNames,
                'fieldValue' => $fieldValues
            ];

            $fieldName = $result['fieldName'];
            $fieldValue = $result['fieldValue'];
            $tableFormula = collect($formula)->pluck('formula')->toArray();

            $results = [];



            foreach ($fieldValue as $set)
            {
                $tableFormulaString = $tableFormula[0];

                foreach ($fieldName as $nameIndex => $name) {
                    $tableFormulaString = str_replace($name, $set[$nameIndex], $tableFormulaString);

                }
                // return $tableFormulaString;

                // Add multiplication operator where necessary
                $tableFormulaString = preg_replace('/([a-zA-Z0-9)])(\()/', '$1*$2', $tableFormulaString);
                $tableFormulaString = preg_replace('/(\))([a-zA-Z0-9(])/', '$1*$2', $tableFormulaString);

                // Evaluate the formula using eval() function
                $result = eval("return $tableFormulaString;");


                    $results[] = $result;
            }

           $resultss[] = $results;

           $table_row_sum = array_sum($results);

           $test["table " . $tableID] = [
            'row_result' => $results,
            'table_total' => $table_row_sum
           ];

           return $test;


        }















    }








}
