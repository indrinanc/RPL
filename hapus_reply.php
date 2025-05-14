<?php
session_start();
include 'C:\xampp\htdocs\RPL\db.php';

if (!isset($_SESSION['username']) || !isset($_GET['reply_id']) || !isset($_GET['post_id'])) {
    header("Location: forum.php");
    exit();
}

$reply_id = intval($_GET['reply_id']);
$post_id = intval($_GET['post_id']);

// Optional: pastikan hanya pemilik komentar yang bisa hapus
$result = $conn->query("SELECT username FROM forum_replies WHERE id = $reply_id");
$row = $result->fetch_assoc();

if (!$row || $_SESSION['username'] !== $row['username']) {
    die("Tidak diizinkan menghapus balasan ini.");
}

// Hapus balasan
$conn->query("DELETE FROM forum_replies WHERE id = $reply_id");

header("Location: reply.php?post_id=$post_id");
exit();
