<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DupaEquipment\DupaEquipmentRequest;

use App\Models\DupaEquipment;

class DupaEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dupa_equip = DupaEquipment::with(['equipment', 'dupaContent'])
        ->get();

        return response()->json($dupa_equip);
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
    public function store(DupaEquipmentRequest $request)
    {
        try {
            DupaEquipment::updateOrCreate(
                ['equipment_id' => $request['equipment_id']],
                [
                    'dupa_content_id' => $request['dupa_content_id'],
                    'no_of_unit' => $request['no_of_unit'],
                    'no_of_hour' => $request['no_of_hour'],
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
    public function show(DupaEquipment $dupaequipment)
    {
        $dupa_equip = DupaEquipment::where('id', $dupaequipment->id)
        ->with([
            'equipment',
            'dupaContent' => function($q){
                $q->join('dupas', 'dupa_contents.dupa_id', 'dupas.id')
                ->select('dupa_contents.*', 'description');
            },
        ])
        ->first();

        return response()->json($dupa_equip);
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
    public function destroy(DupaEquipment $dupaequipment)
    {
        try {
            $dupaequipment->delete();

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
