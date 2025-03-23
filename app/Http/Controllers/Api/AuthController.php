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

    // Get authenticated user
    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user()
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

    // Update user profile
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'full_name' => 'sometimes|required|string|max:255',
            'profile_pic' => 'nullable|string',
            'phone' => 'nullable|string',
            'password' => 'sometimes|required|string|min:8',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'user' => $user
        ]);
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        // Check if the user already exists
        $customer = Customer::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if (!$customer) {
            // Create a new customer if they don't exist
            $customer = Customer::create([
                'full_name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'profile_pic' => $socialUser->getAvatar(),
            ]);
        }

        // Log in the customer
        Auth::login($customer, true);

        return redirect('/dashboard'); // Redirect to the desired page
    }
}
