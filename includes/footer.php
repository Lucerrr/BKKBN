<?php
// Bagian kaki (footer) website yang dimuat di setiap halaman.
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
<footer class="footer mt-auto position-relative" style="overflow: hidden;">
    <!-- Background Pattern Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.03; pointer-events: none; z-index: 0;">
        <svg width="100%" height="100%">
            <pattern id="footer-grid" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="1" style="stroke: white;"></path>
            </pattern>
            <rect x="0" y="0" width="100%" height="100%" fill="url(#footer-grid)"></rect>
        </svg>
    </div>

    <!-- Soft Glow Effect Bottom Right -->
    <div style="position: absolute; bottom: -100px; right: -100px; width: 500px; height: 500px; background: radial-gradient(circle, rgba(41,182,246,0.15) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; pointer-events: none; z-index: 0;"></div>

    <!-- Curved SVG Separator -->
    <div style="position: absolute; top: -1px; left: 0; width: 100%; overflow: hidden; line-height: 0; z-index: 1;">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" style="position: relative; display: block; width: calc(100% + 1.3px); height: 60px;">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill" fill="#FFFFFF"></path>
            <path d="M0,0V15.81C13,36.92,46,62.34,98.58,81.55c50.86,18.58,106.46,24.3,161.76,16.59C348.65,83.84,413.75,44.75,502.6,35.13c87.31-9.45,160.78,28.27,243.32,66.07C823.15,136.63,907.83,141,993.44,124.7,1093.55,105.7,1176.43,53.48,1200,0Z" opacity=".5" class="shape-fill" fill="#FFFFFF"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill" fill="#FFFFFF"></path>
        </svg>
    </div>

    <div class="container pt-5 position-relative" style="z-index: 2;">
        <div class="row gy-4 mb-5">
            <div class="col-lg-5 col-md-12 mb-4 mb-lg-0">
                <h5 class="text-white mb-4">Dinas Pengendalian Penduduk dan Keluarga Berencana/BKKBN Muna Barat</h5>
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
                        <div class="w-100">
                            <span class="d-block mb-2">Jam Operasional:</span>
                            <div class="d-flex justify-content-between mb-1 small border-bottom border-secondary border-opacity-25 pb-1">
                                <span class="text-white-50">Senin - Jum'at</span>
                                <span class="text-white fw-bold">08:00 - 16:00</span>
                            </div>
                            
                            <div class="d-flex justify-content-between small">
                                <span class="text-white-50">Sabtu - Minggu</span>
                                <span class="text-danger fw-bold">LIBUR</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Statistik Pengunjung Bar -->
        <!-- <div class="row mb-4 justify-content-center">
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
        </div> -->
        
        <!-- Decorative Curve Divider -->
        <div class="position-relative my-5">
            <svg class="w-100" height="24" viewBox="0 0 1200 24" preserveAspectRatio="none" style="opacity: 0.15;">
                <path d="M0,12 Q300,24 600,12 T1200,12" fill="none" stroke="white" stroke-width="2" stroke-dasharray="8 8"/>
            </svg>
            <div class="position-absolute top-50 start-50 translate-middle px-3" style="background: #0b1120;">
                <i class="bi bi-flower1 text-white-50 fs-5"></i>
            </div>
        </div>

        <div class="text-center opacity-75">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 text-center mb-3 mb-md-0">
                    <small>Copyright &copy; <?php echo date('Y'); ?>. All rights reserved.</small>
                    <span class="mx-2">|</span>
                    <a href="admin/login.php" class="text-muted small text-decoration-none d-inline-block"><i class="bi bi-lock-fill me-1"></i> Login Admin</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>