<?php

$avatar_seeds = ['christopher', 'alex', 'morgan', 'jordan', 'taylor', 'riley', 'casey', 'dana'];

$notifications = [
    [
        'id' => 1,
        'user' => 'CHRISTOPHER',
        'action' => 'Give you a feedback',
        'body' => 'Lorem ipsum dolor sit amet',
        'date' => '13/06/2026',
        'unread' => true,
        'seed' => 'christopher',
    ],
    [
        'id' => 2,
        'user' => 'CHRISTOPHER',
        'action' => 'Give you a feedback',
        'body' => 'Lorem ipsum dolor sit amet',
        'date' => '13/06/2026',
        'unread' => false,
        'seed' => 'alex',
    ],
    [
        'id' => 3,
        'user' => 'CHRISTOPHER',
        'action' => 'Give you a feedback',
        'body' => 'Lorem ipsum dolor sit amet',
        'date' => '13/06/2026',
        'unread' => true,
        'seed' => 'morgan',
    ],
    [
        'id' => 4,
        'user' => 'CHRISTOPHER',
        'action' => 'Give you a feedback',
        'body' => 'Lorem ipsum dolor sit amet',
        'date' => '13/06/2026',
        'unread' => false,
        'seed' => 'jordan',
    ],
    [
        'id' => 5,
        'user' => 'CHRISTOPHER',
        'action' => 'Give you a feedback',
        'body' => 'Lorem ipsum dolor sit amet',
        'date' => '13/06/2026',
        'unread' => false,
        'seed' => 'taylor',
    ],
    [
        'id' => 6,
        'user' => 'CHRISTOPHER',
        'action' => 'Give you a feedback',
        'body' => 'Lorem ipsum dolor sit amet',
        'date' => '13/06/2026',
        'unread' => true,
        'seed' => 'riley',
    ],
    [
        'id' => 7,
        'user' => 'CHRISTOPHER',
        'action' => 'Give you a feedback',
        'body' => 'Lorem ipsum dolor sit amet',
        'date' => '13/06/2026',
        'unread' => false,
        'seed' => 'casey',
    ],
    [
        'id' => 8,
        'user' => 'CHRISTOPHER',
        'action' => 'Give you a feedback',
        'body' => 'Lorem ipsum dolor sit amet',
        'date' => '13/06/2026',
        'unread' => false,
        'seed' => 'dana',
    ],
];

$logo_colors = ['#1A56DB', '#E53E3E', '#047857', '#7C3AED', '#B45309'];
$logo_bg = $logo_colors[array_rand($logo_colors)];

function avatarUrl(string $seed): string
{
    return "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($seed) . "&backgroundColor=b6e3f4,c0aede,d1d4f9";
}


$current_page = 'notifications';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications — ImmaSpark</title>
    <link rel="stylesheet" href="/css/responsive/notifications.css">
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='8' fill='%231A56DB'/><text x='16' y='22' font-size='14' text-anchor='middle' fill='white' font-family='monospace' font-weight='bold'>IS</text></svg>">
</head>

<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="sidebar-logo">
                <div class="logo-badge" style="background: <?= htmlspecialchars($logo_bg) ?>;">
                                                   <img src="/assets/image/logo/logo.png" alt="">
                </div>
                <div style="line-height:1.15;">
                    <div
                        style="color:rgba(255,255,255,0.7);font-family:'Space Mono',monospace;font-size:14px;font-weight:400;letter-spacing:-0.5px;">
                        </div>
                </div>
            </div>

            <div class="sidebar-divider"></div>

            <nav class="nav-section" style="margin-bottom:10px;">
                <a href="#" class="nav-item <?= $current_page === 'explore' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                        <path d="M2 12h20" />
                    </svg>
                    <span>Explore</span>
                </a>
                <a href="#" class="nav-item <?= $current_page === 'latest' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="5" />
                        <line x1="12" y1="1" x2="12" y2="3" />
                        <line x1="12" y1="21" x2="12" y2="23" />
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
                        <line x1="1" y1="12" x2="3" y2="12" />
                        <line x1="21" y1="12" x2="23" y2="12" />
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
                    </svg>
                    <span>Latest</span>
                </a>
                <a href="#" class="nav-item <?= $current_page === 'pinned' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                    <span>Pinned</span>
                </a>
                <a href="#" class="nav-item <?= $current_page === 'popular' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 6v6l4 2" />
                    </svg>
                    <span>Popular</span>
                </a>
            </nav>

            <div class="sidebar-divider"></div>
            <nav class="nav-section" style="margin-top:10px;">
                <a href="#" class="nav-item <?= $current_page === 'create' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    <span>Create a Post</span>
                </a>
                <a href="#" class="nav-item <?= $current_page === 'your_posts' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    <span>Your Posts</span>
                </a>
                <a href="#" class="nav-item <?= $current_page === 'notifications' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                    <span>Notifications</span>
                </a>
            </nav>

            <div class="sidebar-spacer"></div>
            <div class="sidebar-divider"></div>
            <label class="toggle-row" title="Toggle Dark Mode">
                <span class="toggle-row-left">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
                    </svg>
                    <span>Dark Mode</span>
                </span>
                <div class="toggle-switch">
                    <input type="checkbox" id="darkModeToggle" onchange="toggleDarkMode(this)">
                    <div class="toggle-track"></div>
                </div>
            </label>

            <label class="toggle-row" title="Toggle Dyslexic Font">
                <span class="toggle-row-left">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="4 7 4 4 20 4 20 7" />
                        <line x1="9" y1="20" x2="15" y2="20" />
                        <line x1="12" y1="4" x2="12" y2="20" />
                    </svg>
                    <span>Dyslexic</span>
                </span>
                <div class="toggle-switch">
                    <input type="checkbox" id="dyslexicToggle" onchange="toggleDyslexic(this)">
                    <div class="toggle-track"></div>
                </div>
            </label>

            <div class="sidebar-divider"></div>

            <!-- Logout -->
            <nav class="nav-section" style="margin-top:6px;">
                <a href="#" class="nav-item" onclick="return confirm('Yakin logout?');">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    <span>Logout</span>
                </a>
            </nav>

        </aside>
        <main class="main-content">
            <div class="content-wrapper">
                <div class="search-bar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input type="text" placeholder="Enter search terms" id="searchInput"
                        oninput="filterNotifications(this.value)">
                </div>

                <div class="notifications-card" id="notificationsCard">

                    <?php if (empty($notifications)): ?>
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                                <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                            </svg>
                            <span>Tidak ada notifikasi</span>
                        </div>
                    <?php else: ?>
                        <?php foreach ($notifications as $notif): ?>
                            <div class="notif-item <?= $notif['unread'] ? 'unread' : '' ?>"
                                data-title="<?= htmlspecialchars(strtolower($notif['user'] . ' ' . $notif['action'] . ' ' . $notif['body'])) ?>"
                                id="notif-<?= (int) $notif['id'] ?>">

                                <div class="notif-top-row">
                                    <div class="notif-left">
                                        <!-- Random avatar via DiceBear -->
                                        <img class="avatar" src="<?= htmlspecialchars(avatarUrl($notif['seed'])) ?>"
                                            alt="Avatar <?= htmlspecialchars($notif['user']) ?>"
                                            onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($notif['user']) ?>&background=1A56DB&color=fff&size=80&bold=true&rounded=true';"
                                            width="38" height="38" loading="lazy">
                                        <span class="notif-title">
                                            <?= htmlspecialchars($notif['user']) ?>
                                            <?= htmlspecialchars($notif['action']) ?>
                                        </span>
                                    </div>
                                    <span class="notif-date"><?= htmlspecialchars($notif['date']) ?></span>
                                </div>

                                <div class="notif-bottom-row">
                                    <span class="notif-body"><?= htmlspecialchars($notif['body']) ?></span>
                                    <button class="btn-reply" onclick="handleReply(<?= (int) $notif['id'] ?>, this)"
                                        title="Reply to <?= htmlspecialchars($notif['user']) ?>">
                                        Reply
                                    </button>
                                </div>

                                <!-- Unread indicator dot -->
                                <div class="unread-dot"></div>

                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
        </main>
    </div>

    <script>
        function handleReply(notifId, btn) {
            const item = document.getElementById('notif-' + notifId);
            if (!item) return;
            item.classList.remove('unread');
            btn.textContent = '✓ Replied';
            btn.style.background = '#047857';
            btn.style.boxShadow = '0 3px 10px rgba(4,120,87,0.3)';
            btn.disabled = true;
            btn.style.cursor = 'default';
        }
        function filterNotifications(query) {
            const q = query.trim().toLowerCase();
            const items = document.querySelectorAll('.notif-item');
            let anyVisible = false;

            items.forEach(function (item) {
                const text = item.getAttribute('data-title') || '';
                const match = !q || text.includes(q);
                item.style.display = match ? '' : 'none';
                if (match) anyVisible = true;
            });

            let emptyState = document.getElementById('filterEmptyState');
            if (!anyVisible) {
                if (!emptyState) {
                    emptyState = document.createElement('div');
                    emptyState.id = 'filterEmptyState';
                    emptyState.className = 'empty-state';
                    emptyState.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="48" height="48"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg><span>Tidak ada notifikasi yang cocok</span>';
                    document.getElementById('notificationsCard').appendChild(emptyState);
                }
                emptyState.style.display = 'flex';
            } else if (emptyState) {
                emptyState.style.display = 'none';
            }
        }

        function toggleDarkMode(checkbox) {
            if (checkbox.checked) {
                document.documentElement.style.setProperty('--white', '#1E293B');
                document.documentElement.style.setProperty('--gray-100', '#263244');
                document.documentElement.style.setProperty('--gray-200', '#2D3748');
                document.documentElement.style.setProperty('--text-dark', '#F1F5F9');
                document.documentElement.style.setProperty('--text-muted', '#94A3B8');
                document.documentElement.style.setProperty('--gray-500', '#64748B');
            } else {
                document.documentElement.style.setProperty('--white', '#ffffff');
                document.documentElement.style.setProperty('--gray-100', '#F7F9FC');
                document.documentElement.style.setProperty('--gray-200', '#EDF2F7');
                document.documentElement.style.setProperty('--text-dark', '#1A202C');
                document.documentElement.style.setProperty('--text-muted', '#4A5568');
                document.documentElement.style.setProperty('--gray-500', '#718096');
            }
        }

        function toggleDyslexic(checkbox) {
            if (checkbox.checked) {
                document.body.style.fontFamily = "'OpenDyslexic', 'Comic Sans MS', cursive";
                document.querySelectorAll('.notif-title, .notif-body, .notif-date, .nav-item, .btn-reply').forEach(function (el) {
                    el.style.fontFamily = "'OpenDyslexic', 'Comic Sans MS', cursive";
                });
            } else {
                document.body.style.fontFamily = "";
                document.querySelectorAll('.notif-title, .notif-body, .notif-date, .nav-item, .btn-reply').forEach(function (el) {
                    el.style.fontFamily = "";
                });
            }
        }
    </script>

</body>

</html>