<?php
require_once 'config/database.php';

$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);

$username = 'admin';

// Cek apakah user admin sudah ada
$check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
if (mysqli_num_rows($check) > 0) {
    // Update password
    $sql = "UPDATE users SET password = '$hash' WHERE username = '$username'";
    if (mysqli_query($conn, $sql)) {
        echo "<h1>Password Berhasil Direset!</h1>";
        echo "<p>Username: <b>admin</b></p>";
        echo "<p>Password: <b>admin123</b></p>";
        echo "<p>Silakan <a href='admin/login.php'>Login di sini</a></p>";
    } else {
        echo "Gagal update password: " . mysqli_error($conn);
    }
} else {
    // Insert user baru jika belum ada
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hash')";
    if (mysqli_query($conn, $sql)) {
        echo "<h1>User Admin Berhasil Dibuat!</h1>";
        echo "<p>Username: <b>admin</b></p>";
        echo "<p>Password: <b>admin123</b></p>";
        echo "<p>Silakan <a href='admin/login.php'>Login di sini</a></p>";
    } else {
        echo "Gagal membuat user: " . mysqli_error($conn);
    }
}
?>