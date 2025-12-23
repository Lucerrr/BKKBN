CREATE DATABASE IF NOT EXISTS bkkbn_muna_barat;
USE bkkbn_muna_barat;

-- Tabel Users untuk Admin
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Profil (Menyimpan data statis seperti Sambutan, Visi, Misi)
-- Menggunakan struktur key-value agar fleksibel
CREATE TABLE IF NOT EXISTS profil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    meta_key VARCHAR(50) UNIQUE NOT NULL,
    meta_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Program
CREATE TABLE IF NOT EXISTS program (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Berita
CREATE TABLE IF NOT EXISTS berita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    isi TEXT NOT NULL,
    link_sumber VARCHAR(255),
    gambar VARCHAR(255),
    tanggal DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Pejabat / Struktur Organisasi Detail
CREATE TABLE IF NOT EXISTS pejabat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(100) NOT NULL,
    foto VARCHAR(255),
    urutan INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Galeri
CREATE TABLE IF NOT EXISTS galeri (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(100),
    gambar VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert User Admin Default (Password: admin123)
INSERT INTO users (username, password) VALUES ('admin', '$2y$10$aUuOz2T0zSoJA34OwQ1mmOkril5W8KbaVPfMkPdAlILPjBFYN05sG');

-- Insert Data Profil Default
INSERT INTO profil (meta_key, meta_value) VALUES 
('nama_instansi', 'Dinas Pengendalian Penduduk dan Keluarga Berencana (BKKBN) Kabupaten Muna Barat'),
('sambutan_kepala', 'Selamat datang di website resmi BKKBN Kabupaten Muna Barat. Kami berkomitmen untuk mewujudkan keluarga berkualitas.'),
('visi', 'Mewujudkan Keluarga Berkualitas dan Pertumbuhan Penduduk yang Seimbang.'),
('misi', '1. Mengendalikan pertumbuhan penduduk.\n2. Meningkatkan kualitas keluarga.\n3. Menurunkan angka stunting.'),
('struktur_organisasi', 'Kepala Dinas -> Sekretaris -> Bidang KB -> Bidang KS -> Bidang Dalduk'),
('alamat', 'Kompleks Perkantoran Bumi Praja Laworoku, Kabupaten Muna Barat'),
('email', 'bkkbn@munabarat.go.id'),
('telepon', '081234567890');

-- Insert Data Program Default
INSERT INTO program (judul, deskripsi) VALUES 
('Program Keluarga Berencana (KB)', 'Pelayanan kontrasepsi dan edukasi perencanaan keluarga bagi pasangan usia subur.'),
('Penurunan Stunting', 'Program prioritas nasional untuk mencegah dan menangani kasus stunting pada balita.'),
('Pendampingan Keluarga', 'Tim Pendamping Keluarga (TPK) bergerak mendampingi calon pengantin, ibu hamil, dan pasca persalinan.');

-- Insert Berita Contoh
INSERT INTO berita (judul, isi, tanggal) VALUES 
('Penyuluhan KB di Desa Wakoila', 'Kegiatan penyuluhan KB telah dilaksanakan dengan antusiasme tinggi dari masyarakat...', CURDATE()),
('Rapat Koordinasi Penurunan Stunting', 'BKKBN Muna Barat menggelar rapat koordinasi teknis percepatan penurunan stunting...', CURDATE());
