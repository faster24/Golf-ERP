<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CancelBooking;

class CancelBookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'course_name' => 'required|string',
            'golf_pic' => 'required|string',
            'total_price' => 'required|numeric|min:0',
            'cancel_date' => 'required|string',
        ]);

        $cancelBooking = CancelBooking::create($validated);
        return response()->json($cancelBooking, 201);
    }

    public function show(CancelBooking $cancelBooking)
    {
        return response()->json($cancelBooking);
    }

    public function update(Request $request, CancelBooking $cancelBooking)
    {
        $validated = $request->validate([
            'customer_id' => 'sometimes|required|exists:customers,id',
            'course_name' => 'sometimes|required|string',
            'golf_pic' => 'sometimes|required|string',
            'total_price' => 'sometimes|required|numeric|min:0',
            'cancel_date' => 'sometimes|required|string',
        ]);

        $cancelBooking->update($validated);
        return response()->json($cancelBooking);
    }

    public function destroy(CancelBooking $cancelBooking)
    {
        $cancelBooking->delete();
        return response()->json(['message' => 'Canceled booking deleted successfully']);
    }
}
