<?php
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullname = trim($_POST['fullname'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $classid = $_POST['classid'] ?? '';
  $is_admin = isset($_POST['is_admin']);

  if ($fullname === '')
    $errors[] = 'Full Name wajib diisi.';
  if ($email === '')
    $errors[] = 'Email wajib diisi.';
  elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
    $errors[] = 'Format email tidak valid.';
  if ($password === '')
    $errors[] = 'Password wajib diisi.';
  if ($classid === '')
    $errors[] = 'Class ID wajib diisi.';

  if (empty($errors)) {
    $success = true;
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ImmaSpark – Create Account</title>
  <link rel="stylesheet" href="/css/responsive/admin.css">
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Poppins:wght@400;500;600&display=swap"
    rel="stylesheet" />
</head>

<body>
  <div class="bubbles" aria-hidden="true">
    <div class="b b1"></div>
    <div class="b b2"></div>
    <div class="b b3"></div>
    <div class="b b4"></div>
    <div class="b b5"></div>
    <div class="b b6"></div>
    <div class="b b7"></div>
    <div class="b b8"></div>
    <div class="b b9"></div>
    <div class="b b10"></div>
    <div class="b b11"></div>
    <div class="b b12"></div>
    <div class="b b13"></div>
    <div class="b b14"></div>
    <div class="b b15"></div>
    <div class="b b16"></div>
    <div class="b b17"></div>
  </div>

  <div class="card">
    <div class="logo-glow"></div>

    <div class="logo-wrap">
      <div class="logo">
        <?php
        $logo_path = 'logo.png';
        if (file_exists($logo_path)): ?>
          <img src="<?= htmlspecialchars($logo_path) ?>" alt="ImmaSpark Logo" />
        <?php else: ?>
          <!-- Fallback: SVG perisai jika file gambar belum ada -->
          <svg class="logo-shield-fallback" viewBox="0 0 52 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M26 2L4 11V30c0 13.2 9.4 25.6 22 29 12.6-3.4 22-15.8 22-29V11L26 2Z" fill="#1a5fa8" stroke="#fff"
              stroke-width="2" />
            <path d="M26 2L4 11V30c0 13.2 9.4 25.6 22 29 12.6-3.4 22-15.8 22-29V11L26 2Z" fill="url(#sg)" opacity=".55" />
            <rect x="23" y="13" width="6" height="22" rx="2" fill="white" opacity=".95" />
            <rect x="15" y="21" width="22" height="6" rx="2" fill="white" opacity=".95" />
            <rect x="18" y="38" width="16" height="2" rx="1" fill="#d4a820" />
            <rect x="20" y="42" width="12" height="2" rx="1" fill="#d4a820" opacity=".7" />
            <defs>
              <linearGradient id="sg" x1="4" y1="2" x2="48" y2="60" gradientUnits="userSpaceOnUse">
                <stop offset="0%" stop-color="#2176cc" />
                <stop offset="100%" stop-color="#0d3a6e" />
              </linearGradient>
            </defs>
          </svg>
        <?php endif; ?>

        <div class="logo-text">
          <small>SMK Kristen Immanuel</small>
          Imma<br>Spark
        </div>
      </div>
    </div>

    <?php if ($success): ?>
      <div class="alert alert-success">
        ✅ Akun berhasil dibuat untuk <strong><?= htmlspecialchars($fullname) ?></strong>!
      </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-error">
        <ul>
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST" action="">

      <!-- Full Name -->
      <div class="form-group">
        <label for="fullname">Full Name</label>
        <div class="input-wrap">
          <input type="text" id="fullname" name="fullname" placeholder="Enter your name"
            value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>" />
        </div>
      </div>

      <!-- Email -->
      <div class="form-group">
        <label for="email">Email</label>
        <div class="input-wrap">
          <input type="email" id="email" name="email" placeholder="Enter email"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
        </div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="pwd-wrap">
          <input type="password" id="password" name="password" placeholder="Enter password" />
          <span class="eye-label" title="Show/hide password (gunakan browser built-in)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
              <circle cx="12" cy="12" r="3" />
            </svg>
          </span>
        </div>
      </div>

      <div class="form-group">
        <label for="classid">Class ID</label>
        <div class="pwd-wrap">
          <input type="password" id="classid" name="classid" placeholder="Enter class ID" value="" />
          <span class="eye-label">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
              <circle cx="12" cy="12" r="3" />
            </svg>
          </span>
        </div>
      </div>

      <label class="check-wrap">
        <input type="checkbox" name="is_admin" value="1" <?= isset($_POST['is_admin']) ? 'checked' : '' ?> />
        <span>Is admin?</span>
      </label>

      <button type="submit" class="btn-create">Create</button>

    </form>

    <div class="page-footer">© 2026 Copyright. All rights reserved.</div>
  </div>

</body>

</html>