<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Coupon;
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
            'booking_date' => 'required|string',
            'booking_time' => 'required|string',
            'location_city' => 'required|string|max:255',
            'location_country' => 'required|string|max:255',
            'course_id' => 'required|exists:golf_courses,id',
            'golfers' => 'required|integer|min:1',
            'holes' => 'required|integer|min:9|max:18',
            'package_id' => 'nullable|exists:packages,id',
            'hole_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|string',
            'coupon_code' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->all();

        if ($request->filled('coupon_code')) {
            $coupon = Coupon::where('code', $data['coupon_code'])->first();

            if (!$coupon) {
                return response()->json(['coupon_code' => ['The provided coupon code does not exist.']], 422);
            }

            if (!$coupon->isValid()) {
                return response()->json(['coupon_code' => ['The coupon is inactive, expired, or has reached its usage limit.']], 422);
            }

            $data['total_price'] = $coupon->applyDiscount($data['total_price']);
            $data['coupon_id'] = $coupon->id;
        }

        unset($data['coupon_code']);

        $booking = Booking::create($data);

        return response()->json($booking, 201);
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
        $bookings = Booking::where('customer_id', $customer_id)->get();

        return response()->json([
            'bookings' => $bookings
        ]);
    }

    public function getCancelBookingByCustomer($customer_id)
    {
        $bookings = Booking::where('customer_id' , $customer_id)->where('status', 'canceled')->get();

        return response()->json([
            'bookings' => $bookings
        ]);
    }
}
