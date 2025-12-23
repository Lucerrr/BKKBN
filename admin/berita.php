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
            if ($gambar_nama && file_exists("../uploads/".$gambar_nama)) {
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
        $message = '<div class="alert alert-danger">Gagal menyimpan data: '.mysqli_error($conn).'</div>';
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
        <h1 class="h2"><?php echo ($act == 'tambah') ? 'Tambah Berita' : 'Edit Berita'; ?></h1>
        <a href="berita.php" class="btn btn-secondary">Kembali</a>
    </div>

    <?php echo $message; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="gambar_lama" value="<?php echo $gambar; ?>">
        
        <div class="mb-3 p-3 bg-light border rounded">
            <label class="form-label fw-bold text-primary">Isi Otomatis dari Link Berita</label>
            <div class="input-group">
                <input type="url" id="auto_url" class="form-control" placeholder="Tempel link berita di sini (Contoh: https://news.detik.com/...)">
                <button type="button" class="btn btn-info text-white" onclick="fetchMetadata()">Ambil Data</button>
            </div>
            <div class="form-text">Fitur ini akan mencoba mengambil Judul, Deskripsi, dan Gambar Utama dari link yang Anda masukkan.</div>
            <div id="fetch_status" class="mt-2"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Judul Berita</label>
            <input type="text" name="judul" id="judul" class="form-control" value="<?php echo $judul; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?php echo $tanggal; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Link Sumber / URL Eksternal (Opsional)</label>
            <input type="url" name="link_sumber" id="link_sumber" class="form-control" value="<?php echo $link_sumber; ?>" placeholder="https://contoh-berita.com/...">
            <div class="form-text">Isi jika berita berasal dari website lain. Pengunjung akan diarahkan langsung ke link ini.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Gambar Utama</label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
            <input type="hidden" name="gambar_url" id="gambar_url"> <!-- Hidden input untuk gambar dari URL -->
            <div id="preview_gambar_url" class="mt-2 text-muted"></div>
            <?php if ($gambar): ?>
                <div class="mt-2">
                    <img src="../uploads/<?php echo $gambar; ?>" width="150" class="img-thumbnail">
                </div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Isi Berita</label>
            <textarea name="isi" id="isi" class="form-control" rows="10" required><?php echo $isi; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

    <script>
    function fetchMetadata() {
        const url = document.getElementById('auto_url').value;
        const statusDiv = document.getElementById('fetch_status');
        
        if (!url) {
            alert('Mohon isi URL terlebih dahulu');
            return;
        }

        statusDiv.innerHTML = '<span class="text-info">Sedang mengambil data...</span>';

        // Gunakan proxy atau backend PHP sederhana untuk scraping agar tidak kena CORS
        // Di sini kita akan buat file helper fetch_meta.php
        fetch('fetch_meta.php?url=' + encodeURIComponent(url))
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('judul').value = data.title || '';
                    document.getElementById('isi').value = data.description || '';
                    document.getElementById('link_sumber').value = url;
                    
                    if (data.image) {
                        document.getElementById('gambar_url').value = data.image;
                        document.getElementById('preview_gambar_url').innerHTML = 
                            '<img src="' + data.image + '" style="max-width: 200px; max-height: 200px;" class="img-thumbnail"><br><small>Gambar diambil dari URL. Akan didownload saat disimpan.</small>';
                    }
                    
                    statusDiv.innerHTML = '<span class="text-success">Data berhasil diambil!</span>';
                } else {
                    statusDiv.innerHTML = '<span class="text-danger">Gagal mengambil data: ' + data.error + '</span>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                statusDiv.innerHTML = '<span class="text-danger">Terjadi kesalahan koneksi.</span>';
            });
    }
    </script>

<?php else: ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manajemen Berita</h1>
        <a href="?act=tambah" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Berita</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $q = mysqli_query($conn, "SELECT * FROM berita ORDER BY tanggal DESC");
                while ($row = mysqli_fetch_assoc($q)):
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td>
                        <?php if ($row['gambar']): ?>
                            <img src="../uploads/<?php echo $row['gambar']; ?>" width="80" class="img-thumbnail">
                        <?php else: ?>
                            <span class="text-muted">No Image</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row['judul']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                    <td>
                        <a href="?act=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="?act=hapus&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>