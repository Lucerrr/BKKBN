<?php
// Halaman daftar berita dan kegiatan terbaru.
include 'includes/navbar.php'; 
?>

<section class="py-5">
    <div class="container">
        <h1 class="text-center mb-5 section-title">Berita & Kegiatan</h1>
        
        <div class="row g-4">
            <?php
            $q = mysqli_query($conn, "SELECT * FROM berita ORDER BY tanggal DESC");
            if (mysqli_num_rows($q) > 0) {
                while ($row = mysqli_fetch_assoc($q)):
            ?>
            <div class="col-md-4 mb-4">
                <div class="card card-news h-100 border-0 shadow-sm hover-lift overflow-hidden rounded-4">
                    <div class="position-relative overflow-hidden" style="height: 220px;">
                        <?php 
                        $link = !empty($row['link_sumber']) ? $row['link_sumber'] : 'detail_berita.php?id='.$row['id'];
                        $target = !empty($row['link_sumber']) ? '_blank' : '_self';
                        ?>
                        <a href="<?php echo $link; ?>" target="<?php echo $target; ?>" class="d-block w-100 h-100">
                            <?php if ($row['gambar']): ?>
                                <img src="uploads/<?php echo $row['gambar']; ?>" class="card-img-top w-100 h-100 object-fit-cover transition-transform duration-500" alt="<?php echo $row['judul']; ?>">
                            <?php else: ?>
                                <div class="bg-light text-muted d-flex align-items-center justify-content-center w-100 h-100">
                                    <i class="bi bi-image fs-1"></i>
                                </div>
                            <?php endif; ?>
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-white text-primary shadow-sm fw-bold">
                                    <i class="bi bi-calendar-event me-1"></i> <?php echo date('d M', strtotime($row['tanggal'])); ?>
                                </span>
                            </div>
                        </a>
                    </div>
                    <div class="card-body d-flex flex-column p-4">
                        <div class="mb-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1" style="font-size: 0.7rem;">BERITA</span>
                        </div>
                        <h5 class="card-title mb-3 fw-bold lh-base">
                            <a href="<?php echo $link; ?>" target="<?php echo $target; ?>" class="text-dark text-decoration-none hover-primary stretched-link">
                                <?php echo $row['judul']; ?>
                            </a>
                        </h5>
                        <p class="card-text text-secondary mb-4 small flex-grow-1" style="line-height: 1.6;">
                            <?php echo substr(strip_tags($row['isi']), 0, 100); ?>...
                        </p>
                        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="bi bi-clock me-1"></i> <?php echo date('Y', strtotime($row['tanggal'])); ?></small>
                            <span class="text-primary fw-bold small">Baca <i class="bi bi-arrow-right ms-1"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                endwhile; 
            } else {
                echo '<div class="col-12 text-center py-5"><div class="text-muted"><i class="bi bi-newspaper display-1 text-light mb-3 d-block"></i>Belum ada berita yang diterbitkan.</div></div>';
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>