<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SowCategory\SowCategoryRequest;

use App\Models\SowCategory;

class SowCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sow_cat = SowCategory::with('sowSubCategory.reference.SubCategory.reference.SubCategory')
        ->get();

        return response()->json($sow_cat);
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
    public function store(SowCategoryRequest $request)
    {
        try {
           $sub_cat = SowCategory::updateOrCreate(
                ['id' => $request['sow_cat_id']],
                [
                    'item_code' => $request['item_code'],
                    'name' => $request['name'],
                ]
        );


            if ($sow_cat->wasRecentlyCreated) {
                return response()->json([
                    'status' => "Created",
                    'message' => "SOW Successfully Created"
                ]);
            }else{
                return response()->json([
                    'status' => "Updated",
                    'message' => "SOW Successfully Updated "
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
    public function show(SowCategory $sowcat)
    { //get child of sow category
        $sow_cat = SowCategory::leftJoin('sow_sub_categories', 'sow_categories.id', 'sow_sub_categories.sow_cat_id')
        ->leftJoin('sub_cat_references', 'sow_sub_categories.id', 'sub_cat_references.parent_id')
        ->select('sow_categories.item_code as sowcat_item_code', 'sow_sub_categories.item_code as subcat_item_code', 'sub_cat_references.sow_subcat_id')
        ->where('sow_categories.id', $sowcat->id)
        ->get();

        return response()->json($sow_cat);
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
    public function destroy(SowCategory $sowcat)
    {
        try {
            $sowcat->delete();

            return response()->json([
                'status' => "Deleted",
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
