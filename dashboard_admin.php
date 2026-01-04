<?php
session_start();
include 'koneksi.php';

// Proteksi: Hanya admin yang boleh masuk
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil Statistik Global
$total_mhs = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM users WHERE role='mahasiswa'"));
$total_dosen = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM users WHERE role='dosen'"));
$total_proyek = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM projects"));
$belum_dinilai = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM projects WHERE nilai IS NULL"));
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Admin Panel - Portofolio Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; overflow-x: hidden; }
        
        /* Sidebar Style */
        #sidebar { width: 260px; height: 100vh; background: #1c2d3d; position: fixed; left: 0; top: 0; color: #fff; padding: 20px; transition: 0.3s; z-index: 1000; }
        #sidebar.hide { left: -260px; }
        #sidebar h4 { color: #fff; font-size: 1.2rem; border-bottom: 1px solid #2c3e50; padding-bottom: 15px; }
        #sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 12px; border-radius: 8px; margin-bottom: 5px; transition: 0.2s; }
        #sidebar a:hover, #sidebar a.active { background: #3498db; color: #fff; }
        #sidebar .logout { color: #e74c3c; margin-top: 30px; border-top: 1px solid #2c3e50; padding-top: 15px; }

        /* Main Content */
        #main { margin-left: 260px; padding: 25px; transition: 0.3s; }
        #main.full { margin-left: 0; }

        /* Topbar Style */
        .topbar { background: #fff; border-radius: 12px; padding: 10px 20px; display: flex; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 25px; }
        .toggle-btn { background: #f0f2f5; border: none; border-radius: 8px; padding: 5px 10px; color: #1c2d3d; cursor: pointer; }

        /* Card Customization */
        .stat-card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); }
        .stat-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
    </style>
</head>
<body>

<div id="sidebar">
    <h4 class="fw-bold mb-4"><i class="bi bi-shield-lock me-2"></i>ADMIN PANEL</h4>
    <a href="dashboard_admin.php" class="active"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
    <a href="admin_users.php"><i class="bi bi-people me-2"></i>Kelola Pengguna</a>
    <a href="admin_projects.php"><i class="bi bi-folder me-2"></i>Semua Proyek</a>
    <a href="logout.php" class="logout"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a>
</div>

<div id="main">
    <div class="topbar d-flex justify-content-between">
        <div class="d-flex align-items-center">
            <button class="toggle-btn me-3" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <h5 class="fw-bold mb-0">Selamat Datang, <?php echo $_SESSION['role']; ?></h5>
        </div>
        <div class="text-muted small"><?php echo date('l, d F Y'); ?></div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary text-white shadow-sm"><i class="bi bi-person-badge"></i></div>
                    <div class="ms-3">
                        <h3 class="fw-bold mb-0"><?php echo $total_dosen; ?></h3>
                        <small class="text-muted">Total Dosen</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success text-white shadow-sm"><i class="bi bi-people"></i></div>
                    <div class="ms-3">
                        <h3 class="fw-bold mb-0"><?php echo $total_mhs; ?></h3>
                        <small class="text-muted">Mahasiswa</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning text-white shadow-sm"><i class="bi bi-journal-code"></i></div>
                    <div class="ms-3">
                        <h3 class="fw-bold mb-0"><?php echo $total_proyek; ?></h3>
                        <small class="text-muted">Total Proyek</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-danger text-white shadow-sm"><i class="bi bi-hourglass-split"></i></div>
                    <div class="ms-3">
                        <h3 class="fw-bold mb-0"><?php echo $belum_dinilai; ?></h3>
                        <small class="text-muted">Antrean Nilai</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-0">Pengguna Terbaru</h5>
            </div>
            <a href="admin_users.php" class="btn btn-sm btn-primary px-3 rounded-pill">Kelola Semua</a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 rounded-start">NAMA LENGKAP</th>
                        <th class="border-0">PERAN</th>
                        <th class="border-0 text-center rounded-end">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $users = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC LIMIT 5");
                    while($u = mysqli_fetch_assoc($users)):
                    ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($u['nama']); ?>&background=random" class="rounded-circle me-2" width="32">
                                <span class="fw-semibold"><?php echo $u['nama']; ?></span>
                            </div>
                        </td>
                        <td>
                            <?php if($u['role'] == 'admin'): ?>
                                <span class="badge bg-dark">ADMIN</span>
                            <?php elseif($u['role'] == 'dosen'): ?>
                                <span class="badge bg-info-subtle text-info">DOSEN</span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary">MHS</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="admin_users.php?edit=<?php echo $u['id']; ?>" class="btn btn-sm btn-light border shadow-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("hide");
        document.getElementById("main").classList.toggle("full");
    }
</script>
</body>
</html>