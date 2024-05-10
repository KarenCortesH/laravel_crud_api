<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//importamos el StudentController
use App\Http\Controllers\Api\studentController;

Route::get('/students', [studentController::class, 'index']);

Route::post('/students',[studentController::class, 'store']);
Route::put('/students/{id}', function () {
    return "Update students";
});

Route::put('/students/{id}', function () {
    return "Delete students";
});
