<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Dashboard - SafeVoice</title>
  <link rel="stylesheet" href="dashboarduser.css"/>
</head>
<body>
  <!-- SIDEBAR tetap sama -->
  <div class="sidebar">
    <div class="logo">SafeVoice</div>
    <div class="sidebar-menu">
      <ul>
        <li><a href="dashboard.php"><span class="icon">🏠</span><span>Dashboard</span></a></li>
        <li><a href="forum.php"><span class="icon">💬</span><span>Forum Diskusi</span></a></li>
        <li><a href="akun.php"><span class="icon">⚙️</span><span>Pengaturan</span></a></li>
      </ul>
    </div>
    <ul class="sidebar-logout">
      <li><a href="logout.php"><span class="icon">🚪</span><span>Logout</span></a></li>
    </ul>
  </div>

  <!-- MAIN: gunakan class .main sesuai CSS -->
  <div class="main">
    <!-- HEADER -->
    <header class="header">
      <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
      <a href="logout.php" class="logout-button">Logout</a>
    </header>

    <!-- KONTEN UTAMA -->
    <main class="main-content">
      <!-- Greeting Card -->
      <div class="greeting-card">
        Hai, <?php echo htmlspecialchars($_SESSION['username']); ?>!
      </div>

      <!-- ACTION CARDS: class .actions & .action-card -->
      <section class="actions">
        <div class="action-card">
          <h2>Lapor Insiden</h2>
          <p>Laporkan kejadian kekerasan seksual yang Anda alami.</p>
          <a href="lapor.php" class="action-btn">Lapor Sekarang</a>
        </div>
        <div class="action-card">
          <h2>Status Laporan</h2>
          <p>Lihat perkembangan dan tanggapan dari laporan Anda.</p>
          <a href="status_laporan.php" class="action-btn">Lihat Status</a>
        </div>
        <div class="action-card">
          <h2>Bantuan & Konseling</h2>
          <p>Dapatkan akses ke layanan konseling secara aman.</p>
          <a href="konseling.php" class="action-btn">Cari Bantuan</a>
        </div>
        <div class="action-card">
          <h2>Informasi & Edukasi</h2>
          <p>Dapatkan informasi dan edukasi.</p>
          <a href="edukasi.php" class="action-btn">Baca Info</a>
        </div>
      </section>

      <!-- Related Articles -->
      <section class="related-articles">
        <h2>Artikel Terkait</h2>
        <div class="article-card">
          <h3>Judul Artikel 1</h3>
          <p>Ringkasan singkat tentang artikel ini. Klik untuk membaca lebih lanjut.</p>
          <a href="#" class="read-more">Baca Selengkapnya</a>
        </div>
        <div class="article-card">
          <h3>Judul Artikel 2</h3>
          <p>Ringkasan singkat tentang artikel ini. Klik untuk membaca lebih lanjut.</p>
          <a href="#" class="read-more">Baca Selengkapnya</a>
        </div>
      </section>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
      <p>© 2025 SafeVoice. Semua Hak Dilindungi.</p>
    </footer>
  </div>
</body>
</html>