<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCityToZones extends Migration
{
    public function up()
    {
        Schema::table('zones', function (Blueprint $table) {
            $table->string('city', 191)->collation('utf8mb4_unicode_ci')->nullable();
        });
    }

    public function down()
    {
        Schema::table('zones', function (Blueprint $table) {
            $table->dropColumn('city');
        });
    }
}

  

