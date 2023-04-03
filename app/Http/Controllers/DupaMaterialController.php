<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DupaMaterial\AddDupaMaterialRequest;

use App\Models\DupaMaterial;

class DupaMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dupa_material = DupaMaterial::with(['material', 'dupaContent'])
        ->get();

        return response()->json($dupa_material);
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
    public function store(AddDupaMaterialRequest $request)
    {
        try {
            DupaMaterial::updateOrCreate(
                ['material_id' => $request['material_id']],
                [
                    'dupa_content_id' => $request['dupa_content_id'],
                    'quantity' => $request['quantity'],
                ]
            );

            return response()->json([
                'status' => 'Success',
                'message' => 'Added Succesfully'
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
    public function show(DupaMaterial $dupamaterial)
    {
        $dupa_material = DupaMaterial::where('id', $dupamaterial->id)
        ->with([
            'material',
            'dupaContent' => function ($q){
                $q->join('dupas', 'dupa_contents.dupa_id', 'dupas.id')
                ->select('dupa_contents.*', 'description');
            },
        ])
        ->first();

        return response()->json($dupa_material);
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
    public function destroy(DupaMaterial $dupamaterial)
    {
        try {
            $dupamaterial->delete();

            return response()->json([
                'status' => 'Success',
                'message' => 'Deleted Succesfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ]);
        }
    }
}
