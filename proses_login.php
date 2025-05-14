<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "safevoice_db");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Cek di tabel admin
  $queryAdmin = "SELECT * FROM admin WHERE email = ? AND password = ?";
    $stmtAdmin = $koneksi->prepare($queryAdmin);
    $stmtAdmin->bind_param("ss", $email, $password);
    $stmtAdmin->execute();
    $resultAdmin = $stmtAdmin->get_result();
    $admin = $resultAdmin->fetch_assoc();

    if ($admin) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['username'] = $admin['username'];
        $_SESSION['role'] = 'admin';
        header("Location: dashboard_admin.php");
        exit();
    }

    // Cek di tabel admin
    $queryKonselor = "SELECT * FROM konselor WHERE email = ? AND password = ?";
    $stmtKonselor = $koneksi->prepare($queryKonselor);
    $stmtKonselor->bind_param("ss", $email, $password);
    $stmtKonselor->execute();
    $resultKonselor = $stmtKonselor->get_result();
    $konselor = $resultKonselor->fetch_assoc();

    if ($konselor) {
        $_SESSION['user_id'] = $konselor['id'];
        $_SESSION['username'] = $konselor['username'];
        $_SESSION['role'] = 'konselor';
        header("Location: dashboard_konselor.php");
        exit();
    }

  // Cek di tabel users (pengguna biasa)
  $query = "SELECT * FROM users WHERE email = ?";
  $stmt = $koneksi->prepare($query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user && password_verify($password, $user['password'])) {
      $_SESSION['username'] = $user['username'];
      $_SESSION['role'] = 'user';
      $query = "SELECT * FROM users WHERE jurusan = ?";
      if (empty($user['jurusan'])){
        header("Location: akun.php");
        exit();
      }
      header("Location: dashboard.php");
      exit();
  }

  // Jika tidak ditemukan di keduanya
  echo "<script>alert('Email atau password salah!'); window.history.back();</script>";
}
?>
