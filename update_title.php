<?php
require_once 'config/database.php';

$key = 'nama_instansi';
$value = "BKKBN Mubar";

// Check if key exists
$check = mysqli_query($conn, "SELECT * FROM profil WHERE meta_key = '$key'");
if (mysqli_num_rows($check) > 0) {
    $sql = "UPDATE profil SET meta_value = '$value' WHERE meta_key = '$key'";
} else {
    $sql = "INSERT INTO profil (meta_key, meta_value) VALUES ('$key', '$value')";
}

if (mysqli_query($conn, $sql)) {
    echo "Successfully updated nama_instansi to: " . $value;
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
?>