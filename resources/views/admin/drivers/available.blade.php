@extends('admin.layouts.app')
@section('title', 'Main page')


@section('content')

    <!-- Start Page content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                      @livewire('admin.driver.available-driver-component')
                    </div>


                </div>
            </div>
        </div>

    </div>

    </div>

@endsection
