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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - SafeVoice</title>
  <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
  
  <!-- SIDEBAR tetap sama -->
  <div class="sidebar">
    <div class="logo">SafeVoice</div>
    <div class="sidebar-menu">
      <ul>
        <li><a href="dashboard.php"><span class="icon">🏠</span><span>Dashboard</span></a></li>
        <li><a href="forum_admin.php"><span class="icon">💬</span><span>Forum Diskusi</span></a></li>
      </ul>
    </div>
    <ul class="sidebar-logout">
      <li><a href="logout.php"><span class="icon">🚪</span><span>Logout</span></a></li>
    </ul>
  </div>

  <div class="main">
  <header class="header">
    <h1>Selamat Datang, Admin <?php echo $_SESSION['username']; ?> !</h1>
    <a href="login.php" class="logout-button">Logout</a>
  </header>

  <main class="main-content">
    <div class="greeting-card">
        Hai, <?php echo htmlspecialchars($_SESSION['username']); ?>!
      </div>
    

      <section class="actions">
        <div class="action-card">
          <h2>Laporan Masuk</h2>
          <a href="laporan_admin.php" class="action-btn">Cek Laporan Masuk</a>
    </div>

      <div class="action-card">
        <h2>Artikel</h2>
        <a href="artikel_admin.php" class="action-btn">List Artikel</a>
      </div>
    </section>
  </div>
</main>
</body>
</html>
