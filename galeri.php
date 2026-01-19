<?php include 'includes/navbar.php'; ?>

<section class="py-5 bg-white">
    <div class="container py-4">
        <!-- Header -->
        <div class="text-center mb-5">
            <h2 class="section-title">Galeri Kegiatan</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">Dokumentasi kegiatan dan program kerja yang telah dilaksanakan.</p>
        </div>

        <!-- Gallery Grid -->
        <div class="row g-4">
            <?php
            // Pastikan koneksi database tersedia
            if (isset($conn)) {
                $q = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
                
                if ($q) {
                    if (mysqli_num_rows($q) > 0) {
                        while ($row = mysqli_fetch_assoc($q)) {
            ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm overflow-hidden hover-zoom">
                    <div class="position-relative" style="height: 250px;">
                        <a href="uploads/<?php echo htmlspecialchars($row['gambar']); ?>" target="_blank">
                            <img src="uploads/<?php echo htmlspecialchars($row['gambar']); ?>" class="card-img-top w-100 h-100 object-fit-cover" alt="<?php echo htmlspecialchars($row['judul']); ?>">
                            <div class="overlay-hover d-flex align-items-center justify-content-center">
                                <i class="bi bi-zoom-in text-white fs-2"></i>
                            </div>
                        </a>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title fs-6 mb-0 fw-bold"><?php echo htmlspecialchars($row['judul']); ?></h5>
                    </div>
                </div>
            </div>
            <?php 
                        }
                    } else {
                        echo '<div class="col-12 text-center py-5"><div class="text-muted fs-5">Belum ada data galeri.</div></div>';
                    }
                } else {
                    echo '<div class="col-12 text-center py-5"><div class="text-danger">Error: Gagal mengambil data galeri.</div></div>';
                }
            } else {
                echo '<div class="col-12 text-center py-5"><div class="text-danger">Koneksi database tidak tersedia.</div></div>';
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>