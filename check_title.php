<?php
require_once 'config/database.php';

$query = "SELECT meta_value FROM profil WHERE meta_key = 'nama_instansi'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo "Current nama_instansi: " . $row['meta_value'];
} else {
    echo "nama_instansi not found in database";
}
?>