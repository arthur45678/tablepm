<?php

use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('countries')->insert([
            'title' => 'Hong Kong',
            'lang' => 'zh',
            'phone_code' => '852',
        ]);

        DB::table('countries')->insert([
            'title' => 'USA',
            'lang' => 'en',
            'phone_code' => '1'
        ]);


        DB::table('countries')->insert([
            'title' => 'Armenia',
            'lang' => 'am',
            'phone_code' => '374'
        ]);
    }
}
