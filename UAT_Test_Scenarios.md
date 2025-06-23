# Skenario UAT (User Acceptance Testing) - Website Layanan Pengaduan

## 1. Testing untuk Role PELAPOR

### 1.1 Register (RF-01)
**Skenario:** Pelapor baru mendaftar ke sistem
- **Precondition:** User belum memiliki akun
- **Steps:**
  1. Buka halaman register
  2. Isi form pendaftaran dengan data valid
  3. Submit form
- **Expected Result:** Akun berhasil dibuat dan user dapat login

### 1.2 Login (RF-02)
**Skenario:** Pelapor login ke sistem
- **Precondition:** User sudah memiliki akun
- **Steps:**
  1. Buka halaman login
  2. Masukkan email/username dan password
  3. Klik tombol login
- **Expected Result:** User berhasil login dan diarahkan ke dashboard

### 1.3 Logout (RF-03)
**Skenario:** Pelapor logout dari sistem
- **Precondition:** User sudah login
- **Steps:**
  1. Klik menu logout
  2. Konfirmasi logout
- **Expected Result:** User berhasil logout dan diarahkan ke halaman login

### 1.4 Forgot Password (RF-04)
**Skenario:** Pelapor lupa password
- **Precondition:** User memiliki akun terdaftar
- **Steps:**
  1. Klik "Lupa Password"
  2. Masukkan email terdaftar
  3. Submit form
- **Expected Result:** Email reset password terkirim

### 1.5 View Profile (RF-05)
**Skenario:** Pelapor melihat profil sendiri
- **Precondition:** User sudah login
- **Steps:**
  1. Klik menu "Profile"
- **Expected Result:** Data profil ditampilkan dengan benar

### 1.6 Update Profile (RF-06)
**Skenario:** Pelapor mengupdate data profil
- **Precondition:** User sudah login
- **Steps:**
  1. Buka halaman profile
  2. Edit data yang ingin diubah
  3. Submit perubahan
- **Expected Result:** Data profil berhasil diupdate

### 1.7 Update Password (RF-07)
**Skenario:** Pelapor mengubah password
- **Precondition:** User sudah login
- **Steps:**
  1. Buka menu "Change Password"
  2. Masukkan password lama
  3. Masukkan password baru
  4. Konfirmasi password baru
  5. Submit
- **Expected Result:** Password berhasil diubah

### 1.8 Home (RF-08)
**Skenario:** Pelapor mengakses halaman home
- **Precondition:** User sudah login
- **Steps:**
  1. Klik menu "Home"
- **Expected Result:** Halaman home ditampilkan dengan informasi yang relevan

### 1.9 Create Pengaduan (RF-09)
**Skenario:** Pelapor membuat pengaduan baru
- **Precondition:** User sudah login
- **Steps:**
  1. Klik "Buat Pengaduan"
  2. Isi form pengaduan lengkap
  3. Upload bukti pendukung (jika ada)
  4. Submit pengaduan
- **Expected Result:** Pengaduan berhasil dibuat dan mendapat nomor tracking

### 1.10 View Pengaduan (RF-11)
**Skenario:** Pelapor melihat daftar pengaduan
- **Precondition:** User sudah login
- **Steps:**
  1. Klik menu "Pengaduan Saya"
- **Expected Result:** Daftar pengaduan user ditampilkan

### 1.11 View Status Pengaduan (RF-12)
**Skenario:** Pelapor melihat status pengaduan
- **Precondition:** User memiliki pengaduan
- **Steps:**
  1. Buka detail pengaduan
- **Expected Result:** Status pengaduan dan timeline progress ditampilkan

### 1.12 View Riwayat Pengaduan (RF-14)
**Skenario:** Pelapor melihat riwayat pengaduan
- **Precondition:** User sudah login
- **Steps:**
  1. Klik menu "Riwayat Pengaduan"
- **Expected Result:** Riwayat lengkap pengaduan ditampilkan

### 1.13 Create Pendampingan (RF-15)
**Skenario:** Pelapor membuat permintaan pendampingan
- **Precondition:** User sudah login
- **Steps:**
  1. Klik "Buat Pendampingan"
  2. Isi form pendampingan
  3. Submit
- **Expected Result:** Permintaan pendampingan berhasil dibuat

### 1.14 View Pendampingan (RF-18)
**Skenario:** Pelapor melihat data pendampingan
- **Precondition:** User sudah login
- **Steps:**
  1. Klik menu "Pendampingan"
- **Expected Result:** Data pendampingan ditampilkan

### 1.15 Konfirmasi Pendampingan (RF-19)
**Skenario:** Pelapor mengkonfirmasi jadwal pendampingan
- **Precondition:** Ada jadwal pendampingan yang ditawarkan
- **Steps:**
  1. Buka detail pendampingan
  2. Klik "Konfirmasi" atau "Tolak"
- **Expected Result:** Status pendampingan berubah sesuai konfirmasi

### 1.16 Create Konseling (RF-20)
**Skenario:** Pelapor membuat permintaan konseling
- **Precondition:** User sudah login
- **Steps:**
  1. Klik "Buat Konseling"
  2. Isi form konseling
  3. Submit
- **Expected Result:** Permintaan konseling berhasil dibuat

### 1.17 View Konseling (RF-23)
**Skenario:** Pelapor melihat data konseling
- **Precondition:** User sudah login
- **Steps:**
  1. Klik menu "Konseling"
- **Expected Result:** Data konseling ditampilkan

### 1.18 Konfirmasi Konseling (RF-24)
**Skenario:** Pelapor mengkonfirmasi jadwal konseling
- **Precondition:** Ada jadwal konseling yang ditawarkan
- **Steps:**
  1. Buka detail konseling
  2. Klik "Konfirmasi" atau "Tolak"
- **Expected Result:** Status konseling berubah sesuai konfirmasi

---

## 2. Testing untuk Role STAFF

### 2.1 Login (RF-02)
**Skenario:** Staff login ke sistem
- **Precondition:** Staff memiliki akun
- **Steps:**
  1. Buka halaman login
  2. Masukkan kredensial staff
  3. Login
- **Expected Result:** Staff berhasil login ke dashboard staff

### 2.2 Logout (RF-03)
**Skenario:** Staff logout dari sistem
- **Precondition:** Staff sudah login
- **Steps:**
  1. Klik menu logout
- **Expected Result:** Staff berhasil logout

### 2.3 View Profile (RF-05)
**Skenario:** Staff melihat profil
- **Precondition:** Staff sudah login
- **Steps:**
  1. Klik menu "Profile"
- **Expected Result:** Data profil staff ditampilkan

### 2.4 Update Profile (RF-06)
**Skenario:** Staff mengupdate profil
- **Precondition:** Staff sudah login
- **Steps:**
  1. Edit data profil
  2. Submit perubahan
- **Expected Result:** Profil berhasil diupdate

### 2.5 Update Password (RF-07)
**Skenario:** Staff mengubah password
- **Precondition:** Staff sudah login
- **Steps:**
  1. Masukkan password lama dan baru
  2. Submit
- **Expected Result:** Password berhasil diubah

### 2.6 Home (RF-08)
**Skenario:** Staff mengakses dashboard
- **Precondition:** Staff sudah login
- **Steps:**
  1. Buka halaman home
- **Expected Result:** Dashboard staff ditampilkan

### 2.7 Update Pengaduan (RF-10)
**Skenario:** Staff mengupdate data pengaduan
- **Precondition:** Ada pengaduan yang perlu diupdate
- **Steps:**
  1. Buka detail pengaduan
  2. Edit data yang diperlukan
  3. Submit perubahan
- **Expected Result:** Data pengaduan berhasil diupdate

### 2.8 View Pengaduan (RF-11)
**Skenario:** Staff melihat daftar pengaduan
- **Precondition:** Staff sudah login
- **Steps:**
  1. Klik menu "Pengaduan"
- **Expected Result:** Daftar pengaduan ditampilkan

### 2.9 View Status Pengaduan (RF-12)
**Skenario:** Staff melihat status pengaduan
- **Precondition:** Ada pengaduan dalam sistem
- **Steps:**
  1. Buka detail pengaduan
- **Expected Result:** Status dan timeline pengaduan ditampilkan

### 2.10 Update Status Pengaduan (RF-13)
**Skenario:** Staff mengupdate status pengaduan
- **Precondition:** Ada pengaduan yang perlu status diupdate
- **Steps:**
  1. Buka detail pengaduan
  2. Pilih status baru
  3. Tambahkan catatan (jika perlu)
  4. Submit
- **Expected Result:** Status pengaduan berhasil diupdate

### 2.11 View Riwayat Pengaduan (RF-14)
**Skenario:** Staff melihat riwayat pengaduan
- **Precondition:** Staff sudah login
- **Steps:**
  1. Klik menu "Riwayat Pengaduan"
- **Expected Result:** Riwayat pengaduan ditampilkan

### 2.12 Create Pendampingan (RF-15)
**Skenario:** Staff membuat jadwal pendampingan
- **Precondition:** Ada permintaan pendampingan
- **Steps:**
  1. Buka permintaan pendampingan
  2. Buat jadwal pendampingan
  3. Submit
- **Expected Result:** Jadwal pendampingan berhasil dibuat

### 2.13 Update Pendampingan (RF-16)
**Skenario:** Staff mengupdate data pendampingan
- **Precondition:** Ada pendampingan yang perlu diupdate
- **Steps:**
  1. Buka detail pendampingan
  2. Edit data yang diperlukan
  3. Submit
- **Expected Result:** Data pendampingan berhasil diupdate

### 2.14 Delete Pendampingan (RF-17)
**Skenario:** Staff menghapus pendampingan
- **Precondition:** Ada pendampingan yang perlu dihapus
- **Steps:**
  1. Buka detail pendampingan
  2. Klik "Delete"
  3. Konfirmasi penghapusan
- **Expected Result:** Pendampingan berhasil dihapus

### 2.15 View Pendampingan (RF-18)
**Skenario:** Staff melihat daftar pendampingan
- **Precondition:** Staff sudah login
- **Steps:**
  1. Klik menu "Pendampingan"
- **Expected Result:** Daftar pendampingan ditampilkan

### 2.16 Create Konseling (RF-20)
**Skenario:** Staff membuat jadwal konseling
- **Precondition:** Ada permintaan konseling
- **Steps:**
  1. Buka permintaan konseling
  2. Buat jadwal konseling
  3. Submit
- **Expected Result:** Jadwal konseling berhasil dibuat

### 2.17 Update Konseling (RF-21)
**Skenario:** Staff mengupdate data konseling
- **Precondition:** Ada konseling yang perlu diupdate
- **Steps:**
  1. Buka detail konseling
  2. Edit data yang diperlukan
  3. Submit
- **Expected Result:** Data konseling berhasil diupdate

### 2.18 Delete Konseling (RF-22)
**Skenario:** Staff menghapus konseling
- **Precondition:** Ada konseling yang perlu dihapus
- **Steps:**
  1. Buka detail konseling
  2. Klik "Delete"
  3. Konfirmasi penghapusan
- **Expected Result:** Konseling berhasil dihapus

### 2.19 View Konseling (RF-23)
**Skenario:** Staff melihat daftar konseling
- **Precondition:** Staff sudah login
- **Steps:**
  1. Klik menu "Konseling"
- **Expected Result:** Daftar konseling ditampilkan

### 2.20 View Dashboard (RF-25)
**Skenario:** Staff melihat dashboard
- **Precondition:** Staff sudah login
- **Steps:**
  1. Buka dashboard
- **Expected Result:** Dashboard dengan statistik ditampilkan

### 2.21 Filter Data (RF-26)
**Skenario:** Staff memfilter data
- **Precondition:** Ada data yang dapat difilter
- **Steps:**
  1. Pilih filter yang diinginkan
  2. Apply filter
- **Expected Result:** Data ditampilkan sesuai filter

---

## 3. Testing untuk Role SUPER ADMIN

### 3.1 Login (RF-02)
**Skenario:** Super Admin login ke sistem
- **Precondition:** Super Admin memiliki akun
- **Steps:**
  1. Buka halaman login
  2. Masukkan kredensial Super Admin
  3. Login
- **Expected Result:** Super Admin berhasil login ke dashboard admin

### 3.2 Logout (RF-03)
**Skenario:** Super Admin logout dari sistem
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu logout
- **Expected Result:** Super Admin berhasil logout

### 3.3 View Profile (RF-05)
**Skenario:** Super Admin melihat profil
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Profile"
- **Expected Result:** Data profil Super Admin ditampilkan

### 3.4 Update Profile (RF-06)
**Skenario:** Super Admin mengupdate profil
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Edit data profil
  2. Submit perubahan
- **Expected Result:** Profil berhasil diupdate

### 3.5 Update Password (RF-07)
**Skenario:** Super Admin mengubah password
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Masukkan password lama dan baru
  2. Submit
- **Expected Result:** Password berhasil diubah

### 3.6 Home (RF-08)
**Skenario:** Super Admin mengakses dashboard
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Buka halaman home
- **Expected Result:** Dashboard Super Admin ditampilkan

### 3.7 View Pengaduan (RF-11)
**Skenario:** Super Admin melihat semua pengaduan
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Pengaduan"
- **Expected Result:** Semua pengaduan dari semua user ditampilkan

### 3.8 View Status Pengaduan (RF-12)
**Skenario:** Super Admin melihat status pengaduan
- **Precondition:** Ada pengaduan dalam sistem
- **Steps:**
  1. Buka detail pengaduan
- **Expected Result:** Status dan timeline pengaduan ditampilkan

### 3.9 View Riwayat Pengaduan (RF-14)
**Skenario:** Super Admin melihat riwayat semua pengaduan
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Riwayat Pengaduan"
- **Expected Result:** Riwayat semua pengaduan ditampilkan

### 3.10 Create Pendampingan (RF-15)
**Skenario:** Super Admin membuat jadwal pendampingan
- **Precondition:** Ada permintaan pendampingan
- **Steps:**
  1. Buka permintaan pendampingan
  2. Buat jadwal pendampingan
  3. Submit
- **Expected Result:** Jadwal pendampingan berhasil dibuat

### 3.11 View Pendampingan (RF-18)
**Skenario:** Super Admin melihat semua pendampingan
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Pendampingan"
- **Expected Result:** Semua data pendampingan ditampilkan

### 3.12 Create Konseling (RF-20)
**Skenario:** Super Admin membuat jadwal konseling
- **Precondition:** Ada permintaan konseling
- **Steps:**
  1. Buka permintaan konseling
  2. Buat jadwal konseling
  3. Submit
- **Expected Result:** Jadwal konseling berhasil dibuat

### 3.13 View Konseling (RF-23)
**Skenario:** Super Admin melihat semua konseling
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Konseling"
- **Expected Result:** Semua data konseling ditampilkan

### 3.14 View Dashboard (RF-25)
**Skenario:** Super Admin melihat dashboard
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Buka dashboard
- **Expected Result:** Dashboard dengan statistik lengkap ditampilkan

### 3.15 Filter Data (RF-26)
**Skenario:** Super Admin memfilter data
- **Precondition:** Ada data yang dapat difilter
- **Steps:**
  1. Pilih filter yang diinginkan
  2. Apply filter
- **Expected Result:** Data ditampilkan sesuai filter

### 3.16 Create Akun Staff (RF-27)
**Skenario:** Super Admin membuat akun staff baru
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Kelola Staff"
  2. Klik "Tambah Staff"
  3. Isi form data staff
  4. Submit
- **Expected Result:** Akun staff berhasil dibuat

### 3.17 Update Akun Staff (RF-28)
**Skenario:** Super Admin mengupdate data staff
- **Precondition:** Ada akun staff yang perlu diupdate
- **Steps:**
  1. Buka detail staff
  2. Edit data yang diperlukan
  3. Submit
- **Expected Result:** Data staff berhasil diupdate

### 3.18 Delete Akun Staff (RF-29)
**Skenario:** Super Admin menghapus akun staff
- **Precondition:** Ada akun staff yang perlu dihapus
- **Steps:**
  1. Buka detail staff
  2. Klik "Delete"
  3. Konfirmasi penghapusan
- **Expected Result:** Akun staff berhasil dihapus

### 3.19 View Akun Staff (RF-30)
**Skenario:** Super Admin melihat daftar staff
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Kelola Staff"
- **Expected Result:** Daftar semua staff ditampilkan

### 3.20 Create Wilayah (RF-31)
**Skenario:** Super Admin menambah wilayah baru
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Kelola Wilayah"
  2. Klik "Tambah Wilayah"
  3. Isi form wilayah
  4. Submit
- **Expected Result:** Wilayah berhasil ditambahkan

### 3.21 Update Wilayah (RF-32)
**Skenario:** Super Admin mengupdate data wilayah
- **Precondition:** Ada wilayah yang perlu diupdate
- **Steps:**
  1. Buka detail wilayah
  2. Edit data yang diperlukan
  3. Submit
- **Expected Result:** Data wilayah berhasil diupdate

### 3.22 Delete Wilayah (RF-33)
**Skenario:** Super Admin menghapus wilayah
- **Precondition:** Ada wilayah yang perlu dihapus
- **Steps:**
  1. Buka detail wilayah
  2. Klik "Delete"
  3. Konfirmasi penghapusan
- **Expected Result:** Wilayah berhasil dihapus

### 3.23 View Wilayah (RF-34)
**Skenario:** Super Admin melihat daftar wilayah
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Kelola Wilayah"
- **Expected Result:** Daftar semua wilayah ditampilkan

### 3.24 View Pekerjaan (RF-35)
**Skenario:** Super Admin melihat daftar pekerjaan
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Kelola Pekerjaan"
- **Expected Result:** Daftar semua pekerjaan ditampilkan

### 3.25 Create Pekerjaan (RF-36)
**Skenario:** Super Admin menambah pekerjaan baru
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Kelola Pekerjaan"
  2. Klik "Tambah Pekerjaan"
  3. Isi form pekerjaan
  4. Submit
- **Expected Result:** Pekerjaan berhasil ditambahkan

### 3.26 Update Pekerjaan (RF-37)
**Skenario:** Super Admin mengupdate data pekerjaan
- **Precondition:** Ada pekerjaan yang perlu diupdate
- **Steps:**
  1. Buka detail pekerjaan
  2. Edit data yang diperlukan
  3. Submit
- **Expected Result:** Data pekerjaan berhasil diupdate

### 3.27 Delete Pekerjaan (RF-38)
**Skenario:** Super Admin menghapus pekerjaan
- **Precondition:** Ada pekerjaan yang perlu dihapus
- **Steps:**
  1. Buka detail pekerjaan
  2. Klik "Delete"
  3. Konfirmasi penghapusan
- **Expected Result:** Pekerjaan berhasil dihapus

### 3.28 View Bentuk Kekerasan (RF-39)
**Skenario:** Super Admin melihat daftar bentuk kekerasan
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Kelola Bentuk Kekerasan"
- **Expected Result:** Daftar semua bentuk kekerasan ditampilkan

### 3.29 Create Bentuk Kekerasan (RF-40)
**Skenario:** Super Admin menambah bentuk kekerasan baru
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Kelola Bentuk Kekerasan"
  2. Klik "Tambah Bentuk Kekerasan"
  3. Isi form bentuk kekerasan
  4. Submit
- **Expected Result:** Bentuk kekerasan berhasil ditambahkan

### 3.30 Update Bentuk Kekerasan (RF-41)
**Skenario:** Super Admin mengupdate data bentuk kekerasan
- **Precondition:** Ada bentuk kekerasan yang perlu diupdate
- **Steps:**
  1. Buka detail bentuk kekerasan
  2. Edit data yang diperlukan
  3. Submit
- **Expected Result:** Data bentuk kekerasan berhasil diupdate

### 3.31 Delete Bentuk Kekerasan (RF-42)
**Skenario:** Super Admin menghapus bentuk kekerasan
- **Precondition:** Ada bentuk kekerasan yang perlu dihapus
- **Steps:**
  1. Buka detail bentuk kekerasan
  2. Klik "Delete"
  3. Konfirmasi penghapusan
- **Expected Result:** Bentuk kekerasan berhasil dihapus

### 3.32 View Layanan (RF-43)
**Skenario:** Super Admin melihat daftar layanan
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Kelola Layanan"
- **Expected Result:** Daftar semua layanan ditampilkan

### 3.33 Create Layanan (RF-44)
**Skenario:** Super Admin menambah layanan baru
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Kelola Layanan"
  2. Klik "Tambah Layanan"
  3. Isi form layanan
  4. Submit
- **Expected Result:** Layanan berhasil ditambahkan

### 3.34 Update Layanan (RF-45)
**Skenario:** Super Admin mengupdate data layanan
- **Precondition:** Ada layanan yang perlu diupdate
- **Steps:**
  1. Buka detail layanan
  2. Edit data yang diperlukan
  3. Submit
- **Expected Result:** Data layanan berhasil diupdate

### 3.35 Delete Layanan (RF-46)
**Skenario:** Super Admin menghapus layanan
- **Precondition:** Ada layanan yang perlu dihapus
- **Steps:**
  1. Buka detail layanan
  2. Klik "Delete"
  3. Konfirmasi penghapusan
- **Expected Result:** Layanan berhasil dihapus

### 3.36 View Instruktur (RF-47)
**Skenario:** Super Admin melihat daftar instruktur
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Kelola Instruktur"
- **Expected Result:** Daftar semua instruktur ditampilkan

### 3.37 Create Instruktur (RF-48)
**Skenario:** Super Admin menambah instruktur baru
- **Precondition:** Super Admin sudah login
- **Steps:**
  1. Klik menu "Kelola Instruktur"
  2. Klik "Tambah Instruktur"
  3. Isi form instruktur
  4. Submit
- **Expected Result:** Instruktur berhasil ditambahkan

### 3.38 Update Instruktur (RF-49)
**Skenario:** Super Admin mengupdate data instruktur
- **Precondition:** Ada instruktur yang perlu diupdate
- **Steps:**
  1. Buka detail instruktur
  2. Edit data yang diperlukan
  3. Submit
- **Expected Result:** Data instruktur berhasil diupdate

### 3.39 Delete Instruktur (RF-50)
**Skenario:** Super Admin menghapus instruktur
- **Precondition:** Ada instruktur yang perlu dihapus
- **Steps:**
  1. Buka detail instruktur
  2. Klik "Delete"
  3. Konfirmasi penghapusan
- **Expected Result:** Instruktur berhasil dihapus

---

## 4. Skenario Testing Negatif

### 4.1 Login dengan Kredensial Salah
**Skenario:** User mencoba login dengan email/password salah
- **Steps:**
  1. Masukkan email yang tidak terdaftar
  2. Masukkan password yang salah
  3. Klik login
- **Expected Result:** Pesan error "Email atau password salah"

### 4.2 Register dengan Email Sudah Terdaftar
**Skenario:** User mencoba register dengan email yang sudah ada
- **Steps:**
  1. Isi form register dengan email yang sudah terdaftar
  2. Submit form
- **Expected Result:** Pesan error "Email sudah terdaftar"

### 4.3 Akses Halaman Tanpa Login
**Skenario:** User mencoba akses halaman yang memerlukan login
- **Steps:**
  1. Buka URL halaman yang memerlukan login
- **Expected Result:** Diarahkan ke halaman login

### 4.4 Akses Halaman Tanpa Permission
**Skenario:** User mencoba akses halaman yang tidak sesuai rolenya
- **Steps:**
  1. Login sebagai Pelapor
  2. Coba akses halaman kelola staff
- **Expected Result:** Pesan error "Anda tidak memiliki akses"

---

## 5. Checklist Testing

### 5.1 Functional Testing
- [ ] Semua fitur register berfungsi
- [ ] Semua fitur login/logout berfungsi
- [ ] Semua fitur CRUD pengaduan berfungsi
- [ ] Semua fitur CRUD pendampingan berfungsi
- [ ] Semua fitur CRUD konseling berfungsi
- [ ] Semua fitur manajemen master data berfungsi
- [ ] Sistem role dan permission berfungsi

### 5.2 UI/UX Testing
- [ ] Interface responsif di berbagai device
- [ ] Navigasi menu berfungsi dengan baik
- [ ] Form validation berfungsi
- [ ] Pesan error/success ditampilkan dengan jelas
- [ ] Loading state ditampilkan saat proses

### 5.3 Security Testing
- [ ] Password di-hash dengan aman
- [ ] Session management berfungsi
- [ ] CSRF protection aktif
- [ ] SQL injection protection
- [ ] XSS protection

### 5.4 Performance Testing
- [ ] Halaman load dalam waktu wajar
- [ ] Database query optimal
- [ ] File upload berfungsi dengan baik
- **Expected Result:** Semua kriteria terpenuhi

---

## 6. Data Testing

### 6.1 Data Valid
- Email: test@example.com
- Password: Password123!
- Nama: Test User
- No. Telepon: 081234567890

### 6.2 Data Invalid
- Email: invalid-email
- Password: 123 (terlalu pendek)
- Nama: "" (kosong)
- No. Telepon: abc123 (bukan angka)

---

## 7. Browser Testing
Test di browser berikut:
- [ ] Chrome
- [ ] Firefox
- [ ] Safari
- [ ] Edge

---

## 8. Device Testing
Test di device berikut:
- [ ] Desktop (Windows/Mac)
- [ ] Tablet (iPad/Android)
- [ ] Mobile (iPhone/Android)

---

**Catatan:** Setiap skenario testing harus dijalankan dan hasilnya dicatat. Jika ada bug atau issue, harus dilaporkan dan diperbaiki sebelum deployment ke production. 