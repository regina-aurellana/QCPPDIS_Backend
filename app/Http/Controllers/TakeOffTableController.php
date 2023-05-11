<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\TakeOff\TakeOffTableRequest;
use App\Models\TakeOffTable;

class TakeOffTableController extends Controller
{

    public function index()
    {

        $table_field = TakeOffTable::get();

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
            TakeOffTable::updateOrCreate(
                ['take_off_id' => $request['take_off_id']],
                [
                    'sow_category_id' => $request['take_off_id'],
                    'dupa_id' => $request['dupa_id'],
                ]
            );

            return response()->json([
                'status' => 'Success',
                'message' => 'New Take-off table Created',
            ]);
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
    public function show(string $id)
    {
        //
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
