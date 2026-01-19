<?php
require_once 'config/database.php';

// Ambil data profil untuk digunakan di header/footer
$q_prof = mysqli_query($conn, "SELECT * FROM profil");
$site_profil = [];
while ($r = mysqli_fetch_assoc($q_prof)) {
    $site_profil[$r['meta_key']] = $r['meta_value'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_profil['nama_instansi'] ?? 'BKKBN Muna Barat'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" href="assets/img/logo_baru.png?v=<?php echo time(); ?>" type="image/png">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom sticky-top p-0">
    <div class="container-fluid p-0">
        <div class="d-flex align-items-center h-100 w-100">
            <!-- Left Side: Brand Section with Gradient -->
            <div class="brand-section d-flex align-items-center py-2 ps-3 pe-4" style="background: linear-gradient(135deg, #0056b3 0%, #0088ff 100%); border-bottom-right-radius: 50px; flex-shrink: 0; max-width: 100%;">
                <a class="navbar-brand d-flex align-items-center me-0" href="index.php">
                    <!-- Logo Muna Barat -->
                    <img src="assets/img/logo.png" alt="Logo BKKBN" class="me-2 bg-white rounded-circle p-1 logo-img" style="object-fit: contain;">
                    
                    <!-- Teks Instansi -->
                    <div class="d-flex flex-column text-white lh-sm me-3">
                        <!-- Desktop View -->
                        <div class="d-none d-md-block">
                            <span class="d-block" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">BADAN KEPENDUDUKAN DAN</span>
                            <span class="d-block" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">KELUARGA BERENCANA NASIONAL</span>
                            <span class="d-block" style="font-size: 0.9rem; font-weight: 800; color: #ffeb3b; margin-top: 2px;">KABUPATEN MUNA BARAT</span>
                        </div>
                        <!-- Mobile View -->
                        <div class="d-md-none">
                            <span class="d-block text-uppercase" style="font-size: 0.6rem; font-weight: 700; letter-spacing: 0.5px; line-height: 1.2;">BADAN KEPENDUDUKAN DAN</span>
                            <span class="d-block text-uppercase" style="font-size: 0.6rem; font-weight: 700; letter-spacing: 0.5px; line-height: 1.2;">KELUARGA BERENCANA NASIONAL</span>
                            <span class="d-block text-uppercase text-warning" style="font-size: 0.55rem; font-weight: 800; margin-top: 2px;">KABUPATEN MUNA BARAT</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Right Side: Navigation Menu -->
            <div class="flex-grow-1 d-flex justify-content-end align-items-center bg-white h-100 pe-lg-5">
                <button class="navbar-toggler border-0 shadow-none text-primary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                    <i class="bi bi-x-lg close-icon"></i>
                </button>
                <div class="collapse navbar-collapse justify-content-end me-lg-4" id="navbarNav">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item"><a class="nav-link px-3 fw-bold" href="index.php">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link px-3 fw-bold" href="profil.php">Profil</a></li>
                        <li class="nav-item"><a class="nav-link px-3 fw-bold" href="berita.php">Berita</a></li>
                        <li class="nav-item"><a class="nav-link px-3 fw-bold" href="program.php">Informasi</a></li>
                        <li class="nav-item"><a class="nav-link px-3 fw-bold" href="galeri.php">Publikasi</a></li>
                        <li class="nav-item"><a class="nav-link px-3 fw-bold" href="layanan.php">Layanan</a></li>
                        <li class="nav-item"><a class="nav-link px-3 fw-bold" href="kontak.php">Kontak Kami</a></li>
                        <!-- Night Mode Toggle -->
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <button class="btn btn-link nav-link px-3 w-100 d-flex align-items-center justify-content-between justify-content-lg-center" id="theme-toggle" title="Ganti Mode Tampilan" style="cursor: pointer;">
                                <div class="d-flex align-items-center d-lg-none">
                                    <i class="bi bi-palette-fill me-2 text-primary"></i>
                                    <span class="fw-bold">Ganti Tema</span>
                                </div>
                                <div class="d-flex align-items-center bg-light rounded-pill px-2 py-1 border d-lg-none">
                                    <span class="small me-2 text-muted" id="theme-text">Terang</span>
                                    <i class="bi bi-moon-stars-fill text-primary" id="theme-icon-mobile"></i>
                                </div>
                                <!-- Desktop Icon Only -->
                                <i class="bi bi-moon-stars-fill d-none d-lg-block" id="theme-icon"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    // Theme Toggle Script
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const themeIconMobile = document.getElementById('theme-icon-mobile');
        const themeText = document.getElementById('theme-text');
        const html = document.documentElement;
        
        function updateThemeUI(isDark) {
            if (isDark) {
                html.setAttribute('data-theme', 'dark');
                // Desktop Icon
                if(themeIcon) {
                    themeIcon.classList.remove('bi-moon-stars-fill');
                    themeIcon.classList.add('bi-sun-fill');
                }
                // Mobile Icon
                if(themeIconMobile) {
                    themeIconMobile.classList.remove('bi-moon-stars-fill');
                    themeIconMobile.classList.add('bi-sun-fill');
                    themeIconMobile.classList.remove('text-primary');
                    themeIconMobile.classList.add('text-warning');
                }
                // Mobile Text
                if(themeText) themeText.textContent = 'Gelap';
            } else {
                html.removeAttribute('data-theme');
                // Desktop Icon
                if(themeIcon) {
                    themeIcon.classList.remove('bi-sun-fill');
                    themeIcon.classList.add('bi-moon-stars-fill');
                }
                // Mobile Icon
                if(themeIconMobile) {
                    themeIconMobile.classList.remove('bi-sun-fill');
                    themeIconMobile.classList.add('bi-moon-stars-fill');
                    themeIconMobile.classList.remove('text-warning');
                    themeIconMobile.classList.add('text-primary');
                }
                // Mobile Text
                if(themeText) themeText.textContent = 'Terang';
            }
        }

        // Check saved preference
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            updateThemeUI(true);
        } else {
            updateThemeUI(false);
        }

        toggleBtn.addEventListener('click', function() {
            const currentTheme = html.getAttribute('data-theme');
            if (currentTheme === 'dark') {
                localStorage.setItem('theme', 'light');
                updateThemeUI(false);
            } else {
                localStorage.setItem('theme', 'dark');
                updateThemeUI(true);
            }
        });
    });
</script>