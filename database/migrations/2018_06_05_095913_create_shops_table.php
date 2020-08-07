<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('status')->unsigned()->default(1);

            $table->string('lat', 300)->nullable();
            $table->string('lng', 300)->nullable();

            $table->string('street')->nullable();
            $table->string('phone')->nullable();

            $table->integer('country_id')->unsigned()->default(1);
            $table->integer('district_id')->unsigned();
            $table->foreign('district_id')->references('id')->on('districts')
                ->onDelete('cascade')
                ->onDelete('cascade');

            $table->string('img')->nullable();


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
        Schema::dropIfExists('shops');
    }
}
