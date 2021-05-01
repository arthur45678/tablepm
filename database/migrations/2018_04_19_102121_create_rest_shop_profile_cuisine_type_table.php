<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestShopProfileCuisineTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restshopprofile_cuisinetype', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('restcuisines_id')->unsigned();
            $table->foreign('restcuisines_id')->references('id')->on('restaurant_cuisines')
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
        Schema::dropIfExists('restshopprofile_cuisinetype');
    }
}
