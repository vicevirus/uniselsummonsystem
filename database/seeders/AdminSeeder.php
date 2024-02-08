<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'adminName' => 'Aiman', // Example admin name
            'admin_username' => 'aiman', // Example username
            'admin_password' => Hash::make('sensonic'), // Example password, hashed
        ]);

        // You can add more Admins here as needed
    }
}
