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
    <title>Admin Dashboard - BKKBN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="../assets/img/logo_baru.png?v=<?php echo time(); ?>" type="image/png">
    <style>
        :root {
            --sidebar-width: 260px;
            --header-height: 70px;
            --primary-color: #3b82f6;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --text-body: #334155;
            --bg-body: #f8fafc;
            --header-bg: #ffffff;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --text-muted: #64748b;
            --text-title: #1e293b;
        }

        [data-theme="dark"] {
            --bg-body: #020617;
            --text-body: #cbd5e1;
            --header-bg: #0f172a;
            --card-bg: #0f172a;
            --border-color: #1e293b;
            --sidebar-bg: #0f172a;
            --text-muted: #94a3b8;
            --text-title: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-body);
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* --- Sidebar (Dark Theme) --- */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            color: #94a3b8;
            transition: all 0.3s ease;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-brand {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 24px;
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            background: rgba(0,0,0,0.1);
        }

        .sidebar-brand img {
            height: 32px;
            margin-right: 12px;
        }

        .sidebar-menu {
            padding: 24px 16px;
            overflow-y: auto;
            flex-grow: 1;
        }

        .menu-header {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            color: #475569;
            margin: 20px 12px 10px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #94a3b8;
            border-radius: 8px;
            margin-bottom: 4px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-link:hover {
            color: white;
            background-color: var(--sidebar-hover);
        }

        .nav-link.active {
            color: white;
            background-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .nav-link i {
            font-size: 1.25rem;
            margin-right: 12px;
            width: 24px;
            text-align: center;
        }

        /* --- Main Layout --- */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- Header (Top Navbar) --- */
        .header {
            height: var(--header-height);
            background: var(--header-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 1030;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .toggle-sidebar-btn {
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-muted);
            border: none;
            background: none;
            padding: 0;
        }

        .header-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 12px;
            border-radius: 50px;
            border: 1px solid var(--border-color);
            background: var(--header-bg);
            cursor: pointer;
            transition: all 0.2s;
        }

        .header-profile:hover {
            background: var(--bg-body);
            border-color: var(--text-muted);
        }

        .header-profile .text-dark {
            color: var(--text-title) !important;
        }

        .avatar {
            width: 36px;
            height: 36px;
            background: #eff6ff;
            color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* --- Content Area --- */
        .content {
            padding: 32px;
            flex-grow: 1;
        }

        .page-header {
            margin-bottom: 32px;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-title);
            margin: 0;
        }

        /* --- Cards --- */
        .card {
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border-radius: 12px;
            background: var(--card-bg);
            color: var(--text-body);
        }

        .card-header {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 20px 24px;
            border-radius: 12px 12px 0 0 !important;
            color: var(--text-title);
        }
        
        .card-header h5, .card-header h6 {
            color: var(--text-title) !important;
        }

        .card-body {
            padding: 24px;
        }

        /* Dark Mode Specific Overrides */
        [data-theme="dark"] .table {
            color: var(--text-body);
            border-color: var(--border-color);
        }
        
        [data-theme="dark"] .table > :not(caption) > * > * {
            background-color: transparent;
            color: var(--text-body);
            border-bottom-color: var(--border-color);
        }

        [data-theme="dark"] .form-control, 
        [data-theme="dark"] .form-select {
            background-color: var(--bg-body);
            border-color: var(--border-color);
            color: var(--text-body);
        }
        
        [data-theme="dark"] .form-control:focus, 
        [data-theme="dark"] .form-select:focus {
            background-color: var(--bg-body);
            color: var(--text-body);
            border-color: var(--primary-color);
        }

        [data-theme="dark"] .text-muted {
            color: var(--text-muted) !important;
        }

        [data-theme="dark"] .text-secondary {
            color: var(--text-muted) !important;
        }

        [data-theme="dark"] .bg-white {
            background-color: var(--card-bg) !important;
            color: var(--text-body) !important;
        }

        [data-theme="dark"] .bg-light {
            background-color: var(--bg-body) !important;
            color: var(--text-body) !important;
        }

        [data-theme="dark"] .text-dark {
            color: var(--text-title) !important;
        }
        
        [data-theme="dark"] .text-body {
            color: var(--text-body) !important;
        }

        /* Comprehensive Dark Mode Fixes */
        [data-theme="dark"] h1, 
        [data-theme="dark"] h2, 
        [data-theme="dark"] h3, 
        [data-theme="dark"] h4, 
        [data-theme="dark"] h5, 
        [data-theme="dark"] h6,
        [data-theme="dark"] .h1, 
        [data-theme="dark"] .h2, 
        [data-theme="dark"] .h3, 
        [data-theme="dark"] .h4, 
        [data-theme="dark"] .h5, 
        [data-theme="dark"] .h6 {
            color: var(--text-title) !important;
        }

        [data-theme="dark"] p, 
        [data-theme="dark"] span, 
        [data-theme="dark"] div,
        [data-theme="dark"] label,
        [data-theme="dark"] small,
        [data-theme="dark"] li,
        [data-theme="dark"] td,
        [data-theme="dark"] th {
            color: var(--text-body);
        }

        /* Specific fix for text visibility issues shown in screenshot */
        [data-theme="dark"] .text-dark {
            color: #f8fafc !important; /* Force white for 'text-dark' class */
        }
        
        [data-theme="dark"] .text-muted {
            color: #94a3b8 !important; /* Lighter gray for readability */
        }

        [data-theme="dark"] .text-secondary {
            color: #cbd5e1 !important;
        }

        /* Card & Container Fixes */
        [data-theme="dark"] .bg-white {
            background-color: var(--card-bg) !important;
            color: var(--text-body) !important;
        }

        [data-theme="dark"] .bg-light {
            background-color: #1e293b !important; /* Slightly lighter than card bg */
            color: var(--text-body) !important;
        }

        /* Form Inputs */
        [data-theme="dark"] .form-control, 
        [data-theme="dark"] .form-select {
            background-color: #020617; /* Darker than card */
            border-color: #334155;
            color: #f8fafc;
        }
        
        [data-theme="dark"] .form-control::placeholder {
            color: #64748b;
        }
        
        [data-theme="dark"] .input-group-text {
            background-color: #1e293b;
            border-color: #334155;
            color: #cbd5e1;
        }

        /* Modal Fixes */
        [data-theme="dark"] .modal-content {
            background-color: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-body);
        }
        
        [data-theme="dark"] .modal-header,
        [data-theme="dark"] .modal-footer {
            border-color: var(--border-color);
        }
        
        [data-theme="dark"] .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* --- Mobile Responsive --- */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .header {
                padding: 0 20px;
            }

            .content {
                padding: 20px;
            }

            /* Overlay when sidebar is open on mobile */
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1035;
                display: none;
                opacity: 0;
                transition: opacity 0.3s;
            }

            .sidebar-overlay.show {
                display: block;
                opacity: 1;
            }
        }
    </style>
</head>
<body>

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="../assets/img/logo_baru.png" alt="Logo">
            <span>Admin Panel</span>
        </div>
        
        <div class="sidebar-menu">
            <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>

            <div class="menu-header">KONTEN WEBSITE</div>
            
            <a href="berita.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'berita.php' ? 'active' : ''; ?>">
                <i class="bi bi-newspaper"></i>
                <span>Berita & Artikel</span>
            </a>
            <a href="galeri.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'galeri.php' ? 'active' : ''; ?>">
                <i class="bi bi-images"></i>
                <span>Galeri Foto</span>
            </a>
            <a href="poster.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'poster.php' ? 'active' : ''; ?>">
                <i class="bi bi-easel"></i>
                <span>Galeri Edukasi</span>
            </a>
            <a href="program.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'program.php' ? 'active' : ''; ?>">
                <i class="bi bi-list-check"></i>
                <span>Program Kerja</span>
            </a>

            <div class="menu-header">DATA INSTANSI</div>

            <a href="pejabat.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'pejabat.php' ? 'active' : ''; ?>">
                <i class="bi bi-people"></i>
                <span>Manajemen Pejabat</span>
            </a>
            <a href="profil.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'profil.php' ? 'active' : ''; ?>">
                <i class="bi bi-building"></i>
                <span>Profil Instansi</span>
            </a>

            <div class="menu-header">PENGATURAN</div>

            <a href="ganti_password.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'ganti_password.php' ? 'active' : ''; ?>">
                <i class="bi bi-shield-lock"></i>
                <span>Ganti Password</span>
            </a>
            <a href="logout.php" class="nav-link text-danger">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar</span>
            </a>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="header">
            <div class="d-flex align-items-center">
                <button class="toggle-sidebar-btn d-lg-none me-3" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                
                <!-- Breadcrumb / Title for Desktop -->
                <div class="d-none d-lg-block">
                    <span class="text-muted small"><?php echo date('l, d F Y'); ?></span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-link p-0 border-0" id="theme-toggle" onclick="toggleTheme()" style="color: var(--text-muted);">
                    <i class="bi bi-moon-stars fs-5"></i>
                </button>

                <div class="header-profile">
                    <div class="avatar">
                        <i class="bi bi-person"></i>
                    </div>
                    <div class="d-none d-sm-block ps-2 pe-1">
                        <div class="fw-bold text-dark small">Administrator</div>
                        <div class="text-muted" style="font-size: 0.7rem;">Super Admin</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Body -->
        <div class="content">
            <div class="page-header">
                <?php 
                $page = basename($_SERVER['PHP_SELF'], ".php");
                $title = $page == 'index' ? 'Dashboard Overview' : ucwords(str_replace('_', ' ', $page)); 
                ?>
                <h1 class="page-title"><?php echo $title; ?></h1>
            </div>
