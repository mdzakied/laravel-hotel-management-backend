<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    // Columns that can be mass assigned
    protected $fillable = [
        'hotel_id',
        'room_id',
        'customer_name',
        'customer_email',
        'check_in',
        'check_out',
        'guest_count',
        'total_amount',
        'status_payment',
        'notes',
    ];

    // Relations to table Hotel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    // Relations to table Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
