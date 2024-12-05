<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;


class HotelController extends Controller
{
    // Add a new hotel
    public function addHotel(Request $request)
    {
        // validate data
        $validated = $request->validate([
            'hotel_name' => 'required|string|max:255|unique:hotels',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'facilities' => 'nullable|array',
            // 'isRead' => 'boolean',
            // 'isApprove' => 'boolean',
            // 'superadmin' => 'nullable|json',
            'owner' => 'nullable|json',
            // 'admin' => 'nullable|json',
            // 'staff' => 'nullable|json',
            // 'isActive' => 'boolean',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Please login to create a hotel.'
            ], 401);
        }

        // Add the authenticated user as the owner
        $validated['owner'] = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];

        // Set the status to pending
        $validated['status'] = 'pending';

        // Return the response
        $hotel = Hotel::create($validated);
        return response()->json([
            'message' => 'Hotel created successfully.',
            'data' => $hotel
        ], 201);
    }

    // Get all hotels with filter
    public function getAllHotels(Request $request)
    {
        // Get the query parameters
        $status = $request->query('status');

        // Get the pagination parameters
        $size = $request->query('size', 10); // Default size = 10
        $page = $request->query('page', 1); // Default page = 1

        // Get the authenticated user
        $user = Auth::user();

        // Determine the role
        // $superadminId = null;
        $ownerId = null;
        $adminId = null;
        $staffId = null;

        // Validate each role
        // if ($user && $user->role === 'superadmin') {
        //     $superadminId = $user->id;
        // } 
        if ($user && $user->role === 'owner') {
            $ownerId = $user->id;
        } elseif ($user && $user->role === 'admin') {
            $adminId = $user->id;
        } elseif ($user && $user->role === 'staff') {
            $staffId = $user->id;
        }

        // Filter hotels with query
        $hotels = Hotel::when(isset($status), function ($query) use ($status) {
            return $query->where('status', $status);
        })
            // ->when(isset($superadminId), function ($query) use ($superadminId) {
            //     return $query->where('superadmin', 'LIKE', '%"id":' . $superadminId . '%'); // Menggunakan LIKE untuk filter ID superadmin
            // })
            ->when(isset($ownerId), function ($query) use ($ownerId) {
                return $query->where('owner', 'LIKE', '%"id":' . $ownerId . '%'); // Menggunakan LIKE untuk filter ID owner
            })
            ->when(isset($adminId), function ($query) use ($adminId) {
                return $query->where('admin', 'LIKE', '%"id":' . $adminId . '%'); // Filter berdasarkan ID admin dalam array JSON
            })
            ->when(isset($staffId), function ($query) use ($staffId) {
                return $query->where('staff', 'LIKE', '%"id":' . $staffId . '%'); // Filter berdasarkan ID staff dalam array JSON
            })
            ->paginate($size, ['*'], 'page', $page);

        // Get all hotels with rooms
        $hotels = Hotel::with('rooms')->get(); // Eager load rooms

        // Return the response
        return response()->json([
            'message' => 'Hotels retrieved successfully.',
            'data' => $hotels
        ], 200);
    }

    // Get hotel by id
    public function getHotelById($id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json([
                'message' => 'Hotel not found for the specified ID.',
                'hotel_id' => $id
            ], 404);
        }

        return response()->json([
            'message' => 'Hotel retrieved successfully.',
            'hotel' => $hotel
        ], 200);
    }

    // Denied hotel
    public function denyHotel($id, Request $request)
    {
        // Get the status reason
        $statusReason = $request->input('status_reason');

        // Search for the hotel
        $hotel = Hotel::find($id);

        // Check if the hotel exists
        if (!$hotel) {
            return response()->json([
                'message' => 'Hotel not found'
            ], 404);
        }

        // Validate if the hotel hast been actioned
        if ($hotel->status != 'pending') {
            return response()->json([
                'message' => 'Hotel has been actioned.'
            ], 400);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Add the authenticated user as the superadmin
        $superadmins = $hotel->superadmin;
        $superadmins = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];

        // Update the hotel
        $hotel->superadmin = $superadmins;
        $hotel->status = 'denied';
        $hotel->status_reason = $statusReason;

        $hotel->save();

        // Return the response
        return response()->json([
            'message' => 'Hotel denied successfully.',
            'data' => $hotel
        ], 200);
    }

    // Approve hotel
    public function approveHotel($id, Request $request)
    {
        // Get the status reason
        $statusReason = $request->input('status_reason');

        // Search for the hotel
        $hotel = Hotel::find($id);

        // Check if the hotel exists
        if (!$hotel) {
            return response()->json([
                'message' => 'Hotel not found'
            ], 404);
        }

        // Validate if the hotel hast been actioned
        if ($hotel->status != 'pending') {
            return response()->json([
                'message' => 'Hotel has been actioned.'
            ], 400);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Add the authenticated user as the superadmin
        $superadmins = $hotel->superadmin;
        $superadmins = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];

        // Update the hotel
        $hotel->superadmin = $superadmins;
        $hotel->status = 'approved';
        $hotel->status_reason = $statusReason;

        $hotel->save();

        // Return the response
        return response()->json([
            'message' => 'Hotel approved successfully.',
            'data' => $hotel
        ], 200);
    }

    // Register admin for hotel
    public function registerAdmin(Request $request, $id)
    {
        // Validate data
        $validated = $request->validate([
            'admin' => 'required|array',
            'admin.*.id' => 'required|exists:users,id',
            'admin.*.name' => 'required|string',
            'admin.*.email' => 'required|email',
        ]);

        // Search for the hotel
        $hotel = Hotel::find($id);

        // Check if the hotel exists
        if (!$hotel) {
            return response()->json([
                'message' => 'Hotel not found'
            ], 404);
        }

        // Validate if the hotel has not been approved
        if ($hotel->status != 'approved') {
            return response()->json([
                'message' => 'Hotel has not been approved.'
            ], 400);
        }

        // Get existing admins
        $existingAdmins = $hotel->admin ?? [];

        // Check if any of the new admins are already in the admin list
        foreach ($validated['admin'] as $newAdmin) {
            foreach ($existingAdmins as $existingAdmin) {
                if ($existingAdmin['id'] == $newAdmin['id']) {
                    return response()->json([
                        'message' => "User ID {$newAdmin['id']} is already in the admin list."
                    ], 400);
                }
            }
        }

        // Merge existing admins with the new admins
        $newAdmins = array_merge($existingAdmins, $validated['admin']);

        // Update data admin hotel
        $hotel->admin = $newAdmins;
        $hotel->save();

        // Return the response
        return response()->json([
            'message' => 'Admin(s) successfully registered to the hotel.',
            'hotel' => $hotel
        ], 200);
    }

    // Register staff for hotel
    public function registerStaff(Request $request, $id)
    {
        // Validate data
        $validated = $request->validate([
            'staff' => 'required|array',
            'staff.*.id' => 'required|exists:users,id',
            'staff.*.name' => 'required|string',
            'staff.*.email' => 'required|email',
        ]);

        // Search for the hotel
        $hotel = Hotel::find($id);

        // Check if the hotel exists
        if (!$hotel) {
            return response()->json([
                'message' => 'Hotel not found'
            ], 404);
        }

        // Validate if the hotel has not been handled by admin
        if ($hotel->admin == null) {
            return response()->json([
                'message' => 'Hotel has not been handled by admin.'
            ], 400);
        }

        // Validate if the hotel has not been approved
        if ($hotel->status != 'approved') {
            return response()->json([
                'message' => 'Hotel has not been approved.'
            ], 400);
        }

        // Get existing staffs
        $existingstaffs = $hotel->staff ?? [];

        // Check if any of the new staffs are already in the staff list
        foreach ($validated['staff'] as $newstaff) {
            foreach ($existingstaffs as $existingstaff) {
                if ($existingstaff['id'] == $newstaff['id']) {
                    return response()->json([
                        'message' => "User ID {$newstaff['id']} is already in the staff list."
                    ], 400);
                }
            }
        }

        // Merge existing staffs with the new staffs
        $newStaffs = array_merge($existingstaffs, $validated['staff']);

        // Update data staff hotel
        $hotel->staff = $newStaffs;
        $hotel->save();

        // Return the updated hotel
        return response()->json([
            'message' => 'Staff successfully registered to the hotel.',
            'hotel' => $hotel
        ], 200);
    }
}
