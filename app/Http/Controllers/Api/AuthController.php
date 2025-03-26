<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'full_name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'profile_pic' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $customer = Customer::create($validated);
        $token = $customer->createToken('auth-token')->plainTextToken;

        return response()->json([
            'customer' => $customer,
            'token' => $token
        ], 201);
    }

    // Login user
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = Customer::where('email', $validated['email'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function user(Request $request)
    {
        $coupons = $request->user()->coupons()->where('is_active' , true)->where(function($query) {
            $query->whereNull('expiration_date')
                  ->orWhere('expiration_date', '>', now());
        })->get();

        return response()->json([
            'user' => $request->user(),
            'coupon' => $coupons
        ]);
    }

    // Logout user
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

    // Logout from all devices
    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out from all devices']);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        try {
        $validated = $request->validate([
            'full_name' => 'nullable|string',
            'profile_pic' => 'nullable|string',
            'phone' => 'nullable|string',
            'bio' => 'nullable|string',
            'linkedin_url'=> 'nullable|string',
            'facebook_url'=> 'nullable|string',
            'x_url'=> 'nullable|string',
            'allowed_networking' => 'nullable|boolean',
        ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors()
            ], 422);
        }

        $user->update($validated);

        return response()->json([
            'user' => $user
        ]);
    }

    public function oauthLogin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'full_name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'profile_pic' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $customer = Customer::create($validated);
        $token = $customer->createToken('auth-token')->plainTextToken;

        return response()->json([ 'customer' => $customer,
            'token' => $token
        ], 201);
    }
}
