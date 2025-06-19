<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staffs = [
            [
                'name' => 'Staff Satu',
                'email' => 'stafsatu@example.com',
                'password' => Hash::make('password123'),
                'nik' => '123456',
                'no_telepon' => '123456',
                'role' => 'staff',
            ],
            [
                'name' => 'Staff Dua',
                'email' => 'staffdua@example.com',
                'password' => Hash::make('password123'),
                'nik' => '1234567',
                'no_telepon' => '1234567',
                'role' => 'staff',
            ],
            [
                'name' => 'Staff Tiga',
                'email' => 'stafftiga@example.com',
                'password' => Hash::make('password123'),
                'nik' => '12345678',
                'no_telepon' => '12345678',
                'role' => 'staff',
            ],
        ];

        foreach ($staffs as $staff) {
            // User::create($staff);
            DB::table('users')->insert([
                'name' => $staff['name'],
                'email' => $staff['email'],
                'password' => $staff['password'],
                'nik' => $staff['nik'],
                'no_telepon' => $staff['no_telepon'],
                'role' => $staff['role'],
                'email_verified_at' => now(),
            ]);
        }
    }
} 