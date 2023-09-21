<?php

namespace App\Http\Controllers;

use App\Models\ShoppingList;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    /**
     * Create a new ShoppingListController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $me = auth()->user()->getAuthIdentifier();
            $shoppingLists = ShoppingList::where([
                ['user_id', '=', $me]
            ])->get();
            foreach ($shoppingLists as $list) {
                $list['user'] = User::findOrFail($list->user_id);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Successfully get shopping lists.',
                'data' => $shoppingLists,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => $th->getCode(),
                'message' => 'Failed to get shopping lists : '.$th->getMessage(),
            ], 500);
        }
    }

    public function getMyList(): JsonResponse
    {
        try {
            $me = auth()->user()->getAuthIdentifier();
            $shoppingList = ShoppingList::where([
                ['user_id', '=', $me],
                ['status', '=', 'PENDING']
            ])->first();
            $shoppingList['user'] = User::findOrFail($shoppingList->user_id);

            return response()->json([
                'status' => 200,
                'message' => 'Successfully get shopping list.',
                'data' => $shoppingList,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => $th->getCode(),
                'message' => 'Failed to get shopping list : '.$th->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $me = auth()->user()->getAuthIdentifier();
            $shoppingList = ShoppingList::create([
                'user_id' => $me,
                'name' => $request->name,
                'status' => 'PENDING'
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Successfully create shopping list.',
                'data' => $shoppingList,
            ]);
        } catch(\Throwable $th) {
            return response()->json([
                'status' => $th->getCode(),
                'message' => 'Failed to create shopping list : '.$th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $shoppingList = ShoppingList::findOrFail($id);
            $shoppingList['user'] = User::findOrFail($shoppingList->user_id);

            return response()->json([
                'status' => 200,
                'message' => 'Successfully get shopping list.',
                'data' => $shoppingList,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => $th->getCode(),
                'message' => 'Failed to get shopping list : '.$th->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $shoppingList = ShoppingList::findOrFail($id);
            $shoppingList->update([
                'name' => $request->name ?? $shoppingList->name,
                'status' => $request->status ?? $shoppingList->status
            ]);

            $shoppingList['user'] = User::findOrFail($shoppingList->user_id);

            return response()->json([
                'status' => 200,
                'message' => 'Successfully updated shopping list.',
                'data' => $shoppingList,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => $th->getCode(),
                'message' => 'Failed to update shopping list : '.$th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $shoppingList = ShoppingList::findOrFail($id);
            $shoppingList->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Successfully deleted shopping list.',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => $th->getCode(),
                'message' => 'Failed to delete shopping list : '.$th->getMessage(),
            ], 500);
        }
    }
}
