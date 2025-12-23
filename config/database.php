<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "bkkbn_muna_barat";

$conn = @mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    // Jika error karena database tidak ditemukan
    if (mysqli_connect_errno() == 1049) {
        die("Database belum dibuat. Silakan jalankan <a href='../install.php'>install.php</a> atau <a href='install.php'>install.php</a> terlebih dahulu.");
    }
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>