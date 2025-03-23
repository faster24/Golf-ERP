<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the bookings.
     */
    public function index()
    {
        $bookings = Booking::all();
        return response()->json($bookings);
    }

    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required|date_format:H:i',
            'location_city' => 'required|string|max:255',
            'location_country' => 'required|string|max:255',
            'course_id' => 'required|exists:golf_courses,id',
            'golfers' => 'required|integer|min:1',
            'holes' => 'required|integer|min:9|max:18',
            'package_id' => 'required|exists:packages,id',
            'hole_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create the booking
        $booking = Booking::create($request->all());

        return response()->json($booking, 201);
    }

    /**
     * Display the specified booking.
     */
    public function show($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }
        return response()->json($booking);
    }

    /**
     * Update the specified booking.
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'sometimes|exists:customers,id',
            'booking_date' => 'sometimes|date',
            'booking_time' => 'sometimes|date_format:H:i',
            'location_city' => 'sometimes|string|max:255',
            'location_country' => 'sometimes|string|max:255',
            'course_id' => 'sometimes|exists:golf_courses,id',
            'golfers' => 'sometimes|integer|min:1',
            'holes' => 'sometimes|integer|min:9|max:18',
            'package_id' => 'sometimes|exists:packages,id',
            'hole_price' => 'sometimes|numeric|min:0',
            'total_price' => 'sometimes|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update the booking
        $booking->update($request->all());

        return response()->json($booking);
    }

    /**
     * Remove the specified booking.
     */
    public function destroy($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully']);
    }

    public function cancelBooking(Request $request , $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        if ($request->user()->id !== $booking->customer_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return response()->json(['error' => 'Booking cannot be canceled'], 400);
        }

        $booking->status = 'canceled';
        $booking->canceled_at = now();
        $booking->save();

        return response()->json(['message' => 'Booking canceled successfully']);
    }

    public function getBookingByCustomer($customer_id)
    {
        $bookings = Booking::where('customer_id' , $customer_id)->get();

        return response()->json([
            'bookings' => $bookings
        ]);
    }
}
