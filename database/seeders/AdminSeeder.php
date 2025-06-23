<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create Staff
        User::create([
            'name' => 'arian',
            'email' => 'stafarian@admin.com',
            'password' => Hash::make('staff123'),
            'nik' => '4545454564564454545',
            'role' => 'staff',
            'email_verified_at' => now(),
        ]);
    }
} 