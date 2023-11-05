<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatPricesTable extends Migration
{
    public function up()
    {
        Schema::create('seat_prices', function (Blueprint $table) {
            $table->id();
            $table->double('front_seat')->default(0);
            $table->double('back_left')->default(0);
            $table->double('back_right')->default(0);
            $table->double('back_center')->default(0);
            $table->string('pick_city', 191);
            $table->string('drop_city', 191);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->double('price')->default(17000);
            $table->enum('vehicle_type', ['Executive', 'Go', 'Mini'])->default('Executive');
            $table->timestamps(0);
            $table->text('vehicle_image');
        });
    }

    public function down()
    {
        Schema::dropIfExists('seat_prices');
    }
}