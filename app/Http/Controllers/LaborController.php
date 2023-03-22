<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Labor\AddLaborRequest;
use App\Http\Requests\Labor\UpdateLaborRequest;
use App\Models\Labor;

class LaborController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labor = Labor::get();

        return response()->json($labor);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddLaborRequest $request)
    {
       
        try {
            Labor::create([
                'item_code' => $request['item_code'],
                'designation' => $request['designation'],        
                'hourly_rate' => $request['hourly_rate'],
            ]);

            return response()->json([
                'status' => 'Success',
                'message' => 'Labor Added'
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
    public function update(UpdateLaborRequest $request, Labor $labor)
    {
        try {
            $labor->update([
                'item_code' => $request->item_code,
                'designation' => $request->designation,        
                'hourly_rate' => $request->hourly_rate,
            ]);

            return response()->json([
                'status' => 'Success',
                'message' => 'Labor Updated'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
