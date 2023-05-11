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
        $take_off = B3Projects::with('takeOff')->get();

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

            TakeOff::updateOrCreate(
                ['b3_project_id' => $request['b3_project_id']],
                [
                    'limit' => $request['limit'],
                    'length' => $request['length'],
                ]
        );

        return response()->json([
            'status' => 'Success',
            'message' => 'Take-Off Created'
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
    public function destroy(string $id)
    {
        //
    }
}
