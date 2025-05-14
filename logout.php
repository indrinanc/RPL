<?php
session_start();

// Hapus semua data session
$_SESSION = [];

// Jika menggunakan cookie session, hapus juga cookie-nya
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// Akhiri session
session_destroy();

// Setelah logout, alihkan ke halaman login
header("Location: login.php");
exit;
?>