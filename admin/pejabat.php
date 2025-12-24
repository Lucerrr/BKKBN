<?php include 'header.php'; ?>

<?php
$act = isset($_GET['act']) ? $_GET['act'] : '';
$message = '';

// Handle Hapus
if ($act == 'hapus' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Hapus foto
    $q_img = mysqli_query($conn, "SELECT foto FROM pejabat WHERE id='$id'");
    $img = mysqli_fetch_assoc($q_img);
    if ($img['foto'] && file_exists("../uploads/".$img['foto'])) {
        unlink("../uploads/".$img['foto']);
    }
    
    mysqli_query($conn, "DELETE FROM pejabat WHERE id='$id'");
    echo "<script>alert('Data pejabat berhasil dihapus'); window.location='pejabat.php';</script>";
}

// Handle Tambah/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $urutan = intval($_POST['urutan']);
    
    // Upload Foto
    $foto_nama = $_POST['foto_lama'] ?? '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $new_name = 'pejabat_' . time() . '.' . $ext;
        if(move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/" . $new_name)) {
            if ($foto_nama && file_exists("../uploads/".$foto_nama)) {
                unlink("../uploads/".$foto_nama);
            }
            $foto_nama = $new_name;
        }
    }

    if ($act == 'tambah') {
        $sql = "INSERT INTO pejabat (nama, jabatan, foto, urutan) VALUES ('$nama', '$jabatan', '$foto_nama', '$urutan')";
    } elseif ($act == 'edit') {
        $id = intval($_POST['id']);
        $sql = "UPDATE pejabat SET nama='$nama', jabatan='$jabatan', foto='$foto_nama', urutan='$urutan' WHERE id='$id'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data pejabat berhasil disimpan'); window.location='pejabat.php';</script>";
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
    $nama = ''; $jabatan = ''; $urutan = 0; $foto = ''; $id = '';
    if ($act == 'edit' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $q = mysqli_query($conn, "SELECT * FROM pejabat WHERE id='$id'");
        $d = mysqli_fetch_assoc($q);
        $nama = $d['nama'];
        $jabatan = $d['jabatan'];
        $urutan = $d['urutan'];
        $foto = $d['foto'];
    }
    ?>
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div>
            <h1 class="h2 mb-0"><?php echo ($act == 'tambah') ? 'Tambah Pejabat' : 'Edit Pejabat'; ?></h1>
            <p class="text-muted small">Kelola data pejabat struktural organisasi.</p>
        </div>
        <a href="pejabat.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <?php echo $message; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="foto_lama" value="<?php echo $foto; ?>">
        
        <div class="row g-4">
            <!-- Left Column: Data Form -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-primary mb-4">Informasi Pejabat</h5>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control form-control-lg" placeholder="Contoh: Dr. Budi Santoso, M.Kes" value="<?php echo $nama; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Kepala Dinas" value="<?php echo $jabatan; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control" placeholder="Angka urutan (1, 2, 3...)" value="<?php echo $urutan; ?>">
                            <div class="form-text">Semakin kecil angkanya, semakin di atas posisinya.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Photo Upload -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-person-bounding-box me-2"></i>Foto Profil</h6>
                    </div>
                    <div class="card-body p-3">
                        <!-- Drag & Drop Area -->
                        <div class="upload-area w-100 d-flex flex-column align-items-center justify-content-center p-3 border-2 border-dashed rounded-3 bg-light position-relative" style="min-height: 250px; border-style: dashed; border-color: #cbd5e1; cursor: pointer; transition: all 0.3s ease;" id="dropZone">
                            <input type="file" name="foto" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;" accept="image/*" onchange="previewImage(this)">
                            
                            <div id="previewContainer" class="text-center w-100 <?php echo $foto ? 'd-none' : ''; ?>">
                                <i class="bi bi-person-plus display-4 text-primary mb-2 opacity-50"></i>
                                <h6 class="text-muted small fw-bold mb-1">Upload Foto</h6>
                                <p class="text-secondary small mb-0" style="font-size: 0.75rem;">Klik atau tarik file ke sini</p>
                                <p class="text-secondary small mb-0" style="font-size: 0.7rem;">Format: JPG, PNG (Max 2MB)</p>
                            </div>
                            
                            <img id="imagePreview" src="<?php echo $foto ? '../uploads/'.$foto : '#'; ?>" alt="Preview" class="img-fluid rounded shadow-sm <?php echo $foto ? '' : 'd-none'; ?>" style="max-height: 220px; width: 100%; object-fit: contain;">
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-save me-2"></i> Simpan Data
                    </button>
                    <a href="pejabat.php" class="btn btn-light border">Batal</a>
                </div>
            </div>
        </div>
    </form>

    <script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const container = document.getElementById('previewContainer');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                container.classList.add('d-none');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Drag & Drop Logic
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
    </script>

<?php else: ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div>
            <h1 class="h2 mb-0">Manajemen Pejabat</h1>
            <p class="text-muted small">Daftar struktur organisasi dan pejabat.</p>
        </div>
        <a href="?act=tambah" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-plus-fill me-2"></i> Tambah Pejabat
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
                                    <th class="ps-4" width="10%">Urutan</th>
                                    <th width="15%">Foto</th>
                                    <th width="30%">Nama Lengkap</th>
                                    <th width="25%">Jabatan</th>
                                    <th class="text-end pe-4" width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $q = mysqli_query($conn, "SELECT * FROM pejabat ORDER BY urutan ASC, id ASC");
                                if (mysqli_num_rows($q) > 0) {
                                    while ($row = mysqli_fetch_assoc($q)):
                                    ?>
                                    <tr>
                                        <td class="ps-4">
                                            <span class="badge bg-light text-dark border rounded-pill px-3"><?php echo $row['urutan']; ?></span>
                                        </td>
                                        <td>
                                            <?php if ($row['foto']): ?>
                                                <div class="ratio ratio-1x1 rounded-circle overflow-hidden border shadow-sm" style="width: 50px;">
                                                    <img src="../uploads/<?php echo $row['foto']; ?>" class="object-fit-cover" alt="Foto">
                                                </div>
                                            <?php else: ?>
                                                <div class="ratio ratio-1x1 rounded-circle bg-light d-flex align-items-center justify-content-center text-muted border" style="width: 50px;">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 fw-bold text-dark"><?php echo $row['nama']; ?></h6>
                                        </td>
                                        <td>
                                            <span class="text-muted"><?php echo $row['jabatan']; ?></span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="?act=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="?act=hapus&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus pejabat ini?');" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; 
                                } else {
                                    echo '<tr><td colspan="5" class="text-center py-5 text-muted"><i class="bi bi-people display-4 d-block mb-3"></i>Belum ada data pejabat.</td></tr>';
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