<?php include 'header.php'; ?>

<?php
// Ensure table exists
$check_table = mysqli_query($conn, "SHOW TABLES LIKE 'poster_edukasi'");
if (mysqli_num_rows($check_table) == 0) {
    $sql_create = "CREATE TABLE poster_edukasi (
        id INT AUTO_INCREMENT PRIMARY KEY,
        judul VARCHAR(100),
        gambar VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    mysqli_query($conn, $sql_create);
}

// Handle Hapus
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $q_img = mysqli_query($conn, "SELECT gambar FROM poster_edukasi WHERE id='$id'");
    $img = mysqli_fetch_assoc($q_img);
    if ($img['gambar'] && file_exists("../uploads/".$img['gambar'])) {
        unlink("../uploads/".$img['gambar']);
    }
    mysqli_query($conn, "DELETE FROM poster_edukasi WHERE id='$id'");
    echo "<script>alert('Poster dihapus'); window.location='poster.php';</script>";
}

// Handle Upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $new_name = 'poster_' . time() . '.' . $ext;
        if(move_uploaded_file($_FILES['gambar']['tmp_name'], "../uploads/" . $new_name)) {
            $sql = "INSERT INTO poster_edukasi (judul, gambar) VALUES ('$judul', '$new_name')";
            mysqli_query($conn, $sql);
            echo "<script>alert('Poster berhasil diupload'); window.location='poster.php';</script>";
        } else {
            echo "<script>alert('Gagal upload file');</script>";
        }
    }
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Galeri Edukasi</h1>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white py-3">
                <h5 class="mb-0"><i class="bi bi-cloud-upload me-2"></i>Upload Poster Edukasi</h5>
            </div>
            <div class="card-body bg-light">
                <form method="POST" enctype="multipart/form-data" id="uploadForm">
                    <div class="row">
                        <div class="col-md-5 mb-3 mb-md-0">
                            <!-- Drag & Drop Area -->
                            <div class="upload-area h-100 d-flex flex-column align-items-center justify-content-center p-4 border-2 border-dashed rounded-3 bg-white position-relative" style="min-height: 250px; border-style: dashed; border-color: #cbd5e1; cursor: pointer; transition: all 0.3s ease;" id="dropZone">
                                <input type="file" name="gambar" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;" accept="image/*" required onchange="previewImage(this)">
                                <div id="previewContainer" class="text-center w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                                    <i class="bi bi-easel display-1 text-muted mb-3"></i>
                                    <h6 class="text-muted fw-bold">Klik atau Tarik Poster ke Sini</h6>
                                    <small class="text-secondary">Disarankan Portrait (Contoh: 350x500px)</small>
                                </div>
                                <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded shadow-sm d-none" style="max-height: 220px; width: 100%; object-fit: contain;">
                            </div>
                        </div>
                        <div class="col-md-7 d-flex flex-column justify-content-center">
                            <div class="form-floating mb-3">
                                <input type="text" name="judul" class="form-control" id="floatingInput" placeholder="Judul Poster" required>
                                <label for="floatingInput">Judul Poster</label>
                            </div>
                            <div class="alert alert-success bg-opacity-10 text-success border-success border-opacity-25 small mb-3">
                                <i class="bi bi-info-circle me-1"></i>
                                Poster ini akan muncul di slider <b>Galeri Edukasi</b> halaman utama.
                            </div>
                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="bi bi-send me-2"></i>Upload Poster
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <?php
    $q = mysqli_query($conn, "SELECT * FROM poster_edukasi ORDER BY id DESC");
    if (mysqli_num_rows($q) > 0) {
        while ($row = mysqli_fetch_assoc($q)):
        ?>
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 shadow-sm border-0 overflow-hidden hover-shadow transition-all">
                <div class="position-relative" style="height: 300px; background: #f8f9fa;">
                    <img src="../uploads/<?php echo $row['gambar']; ?>" class="w-100 h-100 object-fit-contain p-2" alt="<?php echo $row['judul']; ?>">
                    <div class="position-absolute top-0 end-0 p-2">
                        <span class="badge bg-dark bg-opacity-75 rounded-pill small">ID: <?php echo $row['id']; ?></span>
                    </div>
                </div>
                <div class="card-body p-3 d-flex flex-column">
                    <h6 class="card-title fw-bold text-truncate mb-3" title="<?php echo $row['judul']; ?>"><?php echo $row['judul']; ?></h6>
                    <a href="?hapus=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm w-100 mt-auto rounded-pill" onclick="return confirm('Yakin ingin menghapus poster ini?');">
                        <i class="bi bi-trash me-1"></i> Hapus
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; 
    } else {
        echo '<div class="col-12 py-5 text-center text-muted"><i class="bi bi-easel display-4 d-block mb-3"></i>Belum ada poster edukasi.</div>';
    }
    ?>
</div>

<style>
    .hover-shadow:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }
    .transition-all { transition: all 0.3s ease; }
    .upload-area:hover { background-color: #f1f5f9 !important; border-color: var(--success-color) !important; }
</style>

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
    } else {
        preview.classList.add('d-none');
        container.classList.remove('d-none');
    }
}

// Drag and drop effects
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
    dropZone.classList.add('bg-light');
    dropZone.style.borderColor = '#198754'; // Success color for poster
}

function unhighlight(e) {
    dropZone.classList.remove('bg-light');
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

<?php include 'footer.php'; ?>