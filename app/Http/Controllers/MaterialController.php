<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Http\Requests\Material\AddMaterialRequest;
use Carbon\Carbon;

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
    public function show(Material $material)
    {
        $mat = Material::where('id', $material->id)
        ->select('item_code', 'name', 'unit', 'unit_cost')
        ->first();

        return response()->json($mat);
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

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        try {
            $material->delete();

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
