<?php

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'menus'], function() {
    Route::get('/', [MenuController::class, 'index']);
});



