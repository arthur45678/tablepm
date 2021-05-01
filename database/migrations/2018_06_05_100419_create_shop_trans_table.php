<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_trans', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 255)->nullable();
            $table->string('lang', 20)->nullable();
            $table->text('desc')->nullable();
            $table->text('text')->nullable();
            $table->string('meta_desc', 255)->nullable();
            $table->string('keywords', 255)->nullable();

            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('shops')
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
        Schema::dropIfExists('shop_trans');
    }
}
