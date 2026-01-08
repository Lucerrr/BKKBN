<?php include 'header.php'; ?>

<?php
$act = isset($_GET['act']) ? $_GET['act'] : '';
$message = '';

// Handle Hapus
if ($act == 'hapus' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Ambil info gambar dulu untuk dihapus filenya
    $q_img = mysqli_query($conn, "SELECT gambar FROM berita WHERE id='$id'");
    $img = mysqli_fetch_assoc($q_img);
    if ($img['gambar'] && file_exists("../uploads/".$img['gambar'])) {
        unlink("../uploads/".$img['gambar']);
    }
    
    mysqli_query($conn, "DELETE FROM berita WHERE id='$id'");
    echo "<script>alert('Berita berhasil dihapus'); window.location='berita.php';</script>";
}

// Handle Tambah/Edit Submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi = mysqli_real_escape_string($conn, $_POST['isi']);
    $link_sumber = mysqli_real_escape_string($conn, $_POST['link_sumber']);
    $tanggal = $_POST['tanggal'];
    
    // Upload Gambar
    $gambar_nama = $_POST['gambar_lama'] ?? '';
    
    // 1. Prioritas 1: Upload Manual
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $new_name = time() . '.' . $ext;
        if(move_uploaded_file($_FILES['gambar']['tmp_name'], "../uploads/" . $new_name)) {
            if ($gambar_nama && file_exists("../uploads/".$gambar_nama) && strpos($gambar_nama, 'scraped_') === false) {
                // Hapus gambar lama jika bukan default/scraped (opsional)
                unlink("../uploads/".$gambar_nama);
            }
            $gambar_nama = $new_name;
        }
    } 
    // 2. Prioritas 2: Ambil dari URL (Scraping)
    elseif (!empty($_POST['gambar_url'])) {
        $img_url = $_POST['gambar_url'];
        $img_content = @file_get_contents($img_url);
        if ($img_content) {
            $ext = pathinfo(parse_url($img_url, PHP_URL_PATH), PATHINFO_EXTENSION);
            if (!$ext) $ext = 'jpg'; // Default extension
            $new_name = 'scraped_' . time() . '.' . $ext;
            if (file_put_contents("../uploads/" . $new_name, $img_content)) {
                if ($gambar_nama && file_exists("../uploads/".$gambar_nama)) {
                    unlink("../uploads/".$gambar_nama);
                }
                $gambar_nama = $new_name;
            }
        }
    }

    if ($act == 'tambah') {
        $sql = "INSERT INTO berita (judul, isi, link_sumber, gambar, tanggal) VALUES ('$judul', '$isi', '$link_sumber', '$gambar_nama', '$tanggal')";
    } elseif ($act == 'edit') {
        $id = intval($_POST['id']);
        $sql = "UPDATE berita SET judul='$judul', isi='$isi', link_sumber='$link_sumber', gambar='$gambar_nama', tanggal='$tanggal' WHERE id='$id'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil disimpan'); window.location='berita.php';</script>";
    } else {
        $message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal menyimpan data!</strong> '.mysqli_error($conn).'
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
    }
}
?>

<?php if ($act == 'tambah' || $act == 'edit'): ?>
    <?php
    $judul = ''; $isi = ''; $link_sumber = ''; $tanggal = date('Y-m-d'); $gambar = ''; $id = '';
    if ($act == 'edit' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $q = mysqli_query($conn, "SELECT * FROM berita WHERE id='$id'");
        $d = mysqli_fetch_assoc($q);
        $judul = $d['judul'];
        $isi = $d['isi'];
        $tanggal = $d['tanggal'];
        $gambar = $d['gambar'];
    }
    ?>
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div>
            <h1 class="h2 mb-0"><?php echo ($act == 'tambah') ? 'Buat Berita Baru' : 'Edit Berita'; ?></h1>
            <p class="text-muted small">Kelola informasi dan berita terbaru untuk website.</p>
        </div>
        <a href="berita.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <?php echo $message; ?>

    <form method="POST" enctype="multipart/form-data" id="beritaForm">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="gambar_lama" value="<?php echo $gambar; ?>">
        
        <div class="row g-4">
            <!-- Left Column: Main Content -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-primary mb-4">Konten Berita</h5>
                        
                        <!-- Auto Fetch Tool -->
                        <div class="mb-4 p-3 bg-light border border-primary border-opacity-25 rounded-3 position-relative overflow-hidden">
                            <div class="position-absolute top-0 start-0 w-1 p-1 bg-primary h-100"></div>
                            <label class="form-label fw-bold text-primary d-flex align-items-center">
                                <i class="bi bi-magic me-2"></i>Isi Otomatis dari Link (Magic Tool)
                            </label>
                            <div class="input-group">
                                <input type="url" id="auto_url" class="form-control border-end-0" placeholder="Tempel link berita di sini (Detik, Kompas, dll)...">
                                <button type="button" class="btn btn-primary px-4" onclick="fetchMetadata()">
                                    <i class="bi bi-lightning-charge me-1"></i> Ambil Data
                                </button>
                            </div>
                            <div id="fetch_status" class="mt-2 small"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Judul Berita</label>
                            <input type="text" name="judul" id="judul" class="form-control form-control-lg" placeholder="Masukkan judul yang menarik..." value="<?php echo $judul; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Berita</label>
                            <textarea name="isi" id="isi" class="form-control" rows="12" placeholder="Tuliskan isi berita di sini..." required style="resize: none;"><?php echo $isi; ?></textarea>
                            <div class="form-text text-end">Minimal 1 paragraf disarankan.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings & Meta -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-gear me-2"></i>Pengaturan Publikasi</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tanggal Terbit</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-calendar-event"></i></span>
                                <input type="date" name="tanggal" class="form-control" value="<?php echo $tanggal ? $tanggal : date('Y-m-d'); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Link Sumber (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-link-45deg"></i></span>
                                <input type="url" name="link_sumber" id="link_sumber" class="form-control" value="<?php echo $link_sumber; ?>" placeholder="https://...">
                            </div>
                            <div class="form-text small">Jika berita diambil dari website luar.</div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-image me-2"></i>Gambar Utama</h6>
                    </div>
                    <div class="card-body p-3">
                        <!-- Drag & Drop Area -->
                        <div class="upload-area w-100 d-flex flex-column align-items-center justify-content-center p-3 border-2 border-dashed rounded-3 bg-light position-relative" style="min-height: 200px; border-style: dashed; border-color: #cbd5e1; cursor: pointer; transition: all 0.3s ease;" id="dropZone">
                            <input type="file" name="gambar" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;" accept="image/*" onchange="previewImage(this)">
                            
                            <!-- Hidden input untuk gambar dari URL -->
                            <input type="hidden" name="gambar_url" id="gambar_url">
                            
                            <div id="previewContainer" class="text-center w-100 <?php echo $gambar ? 'd-none' : ''; ?>">
                                <i class="bi bi-cloud-arrow-up display-4 text-primary mb-2 opacity-50"></i>
                                <h6 class="text-muted small fw-bold mb-1">Upload Gambar</h6>
                                <p class="text-secondary small mb-0" style="font-size: 0.75rem;">Klik atau tarik file ke sini</p>
                            </div>
                            
                            <img id="imagePreview" src="<?php echo $gambar ? '../uploads/'.$gambar : '#'; ?>" alt="Preview" class="img-fluid rounded shadow-sm <?php echo $gambar ? '' : 'd-none'; ?>" style="max-height: 180px; width: 100%; object-fit: contain;">
                        </div>
                        <div id="preview_gambar_url_status" class="mt-2 small text-center"></div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-save me-2"></i> Simpan Berita
                    </button>
                    <a href="berita.php" class="btn btn-light border">Batal</a>
                </div>
            </div>
        </div>
    </form>

    <script>
    // --- Image Preview Logic (Same as Gallery) ---
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const container = document.getElementById('previewContainer');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                container.classList.add('d-none');
                
                // Clear URL input if manual upload is selected
                document.getElementById('gambar_url').value = '';
                document.getElementById('preview_gambar_url_status').innerHTML = '';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // --- Drag & Drop Logic ---
    const dropZone = document.getElementById('dropZone');
    const fileInput = dropZone.querySelector('input[type="file"]');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('bg-white');
        dropZone.classList.remove('bg-light');
        dropZone.style.borderColor = '#0d6efd';
    }

    function unhighlight(e) {
        dropZone.classList.remove('bg-white');
        dropZone.classList.add('bg-light');
        dropZone.style.borderColor = '#cbd5e1';
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            previewImage(fileInput);
        }
    }

    // --- Fetch Metadata Logic ---
    function fetchMetadata() {
        const url = document.getElementById('auto_url').value;
        const statusDiv = document.getElementById('fetch_status');
        
        if (!url) {
            statusDiv.innerHTML = '<span class="text-danger small"><i class="bi bi-exclamation-circle me-1"></i>Mohon isi URL terlebih dahulu</span>';
            return;
        }

        statusDiv.innerHTML = '<span class="text-primary small"><span class="spinner-border spinner-border-sm me-1"></span>Sedang mengambil data...</span>';

        fetch('fetch_meta.php?url=' + encodeURIComponent(url))
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('judul').value = data.title || '';
                    // Gunakan content jika ada, jika tidak fallback ke description
                    document.getElementById('isi').value = data.content || data.description || '';
                    document.getElementById('link_sumber').value = url;
                    
                    if (data.image) {
                        document.getElementById('gambar_url').value = data.image;
                        
                        // Update preview with URL image
                        const preview = document.getElementById('imagePreview');
                        const container = document.getElementById('previewContainer');
                        preview.src = data.image;
                        preview.classList.remove('d-none');
                        container.classList.add('d-none');
                        
                        document.getElementById('preview_gambar_url_status').innerHTML = 
                            '<span class="text-success fw-bold"><i class="bi bi-check-circle me-1"></i>Gambar ditemukan dari link!</span>';
                    }
                    
                    statusDiv.innerHTML = '<span class="text-success small fw-bold"><i class="bi bi-check-circle me-1"></i>Berhasil! Data telah diisi otomatis.</span>';
                } else {
                    statusDiv.innerHTML = '<span class="text-danger small"><i class="bi bi-x-circle me-1"></i>Gagal: ' + data.error + '</span>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                statusDiv.innerHTML = '<span class="text-danger small"><i class="bi bi-x-circle me-1"></i>' + error.message + '</span>';
            });
    }
    </script>

<?php else: ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div>
            <h1 class="h2 mb-0">Manajemen Berita</h1>
            <p class="text-muted small">Daftar semua berita yang telah dipublikasikan.</p>
        </div>
        <a href="?act=tambah" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Buat Berita Baru
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4" width="5%">No</th>
                                    <th width="15%">Gambar</th>
                                    <th width="40%">Judul Berita</th>
                                    <th width="15%">Tanggal</th>
                                    <th class="text-end pe-4" width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $q = mysqli_query($conn, "SELECT * FROM berita ORDER BY tanggal DESC");
                                if (mysqli_num_rows($q) > 0) {
                                    while ($row = mysqli_fetch_assoc($q)):
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-secondary"><?php echo $no++; ?></td>
                                        <td>
                                            <?php if ($row['gambar']): ?>
                                                <div class="ratio ratio-16x9 rounded overflow-hidden" style="width: 100px;">
                                                    <img src="../uploads/<?php echo $row['gambar']; ?>" class="object-fit-cover" alt="Thumbnail">
                                                </div>
                                            <?php else: ?>
                                                <div class="ratio ratio-16x9 rounded bg-light d-flex align-items-center justify-content-center text-muted border" style="width: 100px;">
                                                    <small>No Img</small>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <h6 class="mb-1 fw-bold text-dark text-truncate" style="max-width: 350px;"><?php echo $row['judul']; ?></h6>
                                            <small class="text-muted text-truncate d-block" style="max-width: 350px;"><?php echo substr(strip_tags($row['isi']), 0, 80); ?>...</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border fw-normal">
                                                <i class="bi bi-calendar3 me-1"></i> <?php echo date('d M Y', strtotime($row['tanggal'])); ?>
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="?act=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="?act=hapus&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus berita ini?');" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; 
                                } else {
                                    echo '<tr><td colspan="5" class="text-center py-5 text-muted"><i class="bi bi-newspaper display-4 d-block mb-3"></i>Belum ada berita yang ditulis.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>