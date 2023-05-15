<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TakeOff\TakeOffRequest;
use App\Models\TakeOff;
use App\Models\B3Projects;

class TakeOffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $take_off = B3Projects::with(['takeOff.takeOffTable.takeOffTableField' => function($q){
            $q->join('unit_of_measurements', 'unit_of_measurements.id', '=', 'take_off_table_fields.measurement_id')
            ->join('take_off_table_fields_inputs', 'take_off_table_fields_inputs.id', 'take_off_table_fields_inputs.take_off_table_field_id')
            ->select('take_off_table_fields.*', 'unit_of_measurements.name as measurement_name', 'take_off_table_fields_inputs.*');
        }])->get();

        return response()->json($take_off);

        // $test = "10+20/5+(10-5)";
        // $result = eval("return $test;");
        // return $result;

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
    public function store(TakeOffRequest $request)
    {
        try {

           $take_off = TakeOff::updateOrCreate(
                ['b3_project_id' => $request['b3_project_id']],
                [
                    'limit' => $request['limit'],
                    'length' => $request['length'],
                ]
        );

        if($take_off->wasRecentlyCreated){
            return response()->json([
                'status' => 'Success',
                'message' => 'Take-Off Created'
            ]);
        } else{
            return response()->json([
                'status' => 'Success',
                'message' => 'Take-Off Updated'
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
    public function show(B3Projects $take_off)
    {
        $take_off = B3Projects::where('id', $take_off->id)
        ->with('takeOff')
        ->first();

        return response()->json($take_off);
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
    public function destroy(TakeOff $take_off)
    {
        try {
            $take_off->delete();

            return response()->json([
                'status' => 'Success',
                'message' => 'Deleted Successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Success',
                'message' => $th->getMessage()
            ]);
        }
    }
}
