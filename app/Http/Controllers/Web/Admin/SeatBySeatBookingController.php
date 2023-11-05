<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\SeatBooking;
class SeatBySeatBookingController extends Controller
{
   public function index()
   {
    $page = trans('pages_names.request');
        $main_menu = 'trip-request';
        $sub_menu = 'request';
        $completed=SeatBooking::where('ride_status','completed')->count();
        $start=SeatBooking::where('ride_status','started')->count();
        $scheduled=SeatBooking::where('ride_status','scheduled')->count();
        $cancelled=SeatBooking::where('ride_status','canceled')->count();
        return view('admin.booking.index', compact('page', 'main_menu', 'sub_menu','completed','start','scheduled','cancelled'));
   }

}
