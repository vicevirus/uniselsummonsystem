<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Import the Hash facade
use App\Models\SecurityGuard; // Import your model

class SecurityGuardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SecurityGuard::create([
            'securityName' => 'Aiman', // Example name
            'guard_username' => 'aiman', // Example username
            'guard_password' => Hash::make('sensonic'), // Example password, hashed
            'api_token' => \Str::random(60), // Generating a random API token
        ]);

        // You can add more entries here
    }
}
