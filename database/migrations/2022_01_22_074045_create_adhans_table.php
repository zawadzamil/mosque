<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdhansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adhans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('schedule_id')->default(null);
            $table->string('fazar')->nullable()->default(null);
            $table->string('dhuhr')->nullable()->default(null);
            $table->string('asr')->nullable()->default(null);
            $table->string('maghrib')->nullable()->default(null);
            $table->string('isha')->nullable()->default(null);
            $table->string('jummah')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adhans');
    }
}
