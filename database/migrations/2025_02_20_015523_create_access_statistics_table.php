<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessStatisticsTable extends Migration
{
    public function up()
    {
        Schema::create('access_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->integer('today_visits')->default(0);
            $table->timestamps();
            
            // Ensure unique entry per date
            $table->unique('date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('access_statistics');
    }
}