<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;

//Route::apiResource('users',UserController::class);
Route::middleware('auth')->
    name('users.')->
    group(function (){
    Route::get('/users',[UserController::class,'index'])->name('index');
    Route::get('/users/{user}',[UserController::class,'show'])->name('show');
    Route::post('/users',[UserController::class,'store'])->name('store');
    Route::patch('/users/{user}',[UserController::class,'update'])->name('update');
    Route::delete('/users/{user}',[UserController::class,'destroy'])->name('destroy');
});
