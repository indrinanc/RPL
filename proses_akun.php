<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database (ubah sesuai konfigurasi Anda)
$host = "localhost";
$user = "root";
$pass = "";
$db = "safevoice_db";

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$username = $_SESSION['username'];
$jurusan = $_POST['jurusan'];
$fakultas = $_POST['fakultas'];
$angkatan = $_POST['angkatan'];
$tanggal_lahir = $_POST['tanggal_lahir'];

// Simpan ke database (cek dulu apakah user sudah ada atau belum)
$sql_check = "SELECT * FROM users WHERE username = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $username);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    // Jika sudah ada, update data
    $sql_update = "UPDATE users SET jurusan=?, fakultas=?, angkatan=?, tanggal_lahir=? WHERE username=?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sssss", $jurusan, $fakultas, $angkatan, $tanggal_lahir, $username);
} else {
    // Jika belum ada, insert data baru
    $sql_insert = "INSERT INTO users (username, jurusan, fakultas, angkatan, tanggal_lahir) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("sssss", $username, $jurusan, $fakultas, $angkatan, $tanggal_lahir);
}

// Eksekusi dan alihkan ke dashboard
if ($stmt->execute()) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>