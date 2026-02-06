<?php include 'header.php'; ?>

<?php
// Handle Emergency Close Logic
if (isset($_POST['toggle_emergency_close'])) {
    $today = date('Y-m-d');
    $action = $_POST['action'];
    
    if ($action == 'close') {
        // Upsert
        $check = mysqli_query($conn, "SELECT id FROM profil WHERE meta_key = 'emergency_close_date'");
        if (mysqli_num_rows($check) > 0) {
            mysqli_query($conn, "UPDATE profil SET meta_value = '$today' WHERE meta_key = 'emergency_close_date'");
        } else {
            mysqli_query($conn, "INSERT INTO profil (meta_key, meta_value) VALUES ('emergency_close_date', '$today')");
        }
        $msg = "Pelayanan berhasil ditutup untuk hari ini. Status akan kembali normal besok.";
    } else {
        // Reset
        mysqli_query($conn, "UPDATE profil SET meta_value = '' WHERE meta_key = 'emergency_close_date'");
        $msg = "Penutupan darurat dibatalkan. Pelayanan kembali buka.";
    }
    
    echo "<script>alert('$msg'); window.location='index.php';</script>";
    exit;
}

// Check Status for Button Display
date_default_timezone_set('Asia/Makassar');
$current_day = date('N');
$current_time = date('H:i');
$today_date = date('Y-m-d');

// Check Scheduled Open (Updated with Friday 11:30 rule)
$is_scheduled_open = false;
if ($current_day >= 1 && $current_day <= 4) { // Mon-Thu
    if (($current_time >= '08:00' && $current_time <= '12:00') || ($current_time >= '13:00' && $current_time <= '16:00')) {
        $is_scheduled_open = true;
    }
} elseif ($current_day == 5) { // Fri
    if (($current_time >= '08:00' && $current_time <= '11:30') || ($current_time >= '13:00' && $current_time <= '16:00')) {
        $is_scheduled_open = true;
    }
}

// Check Emergency Status
$q_em = mysqli_query($conn, "SELECT meta_value FROM profil WHERE meta_key = 'emergency_close_date'");
$d_em = mysqli_fetch_assoc($q_em);
$emergency_date = $d_em['meta_value'] ?? '';
$is_emergency_closed = ($emergency_date == $today_date);
?>

<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1">Status Pelayanan Hari Ini</h5>
                    <p class="text-muted mb-0">
                        <?php 
                        if ($is_emergency_closed) {
                            echo '<span class="badge bg-danger">DITUTUP SEMENTARA</span> - Pelayanan ditutup manual oleh admin.';
                        } elseif ($is_scheduled_open) {
                            echo '<span class="badge bg-success">SEDANG BUKA</span> - Sesuai jadwal operasional.';
                        } else {
                            echo '<span class="badge bg-secondary">TUTUP</span> - Di luar jam operasional.';
                        }
                        ?>
                    </p>
                </div>
                <div>
                    <?php if ($is_emergency_closed): ?>
                        <form method="POST" onsubmit="return confirm('Batalkan penutupan darurat? Pelayanan akan kembali dibuka.');">
                            <input type="hidden" name="action" value="open">
                            <button type="submit" name="toggle_emergency_close" class="btn btn-outline-success">
                                <i class="bi bi-arrow-counterclockwise me-2"></i> Batalkan Penutupan
                            </button>
                        </form>
                    <?php elseif ($is_scheduled_open): ?>
                        <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menutup pelayanan hari ini? Status akan kembali normal besok.');">
                            <input type="hidden" name="action" value="close">
                            <button type="submit" name="toggle_emergency_close" class="btn btn-danger">
                                <i class="bi bi-x-circle me-2"></i> Tutup Pelayanan Hari Ini
                            </button>
                        </form>
                    <?php else: ?>
                        <button class="btn btn-secondary" disabled>
                            <i class="bi bi-clock me-2"></i> Jadwal Tutup
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white h-100 position-relative border-0 overflow-hidden">
            <div class="card-body p-4 position-relative" style="z-index: 1;">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h6 class="text-white-50 text-uppercase fw-bold mb-1">Total Berita</h6>
                        <h2 class="display-4 fw-bold mb-0">
                            <?php
                            $q = mysqli_query($conn, "SELECT COUNT(*) as total FROM berita");
                            $d = mysqli_fetch_assoc($q);
                            echo $d['total'];
                            ?>
                        </h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded p-2">
                        <i class="bi bi-newspaper fs-2"></i>
                    </div>
                </div>
                <a href="berita.php" class="text-white text-decoration-none small d-flex align-items-center">
                    Kelola Berita <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            <!-- Decorative circle -->
            <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle" style="width: 150px; height: 150px; margin-right: -50px; margin-top: -50px;"></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-success text-white h-100 position-relative border-0 overflow-hidden" style="background: linear-gradient(135deg, #198754 0%, #20c997 100%);">
            <div class="card-body p-4 position-relative" style="z-index: 1;">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h6 class="text-white-50 text-uppercase fw-bold mb-1">Total Program</h6>
                        <h2 class="display-4 fw-bold mb-0">
                            <?php
                            $q = mysqli_query($conn, "SELECT COUNT(*) as total FROM program");
                            $d = mysqli_fetch_assoc($q);
                            echo $d['total'];
                            ?>
                        </h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded p-2">
                        <i class="bi bi-list-check fs-2"></i>
                    </div>
                </div>
                <a href="program.php" class="text-white text-decoration-none small d-flex align-items-center">
                    Kelola Program <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            <!-- Decorative circle -->
            <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle" style="width: 150px; height: 150px; margin-right: -50px; margin-top: -50px;"></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-warning text-white h-100 position-relative border-0 overflow-hidden" style="background: linear-gradient(135deg, #ffc107 0%, #ffca2c 100%);">
            <div class="card-body p-4 position-relative" style="z-index: 1;">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h6 class="text-white-50 text-uppercase fw-bold mb-1">Galeri Foto</h6>
                        <h2 class="display-4 fw-bold mb-0">
                            <?php
                            $q = mysqli_query($conn, "SELECT COUNT(*) as total FROM galeri");
                            $d = mysqli_fetch_assoc($q);
                            echo $d['total'];
                            ?>
                        </h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded p-2">
                        <i class="bi bi-images fs-2"></i>
                    </div>
                </div>
                <a href="galeri.php" class="text-white text-decoration-none small d-flex align-items-center">
                    Kelola Galeri <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            <!-- Decorative circle -->
            <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle" style="width: 150px; height: 150px; margin-right: -50px; margin-top: -50px;"></div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body p-4 text-center">
                <div class="mb-3">
                    <div class="bg-primary bg-opacity-10 d-inline-block p-3 rounded-circle text-primary">
                        <i class="bi bi-shield-check fs-1"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-dark">Selamat Datang, Administrator!</h4>
                <p class="text-muted mx-auto" style="max-width: 600px;">
                    Ini adalah panel kontrol utama untuk mengelola konten website BKKBN Kabupaten Muna Barat. 
                    Anda dapat menambah, mengedit, dan menghapus data seperti Berita, Profil, Pejabat, dan Galeri melalui menu di sebelah kiri.
                </p>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="../index.php" target="_blank" class="btn btn-outline-primary rounded-pill px-4">
                        <i class="bi bi-globe me-2"></i> Lihat Website
                    </a>
                    <a href="berita.php" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-plus-lg me-2"></i> Buat Berita Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>