<?php
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['id']) || !isset($_SESSION['user_type'])) {
    header('Location: login.php');
    exit();
}

// Get current user info
if ($_SESSION['user_type'] === 'users') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
} else {
    $stmt = $pdo->prepare("SELECT * FROM konselor WHERE id = ?");
}
$stmt->execute([$_SESSION['id']]);
$currentUser = $stmt->fetch();

// Determine chat partner
if ($_SESSION['user_type'] === 'users') {
    // User chatting with counselor - get first available counselor
    $stmt = $pdo->prepare("SELECT * FROM konselor LIMIT 1");
    $stmt->execute();
    $chatPartner = $stmt->fetch();
    $partnerType = 'konselor';
} else {
    // Counselor chatting with user - get user from session or URL
    if (isset($_GET['user_id'])) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $chatPartner = $stmt->fetch();
        $partnerType = 'users';
    } else {
        die("No user specified for counselor chat");
    }
}

// Get messages between current user and chat partner
$stmt = $pdo->prepare("
    SELECT * FROM pesan 
    WHERE ((sender_type = ? AND sender_id = ? AND receiver_type = ? AND receiver_id = ?)
    OR (sender_type = ? AND sender_id = ? AND receiver_type = ? AND receiver_id = ?))
    ORDER BY created_at ASC
");
$stmt->execute([
    $_SESSION['user_type'], $_SESSION['id'], $partnerType, $chatPartner[$partnerType.'id'],
    $partnerType, $chatPartner[$partnerType.'id'], $_SESSION['user_type'], $_SESSION['id']
]);
$messages = $stmt->fetchAll();

// Handle message submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['message']) && !empty($_POST['message'])) {
        $message = trim($_POST['message']);
        
        $stmt = $pdo->prepare("
            INSERT INTO messages (sender_type, sender_id, receiver_type, receiver_id, message)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $_SESSION['user_type'],
            $_SESSION['id'],
            $partnerType,
            $chatPartner[$partnerType.'id'],
            $message
        ]);
        
        header("Location: tes.php".($_SESSION['user_type'] === 'konselor' ? '?id='.$chatPartner['id'] : ''));
        exit();
    }
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $stmt = $pdo->prepare("
                INSERT INTO messages (sender_type, sender_id, receiver_type, receiver_id, image_path)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $_SESSION['user_type'],
                $_SESSION['id'],
                $partnerType,
                $chatPartner[$partnerType.'id'],
                $targetPath
            ]);
            
            header("Location: tes.php".($_SESSION['user_type'] === 'konselor' ? '?id='.$chatPartner['id'] : ''));
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Konseling - SafeVoice</title>
    <link rel="stylesheet" href="konsel_styles.css">
</head>
<body>
    <div class="chat-container">
        <div class="sidebar">
            <div class="logo">SafeVoice</div>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <?php if ($_SESSION['user_type'] === 'users'): ?>
                    <a href="forum.php">Forum Diskusi</a>
                <?php endif; ?>
                <a href="settings.php">Pengaturan</a>
                <a href="logout.php">Keluar</a>
            </nav>
        </div>
        
        <div class="chat-area">
            <div class="chat-header">
                <h2>Chat Konseling</h2>
                <p>Berbicara dengan <?php echo htmlspecialchars($chatPartner['username']); ?></p>
            </div>
            
            <div class="messages-container">
                <?php foreach ($messages as $message): ?>
                    <div class="message <?php echo ($message['sender_type'] == $_SESSION['user_type'] && $message['sender_id'] == $_SESSION['id']) ? 'sent' : 'received'; ?>">
                        <?php if (!empty($message['message'])): ?>
                            <p><?php echo htmlspecialchars($message['message']); ?></p>
                        <?php elseif (!empty($message['image_path'])): ?>
                            <img src="<?php echo htmlspecialchars($message['image_path']); ?>" alt="Gambar konseling" class="message-image">
                        <?php endif; ?>
                        <span class="time"><?php echo date('H:i', strtotime($message['created_at'])); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="message-input">
                <form action="chat.php<?php echo $_SESSION['user_type'] === 'counselor' ? '?user_id='.$chatPartner['user_id'] : ''; ?>" method="post" enctype="multipart/form-data">
                    <input type="text" name="message" placeholder="Ketik pesan Anda..." autocomplete="off">
                    <label for="image-upload" class="image-upload-label">
                        <span>📷</span>
                        <input type="file" id="image-upload" name="image" accept="image/*" style="display: none;">
                    </label>
                    <button type="submit">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>