<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectNature\AddProjectNatureRequest;

use App\Models\ProjectNature;

class ProjectNatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proj_nature = ProjectNature::get();

        return response()->json($proj_nature);
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
    public function store(AddProjectNatureRequest $request)
    {
        try {
            ProjectNature::updateOrCreate([
                'name' => $request['name'],
            ]);

            return response()->json([
                'status' => "SUCCESS",
                'message' => "Successfully Added Project Nature"
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
    public function show(ProjectNature $nature)
    {
        $proj_nature = ProjectNature::with('projectNatureType')
        ->where('project_natures.id', $nature->id)
        ->first();

        return response()->json($proj_nature);
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
    public function destroy(string $id)
    {
        //
    }
}
