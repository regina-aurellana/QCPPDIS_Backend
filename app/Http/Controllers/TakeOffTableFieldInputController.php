<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\TakeOff\TakeOffTableFieldsInputsRequest;
use App\Http\Requests\TakeOff\UpdateTakeOffTableFieldInputRequest;
use App\Models\TakeOffTableFieldsInput;
use App\Models\TakeOffTableFields;
use App\Models\TakeOffTableFormula;
use App\Models\TakeOffTable;
use App\Models\TakeOff;


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

    public function store(TakeOffTableFieldsInputsRequest $request)
    {
        try {

            $maxRowNo = TakeOffTableFieldsInput::max('row_no');
            $nextRowNo = $maxRowNo + 1;

            $data = $request;

            $sets = [];

            // Loop through each set of data
            foreach ($request['take_off_table_field_id'] as $key => $value) {
                $sets[] = [
                    'row_no' => $nextRowNo,
                    'take_off_table_field_id' => $request['take_off_table_field_id'][$key],
                    'value' => $request['value'][$key],
                ];
            }

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
            $meas_name = $measurement_name->measurement->name ?? 'Unknown Measurement';

            foreach ($field->takeOffTableFieldInput as $input) {
                $rowNo = $input->row_no;

                if (!isset($rows[$rowNo])) {
                    $rows[$rowNo] = [];
                }

                $rows[$rowNo][] = [
                    'column_id' => $field->id,
                    'column_name' => $measurement_name,
                    'column_value' => $input->value
                ];
            }}
         return $rows;
    }

    public function edit(string $id)
    {
        //
    }

    public function update(UpdateTakeOffTableFieldInputRequest $request, TakeOffTable $take_off_table_field_input)
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
                        'row_no' => $request['row_no'][$key],
                        'take_off_table_field_id' => $request['take_off_table_field_id'][$key],
                        'value' => $value,
                        'created_at' => now()
                    ];

                    }

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

                        $table_no[$table_ids][$value->row_no] []= [

                                'input_value' => $value->value,
                                'input_field_name' => $measurement_name
                        ];
                }
            }
        }
         return $table_no;
    }


//     public function calculateFormula(TakeOffTable $take_off_table_field_input)
// {
//     $fields = $take_off_table_field_input->takeOffTableField;
//     $rows = [];
//     $results = [];

//     foreach ($fields as $field) {
//         $formula_table = $field->takeOffTable;
//         $formula = $formula_table->takeOffTableFormula;

//         $measurement_name = $field->measurement->name;
//         $meas_name = $measurement_name->measurement->name ?? 'Unknown Measurement';

//         foreach ($field->takeOffTableFieldInput as $input) {
//             $rows[] = [
//                 'column_id' => $field->id,
//                 'column_name' => $measurement_name,
//                 'column_value' => $input->value
//             ];
//         }
//     }

//     $fieldName = collect($rows)->pluck('column_name')->toArray();
//     $fieldValue = collect($rows)->pluck('column_value')->toArray();

//     foreach ($formula as $formulaRow) {
//         $tableFormula = $formulaRow['formula'];
//         foreach ($fieldName as $index => $name) {
//             $tableFormula = str_replace($name, $fieldValue[$index], $tableFormula);
//         }

//         // Convert $tableFormula array to a string
//         $tableFormulaString = implode("", $tableFormula);

//         // Modify the formula syntax
//         $tableFormulaString = str_replace(['(', ')'], ['*(', ')'], $tableFormulaString);

//         // Evaluate the final formula using the eval() function
//         $result = eval("return $tableFormulaString;");
//         $results[] = $result;
//     }

//     return $results;


// }






//     public function calculateFormula(TakeOffTable $take_off_table_field_input){
//         $fields = $take_off_table_field_input->takeOffTableField;
//     $rows = [];

//     foreach ($fields as $field) {
//         $formula_table = $field->takeOffTable;
//         $formula = $formula_table->takeOffTableFormula;
//         $measurement_name = $field->measurement->name;

//         foreach ($field->takeOffTableFieldInput as $input) {
//             $rows[] = [
//                 'column_id' => $field->id,
//                 'column_name' => $measurement_name,
//                 'column_value' => $input->value
//             ];
//         }
//     }

//     $fieldName = collect($rows)->pluck('column_name')->toArray();
// $fieldValue = collect($rows)->pluck('column_value')->toArray();

// $chunkedValues = array_chunk($fieldValue, count($fieldName));

// $results = [];

// foreach ($chunkedValues as $values) {
//     $tableFormula = $formula->first()->formula; // Access the formula from the first item

//     foreach ($fieldName as $index => $name) {
//         $tableFormula = str_replace($name, $values[$index], $tableFormula);
//     }

//     $tableFormula = preg_replace('/([a-zA-Z0-9)])(\()/', '$1*$2', $tableFormula);
//     $tableFormula = preg_replace('/(\))([a-zA-Z0-9(])/', '$1*$2', $tableFormula);

//     echo "Formula: " . $tableFormula . "<br>";
//     echo "Values: " . implode(", ", $values) . "<br>";

//     $result = eval("return $tableFormula;");
//     $results[] = $result;
// }

// return $fieldValue;


//     }


        public function calculateFormula(TakeOffTable $take_off_table_field_input)
        {
            $fields = $take_off_table_field_input->takeOffTableField;
            $rows = [];

            foreach ($fields as $field) {
                $formula_table = $field->takeOffTable;
                $formula = $formula_table->takeOffTableFormula;
                $measurement_name = $field->measurement->name;

                foreach ($field->takeOffTableFieldInput as $input) {

                    $column_value = $input->value;
                    if ($measurement_name === 'Considered') {
                        // Convert the percentage value to decimal
                        $column_value = $column_value / 100;
                    }

                    $rows[] = [
                        'column_id' => $field->id,
                        'column_name' => $measurement_name,
                        'column_value' => $column_value
                    ];
                }
            }

            $fieldName = collect($rows)->pluck('column_name')->toArray();
            $fieldValue = collect($rows)->pluck('column_value')->toArray();
            $tableFormula = collect($formula)->pluck('formula')->toArray();

            foreach ($fieldName as $index => $name) {
                $tableFormula = str_replace($name, $fieldValue[$index], $tableFormula);

                 $tableFormulas[] = $tableFormula;
            }

            // $tableFormulaString = implode("", $tableFormula);

            // // Add multiplication operator where necessary
            // $tableFormulaString = preg_replace('/([a-zA-Z0-9)])(\()/', '$1*$2', $tableFormulaString);
            // $tableFormulaString = preg_replace('/(\))([a-zA-Z0-9(])/', '$1*$2', $tableFormulaString);

            // // Evaluate the final formula using the eval() function
            // $result = eval("return $tableFormulaString;");

            return $tableFormulas;
        }




}
