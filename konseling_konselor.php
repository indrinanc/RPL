<?php
$koneksi = new mysqli("localhost", "root", "", "safevoice_db");
$query = "SELECT * FROM janji_temu ORDER BY tanggal ASC";
$result = $koneksi->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Jumpa Temu</title>
    <link rel="stylesheet" href="konselor.css">
    <link rel="stylesheet" type="text/css" href="global.css">
</head>
<body>
 <?php include 'sidebar_3.php'; ?> 

<div class="main">
    <h2>Jadwal Jumpa Temu</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Jenis Konseling</th>
                    <th>Tanggal</th>
                    <th>Detail</th>
                    <th>Waktu Buat</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['jenis_konseling']) ?></td>
                        <td><?= htmlspecialchars(date('d-m-Y H:i', strtotime($row['tanggal']))) ?></td>
                        <td><?= htmlspecialchars($row['detail']) ?></td>
                        <td><?= htmlspecialchars(date('d-m-Y H:i', strtotime($row['created_at']))) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada janji temu yang terjadwal.</p>
    <?php endif; ?>
</div>
</body>
</html>
