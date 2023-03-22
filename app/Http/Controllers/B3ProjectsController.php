<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\B3Project\AddProjectRequest;
use App\Http\Requests\B3Project\UpdateProjectRequest;
use App\Models\B3Projects;

class B3ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $b3Projects = B3Projects::join('project_natures', 'b3_projects.id', 'b3_projects.project_nature_id' )
        ->join('project_nature_types', 'project_natures.id', 'project_nature_types.project_nature_id')        
        ->select('b3_projects.registry_no', 'b3_projects.project_title', 'b3_projects.location', 'project_natures.name As project_nature', 'project_nature_types.name As project_nature_type', 'b3_projects.status')
        ->paginate(2);

        return response()->json($b3Projects);
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
    public function store(AddProjectRequest $request){

        try {
            // B3Projects::create([
            //     'registry_no' => $request['registry_no'],
            //     'project_title' => $request['project_title'],
            //     'project_nature_id' => $request['project_nature'],
            //     'project_nature_type' => $request['project_nature_type'],
            //     'location' => $request['location'],
            //     'status' => $request['status'],
            // ]);
            // return $request;

              $proj = B3Projects::updateOrCreate(
                ['registry_no' => $request['registry_no']],
                    [
                        'project_title' => $request['project_title'],
                        'project_nature_id' => $request['project_nature_id'],
                        'project_nature_type_id' => $request['project_nature_type_id'],
                        'location' => $request['location'],
                        'status' => $request['status'],
                    ]
               );

            return response()->json([
                'status' => "SUCCESS",
                'message' => "Successfully Added Project"
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => "error",
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(UpdateProjectRequest $request, B3Projects $project)
    {
       try {
            $project->update([
                'registry_no' => $request->registry_no,
                'project_title' => $request->project_title,
                'project_nature' => $request->project_nature,
                'project_nature_type' => $request->project_nature_type,
                'location' => $request->location,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => 'Success',
                'message' => 'B3 Project is Updated'
            ]);
       } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Success',
                'message' => $th->getMessage()
            ]);
       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
