<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//importamos el StudentController
use App\Http\Controllers\Api\StudentController;

Route::get('/students', [StudentController::class, 'index']);

Route::post('/students', [StudentController::class, 'store']);

Route::delete('/students/{id}', [StudentController::class, 'destroy']);

Route::put('/students/{id}', [StudentController::class, 'update']);

