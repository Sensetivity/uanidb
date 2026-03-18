<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the admin user.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'admin@uanidb.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('passwor'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
