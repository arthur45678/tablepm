<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestShopProfileDishTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restshopprofile_dish', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('dish_id')->unsigned();
            $table->foreign('dish_id')->references('id')->on('dishes')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('restshopprofile_id')->unsigned();
            $table->foreign('restshopprofile_id')->references('id')->on('restaurant_shop_profiles')
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
        Schema::dropIfExists('restshopprofile_dish');
    }
}
