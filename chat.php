<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "safevoice_db");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$pengguna = $_SESSION['username'];
$role = 'user';  // Role pengguna

// Simpan pesan teks
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['pesan'])) {
    $pesan = trim($_POST['pesan']);
    $penerima = 'konselor';
    $stmt = $conn->prepare("INSERT INTO pesan_chat (pengirim, pengirim_role, penerima, pesan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $pengguna, $role, $penerima, $pesan);
    $stmt->execute();
    $stmt->close();
}

// Simpan pesan gambar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
    $file_name = $_FILES['gambar']['name'];
    $file_tmp = $_FILES['gambar']['tmp_name'];
    $file_type = $_FILES['gambar']['type'];

    $allowed_extensions = array("jpeg", "jpg", "png", "gif");
    $tmp = explode('.', $file_name);
    $file_extension = strtolower(end($tmp));

    if (in_array($file_extension, $allowed_extensions)) {
        $imgContent = file_get_contents($file_tmp);
        $pesan = "[GAMBAR: " . $file_name . "]";
        $penerima = 'konselor';
        $stmt = $conn->prepare("INSERT INTO pesan_chat (pengirim, pengirim_role, penerima, pesan, gambar, tipe_gambar) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $pengguna, $role, $penerima, $pesan, $imgContent, $file_type);
        $stmt->execute();
        $stmt->close();
    }
}

// Ambil semua pesan dari dan ke pengguna (asumsinya konselor cuma satu)
$stmt = $conn->prepare("
    SELECT * FROM pesan_chat 
    WHERE (pengirim = ? AND penerima = 'konselor') 
       OR (pengirim = 'konselor' AND penerima = ?)
    ORDER BY waktu_kirim ASC
");
$stmt->bind_param("ss", $pengguna, $pengguna);
$stmt->execute();
$pesan_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Chat Konselor</title>
    <link rel="stylesheet" href="chat.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
<?php include 'sidebar.php'; ?>

<div class="main">
  <!-- HEADER -->
  <header class="topbar">
    <h1>Chat Konseling</h1>
    <div class="header-right">
      Hai, <?php echo htmlspecialchars($_SESSION['username']); ?>!
    </div>
  </header>

<div class="content">
    <div class="chat-box">
        <div class="chat-header">Konselor</div>

        <div class="chat-messages" id="chat-messages">
            <?php while ($row = $pesan_result->fetch_assoc()): ?>
                <div class="chat-bubble <?= $row['pengirim_role'] === 'user' ? 'user' : 'konselor' ?>">
                    <?php if (!empty($row['gambar'])): ?>
                        <img src="data:<?= $row['tipe_gambar'] ?>;base64,<?= base64_encode($row['gambar']) ?>" alt="Uploaded Image" style="max-width: 200px; max-height: 200px;">
                    <?php else: ?>
                        <span><?= htmlspecialchars($row['pesan']) ?></span>
                    <?php endif; ?>
                    <div class="time"><?= date('H:i', strtotime($row['waktu_kirim'])) ?></div>
                </div>
            <?php endwhile; ?>
        </div>

        <form class="chat-form" method="POST" enctype="multipart/form-data">
            <label for="file-upload" class="file-upload-btn">＋</label>
            <input type="file" name="gambar" id="file-upload" accept="image/*" style="display:none">
            <input type="text" name="pesan" placeholder="Ketik pesan..." autocomplete="off" />
            <button type="submit">➤</button>
        </form>
    </div>
</div>

<script>
    const chatMessages = document.getElementById('chat-messages');
    chatMessages.scrollTop = chatMessages.scrollHeight;

    document.getElementById('file-upload').onchange = function () {
        if (this.files && this.files[0]) {
            document.querySelector('.chat-form').submit();
        }
    };
</script>

</body>
</html>

<?php $conn->close(); ?>
