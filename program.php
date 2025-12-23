<?php include 'includes/navbar.php'; ?>

<section class="py-5">
    <div class="container">
        <h1 class="text-center mb-5 section-title">Program Kerja</h1>
        
        <div class="row">
            <?php
            $q = mysqli_query($conn, "SELECT * FROM program ORDER BY id ASC");
            while ($row = mysqli_fetch_assoc($q)):
            ?>
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="bi bi-check-lg fs-3"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-4">
                                <h3 class="card-title text-primary"><?php echo $row['judul']; ?></h3>
                                <p class="card-text mt-2"><?php echo nl2br($row['deskripsi']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>