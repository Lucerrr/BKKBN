<?php include 'header.php'; ?>

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