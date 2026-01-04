<?php
session_start();
include 'koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Logika Hapus Proyek
if (isset($_GET['hapus'])) {
    $id_proyek = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    
    // Ambil nama file sebelum dihapus agar bisa menghapus file fisiknya
    $query_file = mysqli_query($koneksi, "SELECT file_proyek FROM projects WHERE id = '$id_proyek'");
    $data_file = mysqli_fetch_assoc($query_file);
    
    if ($data_file) {
        $path = "uploads/" . $data_file['file_proyek'];
        if (file_exists($path) && !empty($data_file['file_proyek'])) {
            unlink($path); 
        }
        
        mysqli_query($koneksi, "DELETE FROM projects WHERE id = '$id_proyek'");
        header("Location: admin_projects.php?status=terhapus");
        exit();
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Semua Proyek - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; overflow-x: hidden; }
        
        /* Sidebar Style - Konsisten dengan Dashboard */
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

        .project-card { background: #fff; border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.03); }
    </style>
</head>
<body>

<div id="sidebar">
    <h4 class="fw-bold mb-4"><i class="bi bi-shield-lock me-2"></i>ADMIN PANEL</h4>
    <a href="dashboard_admin.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
    <a href="admin_users.php"><i class="bi bi-people me-2"></i>Kelola Pengguna</a>
    <a href="admin_projects.php" class="active"><i class="bi bi-folder me-2"></i>Semua Proyek</a>
    <a href="logout.php" class="logout"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a>
</div>

<div id="main">
    <div class="topbar d-flex justify-content-between">
        <div class="d-flex align-items-center">
            <button class="toggle-btn me-3" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <h5 class="fw-bold mb-0">Monitoring Semua Proyek</h5>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-primary rounded-pill px-3">
                Total: <?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM projects")); ?> Proyek
            </span>
            <div class="text-muted small d-none d-md-block"><?php echo date('l, d F Y'); ?></div>
        </div>
    </div>

    <?php if(isset($_GET['status'])): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 rounded-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> Data proyek dan file berhasil dihapus.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card project-card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr class="small text-muted">
                        <th class="border-0 rounded-start">MAHASISWA</th>
                        <th class="border-0">JUDUL PROYEK</th>
                        <th class="border-0">TANGGAL UPLOAD</th>
                        <th class="border-0">STATUS NILAI</th>
                        <th class="border-0 text-center rounded-end">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT projects.*, users.nama as nama_mhs 
                            FROM projects 
                            JOIN users ON projects.user_id = users.id 
                            ORDER BY projects.id DESC";
                    $result = mysqli_query($koneksi, $sql);

                    while ($p = mysqli_fetch_assoc($result)):
                        $tanggal = isset($p['created_at']) ? date('d/m/Y', strtotime($p['created_at'])) : '--/--/----';
                        $file = isset($p['file_proyek']) ? $p['file_proyek'] : '#';
                    ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($p['nama_mhs']); ?>&background=random" width="32" class="me-2 rounded-circle shadow-sm">
                                <span class="fw-bold small text-uppercase"><?php echo $p['nama_mhs']; ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold"><?php echo $p['judul']; ?></div>
                            <small class="text-muted"><?php echo isset($p['deskripsi']) ? substr($p['deskripsi'], 0, 40) . '...' : ''; ?></small>
                        </td>
                        <td class="small"><?php echo $tanggal; ?></td>
                        <td>
                            <?php if(empty($p['nilai'])): ?>
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 rounded-pill">
                                    <i class="bi bi-clock me-1"></i>Belum
                                </span>
                            <?php else: ?>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 rounded-pill">
                                    <i class="bi bi-check-circle me-1"></i>Skor: <?php echo $p['nilai']; ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group gap-1">
                                </a>
                                <a href="admin_projects.php?hapus=<?php echo $p['id']; ?>" class="btn btn-sm btn-light border text-danger shadow-sm" onclick="return confirm('Hapus proyek ini secara permanen?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>

                    <?php if(mysqli_num_rows($result) == 0): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada proyek yang diunggah mahasiswa.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Fungsi Sidebar Toggle - Sama dengan Dashboard Admin
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("hide");
        document.getElementById("main").classList.toggle("full");
    }
</script>
</body>
</html>