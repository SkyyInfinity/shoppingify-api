<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes for your application. These
| routes are loaded by the RouteServiceProvider within a group.
| Enjoy building your auth!
|
*/
Route::group(['prefix' => 'auth'], function ($router) {

    /**
     * Sign up a new user
     */
    Route::post('register', [\App\Http\Controllers\AuthController::class, 'register'])->name('auth.register');
    /**
     * Verify a new user
     */
    Route::post('verify', [\App\Http\Controllers\AuthController::class, 'verify'])->name('auth.verify');
    /**
     * Sign in a user
     */
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
    /**
     * Sign out a user
     */
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
    /**
     * Refresh a user token
     */
    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh'])->name('auth.refresh');
    /**
     * Get user data
     */
    Route::post('me', [\App\Http\Controllers\AuthController::class, 'me'])->name('auth.me');

});
