<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Dupa\AddDupaRequest;
use App\Models\Dupa;
use App\Models\ProjectNature;
use App\Models\CategoryDupa;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DupaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $dupa = CategoryDupa::join('dupas', 'category_dupas.id', 'dupas.category_dupa_id')
        ->join('unit_of_measurements', 'unit_of_measurements.id', 'dupas.unit_id')
        ->join('dupa_contents', 'dupas.id', 'dupa_contents.dupa_id')
        ->join('sow_sub_categories', 'sow_sub_categories.id', 'dupas.subcategory_id')
        ->select('dupas.id', 'dupas.item_number', 'sow_sub_categories.name as scope_of_work_subcategory', 'dupas.description', 'unit_of_measurements.abbreviation', 'dupa_contents.direct_unit_cost', 'category_dupas.name as dupa_category')
        ->orderBy('category_dupas.id')
        ->paginate(10);


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
           $dupa = Dupa::updateOrCreate(
                ['id' => $request['id']],
                [
                    'item_number' => $request['item_number'],
                    'subcategory_id' => $request['subcategory_id'],
                    'description' => $request['description'],
                    'unit_id' => $request['unit_id'],
                    'output_per_hour' => $request['output_per_hour'],
                    'category_dupa_id' => $request['category_dupa_id'],
                ]
            );
            if ($dupa->wasRecentlyCreated) {
                return response()->json([
                    'status' => "Created",
                    'message' => "Dupa Successfully Created"
                ]);
            }else{
                return response()->json([
                    'status' => "Updated",
                    'message' => "Dupa Successfully Updated "
                ]);
            }

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
    public function show(Dupa $dupa)

    {
        $dupa = Dupa::where('dupas.id', $dupa->id)
        ->join('unit_of_measurements', 'unit_of_measurements.id', 'dupas.unit_id')
        ->join('category_dupas', 'category_dupas.id', 'dupas.category_dupa_id')
        ->join('dupa_contents', 'dupas.id', 'dupa_contents.dupa_id')
        ->select('dupas.item_number', 'dupas.description', 'dupas.output_per_hour', 'unit_of_measurements.abbreviation', 'dupa_contents.direct_unit_cost', 'category_dupas.name as dupa_category')
        ->first();


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
