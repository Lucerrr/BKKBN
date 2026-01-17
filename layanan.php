<?php include 'includes/navbar.php'; ?>

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
                            if ($current_time >= '08:00' && $current_time <= '16:00') {
                                $is_open = true;
                            }
                        } elseif ($current_day == 5) { // Fri
                            if ($current_time >= '08:00' && $current_time <= '11:00') {
                                $is_open = true;
                            }
                        }

                        if ($is_open) {
                            $status_text = "SEDANG BUKA";
                            $status_class = "success";
                            $status_icon = "bi-door-open-fill";
                        }
                        ?>

                        <div class="alert alert-<?php echo $status_class; ?> d-flex align-items-center justify-content-center mb-4 py-3 shadow-sm border-<?php echo $status_class; ?>" role="alert">
                            <i class="bi <?php echo $status_icon; ?> fs-3 me-3"></i>
                            <div class="text-center">
                                <small class="d-block text-uppercase fw-bold opacity-75">Status Saat Ini</small>
                                <span class="h4 fw-bold mb-0"><?php echo $status_text; ?></span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-borderless mb-0 align-middle">
                                <tbody>
                                    <tr class="border-bottom <?php echo ($current_day >= 1 && $current_day <= 4) ? 'bg-primary bg-opacity-10 rounded-3' : ''; ?>">
                                        <td class="py-3 ps-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3 text-primary">
                                                    <i class="bi bi-calendar-check fs-4"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-bold d-block">Senin - Kamis</span>
                                                    <small class="text-muted">Hari Kerja</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 text-end pe-3">
                                            <span class="badge bg-light text-dark border shadow-sm px-3 py-2 rounded-pill fw-bold">08:00 - 16:00 WITA</span>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom <?php echo ($current_day == 5) ? 'bg-primary bg-opacity-10 rounded-3' : ''; ?>">
                                        <td class="py-3 ps-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3 text-primary">
                                                    <i class="bi bi-clock-history fs-4"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-bold d-block">Jumat</span>
                                                    <small class="text-muted">Hari Pendek</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 text-end pe-3">
                                            <span class="badge bg-light text-dark border shadow-sm px-3 py-2 rounded-pill fw-bold">08:00 - 11:00 WITA</span>
                                        </td>
                                    </tr>
                                    <tr class="<?php echo ($current_day >= 6) ? 'bg-danger bg-opacity-10 rounded-3' : ''; ?>">
                                        <td class="py-3 ps-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-danger bg-opacity-10 p-2 rounded-circle me-3 text-danger">
                                                    <i class="bi bi-slash-circle fs-4"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-bold text-danger d-block">Sabtu - Minggu</span>
                                                    <small class="text-danger opacity-75">Akhir Pekan</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 text-end pe-3">
                                            <span class="badge bg-danger text-white border border-danger px-3 py-2 rounded-pill fw-bold">LIBUR</span>
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