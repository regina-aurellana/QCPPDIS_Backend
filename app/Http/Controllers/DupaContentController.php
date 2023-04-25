<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DupaContent\AddDupaContentRequest;
use App\Models\DupaContent;
use App\Models\Dupa;
use Illuminate\Support\Facades\DB;

class DupaContentController extends Controller
{




    public function index()
    {
        $dupa_content = DupaContent::with(['dupaEquipment', 'dupaLabor', 'dupaMaterial'])
        ->get();

        return response()->json($dupa_content);
    }

    public function create()
    {
        //
    }

    public function store(AddDupaContentRequest $request)
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

    public function show(DupaContent $content)
    {
        $dupa_content = DupaContent::where('id', $content->id)
        ->with([
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
        ->first();

        // Get the Output per hour
        $e_output_per_hour = Dupa::find($content)
            ->first()
            ->output_per_hour;

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

        $dupa_content->direct_unit_cost = $k_total_unit_cost;
        $dupa_content->save();

        return response()->json([
            'dupa_content' => $dupa_content,
            'a_dupaLaborTotal' => $a_dupaLabor_Total,
            'b_dupaEquipmentTotal' => $b_dupaEquipment_Total,
            'c_total_ab' => $c_total_ab,
            'd_direct_unit_cost_c_d' => $d_direct_unit_cost_c_d,
            'e_output_per_hour' => $e_output_per_hour,
            'f_dupaMaterialTotal' => $f_dupaMaterial_Total,
            'g_direct_unit_cost_e_f' => $g_direct_unit_cost_e_f,
            'h_ocm' => $h_ocm,
            'i_contractors_profit' => $i_contractors_profit,
            'j_vat' => $j_vat,
            'k_total_unit_cost' => $k_total_unit_cost,
        ]);


    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }

}
