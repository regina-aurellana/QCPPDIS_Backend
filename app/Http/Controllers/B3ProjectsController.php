<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\B3Project\AddProjectRequest;
use App\Http\Requests\B3Project\UpdateProjectRequest;
use App\Models\B3Projects;
use Carbon\Carbon;

class B3ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $b3Projects = B3Projects::join('project_nature_types', 'project_nature_types.id', 'b3_projects.project_nature_type_id' )
        ->join('project_natures', 'project_natures.id', 'project_nature_types.project_nature_id')
        ->select('b3_projects.id', 'b3_projects.registry_no', 'b3_projects.project_title', 'b3_projects.location', 'b3_projects.status', 'project_natures.name AS project_nature_id', 'project_nature_types.name As project_nature_type_id')
        ->get();

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
					if($request['registry_no'] == null){

						$count =B3Projects::count();
						$str = sprintf('%04d', ++$count );
						$ded = "DED";
						$ded_num = $ded . Carbon::now('Asia/Manila')->format('Y'). '_' . $str;

						$proj = B3Projects::updateOrCreate(
							['registry_no' => $ded_num],
									[
											'project_title' => $request['project_title'],
											'project_nature_id' => $request['project_nature_id'],
											'project_nature_type_id' => $request['project_nature_type_id'],
											'location' => $request['location'],
											'status' => $request['status'],
									]
						 );
					} else{

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

					}

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
    public function show(B3Projects $project)
    {
        $b3Projects = $project->join('project_nature_types', 'project_nature_types.id', 'b3_projects.project_nature_type_id' )
        ->join('project_natures', 'project_natures.id', 'project_nature_types.project_nature_id')
        ->select('b3_projects.*', 'project_natures.name As project_nature', 'project_nature_types.name As project_nature_type')
        ->where('b3_projects.id', $project->id)
        ->first();

        return response()->json($b3Projects);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, B3Projects $project)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(B3Projects $project)
    {
        // try {
        //     $project->delete();

        //     return response()->json([
        //         'status' => "SUCCESS",
        //         'message' => "Deleted Successfully"
        //     ]);

        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'status' => "Error",
        //         'message' => $th->getMessage
        //     ]);
        // }
    }
}
