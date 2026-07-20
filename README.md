# Recap Support Tracker

Recap Support Tracker adalah sistem berbasis web yang dikembangkan menggunakan **Laravel** untuk membantu manajemen pelaporan, rekapitulasi, dan pelacakan tiket *support* antara instansi/koperasi (pelapor) dengan Tim Support. 

## 🌟 Fitur Utama

- **Multi-Role Authentication**: Terdapat pembagian hak akses antara **Tim Support** dan **Pelapor** (Koperasi/Instansi) dengan antarmuka dan *dashboard* yang disesuaikan untuk masing-masing peran.
- **Manajemen Laporan & Rekapitulasi**: Kemudahan dalam membuat, melacak, dan merespons tiket bantuan teknis secara terstruktur.
- **Profil Identitas Digital**: Kartu identitas anggota digital dengan integrasi foto profil, informasi koperasi, nomor anggota, serta verifikasi status.
- **Personalisasi & Pengaturan**: Dukungan tema dinamis (Mode Gelap/Terang), penyesuaian ukuran teks, dan pengaturan multibahasa (Bahasa Indonesia & Inggris).
- **Keamanan Akun**: Pengaturan kata sandi terenkripsi.
- **UI/UX Modern**: Desain antarmuka responsif dengan animasi transisi yang halus, efek *glassmorphism*, dan *skeleton loading state* untuk pengalaman pengguna tingkat tinggi.

## 💻 Tech Stack

- **Framework Backend**: Laravel (PHP)
- **Database**: MySQL
- **Frontend**: Blade Templating Engine, Vanilla CSS, Vanilla JavaScript

## 🚀 Panduan Instalasi (Development)

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

1. **Clone repositori ini:**
   ```bash
   git clone https://github.com/Radithb/Recap-Support-Tracker.git
   cd Recap-Support-Tracker
   ```

2. **Install dependensi PHP dan Node.js:**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment:**
   Salin file `.env.example` menjadi `.env` dan atur konfigurasi database Anda.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi Database:**
   Jalankan migrasi untuk membuat tabel yang dibutuhkan sistem.
   ```bash
   php artisan migrate
   ```

5. **Jalankan Aplikasi:**
   ```bash
   php artisan serve
   ```
   Aplikasi akan berjalan di `http://localhost:8000`.

## 🎨 Cuplikan Antarmuka (Screenshots)
*(Tambahkan gambar screenshot aplikasi di sini nantinya)*

---
*Dibuat untuk mempermudah operasional pengelolaan tiket layanan bantuan.*
