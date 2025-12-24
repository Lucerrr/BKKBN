<?php include 'header.php'; ?>

<?php
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        $val = mysqli_real_escape_string($conn, $value);
        // Update setiap key
        mysqli_query($conn, "UPDATE profil SET meta_value='$val' WHERE meta_key='$key'");
    }
    
    $message = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> Profil instansi telah diperbarui.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
}

// Ambil semua data profil
$q = mysqli_query($conn, "SELECT * FROM profil");
$profil = [];
while ($row = mysqli_fetch_assoc($q)) {
    $profil[$row['meta_key']] = $row['meta_value'];
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2 mb-0">Profil Instansi</h1>
        <p class="text-muted small">Kelola informasi utama, visi misi, dan kontak instansi.</p>
    </div>
</div>

<?php echo $message; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="row g-4">
        <!-- Left Column: Main Information -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-building me-2"></i>Informasi Utama</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama Instansi</label>
                        <input type="text" name="nama_instansi" class="form-control form-control-lg" value="<?php echo $profil['nama_instansi'] ?? ''; ?>" placeholder="Nama Dinas / Instansi">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Sambutan Kepala Dinas</label>
                        <textarea name="sambutan_kepala" class="form-control" rows="6" placeholder="Tuliskan kata sambutan di sini..."><?php echo $profil['sambutan_kepala'] ?? ''; ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold text-primary">Visi</label>
                            <textarea name="visi" class="form-control" rows="5" placeholder="Visi instansi..."><?php echo $profil['visi'] ?? ''; ?></textarea>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold text-primary">Misi</label>
                            <textarea name="misi" class="form-control" rows="5" placeholder="Misi instansi..."><?php echo $profil['misi'] ?? ''; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Contact & Photo -->
        <div class="col-lg-4">
            <!-- Contact Info -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-geo-alt me-2"></i>Kontak & Alamat</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3"><?php echo $profil['alamat'] ?? ''; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" value="<?php echo $profil['email'] ?? ''; ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Telepon / WhatsApp</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-whatsapp"></i></span>
                            <input type="text" name="telepon" class="form-control" value="<?php echo $profil['telepon'] ?? ''; ?>">
                        </div>
                    </div>
                </div>
            </div>



            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-save me-2"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</form>

<?php include 'footer.php'; ?>