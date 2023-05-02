<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DupaEquipment\AddDupaEquipmentRequest;
use Illuminate\Support\Facades\DB;

use App\Models\DupaEquipment;

class DupaEquipmentController extends Controller
{
    public function index()
    {
        $dupa_equip = DupaEquipment::with(['equipment'])
        ->get();


        return response()->json($dupa_equip);
    }

    public function create()
    {
        //
    }

    public function store(AddDupaEquipmentRequest $request)
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

    public function show(DupaEquipment $dupaequipment)
    {
        // $dupa_equip = DupaEquipment::where('dupa_equipment.dupa_content_id', $dupaequipment->id)
        // ->join('dupa_contents', 'dupa_contents.id', 'dupa_equipment.dupa_content_id')
        // ->join('equipment', 'equipment.id', 'dupa_equipment.equipment_id')
        // ->join(
        //     DB::raw('(SELECT dupa_equipment.id, dupa_equipment.dupa_content_id,
        //         dupa_equipment.no_of_unit, dupa_equipment.no_of_hour,
        //         equipment.hourly_rate
        //         FROM dupa_equipment
        //         INNER JOIN equipment ON equipment.id = dupa_equipment.equipment_id) AS dupa_equipment_amount'),
        //         'dupa_equipment_amount.id', '=', 'dupa_equipment.id')
        //         ->select('dupa_equipment.*', 'equipment.hourly_rate', 'equipment.name', DB::raw('dupa_equipment_amount.no_of_unit * dupa_equipment_amount.no_of_hour * dupa_equipment_amount.hourly_rate AS amount'))
        // ->get();


        $dupa_equip = DupaEquipment::where('dupa_content_id', $dupaequipment->id)
        ->with(['equipment' => function($q){
            $q->select('dupa_equipment.id', 'equipment.hourly_rate', 'equipment.name', DB::raw('(dupa_equipment.no_of_unit * dupa_equipment.no_of_hour * equipment.hourly_rate) as equipment_amount'))
              ->join('dupa_equipment', 'equipment.id', '=', 'dupa_equipment.equipment_id');
        }
        ])
        ->get();



        return response()->json($dupa_equip);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

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
