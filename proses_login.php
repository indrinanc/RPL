<?php
session_start(); // Jangan lupa session_start()
$koneksi = new mysqli("localhost", "root", "", "safevoice_db");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST['email'];
  $password = $_POST['password']; // Jangan di-hash lagi!

  $query = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($koneksi, $query);
  $user = mysqli_fetch_assoc($result);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['username'] = $user['username'];
    header("Location: dashboard.php");
    exit(); // Penting untuk menghentikan eksekusi setelah redirect
  } else {
    echo "<script>alert('Username atau password salah!'); window.history.back();</script>";
  }
}
?>
