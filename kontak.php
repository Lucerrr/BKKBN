<?php include 'includes/navbar.php'; ?>

<section class="py-5">
    <div class="container">
        <h1 class="text-center mb-5 section-title">Hubungi Kami</h1>

        <div class="row">
            <div class="col-lg-5 mb-4">
                <div class="card h-100 border-0 shadow-sm bg-primary text-white p-4">
                    <h3>Kantor BKKBN Muna Barat</h3>
                    <p class="mt-3">Silakan datang ke kantor kami atau hubungi melalui kontak di bawah ini untuk informasi lebih lanjut.</p>
                    
                    <div class="mt-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-geo-alt-fill fs-4 me-3"></i>
                            <span><?php echo $site_profil['alamat'] ?? 'Guali, Kec. Kusambi, Kabupaten Muna, Sulawesi Tenggara 93653'; ?></span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-telephone-fill fs-4 me-3"></i>
                            <span><?php echo $site_profil['telepon'] ?? '-'; ?></span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-envelope-fill fs-4 me-3"></i>
                            <span><?php echo $site_profil['email'] ?? 'bkkbn@munabarat.go.id'; ?></span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-clock-fill fs-4 me-3"></i>
                            <span>Senin - Jumat, 08:00 - 16:00 WITA</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 mb-4">
                <div class="card h-100 border-0 shadow-sm p-2">
                    <!-- Google Maps Embed -->
                    <div class="ratio ratio-16x9">
                        <iframe src="https://maps.google.com/maps?q=-4.748263,122.541212&hl=id&z=15&output=embed" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>