<title>Notifications | ImmaSpark</title>
<link rel="stylesheet" href="/css/responsive/main.css">

<?php include __DIR__ . '/../../../app/views/layouts/partials/navbar.php'; ?>

<main class="md:right-0 md:top-0 md:absolute md:w-[calc(100%-16rem)] p-10 flex flex-col gap-10 grow md:mx-auto">
    <div
        class="w-full rounded-4xl bg-white dark:bg-[#1B1B1B] text-[#545F71] dark:text-white drop-shadow-lg p-10 flex flex-col gap-5 post">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold">Notifications</h1>
            <?php if (!empty($notifications)): ?>
                <button id="clearAllBtn"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-white hover:text-red-600 red hover:ring-2 transition cursor-pointer">
                    Clear All
                </button>
            <?php endif; ?>
        </div>

        <?php if (empty($notifications)): ?>
            <div class="text-center py-10">
                <p class="text-gray-500">No notifications yet</p>
            </div>
        <?php else: ?>
            <div id="notificationsList">
                <?php foreach ($notifications as $notif): ?>
                    <div class="border-b-2 border-[#545F71] dark:border-[#3F3F3F] pb-5 mb-5 notification-item"
                        data-id="<?= $notif['id'] ?>">
                        <div class="flex justify-between items-center pb-5">
                            <div class="flex gap-5 items-center">
                                <img src="/assets/image/account/<?= $notif['source_account_id'] ?? 2 ?>.jpg"
                                    class="w-10 h-10 object-cover rounded-full drop-shadow-lg">
                                <div>
                                    <p class="text-2xl font-bold">
                                        <?= htmlspecialchars($notif['source_name'] ?? 'Someone') ?></p>
                                    <p class="text-sm"><?= htmlspecialchars($notif['source_class'] ?? '') ?></p>
                                </div>
                            </div>
                            <p class="text-2xl font-bold"><?= date('M d, Y', strtotime($notif['date'])) ?></p>
                        </div>
                        <div class="flex justify-between items-center gap-5">
                            <p class="flex-1">
                                <?php if ($notif['comment_id']): ?>
                                    Commented on your post:
                                    <span
                                        class="italic">"<?= htmlspecialchars(substr($notif['comment_description'] ?? '', 0, 100)) ?>"</span>
                                <?php elseif ($notif['reply_id']): ?>
                                    Replied to your comment:
                                    <span
                                        class="italic">"<?= htmlspecialchars(substr($notif['reply_description'] ?? '', 0, 100)) ?>"</span>
                                <?php else: ?>
                                    <?= htmlspecialchars($notif['message'] ?? 'New notification') ?>
                                <?php endif; ?>
                            </p>
                            <a href="/posts/<?= $notif['post_id'] ?>"
                                class="px-4 py-2 bg-[#2C7CFF] text-white rounded-lg hover:bg-white hover:text-[#2C7CFF] hover:ring-2 transition">
                                View →
                            </a>
                            <button onclick="showDeleteNotifModal(<?= $notif['id'] ?>)"
                                class="delete-notif-btn px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-white hover:text-red-600 red hover:ring-2 transition cursor-pointer">
                                Remove
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<script src="/js/notification.js"></script>