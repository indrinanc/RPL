<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$hasil = $conn->query("SELECT * FROM forum ORDER BY waktu_post DESC");

function formatWaktu($datetime) {
    return date("H:i:s", strtotime($datetime));
}

// Ambil semua balasan dan kelompokkan berdasarkan post_id
$reply_result = $conn->query("SELECT * FROM forum_replies ORDER BY waktu_post ASC");
$replies_by_post = [];
while ($reply = $reply_result->fetch_assoc()) {
    $replies_by_post[$reply['post_id']][] = $reply;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Forum Diskusi - SafeVoice</title>
    <link rel="stylesheet" href="forum.css?v=2">
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

    <div class="forum-list">
        <?php while ($row = $hasil->fetch_assoc()): ?>
            <div class="forum-card">
                <div class="card-header">
                    <span class="profile-icon">👤</span>
                    <span class="username">Anonim</span>
                    <span class="time"><?= formatWaktu($row['waktu_post']) ?></span>
                </div>
                <div class="card-body"><?= htmlspecialchars($row['pesan']) ?></div>
                <div class="card-actions">
                <a href="like_post.php?post_id=<?= $row['id'] ?>" class="action-button">
                  👍 <?= $row['like_count'] ?>
                  <a href="hapus_post.php?post_id=<?= $row['id'] ?>" class="action-button" 
                  onclick="return confirm('Hapus komentar ini?')">🗑</a>
</a>

                   <a href="reply.php?post_id=<?= $row['id'] ?>" class="action-button">💬</a>
                </div>

                <!-- Tampilkan Balasan -->
                <?php if (isset($replies_by_post[$row['id']])): ?>
                    <div class="replies">
                        <?php foreach ($replies_by_post[$row['id']] as $reply): ?>
                            <div class="reply-card">
                                <div class="card-header">
                                    <span class="profile-icon">👤</span>
                                    <span class="username">Anonim</span>
                                    <span class="time"><?= formatWaktu($reply['waktu_post']) ?></span>
                
                          </div>
                          <div class="card-body"><?= htmlspecialchars($reply['isi']) ?></div>
                                
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>

    <a href="tambah_komentar.php" class="add-button">＋</a>
</div>

</body>
</html>
