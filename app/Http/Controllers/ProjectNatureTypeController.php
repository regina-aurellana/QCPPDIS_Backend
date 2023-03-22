<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectNatureType\AddProjectNatureTypeRequest;

use App\Models\ProjectNatureType;

class ProjectNatureTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proj_nature_type = ProjectNatureType::join('project_natures', 'project_natures.id', 'project_nature_types.project_nature_id')
        ->select('project_nature_types.*', 'project_natures.name as project_nature_name')
        ->get();

        return response()->json($proj_nature_type);
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
    public function store(AddProjectNatureTypeRequest $request)
    {
        try {
            ProjectNatureType::updateOrCreate(
                ['name' => $request['name']],
                    [
                        'project_nature_id' => $request['project_nature_id'],
                    ]
            );

            return response()->json([
                'status' => "SUCCESS",
                'message' => "Successfully Added Project Nature"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "SUCCESS",
                'message' => $th->getMessage
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectNatureType $projnature_type)
    {
        $proj_nature_type = $projnature_type
            ->join('project_natures', 'project_natures.id', 'project_nature_types.project_nature_id')
            ->select('project_nature_types.*', 'project_natures.name as project_nature_name')
            ->where('project_nature_types.id', $projnature_type->id)            
            ->first();

        return response()->json($proj_nature_type);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        
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
