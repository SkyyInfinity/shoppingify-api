<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $checklists = Checklist::query()
            ->with(['user' => fn ($query) => $query->select('id', 'username', 'email', 'last_login_at')])
            ->get()
            ->makeHidden('user_id');

        return response()->json($checklists);
    }

    /**
     * Display a listing of the resource.
     */
    public function current(): JsonResponse
    {
        if (! auth()->check()) {
            return response()->json([
                'message' => 'Unauthenticated',
                'success' => false,
            ], 401);
        }

        $checklists = Checklist::query()
            ->where([
                'user_id' => auth()->id(),
                'status' => 'pending',
            ])
            ->first();

        return response()->json($checklists);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if (! auth()->check()) {
            return response()->json([
                'message' => 'Unauthenticated',
                'success' => false,
            ], 401);
        }

        Checklist::query()->create([
            'id' => uniqid(),
            'user_id' => auth()->id(),
            'name' => $request->name,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Checklist created successfully',
            'success' => true,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (! auth()->check()) {
            return response()->json([
                'message' => 'Unauthenticated',
                'success' => false,
            ], 401);
        }

        $checklist = Checklist::query()
            ->where([
                'id' => $id,
                'user_id' => auth()->id(),
                'status' => 'pending',
            ])
            ->first();

        if (! $checklist) {
            return response()->json([
                'message' => 'Checklist not found',
                'success' => false,
            ], 404);
        }

        $checklist->update([
            'name' => $request->name ?? $checklist->name,
            'status' => $request->status ?? $checklist->status,
        ]);

        return response()->json([
            'message' => 'Checklist updated successfully',
            'success' => true,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (! auth()->check()) {
            return response()->json([
                'message' => 'Unauthenticated',
                'success' => false,
            ], 401);
        }

        $checklist = Checklist::query()
            ->where([
                'id' => $id,
                'user_id' => auth()->id(),
            ])
            ->first();

        if (! $checklist) {
            return response()->json([
                'message' => 'Checklist not found',
                'success' => false,
            ], 404);
        }

        $checklist->delete();

        return response()->json([
            'message' => 'Checklist deleted successfully',
            'success' => true,
        ], 200);
    }
}
