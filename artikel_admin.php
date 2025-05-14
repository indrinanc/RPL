<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $kategori = $_POST['kategori_utama'];
    $subkategori = $_POST['subkategori'];
    $isi = $_POST['isi'];

    $gambar = '';
    if (!empty($_FILES['gambar']['name'])) {
        $targetDir = "uploads/";
        $gambarName = basename($_FILES["gambar"]["name"]);
        $targetFile = $targetDir . time() . "_" . $gambarName;

        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile)) {
            $gambar = $targetFile;
        }
    }

    $stmt = $conn->prepare("INSERT INTO artikel (judul, kategori_utama, subkategori, isi, gambar) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $judul, $kategori, $subkategori, $isi, $gambar);
    $stmt->execute();
    $stmt->close();
    header("Location: artikel_admin.php");
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $stmt = $conn->prepare("DELETE FROM artikel WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: artikel_admin.php");
}

$result = $conn->query("SELECT * FROM artikel ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Artikel - Admin</title>
    <link rel="stylesheet" type="text/css" href="style_artikel.css">
    <link rel="stylesheet" type="text/css" href="global.css">
</head>
<body>
<?php include 'sidebar_2.php'; ?>

<div class="main">
  <!-- HEADER -->
  <header class="header">
    <h1>Artikel</h1>
    <div class="header-right">
      Hai, <?php echo htmlspecialchars($_SESSION['username']); ?>
    </div>
  </header>

    <div class="container">
        <h1>Kelola Artikel</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="judul" placeholder="Judul Artikel" required><br>
            <select name="kategori_utama">
                <option value="Baca Artikel">Baca Artikel</option>
                <option value="Pencegahan">Pencegahan</option>
                <option value="Mengenali">Mengenali</option>
                <option value="Hukum">Hukum</option>
            </select><br>
            <input type="text" name="subkategori" placeholder="Subkategori" required><br>
            <textarea name="isi" placeholder="Isi artikel..." rows="6" required></textarea><br>
            <input type="file" name="gambar" accept="image/*"><br><br>
            <button type="submit" name="submit">Tambah Artikel</button>
        </form>
        
        <h2>Daftar Artikel</h2>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="artikel-item">
                <h3><?= htmlspecialchars($row['judul']) ?></h3>
                <small><?= htmlspecialchars($row['kategori_utama']) ?> - <?= htmlspecialchars($row['subkategori']) ?></small><br>
                <?php if (!empty($row['gambar'])): ?>
                    <img src="<?= htmlspecialchars($row['gambar']) ?>" alt="Gambar artikel: <?= htmlspecialchars($row['judul']) ?>" style="width: 100px; height: auto;">
                <?php endif; ?>
                <p><?= nl2br(htmlspecialchars(substr($row['isi'], 0, 100))) ?>...</p>
                <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus artikel ini?')">Hapus</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
