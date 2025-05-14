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
  <link rel="stylesheet" href="akun.css">
  <link rel="stylesheet" href="global.css">
</head>
<body>
<?php include 'sidebar.php'; ?>

  <main class="main-content">
  <div class="container">
    <div class="box">
      <h2 class="title">Data Diri</h2>
      <form method="POST" action="proses_akun.php">
        <a>Nama <?php echo $_SESSION['username']; ?> !</a>

        <label>Jurusan</label>
        <input type="text" name="jurusan" placeholder="Jurusan" required>

        <label>Fakultas</label>
        <input type="text" name="fakultas" placeholder="fakultas" required>

        <label>Angkatan</label>
        <input type="text" name="angkatan" placeholder="angkatan" required>

        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" placeholder="tanggal_lahir" required>

        <button type="submit" class="button">Simpan</button>
      </form>
      <p class="login-text"><a href="login.php">Logout</a></p>
    </div>
  </div>
</body>
</html>
