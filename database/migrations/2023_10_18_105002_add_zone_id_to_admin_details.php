<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddZoneIdToAdminDetails extends Migration
{
    public function up()
    {
        Schema::table('admin_details', function (Blueprint $table) {
            $table->unsignedBigInteger('zone_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('admin_details', function (Blueprint $table) {
            $table->dropColumn('zone_id');
        });
    }
}