<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatBooking extends Model
{
    use HasFactory;
    protected $table="seat_bookings";
    protected $fillable = [
        'driver_id',
        
        'seatprice_id',
        'vehicle_no',
        'vehicle_type',
        'pickup_franchise',
        'seat1',
        'p_1',
        'p1_status',
        's1_price',
        'seat2',
        'p_2',
        'p2_status',
        's2_price',
        'seat3',
        'p_3',
        'p3_status',
         's3_price',
        'seat4',
        'p_4',
        'p4_status',
         's4_price',
        'seats',
        'drop_franchise',
        'traveling_date',
        'moving_time',
        'price',
        'pickup_address',
        'drop_address',

    ];

    public function driver()
{
    return $this->belongsTo(Driver::class, 'driver_id');
}

public function passenger1()
{
    return $this->belongsTo(\App\Models\User::class, 'p_1');
}

public function passenger2()
{
    return $this->belongsTo(\App\Models\User::class, 'p_2');
}

public function passenger3()
{
    return $this->belongsTo(\App\Models\User::class, 'p_3');
}

public function passenger4()
{
    return $this->belongsTo(\App\Models\User::class, 'p_4');
}

public function pickupZone()
{
    return $this->belongsTo(Zone::class, 'pickup_franchise');
}

public function dropZone()
{
    return $this->belongsTo(Zone::class, 'drop_franchise');
}

public static function search($keyword)
{
    return SeatBooking::where('id', 'like', '%' . $keyword . '%')
    ->orWhere('created_at', 'like', '%' . $keyword . '%')
    ->orWhere('ride_status','like','%'.$keyword.'%')
    ->orWhere('seats','like','%'.$keyword.'%');

}
public function seatPrice()
{
    return $this->belongsTo(SeatPrice::class, 'seatprice_id');
}

}
