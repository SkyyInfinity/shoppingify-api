<?php

use App\Http\Controllers\ShoppingListController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'lists',
], function ($router) {
    Route::get('/', [ShoppingListController::class, 'index'])->name('shopping-lists.index');
    Route::get('/current', [ShoppingListController::class, 'getMyList'])->name('shopping-lists.current');
    Route::post('/create', [ShoppingListController::class, 'store'])->name('shopping-lists.create');
    Route::post('/edit/{id}', [ShoppingListController::class, 'update'])->name('shopping-lists.update');
    Route::post('/delete/{id}', [ShoppingListController::class, 'destroy'])->name('shopping-lists.delete');
});
