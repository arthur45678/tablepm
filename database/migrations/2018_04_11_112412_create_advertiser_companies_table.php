<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertiserCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertiser_companies', function (Blueprint $table) {
            $table->increments('id');

            $table->string('slug')->unique();
            $table->integer('status')->unsigned()->nullable();

            $table->string('img')->nullable();
            $table->string('block')->nullable();
            $table->string('floor')->nullable();
            $table->string('flat')->nullable();
            $table->string('estate_building')->nullable();
            $table->string('street')->nullable();

            $table->string('email')->nullable();


            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->text('website_url')->nullable();

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            $table->string('lat', 300)->nullable();
            $table->string('lng', 300)->nullable();

            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('district_id')->unsigned()->nullable();
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
        Schema::dropIfExists('advertiser_companies');
    }
}
