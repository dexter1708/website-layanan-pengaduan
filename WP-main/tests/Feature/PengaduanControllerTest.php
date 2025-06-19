<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wilayah;
use App\Models\Pengaduan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PengaduanControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $wilayah;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a user
        $this->user = User::factory()->create();
        
        // Create a wilayah record
        $this->wilayah = Wilayah::create([
            'kota_id' => '3578',
            'kota_nama' => 'KOTA SURABAYA',
            'kecamatan_id' => '3578240',
            'kecamatan_nama' => 'SUKOLILO',
            'desa_id' => '3578240001',
            'desa_nama' => 'KEPUTIH'
        ]);
    }

    public function test_create_pengaduan_page_can_be_rendered()
    {
        $response = $this->actingAs($this->user)
            ->get(route('pengaduan.create'));

        $response->assertStatus(200);
        $response->assertViewIs('pelapor.pengaduan');
        $response->assertViewHas('kotas');
    }

    public function test_store_pengaduan_with_valid_data()
    {
        $pengaduanData = [
            'jenis_kasus' => 'KDRT',
            'bentuk_kekerasan' => 'Fisik',
            'tempat_kejadian' => 'Rumah',
            'kota' => $this->wilayah->kota_id,
            'kecamatan' => $this->wilayah->kecamatan_id,
            'desa' => $this->wilayah->desa_id,
            'kecamatan_kejadian' => $this->wilayah->kecamatan_nama,
            'desa_kejadian' => $this->wilayah->desa_nama,
            'tanggal_kejadian' => '2024-03-20',
            'laporan_lama_baru' => 'Baru',
            'kronologi' => 'Kronologi kejadian test',
            'isi_manual' => true,
            'nama_pelapor' => 'John Doe',
            'rt' => '001',
            'rw' => '002',
            'nama_korban' => 'Jane Doe',
            'jenis_kelamin_korban' => 'Perempuan',
            'disabilitas_korban' => 'Tidak',
            'usia_korban' => 25,
            'pendidikan_korban' => 'SMA',
            'status_perkawinan_korban' => 'Belum Kawin',
            'nama_pelaku' => 'James Doe',
            'jenis_kelamin_pelaku' => 'Laki-laki',
            'usia_pelaku' => 30,
            'pendidikan_pelaku' => 'S1',
            'pekerjaan_pelaku' => 'Swasta',
            'hubungan' => 'Tetangga',
            'kewarganegaraan' => 'WNI'
        ];

        $response = $this->actingAs($this->user)
            ->post(route('pengaduan.store'), $pengaduanData);

        $response->assertRedirect(route('pengaduan.riwayat'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('pengaduans', [
            'user_id' => $this->user->id,
            'jenis_kasus' => 'KDRT',
            'status' => 'baru'
        ]);
    }

    public function test_riwayat_pengaduan_can_be_viewed()
    {
        // Create some pengaduan records
        Pengaduan::create([
            'user_id' => $this->user->id,
            'jenis_kasus' => 'KDRT',
            'bentuk_kekerasan' => 'Fisik',
            'tempat_kejadian' => 'Rumah',
            'kecamatan' => 'SUKOLILO',
            'desa' => 'KEPUTIH',
            'tanggal_kejadian' => '2024-03-20',
            'jenis_laporan' => 'Baru',
            'kronologi' => 'Test kronologi',
            'status' => 'baru'
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('pengaduan.riwayat'));

        $response->assertStatus(200);
        $response->assertViewIs('pelapor.riwayat');
        $response->assertViewHas('pengaduans');
    }

    public function test_show_pengaduan_detail()
    {
        $pengaduan = Pengaduan::create([
            'user_id' => $this->user->id,
            'jenis_kasus' => 'KDRT',
            'bentuk_kekerasan' => 'Fisik',
            'tempat_kejadian' => 'Rumah',
            'kecamatan' => 'SUKOLILO',
            'desa' => 'KEPUTIH',
            'tanggal_kejadian' => '2024-03-20',
            'jenis_laporan' => 'Baru',
            'kronologi' => 'Test kronologi',
            'status' => 'baru'
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('pengaduan.show', $pengaduan->id));

        $response->assertStatus(200);
        $response->assertViewIs('pelapor.detail');
        $response->assertViewHas('pengaduan');
    }

    public function test_store_pengaduan_validation_fails()
    {
        $invalidData = [
            // Missing required fields
        ];

        $response = $this->actingAs($this->user)
            ->post(route('pengaduan.store'), $invalidData);

        $response->assertSessionHasErrors([
            'jenis_kasus',
            'bentuk_kekerasan',
            'tempat_kejadian',
            'kecamatan_kejadian',
            'desa_kejadian',
            'tanggal_kejadian',
            'laporan_lama_baru',
            'kronologi'
        ]);
    }
} 