<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DupaController;
use App\Http\Controllers\DupaContentController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\B3ProjectsController;
use App\Http\Controllers\LaborController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ProjectNatureController;
use App\Http\Controllers\ProjectNatureTypeController;
use App\Http\Controllers\DupaLaborController;
use App\Http\Controllers\DupaEquipmentController;
use App\Http\Controllers\DupaMaterialController;
use App\Http\Controllers\SowSubCategoryController;
use App\Http\Controllers\SowCategoryController;
use App\Http\Controllers\SubCatReferenceController;
use App\Http\Controllers\UnitOfMeasurementController;
use App\Http\Controllers\CategoryDupaController;
use App\Http\Controllers\TakeOffController;
use App\Http\Controllers\TakeOffTableController;
use App\Http\Controllers\TakeOffTableFieldController;
use App\Http\Controllers\TakeOffTableFieldInputController;
use App\Http\Controllers\TakeOffTableFormulaController;
use App\Http\Controllers\FormulaController;


Route::resource('dupa', DupaController::class);

Route::resource('content', DupaContentController::class);

Route::resource('project', B3ProjectsController::class);

Route::resource('nature', ProjectNatureController::class);

Route::resource('type', ProjectNatureTypeController::class);
Route::get('type-list/{type}', [ProjectNatureTypeController::class, 'typeList']);

Route::resource('dupalabor', DupaLaborController::class);

Route::resource('dupaequipment', DupaEquipmentController::class);

Route::resource('dupamaterial', DupaMaterialController::class);

Route::get('subcat-list/{subcat}', [SowSubCategoryController::class, 'sowcatDescendants']);
Route::resource('subcat', SowSubCategoryController::class);

Route::resource('sowcat', SowCategoryController::class);

Route::resource('reference', SubCatReferenceController::class);

Route::resource('measurement', UnitOfMeasurementController::class);

Route::resource('category-dupa', CategoryDupaController::class);

Route::resource('take-off', TakeOffController::class);

Route::resource('formula', FormulaController::class);

Route::get('take-off-table-list/{take_off_table}', [TakeOffTableController::class, 'getAllTakeOffTables']);
Route::resource('take-off-table', TakeOffTableController::class);

Route::resource('take-off-table-field', TakeOffTableFieldController::class);

Route::get('take-off-table-field-input-compute/{take_off_table_field_input}', [TakeOffTableFieldInputController::class, 'calculateFormula']);
Route::get('take-off-table-field-input-list/{take_off_table_field_input}', [TakeOffTableFieldInputController::class, 'inputsByTakeOffIdAndTable']);
Route::resource('take-off-table-field-input', TakeOffTableFieldInputController::class);

Route::get('take-off-table-formula-compute', [TakeOffTableFormulaController::class, 'computeTable']);
Route::resource('take-off-table-formula', TakeOffTableFormulaController::class);

Route::post('upload-material', [MaterialController::class, 'uploadMaterial']);
Route::delete('revert-material', [MaterialController::class, 'revertMaterial']);
Route::post('import-material', [MaterialController::class, 'import']);
Route::resource('material', MaterialController::class);

Route::post('upload-labor', [LaborController::class, 'uploadLabor']);
Route::delete('revert-labor', [LaborController::class, 'revertLabor']);
Route::post('import-labor', [LaborController::class, 'importLabor']);
Route::resource('labor', LaborController::class);

Route::post('upload-equipment', [EquipmentController::class, 'uploadEquipment']);
Route::delete('revert-equipment', [EquipmentController::class, 'revertEquipment']);
Route::post('import-equipment', [EquipmentController::class, 'importEquipment']);
Route::resource('equipment', EquipmentController::class);



