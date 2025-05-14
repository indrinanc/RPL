<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$query = "SELECT topik, keterangan, status_laporan, bukti  FROM laporan WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Status Laporan - SafeVoice</title>
  <link rel="stylesheet" href="status_laporan.css" />
  <link rel="stylesheet" href="global.css" />
</head>
<body>
<?php include 'sidebar.php'; ?>

<div class="main">
  <!-- HEADER -->
  <header class="header">
    <h1>Status Laporan</h1>
    <div class="header-right">
      Hai, <?php echo htmlspecialchars($_SESSION['username']); ?>!
    </div>
  </header>

<div class="content">

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card">
            <strong>Topik:</strong>
            <p><?= htmlspecialchars($row['topik']) ?></p>
            <strong>Keterangan:</strong>
            <p><?= htmlspecialchars($row['keterangan']) ?></p>
            <strong>Bukti:</strong><br>
        <?php
            $bukti_path = 'uploads/' . htmlspecialchars($row['bukti']);
            $ext = pathinfo($bukti_path, PATHINFO_EXTENSION);
            $allowed_img = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (in_array(strtolower($ext), $allowed_img)) {
                $modal_id = 'popup-' . md5($bukti_path); // ID unik
                echo "
                <a href='#$modal_id'>
                    <img src='$bukti_path' alt='Bukti Laporan' class='thumbnail' />
                </a>
                <div id='$modal_id' class='popup'>
                    <a href='#' class='overlay'></a>
                    <div class='popup-content'>
                        <img src='$bukti_path' alt='Bukti Full'>
                    </div>
                </div>";
            } else {
                echo "<a href='$bukti_path' target='_blank'>Lihat Bukti</a>";
            }
        ?>
            <div class="status-badge">
                Status: <?= htmlspecialchars($row['status_laporan']) ?>
            </div>
        </div>
    <?php endwhile; ?>

    <a href="dashboard.php"><button class="btn-back">Kembali</button></a>
</div>

</body>
</html>