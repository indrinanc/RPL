<?php
$koneksi = new mysqli("localhost", "root", "", "safevoice_db");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$query = "SELECT DISTINCT pengirim FROM pesan_chat WHERE pengirim_role = 'user'";
$result = $koneksi->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pesan Konseling</title>
    <link rel="stylesheet" href="chat_konselor.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
 <?php include 'sidebar_3.php'; ?>    

<div class="main">
    <h2>Pesan Konseling</h2>
    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <a href="pesan_chat.php?user=<?= urlencode($row['pengirim']) ?>">
                        <?= htmlspecialchars($row['pengirim']) ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Tidak ada pesan masuk.</p>
    <?php endif; ?>
</div>
</body>
</html>
