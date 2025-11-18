<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'address' => '123 Admin Street, Admin City',
                'contact_number' => '1234567890',
                'email' => 'superadmin@capstone.com',
                'password' => Hash::make('password123'),
                'access' => 'super_admin',
                'status' => 'active',
                'img_path' => 'default-avatar.png',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Admin',
                'address' => '456 Admin Avenue, Admin City',
                'contact_number' => '0987654321',
                'email' => 'admin@capstone.com',
                'password' => Hash::make('password123'),
                'access' => 'admin',
                'status' => 'active',
                'img_path' => 'default-avatar.png',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'address' => '789 User Lane, User City',
                'contact_number' => '1112223333',
                'email' => 'user@capstone.com',
                'password' => Hash::make('password123'),
                'access' => 'user',
                'status' => 'active',
                'img_path' => 'default-avatar.png',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Bob',
                'last_name' => 'Smith',
                'address' => '321 Customer Road, User City',
                'contact_number' => '4445556666',
                'email' => 'bob@capstone.com',
                'password' => Hash::make('password123'),
                'access' => 'user',
                'status' => 'active',
                'img_path' => 'default-avatar.png',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Alice',
                'last_name' => 'Johnson',
                'address' => '555 Main Street, User City',
                'contact_number' => '7778889999',
                'email' => 'alice@capstone.com',
                'password' => Hash::make('password123'),
                'access' => 'user',
                'status' => 'active',
                'img_path' => 'default-avatar.png',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Inactive',
                'last_name' => 'User',
                'address' => '999 Inactive Drive, User City',
                'contact_number' => '0001112222',
                'email' => 'inactive@capstone.com',
                'password' => Hash::make('password123'),
                'access' => 'user',
                'status' => 'inactive',
                'img_path' => 'default-avatar.png',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
