<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    // Columns that can be mass assigned
    protected $fillable = [
        'reservation_id',
        'amount',
        'payment_status',
        'income_date',
    ];

    // Relations to table Reservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
