<?php include 'header.php'; ?>

<?php
$act = isset($_GET['act']) ? $_GET['act'] : '';

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
        echo "<div class='alert alert-danger'>Gagal menyimpan: ".mysqli_error($conn)."</div>";
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
        <h1 class="h2"><?php echo ($act == 'tambah') ? 'Tambah Pejabat' : 'Edit Pejabat'; ?></h1>
        <a href="pejabat.php" class="btn btn-secondary">Kembali</a>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="foto_lama" value="<?php echo $foto; ?>">
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="<?php echo $nama; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="<?php echo $jabatan; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Urutan Tampil (Opsional)</label>
            <input type="number" name="urutan" class="form-control" value="<?php echo $urutan; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Foto Profil</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            <?php if ($foto): ?>
                <div class="mt-2">
                    <img src="../uploads/<?php echo $foto; ?>" width="100" class="img-thumbnail">
                </div>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

<?php else: ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manajemen Pejabat / Struktur Organisasi</h1>
        <a href="?act=tambah" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Pejabat</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Urutan</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM pejabat ORDER BY urutan ASC, id ASC");
                while ($row = mysqli_fetch_assoc($q)):
                ?>
                <tr>
                    <td>
                        <span class="badge bg-secondary rounded-pill"><?php echo $row['urutan']; ?></span>
                    </td>
                    <td>
                        <?php if ($row['foto']): ?>
                            <img src="../uploads/<?php echo $row['foto']; ?>" width="60" class="border" style="height:60px; object-fit:cover; border-radius: 4px;">
                        <?php else: ?>
                            <span class="text-muted">No Image</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['jabatan']; ?></td>
                    <td>
                        <a href="?act=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="?act=hapus&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus pejabat ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>