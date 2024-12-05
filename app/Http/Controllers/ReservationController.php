<?php

namespace App\Http\Controllers;

use App\Models\Reservation;

use Illuminate\Http\Request;
use Log;

class ReservationController extends Controller
{
    // Add reservation
    public function addReservation(Request $request)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_id' => 'required|exists:rooms,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guest_count' => 'required|integer|min:1',
            'total_amount' => 'required|numeric',
            'status_payment' => 'required|in:unpaid,partial,paid',
            'notes' => 'nullable|string',
        ]);

        $reservation = Reservation::create($validated);

        return response()->json([
            'message' => 'Reservation created successfully.',
            'data' => $reservation
        ], 201);
    }

    // Get all reservations by room id and hotel id
    public function getReservationsByRoomIdAndHotelId(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_id' => 'required|exists:rooms,id',
        ]);

        // Get the pagination parameters
        $size = $request->query('size', 10); // Default size = 10
        $page = $request->query('page', 1); // Default page = 1

        // Get the reservations
        $reservations = Reservation::where('hotel_id', $validated['hotel_id'])
            ->where('room_id', $validated['room_id'])
            ->paginate($size, ['*'], 'page', $page);;

        // If no reservations found
        if ($reservations->isEmpty()) {
            return response()->json([
                'message' => 'No reservations found for the specified hotel and room.'
            ], 404);
        }

        // Return reservations with pagination
        return response()->json([
            'message' => 'Reservations retrieved successfully.',
            'data' => $reservations
        ]);
    }

    // Edit reservation
    public function editReservationById(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'hotel_id' => 'nullable|exists:hotels,id',
            'room_id' => 'nullable|exists:rooms,id',
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'check_in' => 'nullable|date',
            'check_out' => 'nullable|date|after:check_in',
            'guest_count' => 'nullable|integer|min:1',
            'total_amount' => 'nullable|numeric|min:0',
            'status_payment' => 'nullable|in:unpaid,partial,paid',
            'notes' => 'nullable|string',
        ]);

        // Search for the reservation
        $reservation = Reservation::find($id);

        // Check if the reservation exists
        if (!$reservation) {
            return response()->json([
                'message' => 'Reservation not found.'
            ], 404);
        }

        // Update data 
        $reservation->update([
            'hotel_id' => $validated['hotel_id'] ?? $reservation->hotel_id,
            'room_id' => $validated['room_id'] ?? $reservation->room_id,
            'customer_name' => $validated['customer_name'] ?? $reservation->customer_name,
            'customer_email' => $validated['customer_email'] ?? $reservation->customer_email,
            'check_in' => $validated['check_in'] ?? $reservation->check_in,
            'check_out' => $validated['check_out'] ?? $reservation->check_out,
            'guest_count' => $validated['guest_count'] ?? $reservation->guest_count,
            'total_amount' => $validated['total_amount'] ?? $reservation->total_amount,
            'status_payment' => $validated['status_payment'] ?? $reservation->status_payment,
            'notes' => $validated['notes'] ?? $reservation->notes,
        ]);

        // Return response
        return response()->json([
            'message' => 'Reservation updated successfully.',
            'data' => $reservation
        ], 200);
    }
}
