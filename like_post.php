<?php
session_start();
include 'C:\xampp\htdocs\RPL\db.php';

if (isset($_GET['post_id'])) {
    $post_id = intval($_GET['post_id']);

    // Tambah like
    $conn->query("UPDATE forum SET like_count = like_count + 1 WHERE id = $post_id");
}

header("Location: forum.php");
exit();
