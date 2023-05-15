<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\TakeOff\TakeOffTableRequest;
use App\Models\TakeOffTable;

class TakeOffTableController extends Controller
{

    public function index()
    {

        $table_field = TakeOffTable::with('takeOffTableField.measurement')->get();

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


    public function store(TakeOffTableRequest $request)
    {
        try {
            $take_off_table = TakeOffTable::updateOrCreate(
                ['take_off_id' => $request['take_off_id']],
                [
                    'sow_category_id' => $request['take_off_id'],
                    'dupa_id' => $request['dupa_id'],
                ]
            );

            if($take_off_table->wasRecentlyCreated){
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Take-Off Table Created'
                ]);
            } else{
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Take-Off Table Updated'
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
    public function show(TakeOffTable $take_off_table)
    {
        $table_field = TakeOffTable::where('id', $take_off_table->id)->with('takeOffTableField.measurement')->first();

        return $table_field;
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
