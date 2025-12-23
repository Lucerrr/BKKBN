<?php include 'includes/navbar.php'; ?>

<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$q = mysqli_query($conn, "SELECT * FROM berita WHERE id='$id'");
$d = mysqli_fetch_assoc($q);

if (!$d) {
    echo "<div class='container py-5 text-center'><h3>Berita tidak ditemukan</h3><a href='berita.php' class='btn btn-primary'>Kembali</a></div>";
    include 'includes/footer.php';
    exit;
}
?>

<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item"><a href="berita.php">Berita</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $d['judul']; ?></li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="mb-3"><?php echo $d['judul']; ?></h1>
                <p class="text-muted mb-4"><i class="bi bi-calendar-event me-2"></i> <?php echo date('d F Y', strtotime($d['tanggal'])); ?></p>
                
                <?php if ($d['gambar']): ?>
                    <img src="uploads/<?php echo $d['gambar']; ?>" class="img-fluid rounded shadow mb-4 w-100" alt="<?php echo $d['judul']; ?>">
                <?php endif; ?>

                <div class="content lh-lg">
                    <?php echo nl2br($d['isi']); ?>
                </div>

                <div class="mt-5">
                    <a href="berita.php" class="btn btn-outline-primary">&larr; Kembali ke Daftar Berita</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>