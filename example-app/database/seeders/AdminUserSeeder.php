<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        if (User::where('email', 'admin@example.com')->exists()) {
            $this->command->info('Admin user already exists.');
            return;
        }

        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Change this in production!
            'role' => UserRole::ADMIN,
            'email_verified_at' => now(),
        ]);

        $this->command->info("Admin user created: {$admin->email}");
        $this->command->warn('⚠️  IMPORTANT: Change the admin password in production!');
    }
}
