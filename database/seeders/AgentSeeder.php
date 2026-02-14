<?php

namespace Database\Seeders;

use App\Models\Agent;
use Illuminate\Database\Seeder;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Use raw password; Agent model's 'hashed' cast hashes it.
     */
    public function run(): void
    {
        // Create Super Admin Agent (password: admin123)
        Agent::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'password' => 'admin123',
            'enabled' => true,
            'type' => 'super_admin',
            'email_verified_at' => now(),
        ]);

        // Create Admin Agent (password: admin123)
        Agent::create([
            'name' => 'Admin Agent',
            'email' => 'agent@admin.com',
            'password' => 'admin123',
            'enabled' => true,
            'type' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Manager Agent (password: admin123)
        Agent::create([
            'name' => 'Manager',
            'email' => 'manager@admin.com',
            'password' => 'admin123',
            'enabled' => true,
            'type' => 'manager',
            'email_verified_at' => now(),
        ]);
    }
}
