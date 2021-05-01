<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->integer('role_id')->unsigned()->nullable();
            $table->integer('is_active')->default(0);
            $table->string('name')->nullable();

            $table->string('phone_number')->nullable();
            $table->string('country_code')->nullable();
            $table->string('authy_id')->nullable();

            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();


            $table->string('token', 254)->nullable();
            $table->boolean('confirmed')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
