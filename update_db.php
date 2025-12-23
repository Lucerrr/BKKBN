<?php
require_once 'config/database.php';

// 1. Tambah kolom link_sumber ke tabel berita jika belum ada
$check_col = mysqli_query($conn, "SHOW COLUMNS FROM berita LIKE 'link_sumber'");
if (mysqli_num_rows($check_col) == 0) {
    mysqli_query($conn, "ALTER TABLE berita ADD COLUMN link_sumber VARCHAR(255) AFTER isi");
    echo "Kolom link_sumber berhasil ditambahkan ke tabel berita.<br>";
}

// 2. Buat tabel pejabat
$sql_pejabat = "CREATE TABLE IF NOT EXISTS pejabat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(100) NOT NULL,
    foto VARCHAR(255),
    urutan INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql_pejabat)) {
    echo "Tabel pejabat berhasil dibuat/diperiksa.<br>";
} else {
    echo "Gagal membuat tabel pejabat: " . mysqli_error($conn) . "<br>";
}

echo "Database update selesai. Silakan hapus file ini jika sudah tidak diperlukan.";
?>