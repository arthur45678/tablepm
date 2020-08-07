<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantShopProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_shop_profiles', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('parent_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('restaurant_companies')
                ->onDelete('cascade')
                ->onDelete('cascade');


            $table->string('slug')->unique();
            $table->integer('status')->unsigned()->default(1);

            $table->string('img')->nullable();
            $table->string('block')->nullable();
            $table->string('floor')->nullable();
            $table->string('flat')->nullable();
            $table->string('estate_building')->nullable();
            $table->string('street');

            $table->string('google_map_state')->nullable();
            $table->string('google_map_formatted_address')->nullable();

            $table->string('opening_hours')->nullable();


            $table->string('account_number')->nullable();
            $table->enum('buisness_registration', [0,1])->default('0');

            $table->integer('views')->unsigned()->nullable();
            $table->enum('liquor_license', ['0','1'])->default('0');
            $table->string('wifi_ssid', 355)->nullable();
            $table->string('wifi_password', 355)->nullable();
            $table->string('seat_number')->nullable();
            $table->string('seat_cost')->nullable();
            $table->string('sticker_quantity')->nullable();
            $table->enum('restaurant_status', ['0', '1'])->default('0');

            $table->string('email');
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

            $table->text('link_company_profile')->nullable();

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
        Schema::dropIfExists('restaurant_shop_profiles');
    }
}
