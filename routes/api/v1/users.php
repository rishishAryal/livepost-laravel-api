<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;

//Route::apiResource('users',UserController::class);
Route::middleware([
//    'auth:api',
])
    ->name('users.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {
        Route::get('/users', [UserController::class, 'index'])
            ->name('index')
            ->withoutMiddleware('auth');

        Route::get('/users/{user}', [UserController::class, 'show'])
            ->name('show')
            ->whereNumber('user');

        Route::post('/users', [UserController::class, 'store'])->name('store');

        Route::post('/users/{user}', [UserController::class, 'update'])->name('update');

        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
