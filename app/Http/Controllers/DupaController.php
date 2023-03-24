<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Dupa\AddDupaRequest;
use App\Models\Dupa;
use Carbon\Carbon;

class DupaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dupa = Dupa::with('dupaContent')
        ->get();

        return response()->json($dupa);
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
    public function store(AddDupaRequest $request)
    {
        try {
            Dupa::updateOrCreate(
                ['item_number' => $request['item_number']],
                [
                    'subcategory_id' => $request['subcategory_id'],
                    'description' => $request['description'],
                    'unit' => $request['unit'],
                    'unit_cost' => $request['unit_cost'],
                ]
            );

            return response()->json([
                'status' => "Success",
                'message' => "Successfully Added new Dupa"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Error",
                'message' => $th->getMessage
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Dupa $dupa)
    {
        $dupa = Dupa::where('id', $dupa->id)
        ->with([
            'dupaContent.dupaEquipment' => function($q){
                $q->join('equipment', 'dupa_equipment.equipment_id', 'equipment.id')
                ->select('dupa_equipment.*', 'name');
            }, 
            'dupaContent.dupaLabor' => function($q){
                $q->join('labors', 'dupa_labors.labor_id', 'labors.id')
                ->select('dupa_labors.*', 'designation');
            }, 
            'dupaContent.dupaMaterial' => function($q){
                $q->join('materials', 'dupa_materials.material_id', 'materials.id')
                ->select('dupa_materials.*', 'name');
            },
            ])
        ->get();

        return response()->json($dupa);
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
    public function destroy(Dupa $dupa)
    {
        try {
            $dupa->delete();

            return response()->json([
                'status' => "Success",
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
