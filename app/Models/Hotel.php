<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    // Columns that can be mass assigned
    protected $fillable = [
        'hotel_name',
        'address',
        'description',
        'facilities',
        'status',
        'status_reason',
        'superadmin',
        'owner',
        'admin',
        'staff',
        'isActive',
    ];

    // Define the data type of each column
    protected $casts = [
        'facilities' => 'array',
        'superadmin' => 'object',
        'owner' => 'object',
        'admin' => 'array',
        'staff' => 'array',
    ];

    // Relations to table Room
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    // Relations to table Reservation
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
