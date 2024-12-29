<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    // Fillable fields
    protected $fillable = [
        'hotel_id',
        'room_number',
        'room_name',
        'capacity',
        'price_per_night',
        'status',
    ];

    // Relations to table Hotel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
