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
                <div class="card card-news h-100">
                    <?php if ($row['gambar']): ?>
                        <img src="uploads/<?php echo $row['gambar']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?php echo $row['judul']; ?>">
                    <?php else: ?>
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">No Image</div>
                    <?php endif; ?>
                    <div class="card-body">
                        <small class="text-muted"><i class="bi bi-calendar-event"></i> <?php echo date('d M Y', strtotime($row['tanggal'])); ?></small>
                        <h5 class="card-title mt-2"><?php echo $row['judul']; ?></h5>
                        <p class="card-text"><?php echo substr(strip_tags($row['isi']), 0, 100); ?>...</p>
                        <?php if (!empty($row['link_sumber'])): ?>
                            <a href="<?php echo $row['link_sumber']; ?>" target="_blank" class="btn btn-primary w-100">Baca Selengkapnya <i class="bi bi-box-arrow-up-right"></i></a>
                        <?php else: ?>
                            <a href="detail_berita.php?id=<?php echo $row['id']; ?>" class="btn btn-primary w-100">Baca Selengkapnya</a>
                        <?php endif; ?>
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