<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DupaLabor\DupaLaborRequest;

use App\Models\DupaLabor;

class DupaLaborController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dupa_labor = DupaLabor::with('labor')
        ->with('dupaContent')
        ->get();

        return response()->json($dupa_labor);
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
    public function store(DupaLaborRequest $request)
    {
        try {
            DupaLaborRequest::updateOrCreate(
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

    /**
     * Display the specified resource.
     */
    public function show(DupaLabor $dupalabor)
    {
        $dupa_labor = DupaLabor::where('id', $dupalabor->id)
            ->with([
                'labor:id,designation',
                'dupaContent' => function($q){
                    $q->join('dupas', 'dupa_contents.dupa_id', '=', 'dupas.id')
                    ->select('dupa_contents.*', 'description');
                },
            ])
            ->first();

        return response()->json($dupa_labor);
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
                'message' => $th->getMessage
            ]);
        }
    }
}
