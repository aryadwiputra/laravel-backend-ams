<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'admin',
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'phone_number' => '1234567890',
                'password' => bcrypt('password'),
            ],
            [
                'username'=> 'user',
                'name' => 'User',
                'email' => 'user@example.com',
                'phone_number' => '1234567890',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
