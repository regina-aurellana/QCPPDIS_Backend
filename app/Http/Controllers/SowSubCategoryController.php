<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SowSubCategory\SowSubCategoryRequest;
use App\Models\SowSubCategory;
use App\Models\SowCategory;
use App\Models\SowReference;

class SowSubCategoryController extends Controller
{

    public function index()
    {
        // $subcat = SowCategory::with('sowSubCategory')
        // ->get();

        // return response()->json($subcat);


        // $main_sub_category = SowSubCategory::where('id', 2)->first();
        // $data = $main_sub_category->getAllChildrenSubCategory($main_sub_category);


        // return $data;

        $main_sub_category = SowSubCategory::where('id', 11)->first();
        $data = $main_sub_category->getAllChildrenSubCategory($main_sub_category);


        return $data;

    }

    // public function test($subcat){
    //     $categories = $subcat->children;

    //     foreach ($categories as $category) {
    //         $category->children = $this->test($category);
    //     }

    //     return $categories;
    // }


    public function create()
    {

    }

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


    public function show(SowSubCategory $subcat)
    {
        // DISPLAY SOW CATEGORY AND PARENT SUBCATEGORY
        $subcat = SowSubCategory::where('id', $subcat->id)
        ->with('parentSubCategory')
        ->with('sowCategory')
        ->first();

        return response()->json($subcat);

        // // DISPLAY ALL CHILDREN SUBCATEGORY OF A SOWCAT ID

        // $main_category = SowCategory::where('id', $subcat->id)->first();
        // $main_data = $main_category->sowSubCategory()->first();
        // $main_data->getAllChildrenSubCategory($main_data);

        // return $main_data;
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

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
