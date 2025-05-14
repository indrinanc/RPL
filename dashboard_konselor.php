<?php
session_start();
$nama = $_SESSION['username'] ?? 'Konselor';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Konselor</title>
    <link rel="stylesheet" type="text/css" href="konselor.css">
    <link rel="stylesheet" type="text/css" href="global.css">
</head>
<body>
 <?php include 'sidebar_3.php'; ?> 
 
 <div class="main">
  <!-- HEADER -->
  <header class="topbar">
    <h1>DashBoard Konselor</h1>
    <div class="header-right">
    </div>
  </header>

    <div class="content">
        <div class="welcome-box">Hai, <?= htmlspecialchars($nama) ?></div>
        <div class="items-container">
            <a href="chat_konselor.php" class="card">Pesan Konseling</a>
            <a href="konseling_konselor.php" class="card">Jadwal Jumpa Temu</a>
        </div>
    </div>
</div>
</body>
</html>
