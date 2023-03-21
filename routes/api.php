<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DupaController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\B3ProjectsController;

 
Route::resource('dupa', DupaController::class);

Route::resource('material', MaterialController::class);

Route::resource('project', B3ProjectsController::class);
