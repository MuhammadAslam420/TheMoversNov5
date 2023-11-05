@extends('admin.layouts.app')


@section('title', 'Main page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2>Add New Seat Price</h2>
                <form action="{{ route('seat_price.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Include form fields for all the columns -->
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="front_seat">Front Seat Price</label>
                            <input type="text" name="front_seat" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="back_left">Back Left Price</label>
                            <input type="text" name="back_left" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="back_right">Back Right Price</label>
                            <input type="text" name="back_right" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="back_center">Back Center Price</label>
                            <input type="text" name="back_center" class="form-control" required>
                        </div>
                    </div>
                    <!-- Include more form fields -->
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="pick_city">Pick City Price</label>
                            <input type="text" name="pick_city" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="drop_city">Drop City Price</label>
                            <input type="text" name="drop_city" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="price">Price</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="vehicle_type">Vehicle Type</label>
                            <input type="text" name="vehicle_type" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="vehicle_image">Vehicle Image</label>
                            <input type="file" name="vehicle_image" class="form-control-file" accept="image/*" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection