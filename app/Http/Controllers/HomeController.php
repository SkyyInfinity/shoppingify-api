<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $routes = [];
        $routeCollection = Route::getRoutes();

        foreach ($routeCollection->getRoutes() as $value) {
            if (! str_starts_with($value->uri, '_') && ! str_starts_with($value->uri, 'sanctum')) {
                $routes[] = [
                    'uri' => $value->uri,
                    'methods' => $value->methods,
                ];
            }
        }

        return response()->json([
            'app' => config('app.name'),
            'repository' => 'https://github.com/SkyyInfinity',
            'laravel' => app()->version(),
            'php' => PHP_VERSION,
            'message' => 'Welcome to '.config('app.name').'!',
            'status' => 200,
            'routes' => $routes,
        ]);
    }
}
