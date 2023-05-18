<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TakeOff\TakeOffTableFormulaRequest;
use App\Models\TakeOffTableFormula;

class TakeOffTableFormulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "yey";
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
    public function store(TakeOffTableFormulaRequest $request)
    {
        try {
            TakeOffTableFormula::updateOrCreate([
                'take_off_table_id' => $request['take_off_table_id'],
                'formula' => $request['formula'],
            ]);

            return response()->json([
                'status' => 'Success',
                'message' => 'Formula Saved'
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
