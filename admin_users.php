<?php
session_start();
include 'koneksi.php';

// Proteksi: Hanya admin yang boleh masuk
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Logika Hapus Pengguna
if (isset($_GET['hapus'])) {
    $id_hapus = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    // Jangan biarkan admin menghapus dirinya sendiri
    if ($id_hapus != $_SESSION['user_id']) {
        mysqli_query($koneksi, "DELETE FROM users WHERE id = '$id_hapus'");
        header("Location: admin_users.php?status=terhapus");
    } else {
        header("Location: admin_users.php?status=gagal");
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Kelola Pengguna - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; overflow-x: hidden; }
        
        /* Sidebar Style - Identik dengan Dashboard */
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
    </style>
</head>
<body>

<div id="sidebar">
    <h4 class="fw-bold mb-4"><i class="bi bi-shield-lock me-2"></i>ADMIN PANEL</h4>
    <a href="dashboard_admin.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
    <a href="admin_users.php" class="active"><i class="bi bi-people me-2"></i>Kelola Pengguna</a>
    <a href="admin_projects.php"><i class="bi bi-folder me-2"></i>Semua Proyek</a>
    <a href="logout.php" class="logout"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a>
</div>

<div id="main">
    <div class="topbar d-flex justify-content-between">
        <div class="d-flex align-items-center">
            <button class="toggle-btn me-3" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <h5 class="fw-bold mb-0">Kelola Pengguna</h5>
        </div>
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-person-plus me-1"></i> Tambah User
            </button>
            <div class="text-muted small d-none d-md-block"><?php echo date('l, d F Y'); ?></div>
        </div>
    </div>

    <?php if(isset($_GET['status'])): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo ($_GET['status'] == 'terhapus') ? 'Pengguna berhasil dihapus.' : 'Aksi berhasil dilakukan.'; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 rounded-start">NIM / NIDN</th>
                        <th class="border-0">NAMA LENGKAP</th>
                        <th class="border-0 text-center">PERAN</th>
                        <th class="border-0 text-center rounded-end">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($koneksi, "SELECT * FROM users ORDER BY role ASC, nama ASC");
                    while ($row = mysqli_fetch_assoc($query)):
                    ?>
                    <tr>
                        <td class="fw-bold text-primary"><?php echo $row['nim_nidn']; ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($row['nama']); ?>&background=random" class="rounded-circle me-2" width="32">
                                <span class="fw-semibold"><?php echo $row['nama']; ?></span>
                            </div>
                        </td>
                        <td class="text-center">
                            <?php if($row['role'] == 'admin'): ?>
                                <span class="badge bg-dark px-3 rounded-pill">ADMIN</span>
                            <?php elseif($row['role'] == 'dosen'): ?>
                                <span class="badge bg-info-subtle text-info px-3 rounded-pill">DOSEN</span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary px-3 rounded-pill">MHS</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group gap-1">
                                <a href="admin_users.php?hapus=<?php echo $row['id']; ?>" 
                                   class="btn btn-sm btn-light border text-danger shadow-sm" 
                                   onclick="return confirm('Hapus user ini?')">
                                   <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="proses_tambah_user.php" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold">NIM / NIDN</label>
                    <input type="text" name="nim_nidn" class="form-control rounded-3" placeholder="Contoh: admin123" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">NAMA LENGKAP</label>
                    <input type="text" name="nama" class="form-control rounded-3" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">PASSWORD</label>
                    <input type="password" name="password" class="form-control rounded-3" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">PERAN (ROLE)</label>
                    <select name="role" class="form-select rounded-3" required>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="dosen">Dosen</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">Simpan User</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("hide");
        document.getElementById("main").classList.toggle("full");
    }
</script>
</body>
</html>