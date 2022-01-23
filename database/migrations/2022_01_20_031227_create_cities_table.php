<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table ->string('name');
            $table->string('state_id')->nullable()->default(null);
            $table->string('state_code')->nullable()->default(null);
            $table ->string('country_id');
            $table ->string('country_code');
            $table ->string('latitude');
            $table ->string('longitude');
            $table ->string('flag')->nullable()->default(null);
            $table ->string('wikiDataId')->nullable()->default(null);

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
        Schema::dropIfExists('cities');
    }
}
