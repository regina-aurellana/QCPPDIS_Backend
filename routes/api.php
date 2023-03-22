<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DupaController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\B3ProjectsController;
use App\Http\Controllers\LaborController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ProjectNatureController;

 
Route::resource('dupa', DupaController::class);

Route::resource('material', MaterialController::class);

Route::resource('project', B3ProjectsController::class);

Route::resource('labor', LaborController::class);

Route::resource('equipment', LaborController::class);

Route::resource('nature', ProjectNatureController::class);
