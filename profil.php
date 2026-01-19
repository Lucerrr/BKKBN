<?php include 'includes/navbar.php'; ?>

<section class="py-5">
    <div class="container">
        <h1 class="text-center mb-5 section-title">Profil Instansi</h1>
        
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card shadow-sm border-0 p-4">
                    <h3><i class="bi bi-building text-primary me-2"></i> Tentang Kami</h3>
                    <p class="lead mt-3">
                        Dinas Pengendalian Penduduk dan Keluarga Berencana/BKKBN Muna Barat merupakan perangkat daerah yang melaksanakan urusan pemerintahan di bidang pengendalian penduduk dan penyelenggaraan program keluarga berencana. Dinas ini berperan dalam mendukung terwujudnya keluarga berkualitas melalui perencanaan, pelayanan, serta pembinaan kepada masyarakat.
                    </p>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0 p-4">
                    <h3 class="text-primary"><i class="bi bi-eye me-2"></i> Visi</h3>
                    <p class="mt-3"><?php echo nl2br($site_profil['visi'] ?? '-'); ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0 p-4">
                    <h3 class="text-primary"><i class="bi bi-bullseye me-2"></i> Misi</h3>
                    <p class="mt-3"><?php echo nl2br($site_profil['misi'] ?? '-'); ?></p>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card shadow-sm border-0 p-4">
                    <h3><i class="bi bi-diagram-3 text-primary me-2"></i> Struktur Organisasi</h3>
                    
                    <h4 class="mb-4 text-center mt-4">Bagan Struktur Organisasi</h4>
                    
                    <div class="org-tree-wrapper overflow-auto pb-4">
                        <div class="org-tree">
                            <ul>
                                <?php
                                // Fetch data pejabat
                                $pejabat = [];
                                $q_pejabat = mysqli_query($conn, "SELECT * FROM pejabat ORDER BY urutan ASC, id ASC");
                                while($row = mysqli_fetch_assoc($q_pejabat)) {
                                    $pejabat[] = $row;
                                }

                                // Fungsi Helper untuk mencari berdasarkan jabatan
                                function findPejabat($data, $keyword) {
                                    foreach($data as $p) {
                                        if (stripos($p['jabatan'], $keyword) !== false) return $p;
                                    }
                                    return null;
                                }

                                function findPejabatMulti($data, $keyword) {
                                    $res = [];
                                    foreach($data as $p) {
                                        if (stripos($p['jabatan'], $keyword) !== false) $res[] = $p;
                                    }
                                    return $res;
                                }

                                // 1. Kepala Dinas
                                $kepala = findPejabat($pejabat, 'Kepala Dinas');
                                // 2. Sekretaris
                                $sekretaris = findPejabat($pejabat, 'Sekretaris');
                                
                                // 3. Sisanya (Kepala Bidang, Kasubag, dll)
                                $bawahan = [];
                                foreach($pejabat as $p) {
                                    // Skip jika ini Kepala Dinas atau Sekretaris
                                    if (isset($kepala['id']) && $p['id'] == $kepala['id']) continue;
                                    if (isset($sekretaris['id']) && $p['id'] == $sekretaris['id']) continue;
                                    
                                    $bawahan[] = $p;
                                }
                                ?>
                                
                                <!-- Level 1: Kepala Dinas -->
                                <li>
                                    <div class="org-card border-primary border-2">
                                        <?php if ($kepala): ?>
                                            <?php if(!empty($kepala['foto']) && file_exists('uploads/'.$kepala['foto'])): ?>
                                                <img src="uploads/<?php echo $kepala['foto']; ?>" alt="<?php echo $kepala['nama']; ?>">
                                            <?php else: ?>
                                                <div class="bg-light d-flex align-items-center justify-content-center mx-auto mb-2 rounded-circle" style="width: 80px; height: 80px; border: 3px solid var(--bg-light);">
                                                    <i class="bi bi-person-badge text-primary fs-1"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div class="org-role-badge">Kepala Dinas</div>
                                            <h6><?php echo $kepala['nama']; ?></h6>
                                        <?php else: ?>
                                            <div class="org-role-badge">Kepala Dinas</div>
                                            <p class="text-muted fst-italic">Belum diisi</p>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($sekretaris || !empty($bawahan)): ?>
                                    <ul>
                                        <!-- Level 2: Sekretaris (Sendirian di Level ini) -->
                                        <li>
                                            <div class="org-card">
                                                <?php if ($sekretaris): ?>
                                                    <?php if(!empty($sekretaris['foto']) && file_exists('uploads/'.$sekretaris['foto'])): ?>
                                                        <img src="uploads/<?php echo $sekretaris['foto']; ?>" alt="<?php echo $sekretaris['nama']; ?>">
                                                    <?php else: ?>
                                                        <div class="bg-light d-flex align-items-center justify-content-center mx-auto mb-2 rounded-circle" style="width: 80px; height: 80px; border: 3px solid var(--bg-light);">
                                                            <i class="bi bi-person text-secondary fs-1"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="org-role-badge bg-info">Sekretaris</div>
                                                    <h6><?php echo $sekretaris['nama']; ?></h6>
                                                <?php else: ?>
                                                    <div class="org-role-badge bg-info">Sekretaris</div>
                                                    <p class="text-muted fst-italic">Belum diisi</p>
                                                <?php endif; ?>
                                            </div>

                                            <?php if (!empty($bawahan)): ?>
                                            <ul>
                                                <!-- Level 3: Kepala Bidang & Anggota Lain (Sejajar di Bawah Sekretaris) -->
                                                <?php foreach($bawahan as $staff): ?>
                                                <li>
                                                    <div class="org-card">
                                                        <?php if(!empty($staff['foto']) && file_exists('uploads/'.$staff['foto'])): ?>
                                                            <img src="uploads/<?php echo $staff['foto']; ?>" alt="<?php echo $staff['nama']; ?>">
                                                        <?php else: ?>
                                                            <div class="bg-light d-flex align-items-center justify-content-center mx-auto mb-2 rounded-circle" style="width: 80px; height: 80px; border: 3px solid var(--bg-light);">
                                                                <i class="bi bi-person text-secondary fs-1"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="org-role-badge bg-secondary"><?php echo $staff['jabatan']; ?></div>
                                                        <h6><?php echo $staff['nama']; ?></h6>
                                                    </div>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <?php endif; ?>
                                        </li>
                                    </ul>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>