<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTypesRestaurantsTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customerTypesRestaurants_trans', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 255)->nullable();
            $table->string('lang', 20)->nullable();

            $table->string('slug_article');
            $table->foreign('slug_article')->references('slug')->on('customerTypesRestaurants')
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
        Schema::dropIfExists('customerTypesRestaurants_trans');
    }
}
