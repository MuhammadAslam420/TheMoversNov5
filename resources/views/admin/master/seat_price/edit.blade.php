@extends('admin.layouts.app')


@section('title', 'Main page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>Edit Seat Price</h1>
                <form action="{{ route('seat_price.update', $seatPrice) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Include form fields for all the columns -->
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="front_seat">Front Seat</label>
                            <input type="text" name="front_seat" class="form-control" value="{{ $seatPrice->front_seat }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="back_left">Back Left</label>
                            <input type="text" name="back_left" class="form-control" value="{{ $seatPrice->back_left }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="back_right">Back Right</label>
                            <input type="text" name="back_right" class="form-control" value="{{ $seatPrice->back_right }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="back_center">Back Center</label>
                            <input type="text" name="back_center" class="form-control" value="{{ $seatPrice->back_center }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="pick_city">Pick City</label>
                            <input type="text" name="pick_city" class="form-control" value="{{ $seatPrice->pick_city }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="drop_city">Drop City</label>
                            <input type="text" name="drop_city" class="form-control" value="{{ $seatPrice->drop_city }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="active" {{ $seatPrice->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $seatPrice->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="price">Price</label>
                            <input type="number" name="price" class="form-control" value="{{ $seatPrice->price }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="vehicle_type">Vehicle Type</label>
                            <input type="text" name="vehicle_type" class="form-control" value="{{ $seatPrice->vehicle_type }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="vehicle_image">Vehicle Image</label>
                            <input type="file" name="vehicle_image" class="form-control-file" accept="image/*">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection