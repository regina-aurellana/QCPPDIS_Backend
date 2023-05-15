<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SowCategory\SowCategoryRequest;

use App\Models\SowCategory;

class SowCategoryController extends Controller
{

    public function index()
    {
        $sow_cat = SowCategory::get();

        return response()->json($sow_cat);
    }


    public function create()
    {
        //
    }

    public function store(SowCategoryRequest $request)
    {
        try {
           $sow_cat = SowCategory::updateOrCreate(
                ['id' => $request['id']],
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

    public function show(SowCategory $sowcat)
    {
        $sow_cat = SowCategory::where('sow_categories.id', $sowcat->id)
        ->first();

        return response()->json($sow_cat);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

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
                'message' => $th->getMessage()
            ]);
        }
    }
}
