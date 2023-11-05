@extends('admin.layouts.app')

@section('title', 'Main page')

@section('content')
    <h1>Seat Prices</h1>
    <a href="{{ route('seat_price.create') }}" class="btn btn-primary">Add New Seat Price</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Front Seat</th>
                <th>Back Left</th>
                <th>Back Right</th>
                <th>Back Center</th>
                <th>Pick City</th>
                <th>Drop City</th>
                <th>Vehicle Type</th>
                <th>Icon</th>
                <th>Status</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($seatPrices as $seatPrice)
                <tr>
                    <td>{{ $seatPrice->id }}</td>
                    <td>{{ $seatPrice->front_seat }}</td>
                    <td>{{ $seatPrice->back_left }}</td>
                    <td>{{ $seatPrice->back_right }}</td>
                    <td>{{ $seatPrice->back_center }}</td>
                    <td>{{ $seatPrice->pick_city }}</td>
                    <td>{{ $seatPrice->drop_city }}</td>
                    <td>{{ $seatPrice->vehicle_type }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $seatPrice->vehicle_image) }}" alt="Vehicle Image" style="max-width: 60%;">
                    </td>
                    <td>{{ $seatPrice->status }}</td>
                    <td>{{ $seatPrice->price }}</td>
                    <td>
                        <a href="{{ route('seat_price.edit', $seatPrice->id) }}" class="btn btn-info">Edit</a>
                        <form action="{{ route('seat_price.destroy', $seatPrice->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
