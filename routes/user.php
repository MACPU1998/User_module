<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserManagement\UserController;
use Illuminate\Support\Facades\Route;

/*
Route::middleware(['web'])->prefix("user")->name("user.")->group(function () {
    Route::prefix("user_management")->name("users_management.")->group(function(){
        Route::resource("users",UserController::class);
    });
});*/


Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::get('logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');

//register
Route::get('register', [RegisteredUserController::class, 'create'])
    ->name('register');
//register post
Route::post('register', [RegisteredUserController::class, 'store'])->name('register.store');


