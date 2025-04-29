<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar - SafeVoice</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <div class="box">
      <h2 class="title">Daftar</h2>
      <form method="POST" action="proses_register.php">
        <label>Email</label>
        <input type="email" name="email" placeholder="Masukkan Email" required>

        <label>Username</label>
        <input type="text" name="username" placeholder="Masukkan Username" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Masukkan Password" required>

        <button type="submit" class="button">Daftar</button>
      </form>
      <p class="login-text">Sudah Punya Akun? <a href="login.php">Login</a></p>
    </div>
  </div>
</body>
</html>
