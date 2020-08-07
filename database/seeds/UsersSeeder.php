<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Arthur*/
        DB::table('users')->insert([
            'name' => 'ARTHUR Hovakimyan',
            'email' => 'arthur@gmail.com',
            'password' => bcrypt('yerevan12'),
        ]);


        /*Valodik*/
        DB::table('users')->insert([
            'name' => 'Valodik Valodikyan',
            'email' => 'valodik@gmail.com',
            'password' => bcrypt('yerevan12'),
        ]);

    }
}
