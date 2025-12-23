<?php include 'header.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle File Upload
    if (isset($_FILES['foto_kepala']) && $_FILES['foto_kepala']['error'] == 0) {
        $ext = pathinfo($_FILES['foto_kepala']['name'], PATHINFO_EXTENSION);
        $filename = 'kepala_dinas_' . time() . '.' . $ext;
        if (move_uploaded_file($_FILES['foto_kepala']['tmp_name'], "../uploads/" . $filename)) {
            // Hapus foto lama jika ada (opsional, tapi disarankan)
            $q_old = mysqli_query($conn, "SELECT meta_value FROM profil WHERE meta_key='foto_kepala'");
            $d_old = mysqli_fetch_assoc($q_old);
            if ($d_old && !empty($d_old['meta_value']) && file_exists("../uploads/" . $d_old['meta_value'])) {
                unlink("../uploads/" . $d_old['meta_value']);
            }
            
            // Update DB
            mysqli_query($conn, "UPDATE profil SET meta_value='$filename' WHERE meta_key='foto_kepala'");
        }
    }

    foreach ($_POST as $key => $value) {
        $val = mysqli_real_escape_string($conn, $value);
        // Update setiap key
        mysqli_query($conn, "UPDATE profil SET meta_value='$val' WHERE meta_key='$key'");
    }
    echo "<script>alert('Profil berhasil diperbarui'); window.location='profil.php';</script>";
}

// Ambil semua data profil
$q = mysqli_query($conn, "SELECT * FROM profil");
$profil = [];
while ($row = mysqli_fetch_assoc($q)) {
    $profil[$row['meta_key']] = $row['meta_value'];
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Profil Instansi</h1>
</div>

<form method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="form-label fw-bold">Nama Instansi</label>
            <input type="text" name="nama_instansi" class="form-control" value="<?php echo $profil['nama_instansi'] ?? ''; ?>">
        </div>
        
        <div class="col-md-12 mb-3">
            <label class="form-label fw-bold">Sambutan Kepala BKKBN</label>
            <textarea name="sambutan_kepala" class="form-control" rows="5"><?php echo $profil['sambutan_kepala'] ?? ''; ?></textarea>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Visi</label>
            <textarea name="visi" class="form-control" rows="4"><?php echo $profil['visi'] ?? ''; ?></textarea>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Misi</label>
            <textarea name="misi" class="form-control" rows="4"><?php echo $profil['misi'] ?? ''; ?></textarea>
        </div>

        <div class="col-md-12 mb-3">
            <hr>
            <h5>Informasi Kontak</h5>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">Alamat</label>
            <input type="text" name="alamat" class="form-control" value="<?php echo $profil['alamat'] ?? ''; ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $profil['email'] ?? ''; ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">No. Telepon / WA</label>
            <input type="text" name="telepon" class="form-control" value="<?php echo $profil['telepon'] ?? ''; ?>">
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-lg">Simpan Perubahan</button>
</form>

<?php include 'footer.php'; ?>