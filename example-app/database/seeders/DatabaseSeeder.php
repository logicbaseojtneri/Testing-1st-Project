<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create the three developers
        User::factory()->create([
            'name' => 'Mara Dadula',
            'email' => 'mara@example.com',
            'role' => UserRole::FRONTEND_DEV,
        ]);

        User::factory()->create([
            'name' => 'Arianne Penolvo',
            'email' => 'arianne@example.com',
            'role' => UserRole::BACKEND_DEV,
        ]);

        User::factory()->create([
            'name' => 'Margaret Neri',
            'email' => 'margaret@example.com',
            'role' => UserRole::SERVER_ADMIN,
        ]);

        // Create a test customer user
        User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'role' => UserRole::CUSTOMER,
        ]);
    }
}
