<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\RatingController;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::group(['middleware' => 'auth:api'], function ($router) {
   Route::post('/index', [DishController::class, 'index']);
   Route::post('/store', [DishController::class, 'store']);
   Route::post('/show/{id}', [DishController::class, 'show']);
   Route::post('/update/{id}', [DishController::class, 'update']);
   Route::post('/destroy/{id}', [DishController::class, 'destroy']);

   Route::post('/rating/{user_id}/{dish_id}', [RatingController::class, 'rating']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});