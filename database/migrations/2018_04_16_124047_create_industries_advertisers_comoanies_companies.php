<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndustriesAdvertisersComoaniesCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industries_advertiserscompanies', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('indus_c_id')->unsigned();
            $table->integer('adver_comp_id')->unsigned();


            $table->foreign('indus_c_id')->references('id')->on('industries_advert_companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('adver_comp_id')->references('id')->on('advertiser_companies')
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
        Schema::table('industries_advertiserscompanies', function (Blueprint $table){
            $table->dropForeign('industries_advertiserscompanies_industries_c_id_foreign');
            $table->dropForeign('industries_advertiserscompanies_advertiser_c_trans_id_foreign');
        });
        Schema::dropIfExists('industries_advertiserscompanies');
    }
}
