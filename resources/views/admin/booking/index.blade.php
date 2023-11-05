@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="row ">
                            <div class="col-md-12">
                                <h1>Seat By Seat Booking Statistics</h1>
                            </div>
                            <div class="col-md-3 bg-warning">
                                <h3 class="text-center">Completed Bookings</h3>
                                <p class="text-center">{{ $completed }}</p>
                            </div>
                            <div class="col-md-3 bg-green">
                                <h3 class="text-center">Started</h3>
                                <p class="text-center">{{ $start }}</p>
                            </div>
                            <div class="col-md-3 bg-info">
                                <h3 class="text-center">Schedule</h3>
                                <p class="text-center">{{ $scheduled }}</p>
                            </div>
                            <div class="col-md-3 bg-danger">
                                <h3 class="text-center">Cancelled</h3>
                                <p class="text-center">{{ $cancelled }}</p>
                            </div>
                        </div>
                    </div>


                        @livewire('admin.booking.seat-booking-component')


                </div>
            </div>
        </div>
    </section>


@endsection
