<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table ->string('name');
            $table ->string('iso3')->default(null);
            $table ->string('numeric_code')->default(null);
            $table ->string('iso2')->default(null);
            $table ->string('phonecode')->default(null);
            $table ->string('capital')->default(null);
            $table ->string('currency')->default(null);
            $table ->string('currency_name')->default(null);
            $table ->string('currency_symbol')->default(null);
            $table ->string('tld')->default(null);
            $table ->string('native')->default(null);
            $table ->string('region')->default(null);
            $table ->string('subregion')->default(null);
            $table ->string('timezones')->default(null);
            $table ->string('translations')->default(null);
            $table ->string('latitude')->default(null);
            $table ->string('longitude')->default(null);
            $table ->string('emoji')->default(null);
            $table ->string('emojiU')->default(null);
            $table ->string('flag')->default(null);
            $table ->string('wikiDataId')->default(null);

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
        Schema::dropIfExists('countries');
    }
}
