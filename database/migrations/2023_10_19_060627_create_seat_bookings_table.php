<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('seat_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('driver_id')->nullable();
            $table->string('vehicle_no', 191)->nullable();
            $table->char('pickup_franchise', 36);
            $table->integer('seat1')->default(0);
            $table->unsignedInteger('p_1')->nullable();
            $table->integer('p1_status')->default(0);
            $table->integer('seat2')->default(0);
            $table->unsignedInteger('p_2')->nullable();
            $table->integer('p2_status')->default(0);
            $table->integer('seat3')->default(0);
            $table->unsignedInteger('p_3')->nullable();
            $table->integer('p3_status')->default(0);
            $table->integer('seat4')->default(0);
            $table->unsignedInteger('p_4')->nullable();
            $table->integer('p4_status')->default(0);
            $table->char('drop_franchise', 36);
            $table->date('traveling_date');
            $table->time('moving_time');
            $table->enum('ride_status', ['scheduled', 'started', 'completed', 'canceled'])->default('scheduled');
            $table->text('pickup_address');
            $table->text('drop_address');
            $table->double('pickup_lng', 15, 8)->nullable();
            $table->double('pickup_lat', 15, 8)->nullable();
            $table->double('drop_lng', 15, 8)->nullable();
            $table->double('drop_lat', 15, 8)->nullable();
            $table->integer('seats');
            $table->double('price');
            $table->integer('admin_commission');
            $table->integer('franchise_commission');
            $table->double('paid_driver');
            $table->double('rent_cost');
            $table->timestamps(0);

            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->foreign('pickup_franchise')->references('id')->on('zones');
            $table->foreign('drop_franchise')->references('id')->on('zones');
            $table->foreign('p_1')->references('id')->on('users');
            $table->foreign('p_2')->references('id')->on('users');
            $table->foreign('p_3')->references('id')->on('users');
            $table->foreign('p_4')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('seat_bookings');
    }
}