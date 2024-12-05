<?php

namespace App\Http\Controllers;

use App\Models\Room;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Add a room
    public function addRoom(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_number' => 'required|string',
            'room_name' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'required|in:available,booked,under_maintenance',
        ]);

        $room = Room::create([
            'hotel_id' => $request->hotel_id,
            'room_number' => $request->room_number,
            'room_name' => $request->room_name,
            'capacity' => $request->capacity,
            'price_per_night' => $request->price_per_night,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Room created successfully', 'room' => $room], 201);
    }

    // Get all rooms by hotel id
    public function getRoomsByHotelId($hotelId, Request $request)
    {
        // Get the pagination parameters
        $page = $request->get('page', 1); // Default page is 1
        $size = $request->get('size', 10); // Default page size is 10
        // Retrieve rooms by hotel_id with pagination
        $rooms = Room::where('hotel_id', $hotelId)
            ->paginate($size, ['*'], 'page', $page);

        // If no rooms found
        if ($rooms->isEmpty()) {
            return response()->json([
                'message' => 'No rooms found for the specified hotel ID.',
            ], 404);
        }

        // Return rooms with pagination
        return response()->json([
            'message' => 'Rooms retrieved successfully.',
            'data' => $rooms,
        ], 200);
    }

    // Edit room by id
    public function editRoomById(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'hotel_id' => 'nullable|exists:hotels,id',
            'room_number' => 'nullable|string|max:255',
            'room_name' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'price_per_night' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:available,booked,under_maintenance',
        ]);
    
        // Cari room berdasarkan ID
        $room = Room::find($id);
    
        // Periksa apakah room ditemukan
        if (!$room) {
            return response()->json([
                'message' => 'Room not found.'
            ], 404);
        }
    
        // Perbarui data room
        $room->update($validated);
    
        // Mengembalikan response sukses
        return response()->json([
            'message' => 'Room updated successfully.',
            'data' => $room
        ], 200);
    }
}
