<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DupaLabor\AddDupaLaborRequest;
use Illuminate\Support\Facades\DB;

use App\Models\DupaLabor;

class DupaLaborController extends Controller
{

    public function index()
    {
        $dupa_labor = DupaLabor::with('labor')
        ->with('dupaContent')
        ->get();

        return response()->json($dupa_labor);
    }


    public function create()
    {
        //
    }


    public function store(AddDupaLaborRequest $request)
    {
        try {
            DupaLabor::updateOrCreate(
                ['labor_id' => $request['labor_id']],
                [
                    'dupa_content_id' => $request['dupa_content_id'],
                    'no_of_person' => $request['no_of_person'],
                    'no_of_hour' => $request['no_of_hour'],
                ]
            );

            return response()->json([
                'status' => "SUCCESS",
                'message' => "Successfully Added Dupa Labor"
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Error",
                'message' => $th->getMessage()
            ]);
        }
    }


    public function show(DupaLabor $dupalabor)
    {
        $dupa_labor = DupaLabor::where('dupa_content_id', $dupalabor->id)
            ->with([
                'labor' => function($q){
                    $q->select('dupa_labors.id', 'labors.designation', 'labors.hourly_rate', DB::raw('(dupa_labors.no_of_person * dupa_labors.no_of_hour * labors.hourly_rate) as labor_amount'))
                    ->join('dupa_labors', 'labors.id', '=', 'dupa_labors.labor_id');
                }
            ])
            ->get();

        return response()->json($dupa_labor);
    }


    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(DupaLabor $dupalabor)
    {
        try {
            $dupalabor->delete();

            return response()->json([
                'status' => 'Success',
                'message' => 'Deleted Successfully'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ]);
        }
    }
}
