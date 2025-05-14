<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || !isset($_GET['post_id'])) {
    header("Location: forum.php");
    exit();
}

$post_id = intval($_GET['post_id']);

// Hapus balasan terkait dulu (agar foreign key tidak error)
$conn->query("DELETE FROM forum_replies WHERE post_id = $post_id");

// Hapus postingan utama
$conn->query("DELETE FROM forum WHERE id = $post_id");

header("Location: forum.php");
exit();
