<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Http\Requests\Equipment\AddEquipmentRequest;
use Carbon\Carbon;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $equipment = Equipment::get();

       return response()->json($equipment);
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
    public function store(AddEquipmentRequest $request)
    {
        try {
            Equipment::updateOrCreate(
                ['item_code' => $request['item_code']],
                [
                    'name' => $request['name'],
                    'hourly_rate' => $request['hourly_rate']
                    
                ]
            );
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Equipment Added'
                ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'erroe',
                'message' => $th->getMessage
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        $equipments = Equipment::find($equipment);

       return response()->json($equipments);
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
    public function destroy(Equipment $equipment)
    {
        try {
            $equipment->delete();

            return response()->json([
                'status' => "SUCCESS",
                'message' => "Deleted Successfully"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Error",
                'message' => $th->getMessage
            ]);
        }
    }
}
