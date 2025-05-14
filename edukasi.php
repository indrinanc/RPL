<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "safevoice_db");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
if (!empty($kategori)) {
    $query = "SELECT * FROM artikel WHERE kategori_utama = ? ORDER BY tanggal DESC";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $kategori);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT * FROM artikel ORDER BY tanggal DESC";
    $result = $koneksi->query($query);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Informasi dan Edukasi</title>
    <link rel="stylesheet" href="edukasi.css?v=1.0">
    <link rel="stylesheet" href="global.css">
</head>
<body>
<?php include 'sidebar.php'; ?>


    <div class="main">
  <!-- HEADER -->
  <header class="topbar">
    <h1>Informasi & Edukasi</h1>
    <div class="header-right">
      Hai, <?php echo htmlspecialchars($_SESSION['username']); ?>!
    </div>
  </header>
    <div class="kategori-tabs">
        <a href="edukasi.php?kategori=Baca Artikel">Baca Artikel</a>
        <a href="edukasi.php?kategori=Pencegahan">Pencegahan</a>
        <a href="edukasi.php?kategori=Mengenali">Mengenali</a>
        <a href="edukasi.php?kategori=Hukum">Hukum</a>
    </div>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="artikel">
            <?php if (!empty($row['gambar'])): ?>
                <img src="<?= htmlspecialchars($row['gambar']) ?>" alt="Gambar Artikel">
            <?php endif; ?>

            <div class="judul"><?= htmlspecialchars($row['judul']) ?></div>
            <div class="info">
                Kategori: <?= htmlspecialchars($row['kategori_utama']) ?> |
                Subkategori: <?= htmlspecialchars($row['subkategori']) ?> |
                Tanggal: <?= htmlspecialchars($row['tanggal']) ?>
            </div>
            <div class="isi"><?= nl2br(htmlspecialchars($row['isi'])) ?></div>
        </div>
    <?php endwhile; ?>

    <?php $koneksi->close(); ?>
</body>
</html>