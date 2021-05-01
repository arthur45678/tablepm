<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictsTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts_trans', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 255)->nullable();
            $table->string('lang', 20)->nullable();

            $table->integer('district_id')->unsigned();
            $table->foreign('district_id')->references('id')->on('districts')
                ->onDelete('cascade')
                ->onDelete('cascade');

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
        Schema::dropIfExists('districts_trans');
    }
}
