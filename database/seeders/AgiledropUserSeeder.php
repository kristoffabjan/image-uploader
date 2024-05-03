<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AgiledropUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::where('email', 'info@agiledrop.si')->exists()) {
            
            Log::info('User already exists');
            
            return;
        }

        Log::info('Creating agiledrop user');

        User::create([
            'name' => 'agiledrop',
            'email' => 'info@agiledrop.si',
            'password' => Hash::make('agiledrop123'),
        ]);
    }
}
