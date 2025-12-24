<?php include 'includes/navbar.php'; ?>

<section class="py-5">
    <div class="container">
        <h1 class="text-center mb-5 section-title">Berita & Kegiatan</h1>
        
        <div class="row">
            <?php
            $q = mysqli_query($conn, "SELECT * FROM berita ORDER BY tanggal DESC");
            if (mysqli_num_rows($q) > 0) {
                while ($row = mysqli_fetch_assoc($q)):
            ?>
            <div class="col-md-4 mb-4">
                <div class="card card-news h-100 border-0 shadow-sm hover-lift">
                    <div class="position-relative overflow-hidden" style="height: 200px;">
                        <?php 
                        $link = !empty($row['link_sumber']) ? $row['link_sumber'] : 'detail_berita.php?id='.$row['id'];
                        $target = !empty($row['link_sumber']) ? '_blank' : '_self';
                        ?>
                        <a href="<?php echo $link; ?>" target="<?php echo $target; ?>">
                            <?php if ($row['gambar']): ?>
                                <img src="uploads/<?php echo $row['gambar']; ?>" class="card-img-top w-100 h-100 object-fit-cover transition-transform" alt="<?php echo $row['judul']; ?>">
                            <?php else: ?>
                                <div class="bg-light text-muted d-flex align-items-center justify-content-center w-100 h-100">
                                    <i class="bi bi-image fs-1"></i>
                                </div>
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="card-body d-flex flex-column p-4">
                        <small class="text-muted mb-2 d-block"><i class="bi bi-calendar-event me-1"></i> <?php echo date('d M Y', strtotime($row['tanggal'])); ?></small>
                        <h5 class="card-title mb-3">
                            <a href="<?php echo $link; ?>" target="<?php echo $target; ?>" class="text-dark text-decoration-none hover-primary">
                                <?php echo $row['judul']; ?>
                            </a>
                        </h5>
                        <p class="card-text text-muted mb-4"><?php echo substr(strip_tags($row['isi']), 0, 100); ?>...</p>
                        <div class="mt-auto">
                            <a href="<?php echo $link; ?>" target="<?php echo $target; ?>" class="btn btn-primary w-100 rounded-pill">
                                Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                endwhile; 
            } else {
                echo '<div class="col-12 text-center">Belum ada berita.</div>';
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>