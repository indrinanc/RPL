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

$message = "";

// Simpan data jika ada form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $jenis = $_POST['jenis_konseling'];
    $tanggal = $_POST['tanggal'] ?? null;
    $detail = $_POST['detail_janji'] ?? '';

    if ($jenis === 'jumpa' && $tanggal && $detail) {
        $stmt = $conn->prepare("INSERT INTO janji_temu (username, jenis_konseling, tanggal, detail) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $jenis, $tanggal, $detail);
        if ($stmt->execute()) {
            $message = "Janji berhasil dibuat!";
        } else {
            $message = "Gagal membuat janji.";
        }
        $stmt->close();
    } elseif ($jenis === 'chat') {
        $message = "Fitur chat belum diimplementasikan.";
    }
}

// Ambil semua janji temu user
$username = $_SESSION['username'];
$result = $conn->prepare("SELECT jenis_konseling, tanggal, detail, created_at FROM janji_temu WHERE username = ? ORDER BY created_at DESC");
$result->bind_param("s", $username);
$result->execute();
$janjiTemus = $result->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Konseling</title>
  <link rel="stylesheet" href="konseling.css">
  <link rel="stylesheet" href="global.css">
</head>
<body>
<?php include 'sidebar.php'; ?>

<div class="main">
  <!-- HEADER -->
  <header class="topbar">
    <h1>Konseling</h1>
    <div class="header-right">
      Hai, <?php echo htmlspecialchars($_SESSION['username']); ?>!
    </div>
  </header>


<div class="content">
  <div class="konseling-box">
    <h2>Konseling</h2>

    <?php if (!empty($message)): ?>
      <div class="alert"><?= $message ?></div>
    <?php endif; ?>

    <form id="formKonseling" method="POST">
  <label for="jenis">Jenis Konseling</label>
  <select name="jenis_konseling" id="jenis" required>
    <option value="">-- Pilih Jenis --</option>
    <option value="chat">Chat Konselor</option>
    <option value="jumpa">Jumpa Temu</option>
  </select>

  <div id="formJanji" style="display:none;">
    <label for="tanggal">Pilih Tanggal</label>
    <input type="date" name="tanggal" id="tanggal">

    <label for="detail">Detail Janji</label>
    <textarea name="detail_janji" id="detail" rows="3" placeholder="Masukkan detail janji..."></textarea>
  </div>

  <button type="button" id="submitButton" class="start-chat">Lanjut</button>
</form>


    <hr>

    <h3>Janji Temu Anda</h3>
    <?php if ($janjiTemus->num_rows > 0): ?>
      <ul class="janji-list">
        <?php while ($row = $janjiTemus->fetch_assoc()): ?>
          <li>
            <strong><?= ucfirst($row['jenis_konseling']) ?></strong><br>
            Tanggal: <?= date('d M Y', strtotime($row['tanggal'])) ?><br>
            Detail: <?= nl2br(htmlspecialchars($row['detail'])) ?><br>
            <small>Dibuat pada: <?= date('d M Y H:i', strtotime($row['created_at'])) ?></small>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
      <p>Belum ada janji temu.</p>
    <?php endif; ?>
  </div>
</div>

<script>
document.getElementById('jenis').addEventListener('change', function () {
  const formJanji = document.getElementById('formJanji');
  if (this.value === 'jumpa') {
    formJanji.style.display = 'block';
    document.querySelector('.start-chat').textContent = 'Buat Janji';
  } else {
    formJanji.style.display = 'none';
    document.querySelector('.start-chat').textContent = 'Mulai Chat';
  }
});
</script>

<script>
document.getElementById('jenis').addEventListener('change', function () {
  const formJanji = document.getElementById('formJanji');
  const btn = document.getElementById('submitButton');
  if (this.value === 'jumpa') {
    formJanji.style.display = 'block';
    btn.textContent = 'Buat Janji';
  } else {
    formJanji.style.display = 'none';
    btn.textContent = 'Mulai Chat';
  }
});

document.getElementById('submitButton').addEventListener('click', function () {
  const jenis = document.getElementById('jenis').value;
  if (jenis === 'chat') {
    window.location.href = 'chat.php';
  } else if (jenis === 'jumpa') {
    document.getElementById('formKonseling').submit();
  } else {
    alert('Silakan pilih jenis konseling terlebih dahulu.');
  }
});
</script>

</body>
</html>
<?php $conn->close(); ?>
