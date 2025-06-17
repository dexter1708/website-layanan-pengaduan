<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\instruktur;

class InstrukturSeeder extends Seeder
{
    public function run(): void
    {
        $instrukturs = [
            // Instruktur untuk Pendampingan Hukum
            [
                'nama' => 'Dr. Ahmad Hidayat, S.H., M.H.',
                'posisi' => 'Pendamping Hukum Senior',
                'foto' => null,
                'nama_layanan' => 'Pendampingan Hukum'
            ],
            [
                'nama' => 'Siti Nurhaliza, S.H.',
                'posisi' => 'Pendamping Hukum',
                'foto' => null,
                'nama_layanan' => 'Pendampingan Hukum'
            ],
            
            // Instruktur untuk Pendampingan Kesehatan
            [
                'nama' => 'Dr. Budi Santoso, Sp.KJ.',
                'posisi' => 'Psikiater',
                'foto' => null,
                'nama_layanan' => 'Pendampingan Kesehatan'
            ],
            [
                'nama' => 'dr. Rina Kartika',
                'posisi' => 'Dokter Umum',
                'foto' => null,
                'nama_layanan' => 'Pendampingan Kesehatan'
            ],
            
            // Instruktur untuk Pendampingan Rehabilitasi Sosial
            [
                'nama' => 'Maya Sari, S.Sos.',
                'posisi' => 'Pekerja Sosial',
                'foto' => null,
                'nama_layanan' => 'Pendampingan Rehabilitasi Sosial'
            ],
            [
                'nama' => 'Bambang Wijaya, S.Pd.',
                'posisi' => 'Konselor Rehabilitasi',
                'foto' => null,
                'nama_layanan' => 'Pendampingan Rehabilitasi Sosial'
            ],
            
            // Instruktur untuk Pendampingan Reintegrasi Sosial
            [
                'nama' => 'Dewi Kusuma, S.Sos.',
                'posisi' => 'Pendamping Reintegrasi',
                'foto' => null,
                'nama_layanan' => 'Pendampingan Reintegrasi Sosial'
            ],
            [
                'nama' => 'Ahmad Fauzi, M.Si.',
                'posisi' => 'Konselor Reintegrasi',
                'foto' => null,
                'nama_layanan' => 'Pendampingan Reintegrasi Sosial'
            ],
            
            // Instruktur untuk Konseling Psikologis
            [
                'nama' => 'Dr. Sarah Indah, M.Psi.',
                'posisi' => 'Psikolog Klinis',
                'foto' => null,
                'nama_layanan' => 'Konseling Psikologis'
            ],
            [
                'nama' => 'Rudi Hartono, M.Psi.',
                'posisi' => 'Psikolog',
                'foto' => null,
                'nama_layanan' => 'Konseling Psikologis'
            ],
            
            // Instruktur untuk Konseling Trauma
            [
                'nama' => 'Dr. Linda Permata, M.Psi.',
                'posisi' => 'Psikolog Trauma',
                'foto' => null,
                'nama_layanan' => 'Konseling Trauma'
            ],
            [
                'nama' => 'Andi Prasetyo, M.Psi.',
                'posisi' => 'Konselor Trauma',
                'foto' => null,
                'nama_layanan' => 'Konseling Trauma'
            ],
            
            // Instruktur untuk Konseling Keluarga
            [
                'nama' => 'Nina Safitri, M.Psi.',
                'posisi' => 'Konselor Keluarga',
                'foto' => null,
                'nama_layanan' => 'Konseling Keluarga'
            ],
            [
                'nama' => 'Eko Prasetyo, S.Psi.',
                'posisi' => 'Konselor Keluarga',
                'foto' => null,
                'nama_layanan' => 'Konseling Keluarga'
            ],
            
            // Instruktur untuk Konseling Anak
            [
                'nama' => 'Sari Indah, M.Psi.',
                'posisi' => 'Psikolog Anak',
                'foto' => null,
                'nama_layanan' => 'Konseling Anak'
            ],
            [
                'nama' => 'Budi Raharjo, S.Psi.',
                'posisi' => 'Konselor Anak',
                'foto' => null,
                'nama_layanan' => 'Konseling Anak'
            ],
        ];

        foreach ($instrukturs as $instruktur) {
            instruktur::create($instruktur);
        }
    }
} 