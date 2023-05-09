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
        $subcat = SowSubCategory::leftJoin('sow_categories', 'sow_categories.id', 'sow_sub_categories.sow_category_id')
        ->select('sow_sub_categories.*', 'sow_categories.name as sow_cat_name')
        ->get();

        return response()->json($subcat);
    }

    public function test($subcat){
        $categories = $subcat->children;

        foreach ($categories as $category) {
            $category->children = $this->test($category);
        }

        return $categories;
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
            /*
            $category_id = $request->category_id;

            $subcat = SowSubCategory::create([
                'item_code' => $request['item_code'],
                'name' => $request['name'],
                'sow_cat_id' => $request['sow_category_id'],
            ]);

            SowReference::create([
                'parent_sow_sub_category_id' => $category_id,
                'sow_sub_category_id' => $subcat->id
            ]);

            fetch subcategory
            $main_category = SowCategory::find(1)->with('sowSubCategory');

            fetch all subsub from main_sub_category
            $main_sub_category = SowSubCategory::where('id', 2)->first();
            $data = $main_sub_category->getAllChildrenSubCategory($main_sub_category);

            fetch subsub
            $subcat = SowSubCategory::where('id', $id)->with('children')->get();

            */
            $subcat = SowSubCategory::updateOrCreate(
                 ['id' => $request['id']],
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
                     'message' => "SubCat Successfully Updated"
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
        ->with('Subcategory')
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
    public function destroy(SowSubCategory $subcat)
    {
        try {
            $subcat->delete();

            return response()->json([
                'status' => "Deleted",
                'message' => "Deleted Successfully"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Error",
                'message' => $th->getMessage()
            ]);
        }
    }
}
