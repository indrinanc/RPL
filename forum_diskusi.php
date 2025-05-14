<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>SafeVoice - Forum Diskusi</title>
  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-p1CmQpVP3Rnm4KI4HAv/9Wx0JLs6YdoxI+uH0eKSCYx0kBc0hNLjF5Qg9kT2bS+hzctvP6ZmOHCkQeVozgrncA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />
  <link rel="stylesheet" href="forum_diskusi.css">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div>
        <div class="logo">SafeVoice</div>
        <nav>
          <ul>
            <li><i class="fas fa-th-large"></i><span>Dashboard</span></li>
            <li class="active"><i class="fas fa-comments"></i><span>Forum Diskusi</span></li>
            <li><i class="fas fa-cog"></i><span>Pengaturan</span></li>
          </ul>
        </nav>
      </div>
      <div class="logout"><i class="fas fa-sign-out-alt"></i><span>Keluar</span></div>
    </aside>

    <!-- Main Content -->
    <main>
      <!-- Header -->
      <div class="main-header">
        <h1>Dashboard</h1>
        <div class="header-icons">
          <i class="fas fa-envelope"></i>
          <i class="fas fa-bell"></i>
          <span>Pengguna</span>
        </div>
      </div>

      <!-- Forum Card -->
      <div class="forum-card" id="forum-card">
        <!-- List of posts -->
        <div id="posts-list">
          <div class="post">
            <div class="avatar"></div>
            <div class="content">
              <div class="meta"><strong>Anonim</strong> · 1 jam yang lalu</div>
              <div class="text">Lorem ipsum dolor sit amet.</div>
            </div>
            <div class="actions">
              <i class="far fa-thumbs-up"></i>
              <i class="far fa-comment-dots"></i>
            </div>
          </div>
          <div class="post">
            <div class="avatar"></div>
            <div class="content">
              <div class="meta"><strong>Anonim</strong> · 1 jam yang lalu</div>
              <div class="text">Lorem ipsum dolor sit amet.</div>
            </div>
            <div class="actions">
              <i class="far fa-thumbs-up"></i>
              <i class="far fa-comment-dots"></i>
            </div>
          </div>
          <!-- ... bisa diperbanyak -->
        </div>

        <!-- Tombol + -->
        <button class="add-btn" id="add-btn">+</button>

        <!-- Compose Form -->
        <div class="compose" id="compose">
          <textarea placeholder="Masukkan Pesan"></textarea>
          <div class="toggle-group">
            <label class="switch">
              <input type="checkbox" id="anon-toggle">
              <span class="slider"></span>
            </label>
            <label for="anon-toggle">Unggah Sebagai Anonim</label>
          </div>
          <button class="send-btn">Kirim</button>
        </div>
      </div>
    </main>
  </div>

  <script>
    const addBtn   = document.getElementById('add-btn');
    const posts    = document.getElementById('posts-list');
    const compose  = document.getElementById('compose');

    addBtn.addEventListener('click', () => {
      posts.style.display   = posts.style.display === 'none' ? 'block' : 'none';
      compose.classList.toggle('active');
      addBtn.textContent    = compose.classList.contains('active') ? '×' : '+';
    });
  </script>
</body>
</html>
