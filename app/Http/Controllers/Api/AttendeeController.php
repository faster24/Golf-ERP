<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendee;

class AttendeeController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|string|email',
                'tournament_name' => 'required|string',
                'name' => 'required|string',  // Note: 'attedee_name' seems to be a typo, should probably be 'attendee_name'
                'phone' => 'required|string'
            ]);

            $attendee = Attendee::create([
                'email' => $validated['email'],
                'tournament' => $validated['tournament_name'],
                'name' => $validated['name'],  // Adjusted to match your validation key
                'phone' => $validated['phone']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Attendee created successfully',
                'data' => $attendee
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the attendee',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
