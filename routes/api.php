<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login',[\App\Http\Controllers\Api\LoginController::class,'login'])->name('login');
//Rotas privadas
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout',[\App\Http\Controllers\Api\LoginController::class,'logout']);

    // Rotas criar usuarios
    Route::get('/user',[UserController::class,'index']);

    Route::put('/user/{user}',[UserController::class,'update']);

    Route::post('/user',[\App\Http\Controllers\Api\UserController::class,'store']);

    Route::delete('/user/{user}',[UserController::class,'destroy']);
//Fim

    /*Rotas de client*/
    Route::post('/client',[\App\Http\Controllers\ClientController::class,'store']);
    Route::get('/client',[\App\Http\Controllers\ClientController::class,'index']);
});

