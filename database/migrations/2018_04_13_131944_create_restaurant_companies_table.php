<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_companies', function (Blueprint $table) {
            $table->increments('id');

            $table->string('slug')->unique();
            $table->integer('status')->unsigned()->default(1);

            $table->string('img')->nullable();
            $table->string('block')->nullable();
            $table->string('floor')->nullable();
            $table->string('flat')->nullable();
            $table->string('estate_building')->nullable();
            $table->string('street')->nullable();


            $table->string('account_number')->nullable();
            $table->enum('buisness_registration', [0,1])->default('0');

            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank')->nullable();

            $table->integer('user_id')->unsigned()->default(1);
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            $table->string('lat', 300)->nullable();
            $table->string('lng', 300)->nullable();

            $table->text('website_url')->nullable();


            $table->integer('country_id')->unsigned()->default(1);
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
        Schema::dropIfExists('restaurant_companies');
    }
}
