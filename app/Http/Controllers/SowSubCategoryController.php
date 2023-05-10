<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SowSubCategory\SowSubCategoryRequest;
use App\Models\SowSubCategory;
use App\Models\SowReference;

class SowSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcat = SowSubCategory::with('parentSubCategory')
        ->with('sowCategory')
        ->get();

        return response()->json($subcat);


        // $main_sub_category = SowSubCategory::where('id', 2)->first();
        // $data = $main_sub_category->getAllChildrenSubCategory($main_sub_category);

        // return $data;
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

            $parent_sub_cat_id = $request->input('parent_sub_cat_id');

            $subcat = SowSubCategory::updateOrCreate(
                ['item_code' => $request['item_code']],
                [
                    'name' => $request['name'],
                    'sow_category_id' => $request['sow_category_id'],
                ]
        );

            SowReference::updateOrCreate(
                ['sow_sub_category_id' => $subcat->id],
                ['parent_sow_sub_category_id' => $parent_sub_cat_id]

            );
/*
            fetch subcategory
            $main_category = SowCategory::find(1)->with('sowSubCategory');

            fetch all subsub from main_sub_category
            $main_sub_category = SowSubCategory::where('id', 2)->first();
            $data = $main_sub_category->getAllChildrenSubCategory($main_sub_category);


            fetch all subsub from main_sub_category
            $main_sub_category = SowSubCategory::find(1);
            $main_sub_category->getAllChildrenSubCategory();

            fetch subsub
            $subcat = SowSubCategory::where('id', $id)->with('children')->get();

            */
        //     $subcat = SowSubCategory::updateOrCreate(
        //          ['id' => $request['id']],
        //          [
        //              'item_code' => $request['item_code'],
        //              'name' => $request['name'],
        //              'sow_cat_id' => $request['sow_cat_id'],
        //          ]
        //  );


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

        return response()->json([
            'status' => "Created",
            'message' => "SubCat Successfully Created"
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
    public function show(SowSubCategory $subcat)
    {

        $subcat = SowSubCategory::where('id', $subcat->id)
        ->with('parentSubCategory')
        ->with('sowCategory')
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

            $subcat->references()->delete();
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
