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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = Customer::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function user(Request $request)
    {
        $coupons = $request->user()->coupons;

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

        $validated = $request->validate([
            'full_name' => 'sometimes|required|string|max:255',
            'profile_pic' => 'nullable|string',
            'phone' => 'nullable|string',
            'password' => 'sometimes|required|string|min:8',
            'linkedin_url'=> 'nullable|string',
            'facebook_url'=> 'nullable|string',
            'x_url'=> 'nullable|string',
            'allowed_networking' => 'nullable|boolean',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'user' => $user
        ]);
    }
}
