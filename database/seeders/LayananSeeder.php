<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\layanan;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $layanans = [
            // Layanan Pendampingan
            [
                'nama_layanan' => 'Pendampingan Hukum',
                'jenis_layanan' => 'pendampingan'
            ],
            [
                'nama_layanan' => 'Pendampingan Kesehatan',
                'jenis_layanan' => 'pendampingan'
            ],
            [
                'nama_layanan' => 'Pendampingan Rehabilitasi Sosial',
                'jenis_layanan' => 'pendampingan'
            ],
            [
                'nama_layanan' => 'Pendampingan Reintegrasi Sosial',
                'jenis_layanan' => 'pendampingan'
            ],
            
            // Layanan Konseling
            [
                'nama_layanan' => 'Konseling Psikologis',
                'jenis_layanan' => 'konseling'
            ],
            [
                'nama_layanan' => 'Konseling Trauma',
                'jenis_layanan' => 'konseling'
            ],
            [
                'nama_layanan' => 'Konseling Keluarga',
                'jenis_layanan' => 'konseling'
            ],
        ];

        foreach ($layanans as $layanan) {
            layanan::updateOrCreate(
                ['nama_layanan' => $layanan['nama_layanan']],
                $layanan
            );
        }
    }
} 