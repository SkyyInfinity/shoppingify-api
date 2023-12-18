<?php

use App\Http\Controllers\ChecklistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Checklist Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Emails routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Emails!
|
*/
Route::group(['prefix' => 'checklists'], function () {

    /**
     * Send test email
     */
    Route::get('/', [ChecklistController::class, 'index'])->name('checklists.index');

});
