<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'C:\xampp\htdocs\RPL\db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $pesan = trim($_POST['pesan']);
    if (!empty($pesan)) {
        $stmt = $conn->prepare("INSERT INTO forum (username, pesan) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $pesan);
        $stmt->execute();
        header("Location: forum.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tulis Komentar</title>
    <link rel="stylesheet" href="tambah_komentar.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
<?php include 'sidebar.php'; ?>

<div class="content form-container">
    <h2>Tulis Komentar Baru</h2>
    <form action="tambah_komentar.php" method="POST">
        <textarea name="pesan" placeholder="Tulis komentar Anda..." rows="5" required></textarea>
        <button type="submit">Kirim</button>
        <a href="forum.php" class="cancel-button">Batal</a>
    </form>
</div>

</body>
</html>
