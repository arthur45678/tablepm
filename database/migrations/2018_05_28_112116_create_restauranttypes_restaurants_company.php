<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestauranttypesRestaurantsCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurantTypes_restaurantCompany', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('restaurantType_id')->unsigned();
            $table->foreign('restaurantType_id')->references('id')->on('restaurantTypes')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('restaurantCompany_id')->unsigned();
            $table->foreign('restaurantCompany_id')->references('id')->on('restaurant_companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('restaurantTypes_restaurantCompany');
    }
}
