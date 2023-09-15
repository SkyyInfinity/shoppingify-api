<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppingListController;

Route::get('/', [ShoppingListController::class, 'index'])->name('shopping-lists.index');
