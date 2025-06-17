<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staffs = [
            [
                'name' => 'Staff Satu',
                'email' => 'staff1@example.com',
                'password' => Hash::make('password123'),
                'nik' => '1234567890123456',
                'no_telepon' => '081234567890',
                'role' => 'staff',
            ],
            [
                'name' => 'Staff Dua',
                'email' => 'staff2@example.com',
                'password' => Hash::make('password123'),
                'nik' => '2345678901234567',
                'no_telepon' => '081234567891',
                'role' => 'staff',
            ],
            [
                'name' => 'Staff Tiga',
                'email' => 'staff3@example.com',
                'password' => Hash::make('password123'),
                'nik' => '3456789012345678',
                'no_telepon' => '081234567892',
                'role' => 'staff',
            ],
        ];

        foreach ($staffs as $staff) {
            User::create($staff);
        }
    }
} 