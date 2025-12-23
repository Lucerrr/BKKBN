<?php
// Visitor Counter Logic
$ip_address = $_SERVER['REMOTE_ADDR'];
$date = date('Y-m-d');

// Cek apakah IP ini sudah berkunjung hari ini
$check_visit = mysqli_query($conn, "SELECT * FROM visitor_stats WHERE ip_address = '$ip_address' AND access_date = '$date'");
if (mysqli_num_rows($check_visit) == 0) {
    // Jika belum, insert data baru
    mysqli_query($conn, "INSERT INTO visitor_stats (ip_address, access_date) VALUES ('$ip_address', '$date')");
}

// Hitung statistik
$q_today = mysqli_query($conn, "SELECT COUNT(*) as count FROM visitor_stats WHERE access_date = '$date'");
$d_today = mysqli_fetch_assoc($q_today);
$today_visitors = $d_today['count'];

$q_week = mysqli_query($conn, "SELECT COUNT(*) as count FROM visitor_stats WHERE YEARWEEK(access_date, 1) = YEARWEEK('$date', 1)");
$d_week = mysqli_fetch_assoc($q_week);
$week_visitors = $d_week['count'];

$q_month = mysqli_query($conn, "SELECT COUNT(*) as count FROM visitor_stats WHERE MONTH(access_date) = MONTH('$date') AND YEAR(access_date) = YEAR('$date')");
$d_month = mysqli_fetch_assoc($q_month);
$month_visitors = $d_month['count'];

$q_total = mysqli_query($conn, "SELECT COUNT(*) as count FROM visitor_stats");
$d_total = mysqli_fetch_assoc($q_total);
$total_visitors = $d_total['count'];
?>
<footer class="footer mt-auto">
    <div class="container">
        <div class="row gy-4 mb-5">
            <div class="col-lg-5 col-md-12 mb-4 mb-lg-0">
                <h5 class="text-white mb-4">Badan Kependudukan dan Keluarga Berencana Nasional Muna Barat</h5>
                <p class="mb-4 text-muted" style="max-width: 400px;">
                    Berkomitmen untuk mewujudkan keluarga berkualitas dan pertumbuhan penduduk yang seimbang demi masa depan yang lebih baik.
                </p>
                <div class="social-links mt-4">
                    <a href="#" title="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" title="Twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" title="Youtube"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5 class="text-white mb-4">Tautan Cepat</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php"><i class="bi bi-chevron-right me-2 small"></i>Beranda</a></li>
                    <li><a href="profil.php"><i class="bi bi-chevron-right me-2 small"></i>Profil Instansi</a></li>
                    <li><a href="program.php"><i class="bi bi-chevron-right me-2 small"></i>Program Kerja</a></li>
                    <li><a href="berita.php"><i class="bi bi-chevron-right me-2 small"></i>Berita & Kegiatan</a></li>
                    <li><a href="layanan.php"><i class="bi bi-chevron-right me-2 small"></i>Layanan Publik</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6">
                <h5 class="text-white mb-4">Hubungi Kami</h5>
                <ul class="list-unstyled">
                    <li class="d-flex mb-3">
                        <i class="bi bi-geo-alt me-3 text-secondary mt-1"></i>
                        <span><?php echo $site_profil['alamat'] ?? 'Guali, Kec. Kusambi, Kabupaten Muna, Sulawesi Tenggara 93653'; ?></span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="bi bi-telephone me-3 text-secondary mt-1"></i>
                        <span><?php echo $site_profil['telepon'] ?? '(0403) XXXXXXX'; ?></span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="bi bi-envelope me-3 text-secondary mt-1"></i>
                        <span><?php echo $site_profil['email'] ?? 'bkkbn@munabarat.go.id'; ?></span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="bi bi-clock me-3 text-secondary mt-1"></i>
                        <span>
                            Senin - Kamis: 08:00 - 16:00 WITA<br>
                            Jumat: 08:00 - 16:30 WITA
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Statistik Pengunjung Bar -->
        <div class="row mb-4 justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="bg-white text-dark rounded-3 p-3 d-md-flex justify-content-between align-items-center shadow-sm" style="font-size: 0.85rem;">
                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <div class="bg-light rounded-circle p-2 me-2 text-primary">
                            <i class="bi bi-people-fill fs-6"></i>
                        </div>
                        <span class="fw-bold text-primary small">Statistik Pengunjung</span>
                    </div>
                    <div class="d-flex gap-3 text-muted small fw-bold flex-wrap justify-content-center">
                        <div class="text-center px-2 border-end">
                            <div class="text-uppercase text-secondary" style="font-size: 0.65rem;">Hari Ini</div>
                            <div class="text-primary"><?php echo number_format($today_visitors); ?></div>
                        </div>
                        <div class="text-center px-2 border-end">
                            <div class="text-uppercase text-secondary" style="font-size: 0.65rem;">Minggu Ini</div>
                            <div class="text-primary"><?php echo number_format($week_visitors); ?></div>
                        </div>
                        <div class="text-center px-2 border-end">
                            <div class="text-uppercase text-secondary" style="font-size: 0.65rem;">Bulan Ini</div>
                            <div class="text-primary"><?php echo number_format($month_visitors); ?></div>
                        </div>
                        <div class="text-center px-2">
                            <div class="text-uppercase text-secondary" style="font-size: 0.65rem;">Total</div>
                            <div class="text-primary"><?php echo number_format($total_visitors); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center pt-4 border-top border-secondary border-opacity-25 opacity-75">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 text-center mb-3 mb-md-0">
                    <small>Copyright &copy; <?php echo date('Y'); ?>. All rights reserved.</small>
                    <span class="mx-2">|</span>
                    <a href="admin/login.php" class="text-muted small text-decoration-none"><i class="bi bi-lock-fill me-1"></i> Login Admin</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>