<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <div class="box">
      <h2 class="title">Login</h2>
      <form action="proses_login.php" method="POST">
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Masukkan Email" required>

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Masukkan Password" required>

        <div class="forgot-password">
          <a href="#">Lupa Password</a>
        </div>

        <button type="submit" class="button">Masuk</button>
      </form>

      <p class="register-text">Belum Punya Akun? <a href="register.php">Daftar</a></p>
    </div>
  </div>
</body>
</html>
