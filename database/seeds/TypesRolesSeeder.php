<?php

use Illuminate\Database\Seeder;

class TypesRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types_roles')->insert([
            'name' => 'Advertiser',
        ]);


        DB::table('types_roles')->insert([
            'name' => 'restaurants',
        ]);

    }
}
