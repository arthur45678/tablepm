<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertiserCompaniesTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertiser_companies_trans', function (Blueprint $table) {
            $table->increments('id');

            $table->string('slug_article');
            $table->string('title', 255)->nullable();
            $table->string('lang', 20)->nullable();
            $table->text('desc')->nullable();
            $table->text('text')->nullable();
            $table->string('meta_desc', 255)->nullable();
            $table->string('keywords', 255)->nullable();

            $table->foreign('slug_article')->references('slug')->on('advertiser_companies')
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
        Schema::dropIfExists('advertiser_companies_trans');
    }
}
