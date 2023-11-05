<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'front_seat', // Add 'front_seat' to the fillable fields
        'back_left',
        'back_right',
        'back_center',
        'pick_city',
        'drop_city',
        'status',
        'price',
        'vehicle_type',
        'vehicle_image',
        
    ];

    public function seatBookings()
    {
        return $this->hasMany(SeatBooking::class, 'seatprice_id');
    }
}
