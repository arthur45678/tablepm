<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskAdvertisersCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasksAdvertisersCompanies', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('status')->unsigned()->default(1);
            $table->string('img')->nullable();
            $table->string('title', 255)->nullable();
            $table->text('text')->nullable();

            $table->integer('advertcompanies_id')->unsigned();
            $table->foreign('advertcompanies_id')->references('id')->on('advertiser_companies')
                ->onDelete('cascade')
                ->onDelete('cascade');

            $table->integer('user_id')->unsigned()->default(1);
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('tasksAdvertisersCompanies');
    }
}
