<?php

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('employee', EmployeeController::class);

    Route::post('logout', [UserController::class, 'logout']);
});
