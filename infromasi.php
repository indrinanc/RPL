<?php
include 'db.php';

$result = $conn->query("SELECT * FROM artikel ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Informasi - SafeVoice</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .container {
            width: 90%;
            margin: auto;
            font-family: Arial, sans-serif;
        }
        .artikel-item {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            background: #f9f9f9;
        }
        .artikel-item h3 {
            margin: 0;
        }
        .artikel-item img {
            max-width: 300px;
            height: auto;
            margin-top: 10px;
        }
        .kategori {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Informasi Edukasi</h1>

        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="artikel-item">
                <h3><?= htmlspecialchars($row['judul']) ?></h3>
                <div class="kategori"><?= htmlspecialchars($row['kategori_utama']) ?> | <?= htmlspecialchars($row['subkategori']) ?></div>
                
                <?php if (!empty($row['gambar'])): ?>
                    <img src="<?= htmlspecialchars($row['gambar']) ?>" alt="Gambar artikel: <?= htmlspecialchars($row['judul']) ?>">
                <?php endif; ?>
                
                <p><?= nl2br(htmlspecialchars($row['isi'])) ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
