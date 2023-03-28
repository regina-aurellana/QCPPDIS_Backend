<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Labor\AddLaborRequest;
use App\Http\Requests\Labor\UpdateLaborRequest;
use App\Models\Labor;
use Carbon\Carbon;

class LaborController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labor = Labor::get();

        return response()->json($labor);
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
    public function store(AddLaborRequest $request)
    {

        try {
            Labor::updateOrCreate(
                ['id' => $request['labor_id']],
                    [
                      'item_code' => $request['item_code'],
                      'designation' => $request['designation'],
                      'hourly_rate' => $request['hourly_rate'],
                    ]
            );

            return response()->json([
                'status' => 'Success',
                'message' => 'Labor Added'
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
    public function show(Labor $labor)
    {
        $labors = Labor::where('id', $labor->id)
        ->select('id', 'item_code', 'designation', 'hourly_rate')
        ->first();

		return response()->json($labors);
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
    public function update(UpdateLaborRequest $request, Labor $labor)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Labor $labor)
    {
        try {
					$labor->delete();

					return response()->json([
						'status' => "Success",
						'message' => 'Deleted Successfully'
					]);

				} catch (\Throwable $th) {
					return response()->json([
						'status' => "Error",
						'message' => $th->getMessage()
					]);
				}
    }
}
