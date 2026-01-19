<?php
require_once 'config/database.php';

$sambutan = "Selamat datang di website resmi Dinas Pengendalian Penduduk dan Keluarga Berencana/BKKBN Muna Barat. Website ini kami hadirkan sebagai sarana informasi dan komunikasi kepada masyarakat dalam mendukung terwujudnya keluarga berkualitas, sehat, dan sejahtera melalui program Bangga Kencana.";
$sambutan = mysqli_real_escape_string($conn, $sambutan);

// Cek apakah key sudah ada
$check = mysqli_query($conn, "SELECT * FROM profil WHERE meta_key = 'sambutan_kepala'");
if (mysqli_num_rows($check) > 0) {
    $sql = "UPDATE profil SET meta_value = '$sambutan' WHERE meta_key = 'sambutan_kepala'";
} else {
    $sql = "INSERT INTO profil (meta_key, meta_value) VALUES ('sambutan_kepala', '$sambutan')";
}

if (mysqli_query($conn, $sql)) {
    echo "Berhasil update sambutan.";
} else {
    echo "Gagal: " . mysqli_error($conn);
}
?>