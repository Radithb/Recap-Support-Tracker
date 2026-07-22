# Recap Support Tracker

<div align="center">

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)
[![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![JavaScript](https://img.shields.io/badge/JavaScript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

Sistem manajemen tiket support terpadu untuk instansi/koperasi dengan antarmuka modern dan responsif.

[Demo](#) • [Dokumentasi](#-dokumentasi) • [Instalasi](#-panduan-instalasi) • [Preview](#-preview) 

</div>

---

## Tentang Proyek

**Recap Support Tracker** adalah aplikasi web berbasis Laravel yang dirancang untuk memudahkan pengelolaan tiket support, pelaporan, dan rekapitulasi antar instansi atau koperasi. Sistem ini menyediakan solusi terpadu untuk manajemen tiket support dengan antarmuka yang intuitif dan responsif.

## <img src="public/icons/star-white.png" width="24" height="24" valign="middle"> Fitur Utama

### <img src="public/icons/padlock-white.png" width="22" height="22" valign="middle"> Multi-Role Authentication
- Sistem pembagian hak akses untuk **Tim Support** dan **Pelapor** (Koperasi/Instansi)
- Dashboard yang disesuaikan untuk masing-masing peran
- Manajemen akses berbasis role yang fleksibel

### <img src="public/icons/data-white.png" width="22" height="22" valign="middle"> Manajemen Laporan & Rekapitulasi
- Pembuatan dan pelacakan tiket bantuan yang terstruktur
- Sistem rekapitulasi otomatis untuk pelaporan berkala
- Respon dan penyelesaian tiket dengan status tracking real-time
- Export laporan dalam berbagai format

### <img src="public/icons/company-white.png" width="22" height="22" valign="middle"> Profil Identitas Digital
- Kartu identitas anggota digital terintegrasi
- Manajemen foto profil dan data pribadi
- Informasi koperasi dan nomor anggota
- Sistem verifikasi status anggota

### <img src="public/icons/setting-white.png" width="22" height="22" valign="middle"> Personalisasi & Pengaturan
- **Tema Dinamis**: Mode Gelap & Mode Terang
- **Aksesibilitas**: Penyesuaian ukuran teks untuk kenyamanan membaca
- **Multibahasa**: Dukungan Bahasa Indonesia & Inggris
- Preferensi pengguna yang tersimpan otomatis

### <img src="public/icons/padlock-white.png" width="22" height="22" valign="middle"> Keamanan Akun
- Enkripsi password tingkat enterprise
- Validasi input untuk mencegah SQL Injection
- CSRF protection
- Session management yang aman

### <img src="public/icons/application-white.png" width="22" height="22" valign="middle"> UI/UX Modern
- Desain antarmuka yang **responsif** dan mobile-friendly
- Animasi transisi halus untuk pengalaman pengguna yang mulus
- Efek **glassmorphism** yang modern
- **Skeleton loading state** untuk feedback pengguna
- Desain yang intuitif dan user-friendly

## <img src="public/icons/monitor-white.png" width="20" height="20" valign="middle"> Tech Stack

| Layer | Teknologi |
|-------|-----------|
| **Backend** | Laravel (PHP) |
| **Database** | MySQL 8.0+ |
| **Frontend** | Blade Templating, Vanilla CSS, Vanilla JavaScript |
| **Package Manager** | Composer, NPM |

## <img src="public/icons/cpu-white.png" width="24" height="24" valign="middle"> Persyaratan Sistem

Sebelum memulai, pastikan Anda memiliki:

- **PHP** >= 8.0
- **Composer** >= 2.0
- **Node.js** >= 14.0 & **npm** >= 6.0
- **MySQL** >= 8.0
- **Git**

## <img src="public/icons/camera-white.png" width="24" height="24" valign="middle"> Preview

<div align="center">

---

### <img src="public/icons/avatar-white.png" width="24" height="24" valign="middle"> Tampilan Peran: Tim Support

*Antarmuka yang dirancang khusus untuk petugas support dalam mengelola, merespons, dan menindaklanjuti setiap tiket bantuan.*

<br>

#### <img src="public/icons/monitor-white.png" width="20" height="20" valign="middle"> Dashboard Utama Support
![Dashboard Support](https://github.com/user-attachments/assets/832a83e3-8516-4ea7-93bc-e35ce884e5da)
*Pemantauan statistik tiket, grafik distribusi status (Open, Proses, Pending, Done), serta daftar tiket aktif secara real-time.*

<br>

#### <img src="public/icons/fast-response-white.png" width="22" height="22" valign="middle"> Modal Update Tiket & Respons
![Update Tiket](https://github.com/user-attachments/assets/d3a4805b-ae18-44e7-a555-99ee79c3016c)
*Form modal interaktif untuk memperbarui status tiket, menambahkan jawaban/respons tim support, serta mengelola lampiran berkas.*

<br>

#### <img src="public/icons/folder-white.png" width="22" height="22" valign="middle"> Manajemen Master Data
![Master Data](https://github.com/user-attachments/assets/f18c08cf-35ad-4395-b466-3b5e7a415c61) 
*Halaman kelola data master aplikasi, kategori kendala, daftar instansi/koperasi, serta hak akses PIC support secara terpusat.*

<br>

---

### <img src="public/icons/group-white.png" width="24" height="24" valign="middle"> Tampilan Peran: Pelapor (Koperasi / Instansi)

*Antarmuka intuitif bagi pelapor untuk mengajukan laporan kendala baru dan memantau status tindak lanjutnya.*

<br>

#### <img src="public/icons/monitor-white.png" width="20" height="20" valign="middle"> Dashboard Pelapor
![Dashboard Pelapor](https://github.com/user-attachments/assets/9973bf08-2b9c-4646-92de-f61b36d8583d)
*Ringkasan statistik laporan pengguna, status penanganan terkini, serta tabel riwayat seluruh tiket kendala.*

<br>

#### <img src="public/icons/contract-white.png" width="20" height="20" valign="middle"> Form Buat Laporan Baru
![Buat Laporan Baru](https://github.com/user-attachments/assets/b52528d0-9d13-4055-846d-111a281ac15f) 
*Form pengajuan tiket kendala baru yang praktis dengan pemilihan jenis aplikasi, kategori masalah, uraian detail, dan upload foto lampiran.*

<br>

#### <img src="public/icons/file-baru.png" width="20" height="20" valign="middle"> Detail & Status Laporan
![Detail Laporan](https://github.com/user-attachments/assets/b4d0b46b-ee36-4013-9c2b-614f2e2a4d85)
*Tampilan rincian informasi tiket, kronologi progress penanganan dari petugas support, dan jawaban solusi akhir.*

</div>

## <img src="public/icons/download-white.png" width="24" height="24" valign="middle"> Panduan Instalasi

### 1️. Clone Repositori

```bash
git clone https://github.com/Radithb/Recap-Support-Tracker.git
cd Recap-Support-Tracker
```

### 2️. Install Dependensi

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3️. Konfigurasi Environment

```bash
# Salin file konfigurasi
cp .env.example .env

# Generate application key
php artisan key:generate
```

Kemudian edit file `.env` dan sesuaikan konfigurasi berikut:

```env
APP_NAME="Recap Support Tracker"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=recap_support_tracker
DB_USERNAME=root
DB_PASSWORD=
```

### 4️. Migrasi Database

```bash
# Jalankan migrasi
php artisan migrate

# (Opsional) Seed data dummy untuk testing
php artisan db:seed
```

### 5️. Jalankan Aplikasi

```bash
# Development server
php artisan serve

# Atau dengan port custom
php artisan serve --port=8001
```

Aplikasi akan dapat diakses di `http://localhost:8000`

### 6️. Compile Assets (Opsional)

```bash
# Development build
npm run dev

# Production build
npm run build
```

## <img src="public/icons/wrench-white.png" width="24" height="24" valign="middle"> Konfigurasi Lanjutan

### Setup Database

```bash
# Buat database baru (jika belum ada)
mysql -u root -p -e "CREATE DATABASE recap_support_tracker;"

# Jalankan migrasi dengan seed
php artisan migrate:fresh --seed
```

### Konfigurasi Mail (Opsional)

Edit file `.env`:

```env
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=noreply@example.com
```

## <img src="public/icons/folder-white.png" width="24" height="24" valign="middle"> Dokumentasi

### Struktur Direktori

```
Recap-Support-Tracker/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Requests/
│   ├── Models/
│   └── ...
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
│   └── web.php
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── storage/
├── .env.example
├── composer.json
├── package.json
└── README.md
```

### Fitur Utama

- **Role Management**: Admin, Support Team, Pelapor
- **Ticket System**: Create, Read, Update, Delete tickets
- **Reporting**: Generate laporan terperinci
- **User Profile**: Manajemen profil dan identitas digital
- **Settings**: Personalisasi theme, language, dan preferences

## <img src="public/icons/working-white.png" width="24" height="24" valign="middle"> Penggunaan

### Login ke Sistem

1. Buka aplikasi di `http://localhost:8000`
2. Gunakan kredensial default (jika ada di seeder)
3. Pilih role: Support Team atau Pelapor

### Membuat Ticket Support

1. Login sebagai Pelapor
2. Navigasi ke "Buat Laporan"
3. Isi detail masalah/permintaan
4. Submit dan tunggu respon dari Support Team

### Tracking Status Ticket

1. Login dan buka "Dashboard"
2. Lihat status semua ticket pada "Riwayat Laporan"
3. Pantau progres secara real-time


## <img src="public/icons/contract-white.png" width="24" height="24" valign="middle"> Commit Message Guidelines

Gunakan format conventional commits:

```
feat: Add new feature
fix: Fix bug
docs: Update documentation
style: Format code
refactor: Refactor code
test: Add tests
```

## <img src="public/icons/bug-white.png" width="24" height="24" valign="middle"> Lapor Bug

Jika Anda menemukan bug, silakan buat [Issue](https://github.com/Radithb/Recap-Support-Tracker/issues) dengan detail:

- Deskripsi bug
- Langkah-langkah reproduksi
- Expected behavior
- Actual behavior
- Screenshot (jika relevan)

## <img src="public/icons/file-baru.png" width="24" height="24" valign="middle"> Lisensi

Proyek ini dilisensikan di bawah lisensi MIT - lihat file [LICENSE](LICENSE) untuk detail.

## <img src="public/icons/group-white.png" width="24" height="24" valign="middle"> Kontak & Support

- **Email**: [mradithn@gmail.com]
- **GitHub Issues**: [Report an Issue](https://github.com/Radithb/Recap-Support-Tracker/issues)
- **Discussions**: [Join Discussion](https://github.com/Radithb/Recap-Support-Tracker/discussions)

---

<div align="center">

**[⬆ kembali ke atas](#-recap-support-tracker)**

Dibuat dengan ❤️ untuk mempermudah operasional pengelolaan tiket layanan bantuan.

</div>
