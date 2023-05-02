<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Dupa\AddDupaRequest;
use App\Models\Dupa;
use App\Models\DupaContent;
use App\Models\ProjectNature;
use App\Models\CategoryDupa;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DupaController extends Controller
{

   public function index(){

        $this->computeDirectUnitCost();

        $dupa = CategoryDupa::join('dupas', 'category_dupas.id', 'dupas.category_dupa_id')
            ->join('unit_of_measurements', 'unit_of_measurements.id', 'dupas.unit_id')
            ->join('sow_sub_categories', 'sow_sub_categories.id', 'dupas.subcategory_id')
            ->select('dupas.id', 'dupas.item_number', 'sow_sub_categories.name as scope_of_work_subcategory', 'dupas.description', 'unit_of_measurements.abbreviation', 'dupas.direct_unit_cost', 'category_dupas.name as dupa_category')
            ->orderBy('dupas.id')
            ->paginate(10);


        return response()->json($dupa);

   }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddDupaRequest $request)
    {
        try {
           $dupa = Dupa::updateOrCreate(
                ['id' => $request['id']],
                [
                    'item_number' => $request['item_number'],
                    'subcategory_id' => $request['subcategory_id'],
                    'description' => $request['description'],
                    'unit_id' => $request['unit_id'],
                    'output_per_hour' => $request['output_per_hour'],
                    'category_dupa_id' => $request['category_dupa_id'],
                ]
            );
            if ($dupa->wasRecentlyCreated) {
                return response()->json([
                    'status' => "Created",
                    'message' => "Dupa Successfully Created"
                ]);
            }else{
                return response()->json([
                    'status' => "Updated",
                    'message' => "Dupa Successfully Updated "
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
    public function show(Dupa $dupa)

    {
        $dupa = Dupa::where('dupas.id', $dupa->id)
        ->join('unit_of_measurements', 'unit_of_measurements.id', 'dupas.unit_id')
        ->join('category_dupas', 'category_dupas.id', 'dupas.category_dupa_id')
        ->select('dupas.item_number', 'dupas.description', 'dupas.output_per_hour', 'unit_of_measurements.abbreviation', 'dupas.direct_unit_cost', 'category_dupas.name as dupa_category')
        ->first();

        return response()->json($dupa);
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
    public function destroy(Dupa $dupa)
    {
        try {
            $dupa->delete();

            return response()->json([
                'status' => "Success",
                'message' => "Deleted Successfully"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Error",
                'message' => $th->getMessage()
            ]);
        }
    }

    private function computeDirectUnitCost(){

        $dupa_contents = DupaContent::with([
            'dupaEquipment' => function($q){
                $q->select('dupa_content_id', 'dupa_equipment.*', 'equipment.hourly_rate', 'equipment.name', DB::raw('(dupa_equipment.no_of_unit * dupa_equipment.no_of_hour * equipment.hourly_rate) as equipment_amount'))
                  ->join('equipment', 'equipment.id', '=', 'dupa_equipment.equipment_id');
            },
            'dupaLabor'=> function($r){
               $r->select('dupa_content_id', 'dupa_labors.*', 'labors.hourly_rate', 'labors.designation', DB::raw('(dupa_labors.no_of_person * dupa_labors.no_of_hour * labors.hourly_rate) as labor_amount'))
                  ->join('labors', 'labors.id', '=', 'dupa_labors.labor_id');
            },
            'dupaMaterial' => function($s){
                $s->select('dupa_content_id', 'dupa_materials.*', 'dupa_materials.quantity', 'materials.unit_cost', DB::raw('(dupa_materials.quantity * materials.unit_cost) as material_amount'))
                ->join('materials', 'materials.id', '=', 'dupa_materials.material_id');
            }
            ])
        ->get();

        $results = [];

        foreach ($dupa_contents as $dupa_content) {
            // Get the Output per hour
        $e_output_per_hour = $dupa_content->dupa->output_per_hour;

        // Get the total sum of dupaLabor
        $a_dupaLabor_Total = round($dupa_content->dupaLabor->sum('labor_amount'), 2);

        // Get the total sum of dupaEquipment
        $b_dupaEquipment_Total = round($dupa_content->dupaEquipment->sum('equipment_amount'), 2);

        // Get the Total sum of Labor and Equipment (A + B)
        $c_total_ab = round($a_dupaLabor_Total + $b_dupaEquipment_Total, 2);

        // Get Direct unit cost (C / D)
        $d_direct_unit_cost_c_d = round($c_total_ab / $e_output_per_hour, 2);

        // Get the total sum of dupaMaterial
        $f_dupaMaterial_Total =round( $dupa_content->dupaMaterial->sum('material_amount'), 2);

        // Get Direct unit cost (E + F)
        $g_direct_unit_cost_e_f = round($d_direct_unit_cost_c_d + $f_dupaMaterial_Total, 2);

        // Get Overhead Contingencies and Miscellaneous(OCM) (9% of G)
        $h_ocm = round(0.09 * $g_direct_unit_cost_e_f, 2);

        // Get Contractor's Profit (8% of G)
        $i_contractors_profit = round(0.08 * $g_direct_unit_cost_e_f, 2);

        // Get Value Added Tax (VAT) 12% of (G + H + I)
        $j_vat = round(0.12 * ($g_direct_unit_cost_e_f + $h_ocm + $i_contractors_profit), 2);

        // Get Total unit Cost (G + H + I + J)
        $k_total_unit_cost = round($g_direct_unit_cost_e_f + $h_ocm + $i_contractors_profit + $j_vat, 2);

        $dupa = $dupa_content->dupa;
        $dupa->direct_unit_cost = $k_total_unit_cost;
        $dupa->save();

        }
    }
}
