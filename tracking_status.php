<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>SafeVoice – Status Laporan</title>
  <!-- Font Awesome untuk ikon -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-p1CmQpVP3Rnm4KI4HAv/9Wx0JLs6YdoxI+uH0eKSCYx0kBc0hNLjF5Qg9kT2bS+hzctvP6ZmOHCkQeVozgrncA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />
  <link rel="stylesheet" href="traking_status.css" />
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div>
        <div class="logo">SafeVoice</div>
        <nav>
          <ul>
            <li class="active"><i class="fas fa-th-large"></i><span>Dashboard</span></li>
            <li><i class="fas fa-comments"></i><span>Forum Diskusi</span></li>
            <li><i class="fas fa-cog"></i><span>Pengaturan</span></li>
          </ul>
        </nav>
      </div>
      <div class="logout"><i class="fas fa-sign-out-alt"></i><span>Keluar</span></div>
    </aside>

    <!-- Main -->
    <main>
      <!-- Header -->
      <div class="main-header">
        <h1>Status Laporan</h1>
        <div class="header-icons">
          <i class="fas fa-envelope"></i>
          <i class="fas fa-bell"></i>
          <span>Pengguna</span>
        </div>
      </div>

      <!-- Status Card -->
      <div class="status-card">
        <h2>Status Laporan</h2>

        <!-- Pilih Topik -->
        <div class="form-group">
          <label for="topic-select">Topik</label>
          <select id="topic-select">
            <option value="" disabled selected>Topik</option>
            <option value="faq">FAQ Umum</option>
            <option value="bug">Laporan Bug</option>
            <option value="feature">Permintaan Fitur</option>
          </select>
          <div id="topic-desc">
            Answer the frequently asked question in a simple sentence, a longish paragraph, or even in a list.
          </div>
        </div>

        <!-- Pilih Laporan -->
        <div class="form-group">
          <label for="report-select">Laporan</label>
          <select id="report-select">
            <option value="" disabled selected>Topik</option>
            <option value="pending">Laporan #001</option>
            <option value="in_progress">Laporan #002</option>
            <option value="resolved">Laporan #003</option>
          </select>
          <div id="status-badge" class="badge">Status: Sedang di Proses</div>
        </div>

        <button class="btn-back" onclick="history.back()">Kembali</button>
      </div>
    </main>
  </div>
</body>
</html>
