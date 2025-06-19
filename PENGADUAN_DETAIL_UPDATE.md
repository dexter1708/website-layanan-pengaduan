# Update Halaman Detail Pengaduan

## Deskripsi Perubahan

Sistem telah diperbarui untuk mengarahkan pengguna ke halaman detail pengaduan setelah melakukan pengaduan, bukan ke dashboard seperti sebelumnya.

## Perubahan yang Dilakukan

### 1. Controller PengaduanController
- **File**: `app/Http/Controllers/PengaduanController.php`
- **Perubahan**:
  - Menambahkan method `show($id)` untuk menampilkan detail pengaduan
  - Mengubah redirect di method `store()` dari `route('dashboard')` ke `route('pengaduan.show', $pengaduan->id)`
  - Menambahkan validasi keamanan untuk memastikan user hanya bisa melihat pengaduan miliknya

### 2. Route Baru
- **File**: `routes/web.php`
- **Perubahan**:
  - Menambahkan route `GET /pengaduan/{id}` yang mengarah ke `PengaduanController@show`

### 3. Halaman Detail Pengaduan Baru
- **File**: `resources/views/pengaduan/show.blade.php`
- **Fitur**:
  - Tampilan modern dengan Tailwind CSS
  - Informasi lengkap pengaduan (nomor, tanggal, jenis, status, dll.)
  - Data pelapor dengan alamat lengkap
  - Data korban dengan informasi detail
  - Data pelaku dengan informasi lengkap
  - Kronologi kejadian
  - Riwayat perubahan status dengan timeline
  - Penanganan data kosong dengan fallback values
  - Tombol kembali ke daftar pengaduan

### 4. Update Link di Halaman Lain
- **File yang diupdate**:
  - `resources/views/Pelapor/tracking.blade.php`
  - `resources/views/dashboard/pelapor.blade.php`
  - `resources/views/dashboard/staff.blade.php`
  - `resources/views/data-dashboard/index.blade.php`
- **Perubahan**: Mengubah link "Detail" dari `route('tracking.show')` ke `route('pengaduan.show')`

## Alur Baru

1. User mengisi form pengaduan
2. Setelah submit berhasil, user diarahkan ke halaman detail pengaduan
3. Halaman detail menampilkan semua informasi pengaduan yang baru dibuat
4. User dapat melihat status, data korban, pelaku, dan riwayat perubahan
5. User dapat kembali ke daftar pengaduan atau melanjutkan ke halaman lain

## Keamanan

- User dengan role 'pelapor' hanya dapat melihat pengaduan miliknya sendiri
- Staff dan admin dapat melihat semua pengaduan
- Validasi keamanan diterapkan di controller

## Tampilan

- Menggunakan layout Laravel Breeze dengan Tailwind CSS
- Responsive design untuk desktop dan mobile
- Status pengaduan ditampilkan dengan warna yang sesuai
- Data ditampilkan dalam card yang terorganisir
- Timeline untuk riwayat perubahan status

## Pesan Sukses

Setelah pengaduan berhasil dibuat, user akan melihat pesan:
"Pengaduan berhasil diajukan! Silakan lihat detail pengaduan Anda di bawah ini."

## Kompatibilitas

- Semua halaman yang sudah ada tetap berfungsi normal
- Link lama masih tersedia untuk tracking status
- Tidak ada breaking changes pada fitur yang sudah ada 