<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MenuController;
Route::group(['prefix' => 'menus'], function() {
    Route::get('/', [MenuController::class, 'index']);
    Route::post('/store', [MenuController::class, 'store']);
    Route::delete('/{id}', [MenuController::class, 'delete']);
});

use App\Http\Controllers\UserController;
Route::group(['prefix' => '/users'], function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/all-users', [UserController::class, 'allUsers']);
    Route::get('/details', [UserController::class, 'details'])->middleware('auth:sanctum');
});

use App\Http\Controllers\ToppingController;
Route::group(['prefix' => '/toppings'], function () {
    Route::get('/index', [ToppingController::class, 'index']);
    Route::post('/store', [ToppingController::class, 'store']);
    Route::delete('/delete', [ToppingController::class, 'delete']);
});

