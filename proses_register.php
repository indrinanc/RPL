<?php
$koneksi = new mysqli("localhost", "root", "", "safevoice_db");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  $query = "INSERT INTO users (email, username, password) VALUES ('$email', '$username', '$password')";
  $result = mysqli_query($koneksi, $query);

  if ($result) {
    header("Location: login.php");
  } else {
    echo "Registrasi gagal: " . mysqli_error($koneksi);
  }
}
?>
