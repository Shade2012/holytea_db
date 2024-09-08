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
    Route::get('/details', [UserController::class, 'details'])->middleware('auth:sanctum');
});


