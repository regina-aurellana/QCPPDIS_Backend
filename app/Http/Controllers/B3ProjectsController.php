<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\B3Project\AddProjectRequest;
use App\Models\B3Projects;

class B3ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $b3Projects = B3Projects::get();

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
            B3Projects::create([
                'registry_no' => $request['registry_no'],
                'project_title' => $request['project_title'],
                'project_nature' => $request['project_nature'],
                'project_nature_type' => $request['project_nature_type'],
                'location' => $request['location'],
                'status' => $request['status'],
            ]);

            return response()->json([
                'status' => "SUCCESS",
                'message' => "Successfully Added Material"
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
    public function update(Request $request, string $id)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
