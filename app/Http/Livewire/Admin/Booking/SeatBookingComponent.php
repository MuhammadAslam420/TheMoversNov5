<?php

namespace App\Http\Livewire\Admin\Booking;

use App\Models\Admin\Driver;
use App\Models\Admin\SeatBooking;
use App\Models\Admin\Zone;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class SeatBookingComponent extends Component
{
    use WithPagination;
    public $perPage = 5;
    public $sorting = 'desc';
    public $byFrunch;

    public $search;

    public $driver_id;
    public $paid_amount;

    public $rent_cost;
    public $ride_id;

    public function updateDriver()
    {
        try {
            $booking = SeatBooking::findorFail($this->ride_id);
            $driver = Driver::findorFail($this->driver_id);
            $booking->driver_id = $this->driver_id;
            $booking->vehicle_no = $driver->car_number;
            $booking->paid_driver = $this->paid_amount;
            $booking->rent_cost = $this->rent_cost;
            if ($booking->price >= $this->paid_amount) {
                $profit = $booking->price - $this->paid_amount;
                $admin_profit = $profit / 2;
                $f_profit = $profit / 2;
                $booking->admin_commission = $admin_profit;
                $booking->frunchise_commission = $f_profit;
            }else{
                $profit = $booking->price - $this->paid_amount;
                $admin_profit = $profit / 2;
                $f_profit = $profit / 2;
                $booking->admin_commission = $admin_profit;
                $booking->frunchise_commission = $f_profit;

            }
            $booking->save();
            return redirect()->back()->with('message', 'driver has been updated');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function updateStatus($id)
    {
        try {
            $booking = SeatBooking::findorFail($id);
            $booking->ride_status = 'canceled';
            $booking->save();
            return redirect()->back()->with('message', 'status has been updated');
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 201);
        }
    }
    public function render()
    {
        if (Auth::user()->id != 1) {
            $bookings = SeatBooking::where('pickup_franchise', Auth::user()->admin->zone_id)->search($this->search)->orWhere('pickup_franchise', $this->byFrunch)->orderBy('created_at', $this->sorting)
                ->paginate($this->perPage);
        } else {
            $bookings = SeatBooking::search($this->search)->orWhere('pickup_franchise', $this->byFrunch)->orderBy('created_at', $this->sorting)
                ->paginate($this->perPage);

        }
        $zones = Zone::where('active', 1)->get();

        return view('livewire.admin.booking.seat-booking-component', ['bookings' => $bookings,
            'zones' => $zones]);
    }
}
