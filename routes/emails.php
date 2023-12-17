<?php

use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Emails Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Emails routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Emails!
|
*/
Route::group(['prefix' => 'emails'], function () {

    /**
     * Send test email
     */
    Route::post('/test', [MailController::class, 'testMail'])->name('emails.test');

});
