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
     * Get all checklists
     */
    Route::get('/', [ChecklistController::class, 'index'])->name('checklists.index');
    /**
     * Get current user checklists
     */
    Route::get('/current', [ChecklistController::class, 'current'])->name('checklists.current');
    /**
     * Create new checklist
     */
    Route::post('/create', [ChecklistController::class, 'store'])->name('checklists.create');
    /**
     * Update checklist
     */
    Route::patch('/edit/{id}', [ChecklistController::class, 'update'])->name('checklists.edit');
    /**
     * Delete checklist
     */
    Route::delete('/delete/{id}', [ChecklistController::class, 'destroy'])->name('checklists.delete');

});
