<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hotel name');
            $table->string('address');
            $table->string('state');
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email id')->nullable();
            $table->string('website')->nullable();
            $table->string('type');
            $table->integer('size')->nullable();
            $table->integer('rooms')->unsigned();
            $table->string('latitude')->nullable();;
            $table->string('longitude')->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}
