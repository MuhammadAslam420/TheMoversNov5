<?php
namespace App\Http\Controllers\api\v1\request;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeatBookingRequest;
use App\Models\Admin\SeatBooking;
use App\Models\Admin\Zone;
use App\Models\SeatPrice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class SeatBySeatController extends Controller
{
    public function getActiveSeatPricesByCity()
    {
        $seatPrices = SeatPrice::where('status', 'active')
            ->get();
        return response()->json($seatPrices, 200);
    }
    public function checkSeatAvailability()
    {
        $currentTime = Carbon::now();
        $thresholdTime = $currentTime->subMinutes(30);

        $seatBookings = SeatBooking::where('seat1', '>', 0)
            ->where('seat2', '>', 0)
            ->where('seat3', '>', 0)
            ->where('seat4', '>', 0)
            ->where('traveling_date', '>=', $currentTime->toDateString())
            ->where('moving_time', '>=', $thresholdTime->toTimeString())
            ->where('ride_status', '=', 'scheduled')
            ->get();

        if ($seatBookings->isEmpty()) {
            return response()->json(['message' => 'No available seats'], 404);
        }

        return response()->json($seatBookings, 200);
    }
    public function getZoneByCity(Request $request)
    {
 

        try {
            $zones = Zone::where('city', $request->city)->get(['id','name','lat','lng']);

          if ($zones) {
            $response = [
                'data' => $zones,
                'messages' => 'Franchise found !',
                'success' => true,
            ];
          
        } else {
            $response = [
               
                'messages' => 'No Franchise in this city !',
                'success' => true,
            ];
        }
        return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

 public function otherCity(Request $request)
    {
       

        try {
            $othercity = SeatPrice::where('pick_city', $request->pick_city)->where('drop_city', $request->drop_city)->get();
           
            if ($othercity) {
                $response = [
                    'data' => $othercity,
                    'messages' => 'City found ! ',
                    'success' => true,
                ];
            } else {
                $response = [
                    'messages' => 'Currently this city is not available!',
                    'success' => true,
                ];
            }
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

		
    public function scheduledRides(Request $request)
    {
      

        try {
            $scheduled_rides = SeatBooking::where('pickup_address', $request->pickup_address)
                ->where('drop_address', $request->drop_address)
                ->where('seats','<', 4)
                ->get();
    
            if ($scheduled_rides->count() > 0) {
                $addressList = [];
                foreach ($scheduled_rides as $booking) {
                    $pickupFranchise = Zone::find($booking->pickup_franchise);
                    $dropFranchise = Zone::find($booking->drop_franchise);
    
                    if ($pickupFranchise && $dropFranchise) {
                        $booking->pickup_franchise = $pickupFranchise->name;
                        $booking->drop_franchise = $dropFranchise->name;
                        $addressList[] = $booking;
                    }
                }

                $response = [
                    'data' => $addressList,
                    'messages' => 'No schedule ride',
                    'success' => true,
                ];
              
            } else {
                $response = [
                   
                    'messages' => 'No bookings found for the given addresses ',
                    'success' => true,
                ];
               
            }
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

    }
public function getSeatDetail($id)
    {
       

        

        try {
         
            $seatBookingUser = SeatBooking::where('p_1', $id)
            ->orWhere('p_2',$id)
            ->orWhere('p_3',$id)
            ->orWhere('p_4',$id)
            ->where('ride_status', 'scheduled')->first();

            if ($seatBookingUser) {
                $pickupFranchise = Zone::find($seatBookingUser->pickup_franchise);
                $dropFranchise = Zone::find($seatBookingUser->drop_franchise);
                
                if ($pickupFranchise && $dropFranchise) {
                    $seatBookingUser->pickup_franchise = $pickupFranchise->name;
                    $seatBookingUser->drop_franchise = $dropFranchise->name;
                   $response = [
                'data' => $seatBookingUser,
                'messages' => 'Seat booked !',
                'success' => true,
            ];
        } else {
            $response = [
                'messages' => 'Seat not booked !',
                'success' => false,
            ];
        }
    } else {
        $response = [
            'messages' => 'User Not found!',
            'success' => false,
        ];
    }
	return response()->json($response, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage());
        }
    }

    public function seatBooking(SeatBookingRequest $request)
    {
        try {
            $request->validated();
      
          
            $seatBookingoldUser = SeatBooking::where('p_1', $request->user_id)
            ->orWhere('p_2',$request->user_id)
            ->orWhere('p_3',$request->user_id)
            ->orWhere('p_4',$request->user_id)
            ->where('ride_status', 'scheduled')->first();
            if($seatBookingoldUser){
                return response()->json(['error' => 'user alredy booked a seat'], 400);
            }else{
                $seatBooking = SeatBooking::create([
                    'driver_id' => $request->driver_id,
    
                    'vehicle_no' => $request->vehicle_no,
                    'vehicle_type' => $request->vehicle_type,
                    'seatprice_id' => $request->seatprice_id,
                    'pickup_franchise' => $request->pickup_franchise,
                    'seat1' => $request->seat1,
                    'p_1' => $request->p_1,
                    'p1_status' => $request->p1_status,
                    // 's1_price' => $request->s1_price,
                    'seat2' => $request->seat2,
                    'p_2' => $request->p_2,
                    'p2_status' => $request->p2_status,
                    // 's2_price' => $request->s2_price,
                    'seat3' => $request->seat3,
                    'p_3' => $request->p_3,
                    'p3_status' => $request->p3_status,
                    // 's3_price' => $request->s3_price,
                    'seat4' => $request->seat4,
                    'p_4' => $request->p_4,
                    'p4_status' => $request->p4_status,
                    // 's4_price' => $request->s4_price,
                    'drop_franchise' => $request->drop_franchise,
                    'traveling_date' => $request->traveling_date,
                    'moving_time' => $request->moving_time,
                    'ride_status' => $request->ride_status,
                    'pickup_address' => $request->pickup_address,
                    'drop_address' => $request->drop_address,
                    'pickup_lng' => $request->pickup_lng,
                    'pickup_lat' => $request->pickup_lat,
                    'drop_lng' => $request->drop_lng,
                    'drop_lat' => $request->drop_lat,
                    'seats' => $request->seats,
                    'price' => $request->price,
                    'admin_commission' => $request->admin_commission,
                    'franchise_commission' => $request->franchise_commission,
                    'paid_driver' => $request->paid_driver,
                    'rent_cost' => $request->rent_cost,
                    
                ]);
                $seatPrice = SeatPrice::find($request->seatprice_id);
    
                if ($seatPrice) {
                    $updated_s1 = $seatPrice->front_seat;
                    $updated_s2 = $seatPrice->back_right;
                    $updated_s3 = $seatPrice->back_center;
                    $updated_s4 = $seatPrice->back_left;
                    $updated_price = $seatPrice->price;
                   
                    // Update the seat booking with the new s_price values from `seat_price` table
                    $seatBooking->update([
                        's1_price' => $updated_s1,
                        's2_price' => $updated_s2,
                        's3_price' =>$updated_s3,
                        's4_price' => $updated_s4,
                        'rent_cost' => $updated_price,
                       
                    ]);
                }
                $seats = SeatBooking::find($seatBooking->id);
             
                return response()->json([$seatBooking, $seats], 200);
            }
        } catch (\Exception $e) {
            Log::error('Seat booking failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

 public function updateSeatBooking(Request $request, $id)
    {
        try {
            $seatBookingoldUser = SeatBooking::where('p_1', $request->user_id)
            ->orWhere('p_2',$request->user_id)
            ->orWhere('p_3',$request->user_id)
            ->orWhere('p_4',$request->user_id)
            ->where('ride_status', 'scheduled')->first();
            if($seatBookingoldUser){
                return response()->json(['error' => 'user alredy booked a seat'], 400);
            }else{
            $seatBooking = SeatBooking::find($id);
    
            if (!$seatBooking) {
                return response()->json(['error' => 'Seat booking not found'], 404);
            }
    
            if ( $request->seat1 != 0  && $request->p1_status != 0) {
                $seatBooking->seat1 = $request->seat1;
                $seatBooking->p_1 = $request->p_1;
                $seatBooking->p1_status = $request->p1_status;
                $seatBooking->price = $seatBooking->price +  $seatBooking->s1_price;
                $seatBooking->seats = $seatBooking->seats +  1;
             }
    
            if ( $request->seat2 != 0  && $request->p2_status != 0) {
                $seatBooking->seat2 = $request->seat2;
                $seatBooking->p_2 = $request->p_2;
                $seatBooking->p2_status = $request->p2_status;
                $seatBooking->price = $seatBooking->price +  $seatBooking->s2_price;
                $seatBooking->seats = $seatBooking->seats +  1;
            }
    
            if ( $request->seat3 != 0  && $request->p3_status != 0) {
                $seatBooking->seat3 = $request->seat3;
                $seatBooking->p_3 = $request->p_3;
                $seatBooking->p3_status = $request->p3_status;
                $seatBooking->price = $seatBooking->price +  $seatBooking->s3_price;
                $seatBooking->seats = $seatBooking->seats +  1;
            }
            if ( $request->seat4 != 0  && $request->p4_status != 0) {
                $seatBooking->seat4 = $request->seat4;
                $seatBooking->p_4 = $request->p_4;
                $seatBooking->p4_status = $request->p4_status;
                $seatBooking->price = $seatBooking->price +  $seatBooking->s4_price;
                $seatBooking->seats = $seatBooking->seats +  1;
            }
    
            $seatBooking->save();
    
            return response()->json($seatBooking, 200);
        }
        } catch (\Exception $e) {
            Log::error('Seat booking update failed: ' . $e->getMessage());
            return response()->json(['error' => 'Seat booking update failed'], 500);
        }
    }

    public function userArrived($seatBookingId, $passengerNumber)
    {
        $seatBooking = SeatBooking::where('id', $seatBookingId)
            ->where('ride_status', '=', 'schedule')
            ->whereDate('traveling_date', Carbon::now()->toDateString())
            ->firstOrFail();

        $pStatusColumn = "p{$passengerNumber}_status";
        if (!Schema::hasColumn('seat_bookings', $pStatusColumn)) {
            return response()->json(['message' => 'Invalid passenger number'], 400);
        }
        $seatBooking->$pStatusColumn = 2;
        $seatBooking->save();

        return response()->json(['message' => 'Passenger status updated successfully'], 200);
    }

    public function updateRideStatus($seatBookingId, $status)
    {

        $seatBooking = SeatBooking::findOrFail($seatBookingId);
        $seatBooking->ride_status = $status;
        $seatBooking->save();

        $message = ($status === 'started') ? 'Ride started successfully' : 'Ride completed successfully';

        return response()->json(['message' => $message], 200);
    }

    public function cancelSeat($rideId, $userId, $seatId)
    {
        $ride = SeatBooking::findOrFail($rideId);

        if ($ride->ride_status != 'scheduled') {
            return response()->json(['message' => 'Cannot cancel a ride that is not in schedule status'], 400);
        }
        $currentDateTime = Carbon::now();
        $travelingDateTime = Carbon::parse($ride->travelling_date . ' ' . $ride->moving_time);
        $cancellationDeadline = $travelingDateTime->subMinutes(30);

        if ($currentDateTime > $cancellationDeadline) {
            return response()->json(['message' => 'Cannot cancel the seat. Cancellation deadline has passed'], 400);
        }

        // Determine which passenger's seat to cancel based on the user ID
        $passengerKey = null;
        $status = null;
        $price = null;
        $seat_index = null;
        if ($ride->p_1 == $userId && $ride->seat1 == $seatId) {
            $passengerKey = 'p_1';
            $status= 'p1_status';
            $price = 's1_price';
            $seat_index = 'seat1';
        } elseif ($ride->p_2 == $userId && $ride->seat2 == $seatId) {
            $passengerKey = 'p_2';
            $status= 'p2_status';
            $price = 's2_price';
            $seat_index = 'seat2';
        } elseif ($ride->p_3 == $userId &&  $ride->seat3 == $seatId) {
            $passengerKey = 'p_3';
            $status= 'p3_status';
            $price = 's3_price';
            $seat_index = 'seat3';
        } elseif ($ride->p_4 == $userId && $ride->seat4 == $seatId) {
            $passengerKey = 'p_4';
            $status= 'p4_status';
            $price = 's4_price';
            $seat_index = 'seat4';
        } else {
            return response()->json(['message' => 'User is not assigned to any seat in this ride'], 400);
        }

        $ride->$passengerKey = null;
         $seatKey =   $seat_index;
        $ride->$seatKey = 0;
        $ride->$status = 0;
        $ride->$seat_index =0;
        $ride->seats =$ride->seats - 1 ;
        $ride->price =  $ride->price - $ride->$price;
       
        $ride->save();
 // Check if all passenger statuses are zero
 if ($ride->p1_status == 0 && $ride->p2_status == 0 && $ride->p3_status == 0 && $ride->p4_status == 0) {
    
    $ride->delete();
}
        return response()->json(['message' => 'Your seat has been canceled'], 200);
    }

    public function bookRemainingSeats(Request $request, $bookingId)
    {
        try {
            $booking = SeatBooking::findOrFail($bookingId);
            $booking->update($request->all());
            return response()->json(['message' => 'Seat booking for remaining seats successful', 'booking' => $booking], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Seat booking for remaining seats failed'], 500);
        }
    }

}
