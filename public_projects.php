<?php
include 'koneksi.php';
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Portofolio Mahasiswa </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body { background: #f6f8fc; }
        .navbar-public { background: #243b64; padding: 15px 0; }
        .hero-section { background: #243b64; color: #fff; padding: 60px 0; border-radius: 0 0 50px 50px; margin-bottom: 40px; }
        .project-card { 
            border: none; 
            border-radius: 15px; 
            transition: 0.3s; 
            overflow: hidden; 
            background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .project-card:hover { transform: translateY(-10px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
        .project-card img { height: 180px; object-fit: cover; }
        .search-box { 
            margin-top: -30px; 
            background: #fff; 
            padding: 20px; 
            border-radius: 15px; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.1); 
        }
        .badge-jurusan { position: absolute; top: 15px; left: 15px; padding: 5px 12px; border-radius: 20px; font-size: 0.7rem; }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-public shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="bi bi-mortarboard-fill me-2"></i>PORTOFOLIO</a>
            <div class="ms-auto">
                <a href="login.php" class="btn btn-outline-light btn-sm px-4 rounded-pill">Login</a>
            </div>
        </div>
    </nav>

    <header class="hero-section text-center">
        <div class="container">
            <h1 class="fw-bold display-5">Eksplorasi Karya Mahasiswa</h1>
            <p class="opacity-75">Inspirasi, Inovasi, dan Kreativitas dalam satu platform digital.</p>
        </div>
    </header>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 search-box">
                <form action="" method="GET" class="row g-2">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="cari" class="form-control border-0" placeholder="Cari judul proyek atau nama mahasiswa..." value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100 rounded-pill">Cari Proyek</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-5 g-4">
            <?php
            $keyword = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : '';
            
            // Query mengambil proyek beserta nama mahasiswa
            $sql = "SELECT projects.*, users.nama 
                    FROM projects 
                    JOIN users ON projects.user_id = users.id 
                    WHERE projects.judul LIKE '%$keyword%' OR users.nama LIKE '%$keyword%'
                    ORDER BY projects.id DESC";
            
            $result = mysqli_query($koneksi, $sql);

            if(mysqli_num_rows($result) > 0):
                while($p = mysqli_fetch_assoc($result)):
                    // Warna badge dinamis
                    $badgeClass = [
                        "Teknik Informatika" => "bg-primary",
                        "Teknik Elektro" => "bg-warning text-dark",
                        "Teknik Mesin" => "bg-success",
                        "Manajemen dan Bisnis" => "bg-danger"
                    ][$p['jurusan']] ?? "bg-secondary";
            ?>
            
            <div class="col-md-6 col-lg-3">
                <div class="card project-card h-100">
                    <span class="badge <?php echo $badgeClass; ?> badge-jurusan shadow-sm"><?php echo $p['jurusan']; ?></span>
                    <img src="uploads/<?php echo $p['gambar']; ?>" class="card-img-top" alt="Gambar Proyek">
                    <div class="card-body d-flex flex-column">
                        <h6 class="fw-bold mb-1 text-dark"><?php echo $p['judul']; ?></h6>
                        <p class="small text-muted mb-3"><i class="bi bi-person me-1"></i><?php echo $p['nama']; ?></p>
                        <p class="small text-secondary flex-grow-1">
                            <?php echo substr($p['deskripsi'], 0, 90); ?>...
                        </p>
                        <hr class="opacity-25">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted" style="font-size: 0.7rem;">
                                <i class="bi bi-calendar3 me-1"></i><?php echo date('d M Y', strtotime($p['waktu'])); ?>
                            </small>
                            <a href="detail_proyek_public.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php 
                endwhile; 
            else: 
            ?>
                <div class="col-12 text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" width="100" class="opacity-25 mb-3">
                    <p class="text-muted">Maaf, proyek yang Anda cari tidak ditemukan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="mt-5 py-4 bg-white border-top">
        <div class="container text-center">
            <p class="text-muted small mb-0">&copy; <?php echo date('Y'); ?> Portofolio Hub Mahasiswa. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>