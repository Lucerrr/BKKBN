<?php
require_once 'config/database.php';
 = 'CREATE TABLE IF NOT EXISTS poster_edukasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(100),
    gambar VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)';
if (mysqli_query(, )) { echo 'Table poster_edukasi created successfully'; }
else { echo 'Error creating table: ' . mysqli_error(); }
?>
