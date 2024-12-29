<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Get all users with filter.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUsers(Request $request)
    {
        // Get the query parameters
        $role = $request->query('role');

        // Get the pagination parameters
        $size = $request->query('size', 10); // Default size = 10
        $page = $request->query('page', 1); // Default page = 1

        // Filter users with query
        $users = User::when($role, function ($query) use ($role) {
            return $query->where('role', $role);
        })
            ->paginate($size, ['*'], 'page', $page);

        return response()->json([
            'message' => 'Users retrieved successfully',
            'data' => $users
        ], 200);
    }

    // Edit Staff permissions by id
    public function editPermissionsStaffById(Request $request, $id)
    {
        // Validase input request
        $validated = $request->validate([
            'permissions' => 'required|array', 
            'permissions.*' => ['required', Rule::in(['add_room', 'view_room', 'edit_room', 'add_reservation', 'view_reservation', 'edit_reservation'])],
        ]);

        // Search user
        $user = User::find($id);

        // Check if user exists
        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        // Check if user is a staff
        if ($user->role != 'staff') {
            return response()->json([
                'message' => 'User is not a staff. Only staff can be edited.'
            ], 400);
        }

        // Update permissions
        $user->permissions = $validated['permissions'];
        $user->save();

        return response()->json([
            'message' => 'Permissions updated successfully.',
            'data' => $user
        ], 200);
    }
}
