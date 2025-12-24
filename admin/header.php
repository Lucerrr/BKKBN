<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
require_once '../config/database.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - BKKBN Muna Barat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="../assets/img/logo_baru.png?v=<?php echo time(); ?>" type="image/png">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #0d47a1;
            --secondary-color: #1976d2;
            --text-light: #e3f2fd;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, #002171 100%);
            color: white;
            padding-top: 20px;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .sidebar-brand {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar-brand i {
            font-size: 1.5rem;
            color: #42a5f5;
        }
        
        .sidebar-brand span {
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
        }

        .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 25px;
            display: flex;
            align-items: center;
            font-weight: 400;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.05);
            padding-left: 30px;
        }

        .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
            border-left-color: #42a5f5;
            font-weight: 500;
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            transition: all 0.3s ease;
        }

        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 15px 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #f0f0f0;
            padding: 20px;
            font-weight: 600;
            color: #333;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            .sidebar.active {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Sidebar Toggle Overlay -->
    <div class="d-md-none position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50" id="sidebarOverlay" style="display: none; z-index: 999;"></div>

    <div class="container-fluid p-0">
        <nav class="sidebar">
            <div class="sidebar-brand">
                <i class="bi bi-shield-check"></i>
                <span>Admin Panel</span>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'berita.php' ? 'active' : ''; ?>" href="berita.php">
                        <i class="bi bi-newspaper"></i> Berita & Kegiatan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'profil.php' ? 'active' : ''; ?>" href="profil.php">
                        <i class="bi bi-building"></i> Profil Instansi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'pejabat.php' ? 'active' : ''; ?>" href="pejabat.php">
                        <i class="bi bi-people-fill"></i> Manajemen Pejabat
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'program.php' ? 'active' : ''; ?>" href="program.php">
                        <i class="bi bi-list-check"></i> Program Kerja
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'galeri.php' ? 'active' : ''; ?>" href="galeri.php">
                        <i class="bi bi-images"></i> Galeri Foto
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'poster.php' ? 'active' : ''; ?>" href="poster.php">
                        <i class="bi bi-easel"></i> Galeri Edukasi
                    </a>
                </li>
                
                <li class="nav-item mt-4">
                    <div class="px-4 mb-2 text-white-50 small text-uppercase fw-bold" style="font-size: 0.75rem;">Akun</div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'ganti_password.php' ? 'active' : ''; ?>" href="ganti_password.php">
                        <i class="bi bi-key"></i> Ganti Password
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <main class="main-content">
            <!-- Top Navbar -->
            <div class="top-navbar">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link d-md-none text-dark p-0 me-3" onclick="document.querySelector('.sidebar').classList.toggle('active')">
                        <i class="bi bi-list fs-3"></i>
                    </button>
                    <h5 class="m-0 fw-bold text-secondary">
                        <?php 
                        $page = basename($_SERVER['PHP_SELF'], ".php");
                        echo $page == 'index' ? 'Dashboard Overview' : ucwords(str_replace('_', ' ', $page)); 
                        ?>
                    </h5>
                </div>
                <div class="user-profile">
                    <div class="text-end me-3 d-none d-md-block">
                        <div class="fw-bold text-dark small">Administrator</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Super Admin</div>
                    </div>
                    <div class="user-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                </div>
            </div>
