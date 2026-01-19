<?php
// Halaman informasi program kerja instansi.
include 'includes/navbar.php'; 
?>

<section class="py-5 bg-light">
    <div class="container">
        <h1 class="text-center mb-5 section-title">Program Kerja</h1>
        
        <!-- Quote Section -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-lg-5 position-relative bg-white">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-4 d-none d-md-block">
                                <i class="bi bi-quote fs-1 text-primary opacity-50"></i>
                            </div>
                            <div>
                                <p class="lead text-secondary mb-0" style="line-height: 1.8;">
                                    "Program kerja BKKBN Kabupaten Muna Barat merupakan bagian dari pelaksanaan <span class="fw-bold text-primary">Program Bangga Kencana</span> yang bertujuan untuk mengendalikan pertumbuhan penduduk serta meningkatkan kualitas dan ketahanan keluarga melalui berbagai kegiatan pelayanan, pembinaan, dan pendampingan kepada masyarakat."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Program List -->
        <div class="row g-4">
            <?php
            if (isset($conn)) {
                $q = mysqli_query($conn, "SELECT * FROM program ORDER BY id ASC");
                if ($q) {
                    while ($row = mysqli_fetch_assoc($q)):
            ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition-all rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="bi bi-journal-check fs-3"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title fw-bold text-dark mb-3"><?php echo htmlspecialchars($row['judul']); ?></h5>
                                <p class="card-text text-muted mb-0" style="text-align: justify;">
                                    <?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                    endwhile;
                } else {
                    echo '<div class="col-12 text-center text-danger">Gagal memuat program kerja.</div>';
                }
            } else {
                echo '<div class="col-12 text-center text-danger">Koneksi database bermasalah.</div>';
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>