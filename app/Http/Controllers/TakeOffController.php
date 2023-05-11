<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TakeOff\TakeOffRequest;
use App\Models\TakeOff;

class TakeOffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $take_off = TakeOff::with('b3Projects')->get();

        return response()->json($take_off);
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
