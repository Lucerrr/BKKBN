<?php include 'header.php'; ?>

<?php
$act = isset($_GET['act']) ? $_GET['act'] : '';
$message = '';

// Handle Hapus
if ($act == 'hapus' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($conn, "DELETE FROM program WHERE id='$id'");
    echo "<script>alert('Program berhasil dihapus'); window.location='program.php';</script>";
}

// Handle Tambah/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    if ($act == 'tambah') {
        $sql = "INSERT INTO program (judul, deskripsi) VALUES ('$judul', '$deskripsi')";
    } elseif ($act == 'edit') {
        $id = intval($_POST['id']);
        $sql = "UPDATE program SET judul='$judul', deskripsi='$deskripsi' WHERE id='$id'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Program berhasil disimpan'); window.location='program.php';</script>";
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
    $judul = ''; $deskripsi = ''; $id = '';
    if ($act == 'edit' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $q = mysqli_query($conn, "SELECT * FROM program WHERE id='$id'");
        $d = mysqli_fetch_assoc($q);
        $judul = $d['judul'];
        $deskripsi = $d['deskripsi'];
    }
    ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div>
            <h1 class="h2 mb-0"><?php echo ($act == 'tambah') ? 'Tambah Program' : 'Edit Program'; ?></h1>
            <p class="text-muted small">Kelola program kerja dan kegiatan.</p>
        </div>
        <a href="program.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <?php echo $message; ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold text-primary mb-4">Detail Program Kerja</h5>
                    
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nama Program</label>
                            <input type="text" name="judul" class="form-control form-control-lg" placeholder="Contoh: Penyuluhan KB di Desa..." value="<?php echo $judul; ?>" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Deskripsi Program</label>
                            <textarea name="deskripsi" class="form-control" rows="8" placeholder="Jelaskan detail program kerja di sini..." required style="resize: none;"><?php echo $deskripsi; ?></textarea>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="program.php" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-2"></i> Simpan Program
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div>
            <h1 class="h2 mb-0">Manajemen Program</h1>
            <p class="text-muted small">Daftar program kerja yang sedang atau akan dilaksanakan.</p>
        </div>
        <a href="?act=tambah" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Tambah Program
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
                                    <th width="30%">Nama Program</th>
                                    <th width="45%">Deskripsi Singkat</th>
                                    <th class="text-end pe-4" width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $q = mysqli_query($conn, "SELECT * FROM program ORDER BY id DESC");
                                if (mysqli_num_rows($q) > 0) {
                                    while ($row = mysqli_fetch_assoc($q)):
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-secondary"><?php echo $no++; ?></td>
                                        <td>
                                            <h6 class="mb-0 fw-bold text-dark"><?php echo $row['judul']; ?></h6>
                                        </td>
                                        <td class="text-muted">
                                            <?php echo substr($row['deskripsi'], 0, 100) . (strlen($row['deskripsi']) > 100 ? '...' : ''); ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="?act=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="?act=hapus&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus program ini?');" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; 
                                } else {
                                    echo '<tr><td colspan="4" class="text-center py-5 text-muted"><i class="bi bi-clipboard-data display-4 d-block mb-3"></i>Belum ada program kerja.</td></tr>';
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