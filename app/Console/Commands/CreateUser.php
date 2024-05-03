<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {email : The email address of the user} {password : The password for the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Check if user with the provided email already exists
        if (User::where('email', $email)->exists()) {
            $this->error('User with this email already exists.');
            return;
        }

        // Check password length
        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters long.');
            return;
        }

        // Create the user
        User::create([
            'email' => $email,
            'name' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('User created successfully.');
    }
}
