<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'VIEW_ADMIN',
        ]);

        DB::table('permissions')->insert([
            'name' => 'EDIT_PERMISSIONS',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ADMIN_USERS',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ADVERTISER_COMPANIES',
        ]);

        DB::table('permissions')->insert([
            'name' => 'RESTAURANT_COMPANIES',
        ]);

        DB::table('permissions')->insert([
            'name' => 'INDUSTRIES_FOR_ADVERTISER_COMPANIES',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ADD_DISH_FOR_RESTAURANTS',
        ]);

        DB::table('permissions')->insert([
            'name' => 'RESTAURANT_CUISINE',
        ]);
        DB::table('permissions')->insert([
            'name' => 'RESTAURANT_SHOP_PROFILE',
        ]);
        DB::table('permissions')->insert([
            'name' => 'CUSTOMER_TYPES_RESTAURANTS',
        ]);
        DB::table('permissions')->insert([
            'name' => 'RESTAURANT_ACCOUNT_TYPE',
        ]);
        DB::table('permissions')->insert([
            'name' => 'TASKS_FOR_ADVERTISERS_COMPANIES',
        ]);

        DB::table('permissions')->insert([
            'name' => 'TASKS_FOR_RESTAURANT_COMPANIES',
        ]);
        DB::table('permissions')->insert([
            'name' => 'ADD_DISTRICTS',
        ]);
        DB::table('permissions')->insert([
            'name' => 'RESTAURANT_TYPE',
        ]);
        DB::table('permissions')->insert([
            'name' => 'SHOPS',
        ]);




    }
}
