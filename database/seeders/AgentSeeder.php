<?php

namespace Database\Seeders;

use App\Models\Agent;
use Illuminate\Database\Seeder;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin Agent
        Agent::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'password' => 'admin123',
            'enabled' => true,
            'type' => 'super_admin',
            'email_verified_at' => now(),
        ]);

        // Create Admin Agent
        Agent::create([
            'name' => 'Admin Agent',
            'email' => 'agent@admin.com',
            'password' => 'admin123',
            'enabled' => true,
            'type' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Manager Agent
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
