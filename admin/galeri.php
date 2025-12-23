<?php include 'header.php'; ?>

<?php
// Handle Hapus
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $q_img = mysqli_query($conn, "SELECT gambar FROM galeri WHERE id='$id'");
    $img = mysqli_fetch_assoc($q_img);
    if ($img['gambar'] && file_exists("../uploads/".$img['gambar'])) {
        unlink("../uploads/".$img['gambar']);
    }
    mysqli_query($conn, "DELETE FROM galeri WHERE id='$id'");
    echo "<script>alert('Foto dihapus'); window.location='galeri.php';</script>";
}

// Handle Upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $new_name = 'galeri_' . time() . '.' . $ext;
        if(move_uploaded_file($_FILES['gambar']['tmp_name'], "../uploads/" . $new_name)) {
            $sql = "INSERT INTO galeri (judul, gambar) VALUES ('$judul', '$new_name')";
            mysqli_query($conn, $sql);
            echo "<script>alert('Foto berhasil diupload'); window.location='galeri.php';</script>";
        } else {
            echo "<script>alert('Gagal upload file');</script>";
        }
    }
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Galeri</h1>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Upload Foto Baru</div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Judul/Caption</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File Foto</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php
    $q = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
    while ($row = mysqli_fetch_assoc($q)):
    ?>
    <div class="col-md-3 mb-4">
        <div class="card h-100">
            <img src="../uploads/<?php echo $row['gambar']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?php echo $row['judul']; ?>">
            <div class="card-body">
                <p class="card-text"><?php echo $row['judul']; ?></p>
                <a href="?hapus=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger w-100" onclick="return confirm('Hapus foto ini?');">Hapus</a>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<?php include 'footer.php'; ?>