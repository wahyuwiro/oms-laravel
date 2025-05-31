<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $staff = Role::create(['name' => 'staff']);

        User::create([
            'name' => 'Admin User',
            'email' => 'phawiro@gmail.com',
            'phone' => '1234567890',
            'password' => Hash::make('password'),
            'role_id' => $admin->id,
        ]);

        User::create([
            'name' => 'Staff User',
            'email' => 'phawiro+staff@gmail.com',
            'phone' => '9876543210',
            'password' => Hash::make('password'),
            'role_id' => $staff->id,
        ]);
    }
}
