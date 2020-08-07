<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRestaurantCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurant_companies', function (Blueprint $table) {
            $table->integer('accountType_id')->unsigned()->nullable();
            $table->foreign('accountType_id')->references('id')->on('restaurantAccountType')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurant_companies', function (Blueprint $table) {
            //
        });
    }
}
