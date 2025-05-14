<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_GET['post_id'])) {
    header("Location: forum.php");
    exit();
}

include 'C:\xampp\htdocs\RPL\db.php';
$post_id = intval($_GET['post_id']);

// Ambil komentar utama
$post_query = $conn->query("SELECT * FROM forum WHERE id = $post_id");
$post = $post_query->fetch_assoc();

// Simpan balasan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isi = $conn->real_escape_string($_POST['isi']);
    $username = $conn->real_escape_string($_SESSION['username']);

    $conn->query("INSERT INTO forum_replies (post_id, username, isi) VALUES ($post_id, '$username', '$isi')");
    header("Location: reply.php?post_id=$post_id");
    exit();
}

// Ambil semua balasan
$replies_query = $conn->query("SELECT * FROM forum_replies WHERE post_id = $post_id ORDER BY waktu_post ASC");

function formatWaktu($datetime) {
    return date("H:i:s", strtotime($datetime));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Balas Komentar</title>
    <link rel="stylesheet" href="reply.css">
    <link rel="stylesheet" href="forum.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
<?php include 'sidebar.php'; ?>

<div class="main">
  <!-- HEADER -->
  <header class="topbar">
    <h1>Forum Diskusi</h1>
    <div class="header-right">
      Hai, <?php echo htmlspecialchars($_SESSION['username']); ?>!
    </div>
  </header>

    <div class="content">
        <h2>Komentar Utama</h2>
        <div class="forum-card">
            <div class="card-header">
                <span class="profile-icon">👤</span>
                <span class="username">Anonim</span>
                <span class="time"><?= formatWaktu($post['waktu_post']) ?></span>
            </div>
            <div class="card-body"><?= htmlspecialchars($post['pesan']) ?></div>
        </div>

        
        <?php while ($reply = $replies_query->fetch_assoc()): ?>
            <div class="reply-card">
                <div class="card-header">
                    <span class="profile-icon">👤</span>
                    <span class="username"><?= htmlspecialchars($reply['username']) ?></span>
                    <span class="time"><?= formatWaktu($reply['waktu_post']) ?></span>
                </div>
                <div class="card-body">
                    <?= htmlspecialchars($reply['isi']) ?>
                    <?php if ($_SESSION['username'] === $reply['username']): ?>
                        <a href="hapus_reply.php?reply_id=<?= $reply['id'] ?>&post_id=<?= $post_id ?>"
                            onclick="return confirm('Hapus balasan ini?')"
                            class="delete-icon">🗑</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>

        <h3>Tambahkan Balasan</h3>
        <form method="POST" class="reply-form">
            <textarea name="isi" placeholder="Tulis balasan..." required></textarea>
            <button type="submit">Kirim</button>
        </form>

        <br><a href="forum.php">← Kembali ke Forum</a>
    </div>
</body>
</html>
