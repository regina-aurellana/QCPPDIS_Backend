<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SowSubCategory\AddSowSubCategoryRequest;
use App\Models\SowSubCategory;

class SowSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcat = SowSubCategory::with('subCatReferenceAncestor')
        ->get();

        return response()->json($subcat);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SowSubCategory $subcat)
    {
        $subcat = SowSubCategory::where('id', $subcat->id)
        ->with('referenceParent')
        ->first();

        return response()->json($subcat);
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
