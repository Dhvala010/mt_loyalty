<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => "Admin",
            'last_name' => "Admin",
            'email' => "admin@yopmail.com",
            'password' => bcrypt('Admin@123'),
            'role' =>'1',
        ]);
        $user->assignRole("admin");
    }
}
