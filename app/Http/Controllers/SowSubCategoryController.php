<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SowSubCategory\SowSubCategoryRequest;
use App\Models\SowSubCategory;

class SowSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcat = SowSubCategory::with('references')
        ->get();

        return response()->json($subcat);
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
    public function store(SowSubCategoryRequest $request)
    {
        try {
            $subcat = SowSubCategory::updateOrCreate(
                 ['id' => $request['sow_subcat_id']],
                 [
                     'item_code' => $request['item_code'],
                     'name' => $request['name'],
                     'sow_cat_id' => $request['sow_cat_id'],
                 ]
         );


             if ($subcat->wasRecentlyCreated) {
                 return response()->json([
                     'status' => "Created",
                     'message' => "SubCat Successfully Created"
                 ]);
             }else{
                 return response()->json([
                     'status' => "Updated",
                     'message' => "SubCat Successfully Updated "
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
    public function show(SowSubCategory $subcat)
    {
        $subcat = SowSubCategory::where('id', $subcat->id)
        ->with('parentSubcategory')
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
