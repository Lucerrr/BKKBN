<?php include 'header.php'; ?>

<?php
$act = isset($_GET['act']) ? $_GET['act'] : '';

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
        <h1 class="h2"><?php echo ($act == 'tambah') ? 'Tambah Program' : 'Edit Program'; ?></h1>
        <a href="program.php" class="btn btn-secondary">Kembali</a>
    </div>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="mb-3">
            <label class="form-label">Nama Program</label>
            <input type="text" name="judul" class="form-control" value="<?php echo $judul; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi Program</label>
            <textarea name="deskripsi" class="form-control" rows="5" required><?php echo $deskripsi; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

<?php else: ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manajemen Program</h1>
        <a href="?act=tambah" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Program</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Program</th>
                    <th>Deskripsi Singkat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $q = mysqli_query($conn, "SELECT * FROM program");
                while ($row = mysqli_fetch_assoc($q)):
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['judul']; ?></td>
                    <td><?php echo substr($row['deskripsi'], 0, 100) . '...'; ?></td>
                    <td>
                        <a href="?act=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="?act=hapus&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus program ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>