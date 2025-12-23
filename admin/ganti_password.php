<?php
include 'header.php';

$msg = "";
$msg_type = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $admin_id = $_SESSION['admin_id'];

    // Ambil data user saat ini
    $query = mysqli_query($conn, "SELECT password FROM users WHERE id = '$admin_id'");
    $user = mysqli_fetch_assoc($query);

    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            if (strlen($new_password) >= 6) {
                $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $update = mysqli_query($conn, "UPDATE users SET password = '$new_hash' WHERE id = '$admin_id'");
                
                if ($update) {
                    $msg = "Password berhasil diubah!";
                    $msg_type = "success";
                } else {
                    $msg = "Gagal mengubah password: " . mysqli_error($conn);
                    $msg_type = "danger";
                }
            } else {
                $msg = "Password baru minimal 6 karakter.";
                $msg_type = "warning";
            }
        } else {
            $msg = "Konfirmasi password baru tidak cocok.";
            $msg_type = "danger";
        }
    } else {
        $msg = "Password saat ini salah.";
        $msg_type = "danger";
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold text-primary">
                        <i class="bi bi-key me-2"></i>Ganti Password
                    </h5>
                </div>
                <div class="card-body p-4">
                    <?php if ($msg): ?>
                        <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
                            <?php echo $msg; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <div class="form-text">Minimal 6 karakter.</div>
                        </div>
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Simpan Password Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm border-0 bg-primary bg-opacity-10">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-primary mb-3">
                        <i class="bi bi-shield-lock me-2"></i>Keamanan Akun
                    </h5>
                    <p class="text-muted mb-4">
                        Menjaga keamanan akun admin sangat penting untuk melindungi data website. Berikut beberapa tips password yang kuat:
                    </p>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Gunakan minimal 8 karakter</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Kombinasikan huruf besar dan kecil</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Gunakan angka dan simbol</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Jangan gunakan tanggal lahir atau nama umum</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>