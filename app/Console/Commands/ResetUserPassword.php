<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ResetUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:reset-password 
                            {email : The user email address} 
                            {password : The new password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password for an admin panel user by email';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("User with email [{$email}] not found.");
            return self::FAILURE;
        }

        $user->password = $password;
        $user->save();

        $this->info("Password reset successfully for [{$email}].");
        return self::SUCCESS;
    }
}
