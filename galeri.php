<?php include 'includes/navbar.php'; ?>

<section class="py-5">
    <div class="container">
        <h1 class="text-center mb-5 section-title">Galeri</h1>
        
        <div class="row">
            <?php
            $q = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
            if (mysqli_num_rows($q) > 0) {
                while ($row = mysqli_fetch_assoc($q)):
            ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <!-- Mengubah object-fit menjadi contain agar gambar utuh -->
                    <div class="bg-light d-flex align-items-center justify-content-center overflow-hidden" style="height: 250px;">
                        <img src="uploads/<?php echo $row['gambar']; ?>" class="w-100 h-100" style="object-fit: contain;" alt="<?php echo $row['judul']; ?>">
                    </div>
                    <div class="card-body">
                        <p class="card-text text-center fw-bold"><?php echo $row['judul']; ?></p>
                    </div>
                </div>
            </div>
            <?php 
                endwhile; 
            } else {
                echo '<div class="col-12 text-center">Belum ada foto galeri.</div>';
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>