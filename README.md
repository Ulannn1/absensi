# Dokumentasi Proyek Absensi PKL

## Konsep Dari Web Yang Saya Buat

Absensi PKL adalah website sistem manajemen absensi online untuk peserta magang (Praktik Kerja Lapangan/PKL) yang dirancang untuk memudahkan proses pencatatan kehadiran, ketidakhadiran, dan aktivitas harian secara digital. Absensi PKL bertujuan untuk memberikan pengalaman pencatatan absensi yang lebih cepat, efisien, dan transparan, sehingga seluruh proses monitoring peserta magang dapat berjalan dengan lancar dan terintegrasi dengan baik.

## Fitur Yang Tersedia

### Halaman Awal

-   Home
-   About (Tentang)
-   Contact (Hubungi)
-   Navigation Menu untuk User & Admin

### Authentication

-   Register (Pendaftaran)
-   Login
-   Logout

### Multi User

#### Admin

-   Dashboard: Melihat ringkasan absensi harian
-   Mengelola Data Peserta Magang
-   Melihat semua data absensi dengan filter tanggal
-   Export data absensi ke CSV dan PDF
-   Melihat detail absensi per peserta (modal view)
-   Melihat aktivitas historis per peserta
-   Mengelola permintaan izin/sakit/cuti dari peserta
-   Approval izin peserta

#### Peserta Magang (Intern)

-   Mengakses halaman awal tanpa login
-   Login sebagai Peserta Magang
-   Check-in pagi (absensi masuk):
    -   Menyimpan jam masuk otomatis
    -   Menambahkan lokasi (opsional)
    -   Upload foto selfie (opsional)
-   Check-out pulang (absensi pulang):
    -   Menyimpan jam pulang otomatis
    -   Menulis laporan aktivitas harian
-   Melihat riwayat absensi dengan detail
-   Print formulir absensi
-   Mengajukan izin/sakit/cuti dengan upload bukti
-   Melihat profil dan mengubah data
-   Upload foto profil

### All (Semua User)

-   Login
-   Logout
-   Lihat halaman awal

## Akun Default

### Admin

-   Email: admin@example.com
-   Password: password

### Peserta Magang

-   Email: intern@example.com
-   Password: password

## Teknologi yang Digunakan

-   **Backend**: Laravel 10.x
-   **Frontend**: Bootstrap 5.3
-   **Database**: MySQL 8.x
-   **Server**: Apache (XAMPP)
-   **PHP**: 8.1+
-   **Authentication**: Laravel Breeze / Sanctum

## Tools yang Digunakan

-   XAMPP (Apache + PHP + MySQL)
-   Visual Studio Code
-   Composer
-   Laravel Artisan
-   MySQL Workbench / Navicat
-   Postman (untuk API testing)

## Persyaratan untuk Instalasi

-   PHP 8.1 atau lebih tinggi
-   Web Server (Apache)
-   Database (MySQL 8.x)
-   Web Browser (Chrome, Firefox, Safari, Edge)
-   Composer

## Struktur Direktori Utama

```
absensi-main/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── AttendanceController.php
│   │   │   ├── AuthController.php
│   │   │   ├── LeaveRequestController.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/
│   │   └── Kernel.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Attendance.php
│   │   └── LeaveRequest.php
│   └── Providers/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   ├── auth/
│   │   ├── attendances/
│   │   ├── admin/
│   │   ├── profile/
│   │   └── leave_requests/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   └── api.php
├── public/
│   ├── css/
│   ├── js/
│   └── storage/
├── config/
├── storage/
│   ├── app/
│   └── logs/
└── tests/
```

## Database Schema

### Tabel Users

-   id (Primary Key)
-   name (nama lengkap)
-   email (unique)
-   password (hashed)
-   role (admin / intern)
-   photo (foto profil, nullable)
-   created_at, updated_at

### Tabel Attendances

-   id (Primary Key)
-   user_id (Foreign Key → Users)
-   date (tanggal absensi)
-   checkin_at (jam masuk)
-   checkout_at (jam pulang, nullable)
-   checkin_location (lokasi masuk, nullable)
-   checkin_photo (foto selfie check-in, nullable)
-   checkout_report (laporan aktivitas pulang, nullable)
-   created_at, updated_at

### Tabel LeaveRequests

-   id (Primary Key)
-   user_id (Foreign Key → Users)
-   type (izin / sakit / cuti)
-   start_date (tanggal mulai)
-   end_date (tanggal akhir)
-   reason (alasan)
-   proof_file (bukti file, nullable)
-   status (pending / approved / rejected)
-   created_at, updated_at

## Cara Instalasi Absensi PKL

### 1. Persyaratan

Pastikan terlebih dulu Anda memenuhi persyaratan berikut:

-   PHP versi 8.1 atau lebih tinggi
-   Web Server (Apache via XAMPP)
-   Database (MySQL 8.x)
-   Web Browser (Chrome, Firefox, Safari, Edge)
-   Composer

### 2. Clone Repository

Pertama, clone repository dari GitHub dengan perintah berikut:

```bash
git clone https://github.com/yourusername/absensi-main.git
```

### 3. Masuk ke Direktori Proyek

Setelah clone selesai, masuk ke direktori proyek:

```bash
cd absensi-main
```

### 4. Instalasi Dependensi

Instal dependensi menggunakan Composer:

```bash
composer install
```

Jika mengalami error terkait zip/git (di Windows), ikuti langkah di bawah:

-   Pastikan **PHP zip extension** sudah diaktifkan di `php.ini`
-   Install **7-Zip** atau **Git for Windows** dan tambahkan ke PATH
-   Jalankan `composer clear-cache` lalu `composer install` kembali

### 5. Salin File .env

Salin file `.env.example` menjadi `.env`:

```bash
copy .env.example .env
```

Atau di Linux/Mac:

```bash
cp .env.example .env
```

### 6. Atur Kunci Aplikasi

Generate kunci aplikasi menggunakan Artisan:

```bash
php artisan key:generate
```

### 7. Konfigurasi Database

Edit file `.env` dan atur konfigurasi database Anda:

```plaintext
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi
DB_USERNAME=root
DB_PASSWORD=
```

**Catatan**: Jika menggunakan XAMPP, pastikan Apache dan MySQL sudah berjalan.

### 8. Jalankan Migrations

Jalankan perintah berikut untuk membuat tabel di database:

```bash
php artisan migrate
```

### 9. Jalankan Seeders (Opsional)

Jalankan seeder untuk menambahkan data default (admin & peserta):

```bash
php artisan db:seed
```

### 10. Setup Storage Link

Buat symbolic link untuk menyimpan file upload (foto profil, bukti izin):

```bash
php artisan storage:link
```

Jika error di Windows, jalankan sebagai Administrator atau gunakan:

```powershell
cmd /c mklink /J "public\storage" "storage\app\public"
```

### 11. Jalankan Server

Jalankan server lokal dengan perintah berikut:

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`

**Atau gunakan Apache via XAMPP:**

-   Letakkan proyek di `C:\xampp\htdocs\absensi-main`
-   Akses via `http://localhost/absensi-main/public`

## Fitur Utama - Panduan Penggunaan

### Untuk Admin

1. **Login**: Akses `http://localhost:8000/login` dengan email: `admin@example.com`
2. **Dashboard**: Lihat ringkasan absensi hari ini
3. **Export**: Export data absensi ke CSV atau PDF berdasarkan tanggal
4. **Detail Absensi**: Klik tombol "Lihat" untuk melihat detail lengkap per peserta
5. **Aktivitas User**: Klik nama peserta untuk melihat riwayat lengkap
6. **Manage Leave Requests**: Approve atau reject permintaan izin peserta

### Untuk Peserta Magang

1. **Register**: Daftar akun baru dengan email & password
2. **Login**: Masuk dengan akun yang sudah terdaftar
3. **Check-in**: Klik "Absensi Masuk" untuk mencatat jam dan lokasi kerja
4. **Check-out**: Klik "Absensi Pulang" untuk mencatat jam & laporan harian
5. **Riwayat**: Lihat history absensi di "Riwayat Absensi"
6. **Profile**: Update data profil & foto di halaman "Profil Saya"
7. **Leave Request**: Ajukan izin/sakit/cuti dengan upload bukti

## API Endpoints (Jika Ada)

### Authentication

-   `POST /api/login` - Login user
-   `POST /api/register` - Register user baru
-   `POST /api/logout` - Logout

### Attendance

-   `GET /api/attendances` - Lihat semua absensi (admin)
-   `POST /api/attendances/checkin` - Check-in
-   `POST /api/attendances/checkout` - Check-out
-   `GET /api/attendances/{id}` - Detail absensi

### Leave Requests

-   `GET /api/leave-requests` - Lihat permintaan izin
-   `POST /api/leave-requests` - Buat permintaan izin
-   `PUT /api/leave-requests/{id}/approve` - Approve izin (admin)
-   `PUT /api/leave-requests/{id}/reject` - Reject izin (admin)

## Troubleshooting

### Error: SQLSTATE[HY000] [1045]

**Solusi**: Periksa konfigurasi database di `.env`. Pastikan MySQL berjalan dan kredensial benar.

### Error: Migration table not found

**Solusi**: Jalankan `php artisan migrate` untuk membuat tabel.

### Error: Storage symlink not found

**Solusi**: Jalankan `php artisan storage:link` atau buat junction manual (lihat step 10).

### Foto tidak tampil

**Solusi**: Pastikan symlink storage sudah dibuat dan file ada di `storage/app/public/`.

### Composer error: zip extension missing

**Solusi**: Aktifkan extension `zip` di `php.ini` atau install 7-Zip/unzip.

## Tips Pengembangan

1. **Debugging**: Set `APP_DEBUG=true` di `.env` untuk melihat error detail
2. **Database Reset**: `php artisan migrate:fresh --seed` untuk reset DB & re-seed
3. **Clear Cache**: `php artisan cache:clear` jika ada cache error
4. **Route List**: `php artisan route:list` untuk melihat semua route
5. **Tinker**: `php artisan tinker` untuk interact dengan aplikasi

## Lisensi

Proyek ini menggunakan lisensi MIT. Silakan lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

---
