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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<div class="sidebar">
    <h2>SafeVoice</h2>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="forum.php">Forum Diskusi</a></li>
        <li><a href="pengaturan.php">Pengaturan</a></li>
        <li><a href="logout.php">Keluar</a></li>
    </ul>
</div>

<main class="main-content">
    <section class="form-section">
        <h2>Buat Laporan</h2>
        <form action="lapor.php" method="POST" enctype="multipart/form-data">
            <label for="topik">Topik</label>
            <input type="text" id="topik" name="topik" required>

            <label for="keterangan">Keterangan</label>
            <textarea id="keterangan" name="keterangan" rows="6" required></textarea>

            <label for="bukti">Unggah Bukti</label>
            <input type="file" id="bukti" name="bukti" accept="image/*,application/pdf">

            <button type="submit">Kirim</button>
        </form>
    </section>
</main>
</body>
</html>
