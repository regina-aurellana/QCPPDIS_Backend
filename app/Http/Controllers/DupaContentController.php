<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Dupa\AddDupaContentRequest;
use App\Models\DupaContent;

class DupaContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dupa_content = DupaContent::get();

        return response()->json($dupa_content);
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
    public function store(DupaContentRequest $request)
    {
        try {
            DupaContent::updateOrCreate([
                'dupa_id' => $request['dupa_id'],
            ]);

            return response()->json([
                'status' => 'Success',
                'message' => 'Dupa Content Successfully Added'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DupaContent $content)
    {
        $dupa_content = DupaContent::find($content);

        return response()->json($dupa_content);
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
