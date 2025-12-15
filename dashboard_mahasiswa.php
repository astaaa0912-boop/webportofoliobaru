<?php
session_start();
if ($_SESSION['role'] != "mahasiswa") {
    header("Location: login.php");
}
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title></title>
  <link rel="stylesheet" href="dashboard_mhs.css">
</head>
<body>

  <div id="overlay" class="overlay"></div>

  <aside id="sidebar" class="sidebar">
    <div class="sidebar-top">
      <h1 class="brand">Portofolio</h1>
      <button id="closeSidebar" class="icon-btn close-btn" aria-label="Tutup sidebar">✕</button>
    </div>

    <nav class="nav">
      <a href="dashboard_mahasiswa.php" class="nav-item">Dashboard Mahasiswa</a>
      <a href="#proyek-saya" class="nav-item">Proyek Saya</a>
      <a href="#" class="nav-item">Penilaian</a>
      <a href="profilemhs.html" class="nav-item">Profil</a>
      <a href="pengaturanmhs.php" class="nav-item">Pengaturan</a>
    </nav>

    <div class="sidebar-bottom">
    <a href="login.html" class="logout">Logout</a>
    </div>
  </aside>

  <header class="topbar">
    <button id="openSidebar" class="icon-btn menu-btn" aria-label="Buka sidebar">☰</button>
    <div class="topbar-title">Dashboard Mahasiswa</div>
    
    <div class="topbar-actions">
        <div class="topbar-logo">
            <img src="logo.png" alt="Logo Kampus"> 
        </div>
    </div>
    </header>

  <main class="main">
    <section class="hero">
      <div class="hero-inner">
        <h2>Selamat Datang</h2>
        <p>Kelola project Anda dan lihat progress penilaian dosen</p>
        <div class="hero-actions">
          <button class="btn btn-white">Upload Proyek</button>
        </div>
      </div>
    </section>

        <section class="section" id="proyek-saya">
      <h3 class="section-title">Proyek Saya</h3>

      <div class="grid">
   
        <article class="card">
          <img src="https://picsum.photos/600/350?random=1" alt="proyek">
          <div class="card-body">
            <h4>Proyek 1</h4>
            <p class="muted">Deskripsi singkat proyek mahasiswa</p>
            <div class="card-actions">
              <button class="btn btn-outline">Lihat Detail</button>
              <button class="btn btn-primary">Lihat Penilaian</button>
            </div>
          </div>
        </article>

        <article class="card">
          <img src="https://picsum.photos/600/350?random=2" alt="proyek">
          <div class="card-body">
            <h4>Proyek 2</h4>
            <p class="muted">Deskripsi singkat proyek mahasiswa</p>
            <div class="card-actions">
              <button class="btn btn-outline">Lihat Detail</button>
              <button class="btn btn-primary">Lihat Penilaian</button>
            </div>
          </div>
        </article>

        <article class="card">
          <img src="https://picsum.photos/600/350?random=3" alt="proyek">
          <div class="card-body">
            <h4>Proyek 3</h4>
            <p class="muted">Deskripsi singkat proyek mahasiswa</p>
            <div class="card-actions">
              <button class="btn btn-outline">Lihat Detail</button>
              <button class="btn btn-primary">Lihat Penilaian</button>
            </div>
          </div>
        </article>

        <article class="card">
          <img src="https://picsum.photos/600/350?random=1" alt="proyek">
          <div class="card-body">
            <h4>Proyek 4</h4>
            <p class="muted">Deskripsi singkat proyek mahasiswa</p>
            <div class="card-actions">
              <button class="btn btn-outline">Lihat Detail</button>
              <button class="btn btn-primary">Lihat Penilaian</button>
            </div>
          </div>
        </article>

        <article class="card">
          <img src="https://picsum.photos/600/350?random=2" alt="proyek">
          <div class="card-body">
            <h4>Proyek 5</h4>
            <p class="muted">Deskripsi singkat proyek mahasiswa</p>
            <div class="card-actions">
              <button class="btn btn-outline">Lihat Detail</button>
              <button class="btn btn-primary">Lihat Penilaian</button>
            </div>
          </div>
        </article>

        <article class="card">
          <img src="https://picsum.photos/600/350?random=3" alt="proyek">
          <div class="card-body">
            <h4>Proyek 6</h4>
            <p class="muted">Deskripsi singkat proyek mahasiswa</p>
            <div class="card-actions">
              <button class="btn btn-outline">Lihat Detail</button>
              <button class="btn btn-primary">Lihat Penilaian</button>
            </div>
          </div>
        </article>
        
      </div>
    </section>
  </main>
</body>
</html>
