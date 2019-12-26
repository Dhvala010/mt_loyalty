<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => "admin",
            'guard_name' => "admin",
        ]);
        Role::create([
            'name' => "customer",
            'guard_name' => "customer",
        ]);
        Role::create([
            'name' => "merchant",
            'guard_name' => "merchant",
        ]);
    }
}
