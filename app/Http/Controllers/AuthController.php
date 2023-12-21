<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\VerifyRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private readonly MailController $mailController;
    private readonly UtilsController $utilsController;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => [
                'login',
                'register',
                'verify'
            ]
        ]);
    }

    /**
     * Register a new user.
     *
     * @throws ValidationException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        // Validate request
        $subscriber = $request->validated();
        // Generate token
        $token = $this->utilsController->generateToken();
        // Create user
        $user = User::create([
            'username' => $subscriber['username'],
            'email' => $subscriber['email'],
            'password' => Hash::make($subscriber['password']),
            'action_token' => $token,
        ]);

        // Send email to user with token and user data
        $this->mailController->registerMail($user->email, [
            'user' => $user,
            'token' => $token,
        ]);

        // Return response
        return response()->json([
            'message' => 'User successfully registered!',
            'success' => true,
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function verify(VerifyRequest $request): JsonResponse
    {
        // Validate request
        $request->validated();

        // Find user
        try {
            $user = User::where('id', $request->input('id'))->firstOrFail();

            // Check if user is already verified
            if ($user->email_verified_at) {
                return response()->json([
                    'message' => 'Email already verified!',
                    'success' => false,
                ], 400);
            }

            // Check if token is valid
            if ($user->action_token !== $request->input('token')) {
                return response()->json([
                    'message' => 'Invalid token!',
                    'success' => false,
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User not found!',
                'error' => $e->getMessage(),
            ]);
        }

        // Update user with verified email
        $user->action_token = null;
        $user->email_verified_at = now();
        $user->save();

        // Send email to user with token and user data
        $this->mailController->verifyMail($user->email, [
            'user' => $user,
        ]);

        // Return response
        return response()->json([
            'message' => 'Email verified successfully!',
            'success' => true
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

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 // @phpstan-ignore-line
        ]);
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

        return response()->json([
            'message' => 'Successfully logged out!',
            'success' => true
        ]);
    }

    /**
     * Refresh a token.
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }
}
