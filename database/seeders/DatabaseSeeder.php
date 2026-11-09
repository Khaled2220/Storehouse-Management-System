<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminPassword = config('seeding.admin.password');
        $userPassword = config('seeding.user.password');

        if (empty($adminPassword) || empty($userPassword)) {
            throw new RuntimeException(
                'Seeder passwords must be configured in the .env file.'
            );
        }

        User::firstOrCreate(
            ['email' => config('seeding.admin.email')],
            [
                'full_name' => 'Admin',
                'password' => Hash::make($adminPassword),
                'user_type' => 1,
            ]
        );

        User::firstOrCreate(
            ['email' => config('seeding.user.email')],
            [
                'full_name' => 'Normal User',
                'password' => Hash::make($userPassword),
                'user_type' => 2,
            ]
        );
    }
}
