<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return [
        'app' => config('app.name'),
        'repository' => 'https://github.com/SkyyInfinity/shoppingify-api',
        'laravel' => app()->version(),
        'php' => PHP_VERSION,
        'message' => 'Welcome to the Shoppingify API!',
        'status' => 200,
    ];
})->name('home');

// EMAILS
Route::post('/test-mail', [App\Http\Controllers\MailController::class, 'sendTestMail'])->name('test.mail');

// AUTH
//Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//    return $request->user();
//});

require __DIR__.'/auth.php';
