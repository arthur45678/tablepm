<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(TypesRolesSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(RoleUserSeeder::class);
        $this->call(PermissionRoleSeeder::class);


    }
}
