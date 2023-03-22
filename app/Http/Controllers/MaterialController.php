<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Http\Requests\Material\AddMaterialRequest;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $material = Material::get();

        return response()->json($material);
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
    public function store(AddMaterialRequest $request)
    {
        try {
            Material::updateOrCreate(
                ['item_code' => $request['item_code']],

                [
                    'name' => $request['name'],
                    'unit' => $request['unit'],
                    'unit_cost' => $request['unit_cost'],
                ]
            );
    
            return response()->json([
                'status' => "SUCCESS",
                'message' => "Successfully Added Material"
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Error",
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
    public function update(AddMaterialRequest $request, Material $material)
    {
        try {
            $material->update([
                'item_code' => $request->item_code,
                'name' => $request->name,
                'unit' => $request->unit,
                'unit_cost' => $request->unit_cost,
            ]);

            return response()->json([
                'status' => 'Success',
                'message' => "Material is Updated"
            ]);

       } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Success',
                'message' => $th->getMessage()
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
