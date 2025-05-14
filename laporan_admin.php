<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $selected_status = $_POST['status'];

    // Konversi value select ke label enum
    switch ($selected_status) {
        case 'terima':
            $status_laporan = "Laporan Diterima";
            break;
        case 'proses':
            $status_laporan = "Laporan Sedang Diproses";
            break;
        case 'selesai':
            $status_laporan = "Selesai";
            break;
        default:
            $status_laporan = null;
    }

    if ($status_laporan) {
        $laporan_id = $_POST['laporan_id'];
        $update = $conn->prepare("UPDATE laporan SET status_laporan = ? WHERE id = ?");
        $update->bind_param("si", $status_laporan, $laporan_id);
        $update->execute();
    }
}

$query = "SELECT id, username, topik, keterangan, bukti, status_laporan FROM laporan";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Status Laporan</title>
    <link rel="stylesheet" href="laporan_admin.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
<?php include 'sidebar_2.php'; ?>

 <div class="main">
  <!-- HEADER -->
  <header class="header">
    <h1>Admin Status Laporan</h1>
    <div class="header-right">
      Hai, <?php echo htmlspecialchars($_SESSION['username']); ?>!
    </div>
  </header>


<div class="content">

    <?php while ($row = $result->fetch_assoc()): ?>
    <form method="POST" class="card">
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
            <label for="status">Status: </label>
            <select name="status" required>
                <option value="terima" <?= $row['status_laporan'] === 'Laporan Diterima' ? 'selected' : '' ?>>Laporan Diterima</option>
                <option value="proses" <?= $row['status_laporan'] === 'Laporan Sedang Diproses' ? 'selected' : '' ?>>Laporan Sedang Diproses</option>
                <option value="selesai" <?= $row['status_laporan'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
            </select>
        </div>

        <input type="hidden" name="laporan_id" value="<?= $row['id'] ?>">
        <button type="submit" name="update_status" class="simpan">Lanjut</button>
    </form>
<?php endwhile; ?>


    <a href="dashboard.php"><button class="btn-back">Kembali</button></a>
</div>

</body>
</html>