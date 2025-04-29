<?php
session_start();
// Jika belum login, alihkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - SafeVoice</title>
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>
  <header class="header">
    <h1>Selamat Datang, Admin <?php echo $_SESSION['username']; ?> !</h1>
    <a href="logout.php" class="logout-button">Logout</a>
  </header>

  <main class="main-content">
    <section class="card">
      <h2>Pelapor</h2>
      <p>Laporkan kejadian kekerasan seksual yang Anda alami atau saksikan secara aman.</p>
      <a href="lapor.php" class="button">Lapor Sekarang</a>
    </section>

    <section class="card">
      <h2>Status Laporan</h2>
      <p>Lihat perkembangan dan tanggapan dari laporan yang telah Anda buat.</p>
      <a href="status_laporan.php" class="button">Lihat Status</a>
    </section>

    <section class="card">
      <h2>Bantuan & Konseling</h2>
      <p>Dapatkan akses ke layanan konseling dan bantuan psikologis secara rahasia dan aman.</p>
      <a href="konseling.php" class="button">Cari Bantuan</a>
    </section>

    <section class="card">
      <h2>Informasi dan Edukasi</h2>
      <p>Dapatkan informasi dan edukasi.</p>
      <a href="konseling.php" class="button">Cari Bantuan</a>
    </section>
  </main>

  <div class="sidebar">
  <h2>SafeVoice</h2>
  <ul>
    <li><a href="dashboard.php"><i class="icon">🏠</i> Dashboard</a></li>
    <li><a href="forum.php"><i class="icon">💬</i> Forum Diskusi</a></li>
    <li><a href="pengaturan.php"><i class="icon">⚙️</i> Pengaturan</a></li>
    <li><a href="logout.php"><i class="icon">🚪</i> Keluar</a></li>
   </ul>
   </div>

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


  <footer class="footer">
    <p>© 2025 SafeVoice. Semua Hak Dilindungi.</p>
  </footer>
</body>
</html>
