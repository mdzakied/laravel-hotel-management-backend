<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Middleware\CheckPermission;

// --- Authentication Route ---

Route::middleware(['auth:sanctum', CheckRole::class . ':superadmin'])->post('/auth/register-superadmin', [AuthController::class, 'registerSuperadmin']); // superadmin can register superadmin account
Route::post('/auth/register-owner', [AuthController::class, 'registerOwner']); // owner can register their own account
Route::middleware(['auth:sanctum', CheckRole::class . ':owner'])->post('/auth/register-admin', [AuthController::class, 'registerAdmin']); // only owner can register admin account
Route::middleware(['auth:sanctum', CheckRole::class . ':admin'])->post('/auth/register-staff', [AuthController::class, 'registerStaff']); // only admin can register staff account

// Login Route
Route::post('/auth/login', [AuthController::class, 'login']);

// Logout Route (hanya bisa diakses setelah login, menggunakan token Sanctum)
Route::middleware('auth:sanctum')->post('/auth/logout', [AuthController::class, 'logout']);

// --- Authentication Route ---


// --- User Route ---

Route::middleware(['auth:sanctum', CheckRole::class . ':superadmin'])->get('/users', [UserController::class, 'getAllUsers']); // only superadmin can get all users
Route::middleware(['auth:sanctum', CheckRole::class . ':admin'])->put('/users/{id}/permissions', [UserController::class, 'editPermissionsStaffById']); // only admin

// --- User Route ---


// --- Hotel Route ---

Route::prefix('hotels')->group(function () {
    Route::middleware(['auth:sanctum', CheckRole::class . ':owner'])->post('/', [HotelController::class, 'addHotel']); // only owner can add hotel
    Route::middleware(['auth:sanctum'])->get('/', [HotelController::class, 'getAllHotels']); // suitable for all role
    Route::get('/hotels/{id}', [HotelController::class, 'getByHotelId']); // Anyone can get hotel by id 
    Route::middleware(['auth:sanctum', CheckRole::class . ':superadmin'])->put('/{id}/deny', [HotelController::class, 'denyHotel']); // only superadmin can deny hotel
    Route::middleware(['auth:sanctum', CheckRole::class . ':superadmin'])->put('/{id}/approve', [HotelController::class, 'approveHotel']); // only superadmin can approve hotel
    Route::middleware(['auth:sanctum', CheckRole::class . ':owner'])->put('/{id}/register-admin', [HotelController::class, 'registerAdmin']); // only owner can register admin
    Route::middleware(['auth:sanctum', CheckRole::class . ':admin'])->put('/{id}/register-staff', [HotelController::class, 'registerStaff']); // only admin can register staff
});    

// --- Hotel Route ---


// --- Room Route ---

Route::middleware(['auth:sanctum', CheckRole::class . ':staff', CheckPermission::class . ':add_room'])->post('/rooms', [RoomController::class, 'addRoom']); // only staff and permit
Route::middleware(['auth:sanctum', CheckRole::class . ':staff', CheckPermission::class . ':view_room'])->get('/rooms/hotel/{hotelId}', [RoomController::class, 'getRoomsByHotelId']); // only staff and permit
Route::middleware(['auth:sanctum', CheckRole::class . ':staff', CheckPermission::class . ':edit_room'])->put('/rooms/{id}', [RoomController::class, 'editRoomById']); // only staff and permit

// --- Room Route ---


// --- Reservation Route ---

Route::middleware(['auth:sanctum', CheckRole::class . ':staff', CheckPermission::class . ':add_reservation'])->post('/reservations', [ReservationController::class, 'addReservation']); // only staff and permit
Route::middleware(['auth:sanctum', CheckRole::class . ':staff', CheckPermission::class . ':view_reservation'])->get('/reservations', [ReservationController::class, 'getReservationsByRoomIdAndHotelId']); // only staff and permit
Route::middleware(['auth:sanctum', CheckRole::class . ':staff', CheckPermission::class . ':edit_reservation'])->put('/reservations/{id}', [ReservationController::class, 'editReservationById']); // only staff and permit

// --- Reservation Route ---