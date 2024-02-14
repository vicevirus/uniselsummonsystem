<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = "sensonic";
        $students = [
            [
                'matricNumber' => '4213005271',
                'icNumber' => '011025050201',
                'name' => 'Muhammad Shariff',
                'plateNumber' => 'VJT8940',
                'phoneNumber' => '601110135496',
                'address' => '3457 JALAN RABU MAJLIS KAMPUNG BARU 89000 PENANG',
                'carType' => 'Proton Axia',
                'password' => Hash::make($password), // Hash the password
                'QRCodeId' => '1d8da54a-4357-416c-ae8b-075fcee1f9a5'
            ],
        ];

        // Loop through each student and create an entry in the database
        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
