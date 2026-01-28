<?php
// Halaman yang menampilkan profil instansi, visi misi, struktur organisasi, dan daftar pejabat.
include 'includes/navbar.php'; 
?>

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
                                
                                // 3. Grouping Bawahan
                                $kasubags = []; // Bawahan Sekretaris
                                $kabids = [];   // Bawahan Langsung Kepala Dinas (selain Sekretaris)

                                foreach($pejabat as $p) {
                                    // Skip Kepala & Sekretaris
                                    if (isset($kepala['id']) && $p['id'] == $kepala['id']) continue;
                                    if (isset($sekretaris['id']) && $p['id'] == $sekretaris['id']) continue;
                                    
                                    // Filter Kasubag (Masuk ke bawah Sekretaris)
                                    if (stripos($p['jabatan'], 'Kasubag') !== false || stripos($p['jabatan'], 'Sub Bagian') !== false) {
                                        $kasubags[] = $p;
                                    } else {
                                        // Sisanya (Kabid, dll) masuk ke bawah Kepala Dinas
                                        $kabids[] = $p;
                                    }
                                }
                                ?>
                                
                                <!-- Level 1: Kepala Dinas -->
                                <li>
                                    <div class="org-card border-primary border-3 shadow-lg" style="min-width: 180px; transform: scale(1.1);">
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

                                    <style>
                                        /* Custom CSS for Org Chart Lines - Fixed & Compact */
                                        .org-tree li {
                                            padding: 10px 1px 0 1px; /* Tighter spacing */
                                        }
                                        .org-tree li::before, .org-tree li::after, .org-tree ul ul::before {
                                            border-color: #333 !important;
                                            border-width: 2px !important;
                                        }
                                        /* Remove curves */
                                        .org-tree li:first-child::after {
                                            border-radius: 0;
                                        }
                                        .org-tree li:last-child::before {
                                            border-radius: 0;
                                        }

                                        /* Dummy Left Node - Hide Lines */
                                        .dummy-left::before, .dummy-left::after {
                                            border: none !important;
                                        }
                                        .dummy-left ul::before {
                                            border: none !important;
                                        }
                                        .dummy-left li::before, .dummy-left li::after {
                                            border: none !important;
                                        }
                                        .dummy-left {
                                            pointer-events: none;
                                        }

                                        /* HIDE LEFT LINE from Main Node to Dummy */
                                        .main-line-node::before {
                                            border: none !important;
                                        }

                                        /* Card Styling */
                                        .org-card {
                                            min-width: 110px; 
                                            padding: 8px;
                                            background: #fff;
                                            border: 1px solid #ccc;
                                            border-radius: 5px;
                                            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
                                            overflow: visible;
                                            white-space: normal;
                                            word-wrap: break-word;
                                            /* Ensure equal height in row */
                                            height: 100%;
                                            display: flex;
                                            flex-direction: column;
                                            justify-content: flex-start; /* Align content to top */
                                            align-items: center; /* Center content horizontally */
                                            text-align: center; /* Center text */
                                        }
                                        /* Align items in LI to stretch */
                                        .org-tree li {
                                            display: flex;
                                            flex-direction: column;
                                            align-items: center;
                                        }
                                        /* Ensure UL is flex row */
                                        .org-tree ul {
                                            display: flex;
                                            justify-content: center;
                                        }

                                        .org-card h6 {
                                            font-size: 12px;
                                            line-height: 1.3;
                                            margin-top: 4px;
                                            font-weight: 600;
                                            flex-grow: 1; /* Push content */
                                        }
                                        .org-role-badge {
                                            font-size: 10px;
                                            padding: 2px 5px;
                                            margin-bottom: 5px;
                                        }

                                        /* Mobile Optimization */
                                        @media (max-width: 768px) {
                                            .org-tree-wrapper {
                                                width: 100%;
                                                overflow-x: auto;
                                                padding: 10px;
                                                display: block; 
                                                text-align: center;
                                                -ms-overflow-style: none;
                                                scrollbar-width: none;
                                            }
                                            .org-tree-wrapper::-webkit-scrollbar {
                                                display: none;
                                            }
                                            /* Hide Dummy on Mobile to remove empty space and balance tree naturally */
                                            .dummy-left {
                                                display: none !important;
                                            }
                                            .org-tree {
                                                display: inline-block;
                                                zoom: 0.65; /* Better zoom */
                                                -moz-transform: scale(0.65);
                                                -moz-transform-origin: top center;
                                                margin: 0 auto;
                                            }
                                            .org-card h6 {
                                                font-size: 14px; 
                                            }
                                            .org-role-badge {
                                                font-size: 12px;
                                            }
                                        }
                                    </style>

                                    <!-- Script untuk auto-scroll ke tengah pada tampilan mobile -->
                                    <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        const wrapper = document.querySelector('.org-tree-wrapper');
                                        if (wrapper) {
                                            // Scroll ke tengah agar Kepala Dinas langsung terlihat
                                            wrapper.scrollLeft = (wrapper.scrollWidth - wrapper.clientWidth) / 2;
                                        }
                                    });
                                    </script>

                                    <ul>
                                        <!-- Level 2: Connector Node (Garis Panjang) -->
                                        <li>
                                            <div style="height: 60px; width: 1px; margin: 0 auto; background: #333;"></div>

                                            <ul>
                                                <!-- KIRI: Dummy Balance (Untuk meluruskan garis utama) -->
                                                <?php if ($sekretaris): ?>
                                                <li class="dummy-left" style="visibility: hidden;">
                                                    <div class="org-card">
                                                        <div class="org-role-badge">Sekretaris</div>
                                                        <h6><?php echo $sekretaris['nama']; ?></h6>
                                                        <?php if(!empty($sekretaris['foto'])): ?><div style="height: 60px;"></div><?php endif; ?>
                                                    </div>
                                                    <?php if (!empty($kasubags)): ?>
                                                    <ul>
                                                        <?php foreach($kasubags as $kb): ?>
                                                        <li><div class="org-card" style="min-width: 110px;"></div></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                    <?php endif; ?>
                                                </li>
                                                <?php endif; ?>

                                                <!-- TENGAH: Jalur Utama Menuju Bidang -->
                                                <li class="main-line-node">
                                                    <!-- Container dengan Padding Top dan Garis Absolute agar Presisi -->
                                                    <div style="position: relative; padding-top: 180px;">
                                                        <!-- Garis Vertikal Lurus (Top -4px untuk overlap kuat) -->
                                                        <div style="position: absolute; top: -4px; left: 50%; height: 186px; border-left: 2px solid #333; transform: translateX(-1px); z-index: 1;"></div>
                                                        
                                                        <!-- Container Kabid -->
                                                        <ul>
                                                            <?php foreach($kabids as $staff): ?>
                                                            <li>
                                                                <div class="org-card">
                                                                    <?php if(!empty($staff['foto']) && file_exists('uploads/'.$staff['foto'])): ?>
                                                                        <img src="uploads/<?php echo $staff['foto']; ?>" alt="<?php echo $staff['nama']; ?>">
                                                                    <?php else: ?>
                                                                        <div class="bg-light d-flex align-items-center justify-content-center mx-auto mb-2 rounded-circle" style="width: 60px; height: 60px; border: 2px solid var(--bg-light);">
                                                                            <i class="bi bi-person text-secondary fs-2"></i>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <div class="org-role-badge bg-success"><?php echo $staff['jabatan']; ?></div>
                                                                    <h6><?php echo $staff['nama']; ?></h6>
                                                                </div>
                                                            </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </li>

                                                <!-- KANAN: Jalur Samping Sekretaris -->
                                                <?php if ($sekretaris): ?>
                                                <li>
                                                    <div class="org-card border-info">
                                                        <?php if(!empty($sekretaris['foto']) && file_exists('uploads/'.$sekretaris['foto'])): ?>
                                                            <img src="uploads/<?php echo $sekretaris['foto']; ?>" alt="<?php echo $sekretaris['nama']; ?>">
                                                        <?php else: ?>
                                                            <div class="bg-light d-flex align-items-center justify-content-center mx-auto mb-2 rounded-circle" style="width: 60px; height: 60px; border: 2px solid var(--bg-light);">
                                                                <i class="bi bi-person text-secondary fs-2"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="org-role-badge bg-info">Sekretaris</div>
                                                        <h6><?php echo $sekretaris['nama']; ?></h6>
                                                    </div>

                                                    <!-- Sub-Level: Kasubag -->
                                                    <?php if (!empty($kasubags)): ?>
                                                    <ul>
                                                        <?php foreach($kasubags as $kb): ?>
                                                        <li>
                                                            <div class="org-card">
                                                                <?php if(!empty($kb['foto']) && file_exists('uploads/'.$kb['foto'])): ?>
                                                                    <img src="uploads/<?php echo $kb['foto']; ?>" alt="<?php echo $kb['nama']; ?>">
                                                                <?php else: ?>
                                                                    <div class="bg-light d-flex align-items-center justify-content-center mx-auto mb-2 rounded-circle" style="width: 60px; height: 60px; border: 2px solid var(--bg-light);">
                                                                        <i class="bi bi-person text-secondary fs-2"></i>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div class="org-role-badge bg-secondary"><?php echo $kb['jabatan']; ?></div>
                                                                <h6><?php echo $kb['nama']; ?></h6>
                                                            </div>
                                                        </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                    <?php endif; ?>
                                                </li>
                                                <?php endif; ?>
                                            </ul>
                                        </li>
                                    </ul>
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