<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleTableSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => "admin",
        ]);
        $customer = Role::create([
            'name' => "customer"
        ]);
        $merchant = Role::create([
            'name' => "merchant"
        ]);

        $Adminpermission = Permission::create( ['name' => 'admin module'] );
        $customerpermission = Permission::create( ['name' => 'customer module'] );
        $merchantpermission = Permission::create( ['name' => 'merchant module'] );

        $admin->givePermissionTo($Adminpermission);
        $admin->givePermissionTo($customerpermission);
        $admin->givePermissionTo($merchantpermission);

        $merchant->givePermissionTo($merchantpermission);
        $merchant->givePermissionTo($customerpermission);
    }
}
