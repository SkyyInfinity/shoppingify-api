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
    Route::post('signup', [\App\Http\Controllers\AuthController::class, 'signUp'])->name('auth.signup');
    /**
     * Verify a new user
     */
    Route::post('verify', [\App\Http\Controllers\AuthController::class, 'verify'])->name('auth.verify');
    /**
     * Sign in a user
     */
    Route::post('signin', [\App\Http\Controllers\AuthController::class, 'signIn'])->name('auth.signin');
    /**
     * Sign out a user
     */
    Route::post('signout', [\App\Http\Controllers\AuthController::class, 'signOut'])->name('auth.signout');
    /**
     * Refresh a user token
     */
    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh'])->name('auth.refresh');
    /**
     * Get user data
     */
    Route::post('me', [\App\Http\Controllers\AuthController::class, 'me'])->name('auth.me');

});
