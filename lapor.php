<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "safevoice_db");

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $topik = $_POST['topik'];
    $keterangan = $_POST['keterangan'];

    // Proses upload file
    $namaFile = $_FILES['bukti']['name'];
    $tmpFile = $_FILES['bukti']['tmp_name'];
    $path = "uploads/" . $namaFile; // pastikan folder uploads/ sudah ada

    if (move_uploaded_file($tmpFile, $path)) {
        // Simpan ke database
        $query = "INSERT INTO laporan (username, topik, keterangan, bukti) VALUES ('".$_SESSION['username']."', '$topik', '$keterangan', '$namaFile')";
        $koneksi->query($query);

        echo "<script>alert('Laporan berhasil dikirim!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal upload bukti!'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Buat Laporan - SafeVoice</title>
  <link rel="stylesheet" href="lapor.css"/>
  <link rel="stylesheet" href="global.css"/>
</head>
<body>
<?php include 'sidebar.php'; ?>

<div class="main">
  <!-- HEADER -->
  <header class="header">
    <h1>Buat Laporan</h1>
    <div class="header-right">
      Hai, <?php echo htmlspecialchars($_SESSION['username']); ?>!
    </div>
  </header>

  <main class="main-content">
    <div class="form-container">
      <form action="lapor.php" method="post" enctype="multipart/form-data">
        <!-- Topik -->
        <div class="form-group">
          <label for="topik">Topik</label>
          <input type="text" id="topik" name="topik" required>
        </div>

        <!-- Keterangan -->
        <div class="form-group">
          <label for="keterangan">Keterangan</label>
          <textarea id="keterangan" name="keterangan" required></textarea>
        </div>

        <!-- Unggah Bukti -->
        <div class="form-group">
          <label for="bukti">Unggah Bukti</label>
          <input type="file" id="bukti" name="bukti" required>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-submit">Kirim</button>
      </form>
    </div>
  </main>
</div>

</body>
</html>
