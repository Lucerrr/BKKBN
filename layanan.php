<?php
// Halaman informasi layanan publik dan jadwal pelayanan.
include 'includes/navbar.php'; 
?>

<section class="py-5">
    <div class="container">
        <h1 class="text-center mb-5 section-title">Layanan Publik</h1>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header text-white" style="background-color: #e65100;">
                        <h4 class="mb-0"><i class="bi bi-clock me-2"></i> Jadwal Pelayanan</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php
                        // Set timezone
                        date_default_timezone_set('Asia/Makassar'); // WITA
                        $current_day = date('N'); // 1 (Mon) to 7 (Sun)
                        $current_time = date('H:i');
                        $is_open = false;
                        $status_text = "TUTUP";
                        $status_class = "danger";
                        $status_icon = "bi-door-closed-fill";

                        // Logic Open/Close
                        if ($current_day >= 1 && $current_day <= 4) { // Mon-Thu
                            if (($current_time >= '08:00' && $current_time <= '12:00') || ($current_time >= '13:00' && $current_time <= '16:00')) {
                                $is_open = true;
                            }
                        } elseif ($current_day == 5) { // Fri
                            if (($current_time >= '08:00' && $current_time <= '11:00') || ($current_time >= '13:00' && $current_time <= '16:00')) {
                                $is_open = true;
                            }
                        }

                        if ($is_open) {
                            $status_text = "SEDANG BUKA";
                            $status_class = "success";
                            $status_icon = "bi-door-open-fill";
                        } elseif ($current_day >= 1 && $current_day <= 5 && $current_time >= '12:00' && $current_time < '13:00') {
                            $status_text = "ISTIRAHAT";
                            $status_class = "warning";
                            $status_icon = "bi-cup-hot-fill";
                        }
                        ?>

                        <div class="alert alert-<?php echo $status_class; ?> d-flex align-items-center justify-content-center mb-4 py-4 shadow-sm border-0 rounded-4" role="alert" style="background: <?php echo $status_class == 'success' ? 'linear-gradient(45deg, rgba(212, 237, 218, 0.8), rgba(195, 230, 203, 0.8))' : ($status_class == 'warning' ? 'linear-gradient(45deg, rgba(255, 243, 205, 0.8), rgba(255, 238, 186, 0.8))' : 'linear-gradient(45deg, rgba(248, 215, 218, 0.8), rgba(245, 198, 203, 0.8))'); ?>;">
                            <div class="p-3 rounded-circle shadow-sm me-3 text-<?php echo $status_class; ?>" style="background: rgba(255,255,255,0.4); backdrop-filter: blur(5px);">
                                <i class="bi <?php echo $status_icon; ?> fs-2"></i>
                            </div>
                            <div>
                                <small class="d-block text-uppercase fw-bold opacity-75 text-<?php echo $status_class; ?>-emphasis" style="letter-spacing: 1px;">Status Saat Ini</small>
                                <span class="h3 fw-bold mb-0 text-<?php echo $status_class; ?>-emphasis"><?php echo $status_text; ?></span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-borderless mb-0 align-middle">
                                <tbody>
                                    <tr class="border-bottom <?php echo ($current_day >= 1 && $current_day <= 4) ? 'active-day-row rounded-3' : ''; ?>">
                                        <td class="py-4 ps-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-wrapper p-2 rounded-circle shadow-sm me-2 me-md-3 text-primary border border-primary border-opacity-10">
                                                    <i class="bi bi-calendar-check fs-5"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-bold d-block text-dark">Senin - Kamis</span>
                                                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem;">Jam Pelayanan</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 text-end pe-3">
                                            <div class="d-flex flex-column align-items-end gap-1">
                                                <span class="badge bg-primary text-white shadow-sm px-3 py-2 rounded-pill fw-bold" style="min-width: 140px;">08:00 - 12:00 WITA</span>
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1 rounded-pill fw-bold my-1" style="font-size: 0.75rem;">12:00 - 13:00 ISTIRAHAT</span>
                                                <span class="badge bg-primary bg-opacity-75 text-white shadow-sm px-3 py-2 rounded-pill fw-bold" style="min-width: 140px;">13:00 - 16:00 WITA</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom <?php echo ($current_day == 5) ? 'active-day-row rounded-3' : ''; ?>">
                                        <td class="py-4 ps-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-wrapper p-2 rounded-circle shadow-sm me-2 me-md-3 text-success border border-success border-opacity-10">
                                                    <i class="bi bi-clock-history fs-5"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-bold d-block text-dark">Jumat</span>
                                                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem;">Jam Pelayanan</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 text-end pe-3">
                                            <div class="d-flex flex-column align-items-end gap-1">
                                                <span class="badge bg-success text-white shadow-sm px-3 py-2 rounded-pill fw-bold" style="min-width: 140px;">08:00 - 11:00 WITA</span>
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1 rounded-pill fw-bold my-1" style="font-size: 0.75rem;">11:00 - 13:00 ISTIRAHAT</span>
                                                <span class="badge bg-success bg-opacity-75 text-white shadow-sm px-3 py-2 rounded-pill fw-bold" style="min-width: 140px;">13:00 - 16:00 WITA</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="<?php echo ($current_day >= 6) ? 'active-day-row-danger rounded-3' : ''; ?>">
                                        <td class="py-4 ps-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-wrapper p-2 rounded-circle shadow-sm me-2 me-md-3 text-danger border border-danger border-opacity-10">
                                                    <i class="bi bi-slash-circle fs-5"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-bold text-danger d-block">Sabtu - Minggu</span>
                                                    <small class="text-danger opacity-75 text-uppercase fw-semibold" style="font-size: 0.7rem;">Libur Akhir Pekan</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 text-end pe-3">
                                            <span class="badge bg-danger text-white border border-danger px-4 py-2 rounded-pill fw-bold shadow-sm">TUTUP</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-warning d-flex align-items-center mt-4 mb-0 py-2" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            <div class="small fst-italic">
                                *Jadwal dapat berubah sewaktu-waktu sesuai kondisi lapangan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-hospital me-2"></i> Pelayanan KB</h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-4">BKKBN Kabupaten Muna Barat menyediakan Pelayanan Keluarga Berencana (KB) yang aman, berkualitas, dan terjangkau bagi masyarakat sebagai upaya mewujudkan keluarga sehat dan sejahtera.</p>
                        
                        <div class="list-group list-group-flush">
                            <div class="list-group-item px-0 border-bottom">
                                <h6 class="fw-bold text-primary mb-1"><i class="bi bi-check-circle-fill me-2 small"></i>Pemasangan IUD (Spiral)</h6>
                                <p class="mb-0 text-muted small ps-4">Metode kontrasepsi jangka panjang yang efektif dan aman.</p>
                            </div>
                            <div class="list-group-item px-0 border-bottom">
                                <h6 class="fw-bold text-primary mb-1"><i class="bi bi-check-circle-fill me-2 small"></i>Pemasangan Implan (Susuk)</h6>
                                <p class="mb-0 text-muted small ps-4">Kontrasepsi jangka panjang untuk mencegah kehamilan dengan tingkat keberhasilan tinggi.</p>
                            </div>
                            <div class="list-group-item px-0 border-bottom">
                                <h6 class="fw-bold text-primary mb-1"><i class="bi bi-check-circle-fill me-2 small"></i>Suntik KB</h6>
                                <p class="mb-0 text-muted small ps-4">Metode kontrasepsi hormonal yang praktis dan mudah digunakan.</p>
                            </div>
                            <div class="list-group-item px-0 border-bottom">
                                <h6 class="fw-bold text-primary mb-1"><i class="bi bi-check-circle-fill me-2 small"></i>Pil KB</h6>
                                <p class="mb-0 text-muted small ps-4">Kontrasepsi oral untuk membantu perencanaan kehamilan secara teratur.</p>
                            </div>
                            <div class="list-group-item px-0 border-bottom">
                                <h6 class="fw-bold text-primary mb-1"><i class="bi bi-check-circle-fill me-2 small"></i>Kondom</h6>
                                <p class="mb-0 text-muted small ps-4">Alat kontrasepsi yang berfungsi mencegah kehamilan serta melindungi dari infeksi menular seksual.</p>
                            </div>
                            <div class="list-group-item px-0">
                                <h6 class="fw-bold text-primary mb-1"><i class="bi bi-check-circle-fill me-2 small"></i>Konseling Kesehatan Reproduksi</h6>
                                <p class="mb-0 text-muted small ps-4">Layanan konsultasi bagi pasangan usia subur terkait perencanaan keluarga dan kesehatan reproduksi.</p>
                            </div>
                        </div>

                        <div class="alert alert-light border-start border-4 border-primary mt-4 mb-0" role="alert">
                            <i class="bi bi-info-circle-fill text-primary me-2"></i>
                            <span class="small fst-italic">Pelayanan KB dilaksanakan melalui kerja sama dengan fasilitas pelayanan kesehatan seperti puskesmas, klinik, dan tenaga kesehatan yang berkompeten.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="bi bi-people me-2"></i> Kontak Penyuluh KB (PLKB)</h4>
                    </div>
                    <div class="card-body">
                        <p>Untuk informasi lebih lanjut di tingkat desa/kelurahan, Anda dapat menghubungi penyuluh KB kami:</p>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="border p-3 rounded">
                                    <h5 class="fw-bold">Kecamatan Lawa</h5>
                                    <p class="mb-0"><i class="bi bi-person"></i> Bpk. Ahmad</p>
                                    <p class="mb-0"><i class="bi bi-whatsapp"></i> 0812-xxxx-xxxx</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border p-3 rounded">
                                    <h5 class="fw-bold">Kecamatan Tiworo</h5>
                                    <p class="mb-0"><i class="bi bi-person"></i> Ibu Siti</p>
                                    <p class="mb-0"><i class="bi bi-whatsapp"></i> 0813-xxxx-xxxx</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border p-3 rounded">
                                    <h5 class="fw-bold">Kecamatan Kusambi</h5>
                                    <p class="mb-0"><i class="bi bi-person"></i> Bpk. Budi</p>
                                    <p class="mb-0"><i class="bi bi-whatsapp"></i> 0852-xxxx-xxxx</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>