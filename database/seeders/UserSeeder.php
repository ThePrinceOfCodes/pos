<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::create(['name' => 'Developer']);
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Staff']);
        $role3 = Role::create(['name' => 'Store Keeper']);
        $role4 = Role::create(['name' => 'Manager']);
        $role5 = Role::create(['name' => 'Cashier']);
        $user = User::create([
            'name' => 'App Developer',
            'email' => 'developer@gmail.com',
            'password' => Hash::make('123456'),
            'branch_id' => 1
        ]);

        $user->assignRole($role);

        $user1 = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'branch_id' => 1
        ]);

        $user1->assignRole($role1);

        $user2 = User::create([
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'password' => Hash::make('123456'),
            'branch_id' => 1
        ]);

        $user2->assignRole($role2);

        $user3 = User::create([
            'name' => 'Store Keeper',
            'email' => 'store@gmail.com',
            'password' => Hash::make('123456'),
            'branch_id' => 1
        ]);

        $user3->assignRole($role3);

        $user4 = User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('123456'),
            'branch_id' => 1
        ]);

        $user4->assignRole($role4);

        $user5 = User::create([
            'name' => 'Cashier',
            'email' => 'cashier@gmail.com',
            'password' => Hash::make('123456'),
            'branch_id' => 1
        ]);
        

        $user5->assignRole($role5);
    }
}
