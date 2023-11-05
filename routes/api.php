<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

/*
 * These routes are prefixed with 'api' by default.
 * These routes use the root namespace 'App\Http\Controllers\Api'.
 */

use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\V1\Request\SeatBySeatController;
Route::namespace ('Api')->group(function () {

	/**
	 * These routes are prefixed with 'api/v1'.
	 * These routes use the root namespace 'App\Http\Controllers\Api\V1'.
	 */
	Route::prefix('v1')->namespace('V1')->group(function () {
		 include_route_files('api/v1');
	Route::get('u-request/{id}',[UserController::class,'index']);
	Route::post('seatprice', [UserController::class, 'getZone']);
	Route::post('address', [UserController::class, 'getAddress']);
	Route::delete('delete-bookings/{id}', [UserController::class, 'deleteSeatBooking']);
	Route::post('seatbooking1',[UserController::class, 'seatBooking']);
	Route::post('change',[UserController::class, 'addChange']);
	Route::post('end',[UserController::class, 'endRequest']);
	
	Route::post('cityzone',[UserController::class, 'getZoneByCity']);
	Route::post('update_seat_booking/{id}',[UserController::class, 'updateSeatBooking']);
	Route::get('seatuser/{id}',[UserController::class, 'getSeatUser']);
	Route::get('cancelseat/{bookingId}/{userId}/{seatNo}',[UserController::class, 'cancelSeat']);
	Route::get('cities', 'CityController@index');
	Route::get('get-timezone', [UserController::class, 'getTimezone']);
	});
	

});
