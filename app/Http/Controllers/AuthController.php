<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $this->loginRateLimit($request);

        // Authenticate the user
        $user = User::where("email", $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                "email" => "The provided credentials are incorrect."
            ]);
        }

        // Create an authentication token
        $token = $user->createToken("auth_token")->plainTextToken;

        // Return the response
        return response()->json([
            "access_token" => $token,
            "token_type" => "bearer",
        ]);
    }

    protected function loginRateLimit(Request $request)
    {
        $email = $request->input('email');
        $key = 'login-' . $email;

        Log::info("Login attempt for email: $email");

        RateLimiter::for($key, function (Request $request) use ($key) {
            return Limit::perMinute(5)
                ->by($key);
        });

        try {
            $hits = RateLimiter::hit($key);
            Log::info("Login attempt count for $key: $hits");

            if ($hits > 5) {
                Log::warning("Too many login attempts for $key");
                throw new TooManyRequestsHttpException(
                    'Too many login attempts for this email, please try again later.'
                );
            }
        } catch (\Exception $e) {
            Log::error("Error during login rate limiting: " . $e->getMessage());
            throw $e;
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(["message" => "logged out successfully"]);
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
