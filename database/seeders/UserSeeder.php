<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User (password cast is hashed on model)
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => 'password',
            'phone' => '+1234567890',
            'enabled' => true,
            'reference' => 'ADM001',
            'cash' => 10000.00,
            'profit' => 500.00,
            'total_profit' => 500.00,
            'min_ratio' => 5.00,
            'max_ratio' => 15.00,
            'currency' => 'USD',
            'city' => 'New York',
            'email_verified_at' => now(),
        ]);

        // Create Test User
        User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => 'password',
            'phone' => '+9876543210',
            'enabled' => true,
            'reference' => 'USR001',
            'cash' => 5000.00,
            'profit' => 250.00,
            'total_profit' => 250.00,
            'min_ratio' => 3.00,
            'max_ratio' => 10.00,
            'currency' => 'USD',
            'city' => 'London',
            'email_verified_at' => now(),
        ]);

        // Create Investor User
        User::create([
            'name' => 'Investor User',
            'email' => 'investor@example.com',
            'password' => 'password',
            'phone' => '+5555555555',
            'enabled' => true,
            'reference' => 'INV001',
            'cash' => 25000.00,
            'profit' => 1250.00,
            'total_profit' => 1250.00,
            'min_ratio' => 7.00,
            'max_ratio' => 20.00,
            'currency' => 'USD',
            'contract_ref' => 'CONTRACT-2024-001',
            'expire_contract' => now()->addYear(),
            'city' => 'Dubai',
            'insurance' => 2500.00,
            'email_verified_at' => now(),
        ]);
    }
}
