# Website Profil Dinas Pengendalian Penduduk dan Keluarga Berencana (BKKBN) Muna Barat

Sistem Informasi Profil Web ini dikembangkan untuk Dinas Pengendalian Penduduk dan Keluarga Berencana Kabupaten Muna Barat. Website ini berfungsi sebagai sarana informasi publik, publikasi kegiatan, dan layanan masyarakat yang dikelola melalui panel admin terintegrasi.

## 🌟 Fitur Utama

### 🖥️ Halaman Publik (Front-End)
- **Beranda (Home)**: Menampilkan slide banner, sambutan kepala dinas, berita terbaru, dan data statistik kependudukan real-time.
- **Profil Instansi**: Visi & Misi, Struktur Organisasi (interaktif), dan Sejarah.
- **Berita & Artikel**: Daftar berita terkini dengan fitur pencarian dan detail berita.
- **Galeri & Publikasi**: Dokumentasi kegiatan dan poster edukasi (Edukasi KIE).
- **Layanan**: Informasi layanan publik yang tersedia di setiap kecamatan.
- **Kontak**: Informasi alamat, peta lokasi, dan kontak resmi.
- **Mode Gelap/Terang (Dark/Light Mode)**: Fitur aksesibilitas untuk kenyamanan pengguna.

### 🔐 Panel Admin (Back-End)
- **Dashboard**: Ringkasan statistik konten website.
- **Manajemen Berita**: Tambah, edit, dan hapus berita/artikel.
- **Manajemen Galeri & Poster**: Upload foto kegiatan dan materi edukasi.
- **Manajemen Pegawai**: Pengelolaan data struktur organisasi dan pegawai.
- **Manajemen Profil**: Pengaturan visi misi, sambutan, dan informasi kontak instansi.
- **Manajemen Program Kerja**: Update informasi program dinas.
- **Keamanan**: Autentikasi login admin yang aman.

## 🛠️ Teknologi yang Digunakan

- **Bahasa Pemrograman**: PHP (Native)
- **Database**: MySQL
- **Frontend Framework**: Bootstrap 5.3
- **Styling**: CSS3 (Custom Variables, Responsive Design, Dark Mode Support)
- **Icons**: Bootstrap Icons
- **Server**: Apache (via XAMPP)

## 📂 Struktur Folder

```
BKKBN-Mubar/
├── admin/          # Halaman dan logika panel admin
├── assets/         # File statis (CSS, JS, Images)
├── config/         # Konfigurasi koneksi database
├── includes/       # Komponen reusable (Navbar, Footer)
├── uploads/        # Folder penyimpanan file upload (Gambar berita, galeri, dll)
├── database.sql    # File dump database
└── index.php       # Halaman utama website
```

## 🚀 Cara Instalasi

1.  **Persiapan Lingkungan**:
    -   Pastikan Anda telah menginstal **XAMPP** atau web server sejenis yang mendukung PHP dan MySQL.

2.  **Clone Repository**:
    ```bash
    git clone https://github.com/Lucerrr/BKKBN.git
    ```
    Atau unduh ZIP dan ekstrak di folder `htdocs` (misal: `C:\xampp\htdocs\BKKBN-Mubar`).

3.  **Konfigurasi Database**:
    -   Buka **phpMyAdmin** (biasanya di `http://localhost/phpmyadmin`).
    -   Buat database baru dengan nama `bkkbn_muna_barat`.
    -   Impor file `database.sql` yang ada di root folder proyek ke dalam database tersebut.

4.  **Konfigurasi Koneksi (Opsional)**:
    -   Jika Anda menggunakan password root MySQL atau port yang berbeda, sesuaikan file `config/database.php`:
    ```php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db   = 'bkkbn_muna_barat';
    ```

5.  **Jalankan Aplikasi**:
    -   Buka browser dan akses: `http://localhost/BKKBN-Mubar`
    -   Untuk akses admin, buka: `http://localhost/BKKBN-Mubar/admin`

## 👤 Akun Admin Default

*(Sesuaikan dengan data di database Anda)*
- **Username**: `admin`
- **Password**: `admin123` (Disarankan untuk segera diganti setelah login)

## 📄 Lisensi

Proyek ini dibuat untuk keperluan Dinas Pengendalian Penduduk dan Keluarga Berencana Kabupaten Muna Barat.
