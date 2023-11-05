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
                                <h1>Verified Jazzcash Transaction</h1>
                       
                        </div>
                    </div>
                    @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
                @elseif (Session::has('error'))
                    @php
                    $error = Session::get('error');
                    $errorMessage = isset($error['response']['pp_ResponseCode']) ? $error['response']['pp_ResponseCode'] : 'An error occurred.';
                    @endphp
                    <div class="alert alert-danger" role="alert">{{ $errorMessage }}</div>
                @endif
                
                
                        @livewire('admin.payment.transaction-verification-component')
                </div>
            </div>
        </div>
    </section>


@endsection
