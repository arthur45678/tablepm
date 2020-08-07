<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CtrateCustomerTypesRestaurantCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customerTypes_restCompanies', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customerTypesRestaurants')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('restcomp_id')->unsigned();
            $table->foreign('restcomp_id')->references('id')->on('restaurant_companies')
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
        Schema::dropIfExists('customerTypes_restCompanies');
    }
}
