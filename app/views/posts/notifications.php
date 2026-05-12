<?php

$notifications = [
    ['id' => 1, 'from_user' => 'CHRISTOPHER', 'action' => 'Give you a feedback', 'description' => 'Lorem ipsum dolor sit amet', 'date' => '13/06/2026', 'post_id' => 1],
    ['id' => 2, 'from_user' => 'CHRISTOPHER', 'action' => 'Give you a feedback', 'description' => 'Lorem ipsum dolor sit amet', 'date' => '13/06/2026', 'post_id' => 1],
    ['id' => 3, 'from_user' => 'CHRISTOPHER', 'action' => 'Give you a feedback', 'description' => 'Lorem ipsum dolor sit amet', 'date' => '13/06/2026', 'post_id' => 2],
    ['id' => 4, 'from_user' => 'CHRISTOPHER', 'action' => 'Give you a feedback', 'description' => 'Lorem ipsum dolor sit amet', 'date' => '13/06/2026', 'post_id' => 2],
    ['id' => 5, 'from_user' => 'CHRISTOPHER', 'action' => 'Give you a feedback', 'description' => 'Lorem ipsum dolor sit amet', 'date' => '13/06/2026', 'post_id' => 1],
    ['id' => 6, 'from_user' => 'CHRISTOPHER', 'action' => 'Give you a feedback', 'description' => 'Lorem ipsum dolor sit amet', 'date' => '13/06/2026', 'post_id' => 3],
    ['id' => 7, 'from_user' => 'CHRISTOPHER', 'action' => 'Give you a feedback', 'description' => 'Lorem ipsum dolor sit amet', 'date' => '13/06/2026', 'post_id' => 1],
    ['id' => 8, 'from_user' => 'CHRISTOPHER', 'action' => 'Give you a feedback', 'description' => 'Lorem ipsum dolor sit amet', 'date' => '13/06/2026', 'post_id' => 4],
];

$is_dyslexic = false; 
$user_name = 'test'; 
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - ImmaSpark</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Space+Mono:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/css/responsive/notifications.css">
</head>

<body class="<?php echo $is_dyslexic ? 'dyslexic' : ''; ?>">

    <aside class="sidebar">
        <div class="logo-wrap">
            <img src="" alt="Immaspark" class="logo-img">
        </div>

        <hr class="sidebar-divider">

        <nav class="sidebar-nav">
            <a href="explore.php" class="nav-item">
                <i class="fas fa-globe"></i>
                <span>Explore</span>
            </a>
            <a href="latest.php" class="nav-item">
                <i class="fas fa-sun"></i>
                <span>Latest</span>
            </a>
            <a href="pinned.php" class="nav-item">
                <i class="fas fa-star"></i>
                <span>Pinned</span>
            </a>
            <a href="popular.php" class="nav-item">
                <i class="fas fa-circle-notch"></i>
                <span>Popular</span>
            </a>
        </nav>

        <hr class="sidebar-divider">

        <nav class="sidebar-nav">
            <a href="create-post.php" class="nav-item">
                <i class="fas fa-pen-to-square"></i>
                <span>Create a Post</span>
            </a>
            <a href="your-posts.php" class="nav-item">
                <i class="fas fa-paste"></i>
                <span>Your Posts</span>
            </a>
            <a href="notifications.php" class="nav-item active">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
            </a>
        </nav>

        <hr class="sidebar-divider">

        <div class="sidebar-nav">
            <div class="nav-item toggle-item">
                <i class="fas fa-a"></i>
                <span>Dyslexic</span>
                <label class="toggle-switch">
                    <input type="checkbox" id="dyslexicToggle" <?php echo $is_dyslexic ? 'checked' : ''; ?>>
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>

        <hr class="sidebar-divider">

        <nav class="sidebar-nav">
            <a href="logout.php" class="nav-item">
                <i class="fas fa-right-from-bracket"></i>
                <span>Logout</span>
            </a>
        </nav>

    </aside>

    <main class="main-content">

        <div class="bg-deco">
            <div class="bg-blob bg-blob-red"></div>
            <div class="bg-blob bg-blob-blue"></div>
        </div>

        <div class="search-wrap">
            <div class="search-bar">
                <i class="fas fa-magnifying-glass search-icon"></i>
                <input type="text" placeholder="Enter search terms" class="search-input">
            </div>
        </div>

        <div class="notif-container">
            <?php if (empty($notifications)): ?>
                <div class="notif-empty">
                    <i class="fas fa-bell-slash"></i>
                    <p>Tidak ada notifikasi.</p>
                </div>
            <?php else: ?>
                <?php foreach ($notifications as $notif): ?>
                    <div class="notif-item">
                        <div class="notif-row notif-row-top">
                            <div class="notif-user">
                                <div class="notif-avatar">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <span class="notif-title">
                                    <?php echo htmlspecialchars($notif['from_user']); ?>
                                    <?php echo htmlspecialchars($notif['action']); ?>
                                </span>
                            </div>
                            <span class="notif-date"><?php echo htmlspecialchars($notif['date']); ?></span>
                        </div>
                        <div class="notif-row notif-row-bottom">
                            <span class="notif-desc"><?php echo htmlspecialchars($notif['description']); ?></span>
                            <a href="post.php?id=<?php echo (int) $notif['post_id']; ?>" class="btn-reply">Reply</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </main>

    <script>
        const dyslexicToggle = document.getElementById('dyslexicToggle');
        dyslexicToggle.addEventListener('change', () => {
            document.body.classList.toggle('dyslexic', dyslexicToggle.checked);
            fetch('toggle-dyslexic.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ is_dyslexic: dyslexicToggle.checked ? 1 : 0 })
            });
        });
    </script>
</body>

</html>