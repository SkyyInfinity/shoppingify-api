<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'app' => config('app.name'),
            'repository' => 'https://github.com/SkyyInfinity',
            'laravel' => app()->version(),
            'php' => PHP_VERSION,
            'message' => 'Welcome to the '.config('app.name').'!',
            'status' => 200,
        ]);
    }
}
