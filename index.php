<?php include 'includes/navbar.php'; ?>

<!-- Hero Section -->
<header class="hero-section text-center position-relative overflow-hidden">
    
    <div class="container position-relative" style="z-index: 2;">
        <h1 class="display-3 fw-bold mb-4">Mewujudkan Keluarga Berkualitas</h1>
        <p class="lead mb-5 mx-auto" style="max-width: 800px;">
            Selamat Datang di Website Resmi Badan Kependudukan dan Keluarga Berencana Nasional Kabupaten Muna Barat. Bersama kita bangun masa depan yang lebih baik.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="profil.php" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm"><i class="bi bi-info-circle me-2"></i> Tentang Kami</a>
            <a href="layanan.php" class="btn btn-outline-primary btn-lg rounded-pill px-4 fw-bold shadow-sm">Layanan Publik</a>
        </div>
    </div>
</header>

<!-- Sambutan -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row align-items-center">
            <?php
            // Ambil data Kepala Dinas (Pejabat dengan urutan teratas/terkecil)
            $q_kepala = mysqli_query($conn, "SELECT * FROM pejabat ORDER BY urutan ASC LIMIT 1");
            $kepala = mysqli_fetch_assoc($q_kepala);
            ?>
            <div class="col-lg-5 text-center mb-4 mb-lg-0" data-aos="fade-right">
                <div class="position-relative d-inline-block">
                    <div style="position: absolute; top: -10px; left: -10px; right: 10px; bottom: 10px; border: 3px solid var(--secondary-color); border-radius: 50%; z-index: 0;"></div>
                    <?php if ($kepala && !empty($kepala['foto'])): ?>
                        <img src="uploads/<?php echo $kepala['foto']; ?>" class="img-fluid rounded-circle shadow-lg position-relative" alt="<?php echo $kepala['nama']; ?>" style="width: 300px; height: 300px; object-fit: cover; z-index: 1;">
                    <?php else: ?>
                        <img src="assets/img/kepala_dinas_placeholder.jpg" class="img-fluid rounded-circle shadow-lg position-relative" alt="Kepala Badan" style="width: 300px; height: 300px; object-fit: cover; z-index: 1;">
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <span class="text-primary fw-bold text-uppercase tracking-wider">Sambutan Kepala Badan</span>
                <h2 class="display-6 fw-bold mb-4 text-dark">Selamat Datang di Portal Resmi</h2>
                <div class="p-4 bg-light rounded-3 border-start border-4 border-primary shadow-sm">
                    <p class="lead fst-italic mb-0 text-secondary">
                        "<?php echo $site_profil['sambutan_kepala'] ?? 'Selamat datang di website resmi BKKBN Kabupaten Muna Barat...'; ?>"
                    </p>
                </div>
                <div class="mt-4">
                    <h5 class="fw-bold mb-0"><?php echo $kepala['nama'] ?? 'Nama Kepala Badan'; ?></h5>
                    <p class="text-muted"><?php echo $kepala['jabatan'] ?? 'Kepala BKKBN Muna Barat'; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Berita Terbaru -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-up">
            <div>
                <h2 class="section-title mb-0">Berita Terbaru</h2>
                <p class="text-muted mb-0 mt-2">Informasi terkini seputar kegiatan dan pengumuman.</p>
            </div>
            <a href="berita.php" class="btn btn-primary rounded-pill px-4">Lihat Semua <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-4">
            <?php
            $q_news = mysqli_query($conn, "SELECT * FROM berita ORDER BY tanggal DESC LIMIT 3");
            if (mysqli_num_rows($q_news) > 0) {
                $delay = 100;
                while ($news = mysqli_fetch_assoc($q_news)):
            ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <div class="card h-100 border-0 shadow-sm overflow-hidden group">
                    <div class="position-relative overflow-hidden" style="height: 220px;">
                        <a href="<?php echo !empty($news['link_sumber']) ? $news['link_sumber'] : 'detail_berita.php?id='.$news['id']; ?>" class="d-block w-100 h-100">
                            <?php if ($news['gambar']): ?>
                                <img src="uploads/<?php echo $news['gambar']; ?>" class="card-img-top w-100 h-100 object-fit-cover transition-transform duration-500" alt="<?php echo $news['judul']; ?>">
                            <?php else: ?>
                                <div class="bg-light w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                    <i class="bi bi-image fs-1"></i>
                                </div>
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="card-title mb-3">
                            <a href="<?php echo !empty($news['link_sumber']) ? $news['link_sumber'] : 'detail_berita.php?id='.$news['id']; ?>" class="text-dark text-decoration-none stretched-link">
                                <?php echo $news['judul']; ?>
                            </a>
                        </h5>
                        <p class="card-text text-muted mb-4"><?php echo substr(strip_tags($news['isi']), 0, 100); ?>...</p>
                        <div class="mt-auto pt-3 border-top w-100">
                             <small class="text-muted d-block">
                                <i class="bi bi-calendar-event me-1"></i> <?php echo date('d M Y', strtotime($news['tanggal'])); ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                $delay += 100;
                endwhile; 
            } else {
                echo '<div class="col-12 text-center py-5"><div class="text-muted"><i class="bi bi-newspaper display-4 mb-3 d-block"></i>Belum ada berita terbaru.</div></div>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Poster Edukasi Marquee -->
<section class="py-5 position-relative overflow-hidden bg-white">
    
    <div class="container-fluid py-4 position-relative">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3 fw-bold tracking-wider">INFORMASI PUBLIK</span>
            <h2 class="section-title">Galeri Edukasi & Informasi</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">Kumpulan poster edukasi dan informasi penting untuk keluarga Indonesia.</p>
        </div>
        
        <!-- Marquee Container with Fade Edges -->
        <div class="marquee-wrapper">
            <!-- Fade Gradients Removed -->

            <!-- Marquee Track -->
            <div class="marquee-content d-inline-flex align-items-center">
                <?php
                // Ambil data galeri dari database
                $q_galeri = mysqli_query($conn, "SELECT * FROM poster_edukasi ORDER BY id DESC");
                $galeri_items = [];
                if ($q_galeri) {
                    while ($row = mysqli_fetch_assoc($q_galeri)) {
                        $galeri_items[] = $row;
                    }
                }

                // Jika database kosong, tampilkan pesan kosong atau biarkan kosong
                if (empty($galeri_items)) {
                    // Default poster dihapus sesuai permintaan agar bisa diisi manual
                }

                // Loop 2x untuk efek marquee infinite scroll (hanya jika ada data)
                if (!empty($galeri_items)) {
                    for ($i = 0; $i < 2; $i++) {
                        foreach ($galeri_items as $item) {
                            // Tentukan path gambar
                            if (isset($item['is_local']) && $item['is_local']) {
                                $img_src = $item['gambar'];
                            } else {
                                $img_src = 'uploads/' . $item['gambar'];
                            }
                            ?>
                            <div class="poster-item">
                                <div class="poster-card" onclick="showPoster('<?php echo $img_src; ?>', '<?php echo htmlspecialchars($item['judul']); ?>')">
                                    <img src="<?php echo $img_src; ?>" alt="<?php echo htmlspecialchars($item['judul']); ?>">
                                    <div class="poster-overlay">
                                        <i class="bi bi-zoom-in"></i>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                } else {
                    echo '<div class="text-center w-100 py-5 text-muted">Belum ada poster edukasi. Silakan upload melalui Admin Panel.</div>';
                }
                ?>
            </div>
        </div>

    </div>
</section>

<!-- Program Highlights -->
<section class="py-5 bg-light position-relative">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Program Unggulan</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">Fokus utama kami dalam meningkatkan kualitas hidup masyarakat melalui program-program strategis.</p>
        </div>
        <div class="row g-4">
            <?php
            $q_prog = mysqli_query($conn, "SELECT * FROM program LIMIT 3");
            while ($prog = mysqli_fetch_assoc($q_prog)):
            ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 text-center p-4 hover-lift">
                    <div class="card-body">
                        <div class="feature-icon-wrapper">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4 class="card-title text-dark"><?php echo $prog['judul']; ?></h4>
                        <p class="card-text mb-4"><?php echo substr(strip_tags($prog['deskripsi']), 0, 120); ?>...</p>
                        <a href="program.php" class="btn btn-outline-primary btn-sm rounded-pill px-4">Selengkapnya <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>



<?php
// Calculate Initial Population Clock Values (Server-Side) to prevent "jumping" numbers
// Data Proyeksi 2025
$START_POP_2025 = 283039291;
$REAL_BIRTH_RATE = 0.1446;
$REAL_DEATH_RATE = 0.0550;
$REAL_POP_RATE = 0.0896;

$now = time();
$current_year = date('Y');
$start_of_year = strtotime("$current_year-01-01");
$seconds_this_year = $now - $start_of_year;

// Projection Logic (Menggunakan data sensus 2025 sebagai base)
// Angka dasar 2025 + pertumbuhan sejak awal tahun ini
$init_population = $START_POP_2025 + ($seconds_this_year * $REAL_POP_RATE);

// Kelahiran dan kematian dihitung dari awal tahun berjalan (reset tiap 1 Jan)
$init_births = $seconds_this_year * $REAL_BIRTH_RATE;
$init_deaths = $seconds_this_year * $REAL_DEATH_RATE;
?>

<!-- Population Clock -->
<section class="py-5 border-top position-relative" style="overflow: hidden;">
    <!-- Background Shape -->
    <div style="position: absolute; top: 10%; bottom: 10%; left: 5%; right: 5%; background: linear-gradient(135deg, #1565C0 0%, #42A5F5 100%); border-radius: 50px; transform: skewY(-2deg); z-index: 0; box-shadow: 0 10px 30px rgba(21, 101, 192, 0.3);">
        <!-- Pattern Overlay inside Shape -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 25%), radial-gradient(circle at 80% 80%, rgba(255,255,255,0.1) 0%, transparent 25%); border-radius: 50px;"></div>
    </div>
    
    <div class="container py-5 position-relative" style="z-index: 2;">
        <div class="text-center mb-5">
            <h2 class="text-white fw-bold text-shadow mb-4">Indonesian Population Clock</h2>
            
            <!-- Real-time Clock Display (Moved to Top) -->
            <div class="clock-container d-inline-flex align-items-center justify-content-center bg-white bg-opacity-10 rounded-4 px-3 px-md-5 py-3 border border-white border-opacity-25 backdrop-blur-md shadow-lg mb-4">
                <i class="bi bi-clock-history me-2 me-md-3 fs-2 text-warning"></i> 
                <span id="current_time" class="display-4 fw-bold font-monospace text-white tracking-widest" style="min-width: 220px;"><?php echo date('H:i:s'); ?></span> 
                <span class="ms-2 ms-md-3 h4 mb-0 text-white-50 fw-bold">WITA</span>
            </div>
            
            <p class="text-white-50 text-shadow fs-5">Estimasi jumlah penduduk Indonesia secara real-time</p>
        </div>
        <div class="row g-4 justify-content-center text-center">
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 border-0 shadow-lg h-100 position-relative overflow-hidden hover-lift">
                    <div class="position-absolute top-0 start-0 w-100 h-1 bg-primary opacity-25"></div>
                    <div class="display-5 fw-bold font-monospace mb-2 text-primary" id="population_count"><?php echo number_format($init_population, 0, ',', '.'); ?></div>
                    <div class="text-muted small text-uppercase tracking-wider fw-bold">Jumlah Penduduk Saat Ini</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 bg-white rounded-4 border-0 shadow-lg h-100 position-relative overflow-hidden hover-lift">
                    <div class="position-absolute top-0 start-0 w-100 h-1 bg-success opacity-25"></div>
                    <div class="display-6 fw-bold font-monospace mb-2 text-success" id="birth_count"><?php echo number_format($init_births, 0, ',', '.'); ?></div>
                    <div class="text-muted small text-uppercase tracking-wider fw-bold">Kelahiran Tahun Ini</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 bg-white rounded-4 border-0 shadow-lg h-100 position-relative overflow-hidden hover-lift">
                    <div class="position-absolute top-0 start-0 w-100 h-1 bg-danger opacity-25"></div>
                    <div class="display-6 fw-bold font-monospace mb-2 text-danger" id="death_count"><?php echo number_format($init_deaths, 0, ',', '.'); ?></div>
                    <div class="text-muted small text-uppercase tracking-wider fw-bold">Kematian Tahun Ini</div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize from PHP-calculated values (Seamless Handover)
    // These variables come directly from the server-side calculation above
    let population = <?php echo $init_population; ?>;
    let births = <?php echo $init_births; ?>;
    let deaths = <?php echo $init_deaths; ?>;
    
    // 2. Growth Rates (Same as PHP side)
    const REAL_BIRTH_RATE = 0.1446;
    const REAL_DEATH_RATE = 0.0550;
    const REAL_POP_RATE = 0.0896;
    
    // Speed factor 1 = Real-time
    const speedFactor = 1; 

    // Previous integer values to check for changes
    let lastPop = Math.floor(population);
    let lastBirth = Math.floor(births);
    let lastDeath = Math.floor(deaths);

    // Current Year for Reset Check
    const currentYear = new Date().getFullYear();

    function updateClock() {
        // Add growth per 'tick' (100ms)
        population += (REAL_POP_RATE * speedFactor) / 10;
        births += (REAL_BIRTH_RATE * speedFactor) / 10;
        deaths += (REAL_DEATH_RATE * speedFactor) / 10;

        // Update DOM only if integer value changes
        const currPop = Math.floor(population);
        const currBirth = Math.floor(births);
        const currDeath = Math.floor(deaths);

        if (currPop !== lastPop) {
            updateNumber('population_count', currPop);
            lastPop = currPop;
        }
        if (currBirth !== lastBirth) {
            updateNumber('birth_count', currBirth);
            lastBirth = currBirth;
        }
        if (currDeath !== lastDeath) {
            updateNumber('death_count', currDeath);
            lastDeath = currDeath;
        }

        // Update time
        const nowLoop = new Date();
        const timeString = nowLoop.toLocaleTimeString('id-ID', { timeZone: 'Asia/Makassar' });
        document.getElementById('current_time').innerText = timeString;
        
        // Auto-reload on New Year
        if (nowLoop.getFullYear() > currentYear) {
             location.reload(); 
        }
    }

    function updateNumber(id, value) {
        const el = document.getElementById(id);
        el.innerText = value.toLocaleString('id-ID');
        el.classList.remove('pulse-text');
        void el.offsetWidth; // trigger reflow
        el.classList.add('pulse-text');
    }

    // Update every 100ms for smooth calculation
    setInterval(updateClock, 100);
    // Note: We do NOT call updateClock() immediately to avoid double-incrementing on load
    // The initial PHP values are already displayed correctly.
});

// Poster Modal Script
function showPoster(src, alt) {
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('posterModalLabel');
    modalImage.src = src;
    modalTitle.textContent = alt;
    const myModal = new bootstrap.Modal(document.getElementById('posterModal'));
    myModal.show();
}
</script>

<!-- Poster Modal -->
<div class="modal fade" id="posterModal" tabindex="-1" aria-labelledby="posterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 bg-transparent shadow-none">
            <div class="modal-header border-0 p-0">
                <h5 class="modal-title visually-hidden" id="posterModalLabel">Poster</h5>
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-index-10" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1056;"></button>
            </div>
            <div class="modal-body p-0 text-center">
                <img id="modalImage" src="" class="img-fluid rounded-3 shadow-lg" alt="Poster Detail" style="max-height: 85vh;">
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  // Inisialisasi AOS saat DOM siap
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            once: false, // Animasi bisa berulang saat scroll up/down
            duration: 800,
            offset: 120, // Offset standar agar tidak terlalu cepat muncul
            easing: 'ease-out-cubic',
        });
    }
  });

  // Fallback di window load jika belum terinit
  window.addEventListener('load', function() {
    if (typeof AOS !== 'undefined') {
        AOS.refresh();
    }
  });
</script>

<?php include 'includes/footer.php'; ?>