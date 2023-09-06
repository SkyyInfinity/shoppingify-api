<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'verify']]);
    }

    /**
     * Register a new user.
     *
     * @throws ValidationException
     */
    public function register(UtilsController $utils, MailController $mailController): JsonResponse
    {
        // Validate request
        $this->validate(request(), [
            'username' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:5',
        ]);
        $subscriber = request(['username', 'email', 'password']);

        // Generate token
        $token = $utils->generateToken();

        // Create user
        $user = User::create([
            'username' => $subscriber['username'],
            'email' => $subscriber['email'],
            'password' => Hash::make($subscriber['password']),
            'action_token' => $token,
        ]);

        // Send email to user with token and user data
        try {
            $mailController->sendRegisterMail($user->email, [
                'user' => $user,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Email not sent!',
                'error' => $e->getMessage(),
            ]);
        }

        // Return response
        return response()->json([
            'message' => 'User successfully registered!',
            'success' => true,
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function verify(MailController $mailController): JsonResponse
    {
        // Validate request
        $this->validate(request(), [
            'token' => 'required|string',
        ]);

        // Get request params
        $id = request('id');
        $token = request('token');

        // Find user
        $user = User::where('id', $id)->firstOrFail();

        // Update user with verified email
        $user->action_token = null;
        $user->email_verified_at = now();
        $user->save();

        // Send email to user with token and user data
        try {
            $mailController->sendVerifyMail($user->email, [
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Email not sent!',
                'error' => $e->getMessage(),
            ]);
        }

        // Return response
        return response()->json([
            'message' => 'Email verified successfully!',
            'success' => true,
        ]);
    }

    /**
     * Get a JWT via given credentials.
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60, // @phpstan-ignore-line
        ]);
    }
}
