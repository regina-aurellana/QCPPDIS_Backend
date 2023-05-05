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


Route::resource('dupa', DupaController::class);

Route::resource('content', DupaContentController::class);

Route::resource('material', MaterialController::class);

Route::resource('project', B3ProjectsController::class);

Route::resource('labor', LaborController::class);

Route::resource('equipment', EquipmentController::class);

Route::resource('nature', ProjectNatureController::class);

Route::resource('type', ProjectNatureTypeController::class);
Route::get('type-list/{type}', [ProjectNatureTypeController::class, 'typeList']);

Route::resource('dupalabor', DupaLaborController::class);

Route::resource('dupaequipment', DupaEquipmentController::class);

Route::resource('dupamaterial', DupaMaterialController::class);

Route::resource('subcat', SowSubCategoryController::class);

Route::resource('sowcat', SowCategoryController::class);

Route::resource('reference', SubCatReferenceController::class);

Route::resource('measurement', UnitOfMeasurementController::class);

Route::resource('category-dupa', CategoryDupaController::class);

Route::post('upload-material', [MaterialController::class, 'uploadMaterial']);
Route::delete('revert-material', [MaterialController::class, 'revertMaterial']);
Route::post('import-material', [MaterialController::class, 'import']);


Route::post('upload-labor', [LaborController::class, 'uploadLabor']);
Route::delete('revert-labor', [LaborController::class, 'revertLabor']);
Route::post('import-labor', [LaborController::class, 'importLabor']);

Route::post('upload-equipment', [EquipmentController::class, 'uploadEquipment']);
Route::delete('revert-equipment', [EquipmentController::class, 'revertEquipment']);
Route::post('import-equipment', [EquipmentController::class, 'importEquipment']);

