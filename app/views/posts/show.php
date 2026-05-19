<title><?= htmlspecialchars($post['title']) ?> | ImmaSpark</title>
<link rel="stylesheet" href="/css/responsive/main.css">

<?php include __DIR__ . '/../../../app/views/layouts/partials/navbar.php'; ?>
<?php include __DIR__ . '/../../../app/helpers/tagText.php'; ?>

<script type="module" src="/js/animation/post.js"></script>
<script type="importmap">
{
    "imports": {
        "three": "/js/library/three/three.module.js",
        "three/addons/": "/js/library/jsm/"
    }
}
</script>

<div id="xIconSvg" class="hidden"><?= essIcon('x', 'w-6 h-6 cursor-pointer') ?></div>

<main class="md:right-0 md:top-0 md:absolute md:w-[calc(100%-16rem)] p-10 flex flex-col gap-10 grow md:mx-auto">
    <!-- Post Detail -->
    <div class="w-full rounded-4xl bg-white text-[#545F71] drop-shadow-lg post">
        <div class="md:pt-10 md:pr-10 md:pl-10 pb-7 pt-7 pr-7 pl-7 flex flex-col md:gap-3 gap-5">
            <div class="flex justify-between items-center">
                <div class="flex gap-5 items-center">
                    <img src="/assets/image/account/<?= htmlspecialchars($post['account_id']) ?>.jpg"
                        class="w-15 h-15 object-cover rounded-full drop-shadow-lg">
                    <div>
                        <p class="text-3xl font-bold"><?= htmlspecialchars($post['account_name']) ?></p>
                        <p><?= htmlspecialchars($post['class_name']) ?></p>
                    </div>
                </div>
                <p class="text-3xl font-bold"><?= $post['date'] ?></p>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex gap-5 items-center">
                    <?php if (!empty($post['tags'])): ?>
                        <?php foreach ($post['tags'] as $tag): ?>
                            <?php $textColor = tagTextColor($tag['color_top'], $tag['color_bottom']); ?>
                            <div class="px-4 py-2 rounded-full drop-shadow-lg flex gap-2 items-center"
                                style="background: linear-gradient(to bottom, #<?= $tag['color_top'] ?>, #<?= $tag['color_bottom'] ?>); color: <?= $textColor ?>;">
                                <?= icon(!empty($tag['icon']) ? $tag['icon'] : 'tag', 'w-7 h-7') ?>
                                <p><?= $tag['name'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="px-4 py-2"></div>
                    <?php endif; ?>
                </div>
                <div class="flex items-center gap-5">
                    <div class="vote-container flex px-4 py-2 bg-[#2C7CFF] text-white rounded-full items-center gap-3"
                        data-post-id="<?= $post['id'] ?>" data-type="post">
                        <button type="button" class="vote-btn vote-up flex items-center justify-center cursor-pointer"
                            data-vote="up"
                            data-current-vote="<?= $post['user_vote'] == 1 ? 'up' : ($post['user_vote'] == -1 ? 'down' : '') ?>">
                            <span style="<?= $post['user_vote'] == 1 ? 'color: #FFE500' : '' ?>">
                                <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                            </span>
                        </button>
                        <p class="vote-count text-2xl"><?= $post['votes'] ?></p>
                        <button type="button" class="vote-btn vote-down flex items-center justify-center cursor-pointer"
                            data-vote="down"
                            data-current-vote="<?= $post['user_vote'] == 1 ? 'up' : ($post['user_vote'] == -1 ? 'down' : '') ?>">
                            <span style="<?= $post['user_vote'] == -1 ? 'color: #FFE500' : '' ?>">
                                <?= essIcon('arrow', 'w-7 h-7') ?>
                            </span>
                        </button>
                    </div>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                        <?php
                        $isPinned = false;
                        foreach ($post['tags'] as $tag) {
                            if (strtolower($tag['name']) === 'pinned') {
                                $isPinned = true;
                                break;
                            }
                        }
                        ?>
                        <?php if ($isPinned): ?>
                            <form action="/posts/<?= $post['id'] ?>/unpin" method="POST" class="inline pinBtn">
                                <button type="submit"
                                    class="text-yellow-500 rounded-full hover:text-yellow-600 hover:bg-yellow-100 transition flex items-center gap-2">
                                    <?= icon('star', 'w-10 h-10') ?>
                                </button>
                            </form>
                        <?php else: ?>
                            <form action="/posts/<?= $post['id'] ?>/pin" method="POST" class="inline pinBtn">
                                <button type="submit"
                                    class="text-[#545F71] rounded-full hover:text-yellow-500 hover:bg-yellow-100 transition flex items-center gap-2">
                                    <?= icon('star', 'w-10 h-10') ?>
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="flex gap-1 items-center">
                        <?= essIcon('eye', 'w-10 h-10') ?>
                        <p class="text-2xl"><?= $post['views'] ?></p>
                    </div>
                    <div class="flex gap-1 items-center">
                        <?= essIcon('comment', 'w-10 h-10') ?>
                        <p class="text-2xl">
                            <?php
                            $replyCount = array_sum(array_map(fn($c) => count($c['replies']), $comments));
                            echo count($comments) + $replyCount;
                            ?>
                        </p>
                    </div>
                    <?php if (isset($_SESSION['account_id']) && $_SESSION['account_id'] == $post['account_id']): ?>
                        <a href="/posts/<?= $post['id'] ?>/edit"
                            class="flex items-center gap-1 hover:opacity-70 transition">
                            <?= essIcon('create', 'w-10 h-10') ?>
                        </a>
                    <?php endif; ?>
                    <button class="shareBtn hover:opacity-70 transition cursor-pointer rounded-full"
                        data-url="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/posts/' . $post['id'] ?>">
                        <?= essIcon('share', 'w-10 h-10') ?>
                    </button>
                </div>
            </div>
            <p class="text-4xl font-bold"><?= $post['title'] ?></p>
        </div>
        <?php include __DIR__ . '/../layouts/partials/carousel.php'; ?>
        <div class="md:p-10 p-7 <?= ($post['imgs']) ? '' : 'pt-0!' ?> flex flex-col md:gap-7 gap-5">
            <div class="revert-tailwind">
                <?= $post['description'] ?>
            </div>
            <?php if (!empty($post['links'])): ?>
                <div class="text-lg">
                    <div class="flex items-center gap-2">
                        <?= essIcon('linked', 'w-6 h-6') ?>
                        <p class="font-bold">Links</p>
                    </div>
                    <ul class="list-disc ml-5">
                        <?php foreach ($post['links'] as $link): ?>
                            <li>
                                <a href="<?= htmlspecialchars($link['link']) ?>" target="_blank"
                                    class="text-blue-600 hover:underline">
                                    <?= htmlspecialchars($link['link_text'] ?? $link['link']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Comment Section -->
    <div
        class="w-full rounded-4xl bg-white text-[#545F71] drop-shadow-lg post md:p-10 p-7 flex flex-col md:gap-5 gap-3">
        <form action="/posts/<?= $post['id'] ?>/comments" method="POST" id="commentForm"
            data-post-id="<?= $post['id'] ?>" class="flex gap-3 items-center">
            <input type="text" name="description" placeholder="Share your thoughts!"
                class="p-3 pl-8 w-full text-[#545F71] rounded-full border border-[#545F71] bg-white" required>
            <button type="submit"
                class="px-6 py-3 bg-[#2C7CFF] text-white rounded-full font-bold hover:bg-white hover:text-[#2C7CFF] hover:ring-2 transition">Post</button>
        </form>

        <div class="w-full h-0.75 bg-[#545F71] rounded-full seperatorLight"></div>

        <div class="flex gap-1 items-center">
            <?= essIcon('comment', 'w-10 h-10') ?>
            <p class="text-2xl">
                <?php
                $replyCount = array_sum(array_map(fn($c) => count($c['replies']), $comments));
                echo count($comments) + $replyCount;
                ?>
            </p>
        </div>

        <?php if (empty($comments)): ?>
            <p class="text-center text-[#545F71] text-xl">No comments here yet!</p>
        <?php endif; ?>

        <!-- Desktop Comment -->
        <div class="comments-list-desktop flex flex-col gap-5">
            <?php foreach ($comments as $comment): ?>
                <div class="hidden md:flex flex-col border-2 border-[#545F71] rounded-4xl comment-item"
                    data-comment-id="<?= $comment['id'] ?>">
                    <div class="flex items-center justify-between p-5 border-b-2 border-[#545F71]">
                        <div class="flex gap-5 items-center">
                            <img src="/assets/image/account/<?= $comment['account_id'] ?>.jpg"
                                class="w-10 h-10 object-cover rounded-full drop-shadow-lg">
                            <div>
                                <p class="text-2xl font-bold"><?= htmlspecialchars($comment['account_name']) ?></p>
                                <p class="text-sm"><?= htmlspecialchars($comment['class_name']) ?></p>
                            </div>
                            <div class="w-2 h-2 bg-[#545F71] rounded-full seperatorLight"></div>
                            <p class="text-2xl font-bold"><?= $comment['date'] ?></p>
                        </div>
                        <div class="flex gap-5 items-center">
                            <label class="flex items-center gap-2 cursor-pointer"
                                onclick="toggleReply('<?= $comment['id'] ?>-d')">
                                <?= essIcon('reply', 'w-8 h-8') ?>
                                <p class="text-2xl">Reply</p>
                            </label>
                            <div class="vote-container flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3"
                                data-comment-id="<?= $comment['id'] ?>" data-type="comment">
                                <button type="button"
                                    class="vote-btn vote-up flex items-center justify-center cursor-pointer" data-vote="up"
                                    data-current-vote="<?= $comment['user_vote'] == 1 ? 'up' : ($comment['user_vote'] == -1 ? 'down' : '') ?>">
                                    <span style="<?= $comment['user_vote'] == 1 ? 'color: #FFE500' : '' ?>">
                                        <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                                    </span>
                                </button>
                                <p class="vote-count text-2xl"><?= $comment['votes'] ?></p>
                                <button type="button"
                                    class="vote-btn vote-down flex items-center justify-center cursor-pointer"
                                    data-vote="down"
                                    data-current-vote="<?= $comment['user_vote'] == 1 ? 'up' : ($comment['user_vote'] == -1 ? 'down' : '') ?>">
                                    <span style="<?= $comment['user_vote'] == -1 ? 'color: #FFE500' : '' ?>">
                                        <?= essIcon('arrow', 'w-7 h-7') ?>
                                    </span>
                                </button>
                            </div>
                            <?php if (!empty($comment['replies'])): ?>
                                <div class="bg-[#747474] w-9 h-9 flex justify-center items-center rounded-full text-white cursor-pointer transition-transform duration-300"
                                    onclick="toggleReplies('<?= $comment['id'] ?>')">
                                    <?= essIcon('arrow', 'w-7 h-7 transform') ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($comment['account_id'] == $_SESSION['account_id'] || ($_SESSION['is_admin'] ?? 0) == 1): ?>
                                <button type="button"
                                    onclick="showConfirmationModal('Delete Comment', 'Are you sure you want to delete this comment? This action cannot be undone.', () => document.getElementById('deleteCommentForm-<?= $comment['id'] ?>').submit())"
                                    class="text-red-500 hover:text-red-700 transition red dark:hover:bg-transparent! dark:hover:opacity-60">
                                    <?= essIcon('delete', 'w-8 h-8') ?>
                                </button>
                                <form id="deleteCommentForm-<?= $comment['id'] ?>"
                                    action="/comments/<?= $comment['id'] ?>/delete" method="POST" class="hidden"></form>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-justify"><?= htmlspecialchars($comment['description']) ?></p>
                    </div>
                    <div id="inputReply-<?= $comment['id'] ?>-d"
                        class="hidden px-5 <?= !empty($comment['replies']) ? 'pb-8' : 'pb-5' ?>">
                        <form action="/posts/<?= $post['id'] ?>/comments/<?= $comment['id'] ?>/replies" method="POST"
                            class="flex gap-3 items-center">
                            <input type="text" name="description" placeholder="Replying..."
                                class="p-3 pl-8 w-full text-[#545F71] rounded-full border border-[#545F71] bg-white"
                                required>
                            <button type="submit"
                                class="px-6 py-3 bg-[#2C7CFF] text-white rounded-full shrink-0 font-bold">Post</button>
                        </form>
                    </div>
                    <?php if (!empty($comment['replies'])): ?>
                        <div id="replies-<?= $comment['id'] ?>">
                            <div class="bg-white p-2 absolute z-1 -translate-y-6 translate-x-3">
                                <p class="font-bold">Replies</p>
                            </div>
                            <?php foreach ($comment['replies'] as $reply): ?>
                                <div class="border-t-2 border-dashed">
                                    <div class="flex justify-between items-center p-5 border-b-2 border-[#545F71]">
                                        <div class="flex gap-5 items-center">
                                            <img src="/assets/image/account/<?= $reply['account_id'] ?>.jpg"
                                                class="w-10 h-10 object-cover rounded-full drop-shadow-lg">
                                            <div>
                                                <p class="text-2xl font-bold"><?= htmlspecialchars($reply['account_name']) ?></p>
                                                <p class="text-sm"><?= htmlspecialchars($reply['class_name']) ?></p>
                                            </div>
                                            <div class="w-2 h-2 bg-[#545F71] rounded-full seperatorLight"></div>
                                            <p class="text-2xl font-bold"><?= $reply['date'] ?></p>
                                        </div>
                                        <div class="flex gap-5 items-center">
                                            <div class="vote-container flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3"
                                                data-reply-id="<?= $reply['id'] ?>" data-type="reply">
                                                <button type="button"
                                                    class="vote-btn vote-up flex items-center justify-center cursor-pointer"
                                                    data-vote="up"
                                                    data-current-vote="<?= $reply['user_vote'] == 1 ? 'up' : ($reply['user_vote'] == -1 ? 'down' : '') ?>">
                                                    <span style="<?= $reply['user_vote'] == 1 ? 'color: #FFE500' : '' ?>">
                                                        <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                                                    </span>
                                                </button>
                                                <p class="vote-count text-2xl"><?= $reply['votes'] ?></p>
                                                <button type="button"
                                                    class="vote-btn vote-down flex items-center justify-center cursor-pointer"
                                                    data-vote="down"
                                                    data-current-vote="<?= $reply['user_vote'] == 1 ? 'up' : ($reply['user_vote'] == -1 ? 'down' : '') ?>">
                                                    <span style="<?= $reply['user_vote'] == -1 ? 'color: #FFE500' : '' ?>">
                                                        <?= essIcon('arrow', 'w-7 h-7') ?>
                                                    </span>
                                                </button>
                                            </div>
                                            <?php if ($reply['account_id'] == $_SESSION['account_id'] || ($_SESSION['is_admin'] ?? 0) == 1): ?>
                                                <button type="button"
                                                    onclick="showConfirmationModal('Delete Reply', 'Are you sure you want to delete this reply? This action cannot be undone.', () => document.getElementById('deleteReplyForm-<?= $reply['id'] ?>').submit())"
                                                    class="text-red-500 hover:text-red-700 transition red dark:hover:bg-transparent! dark:hover:opacity-60">
                                                    <?= essIcon('delete', 'w-8 h-8') ?>
                                                </button>
                                                <form id="deleteReplyForm-<?= $reply['id'] ?>"
                                                    action="/replies/<?= $reply['id'] ?>/delete" method="POST" class="hidden"></form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="p-5">
                                        <p class="text-justify"><?= htmlspecialchars($reply['description']) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Comment Mobile -->
        <div class="comments-list-mobile flex flex-col gap-5">
            <?php foreach ($comments as $comment): ?>
                <div class="flex md:hidden flex-col border-2 border-[#545F71] rounded-4xl comment-item"
                    data-comment-id="<?= $comment['id'] ?>">
                    <div class="p-5 border-b-2 border-[#545F71]">
                        <div class="flex gap-5 items-center justify-between w-full">
                            <div class="flex gap-5 items-center">
                                <img src="/assets/image/account/<?= $comment['account_id'] ?>.jpg"
                                    class="w-14 h-14 object-cover rounded-full drop-shadow-lg">
                                <div>
                                    <p class="text-2xl font-bold"><?= htmlspecialchars($comment['account_name']) ?></p>
                                    <p class="text-lg"><?= htmlspecialchars($comment['class_name']) ?></p>
                                </div>
                            </div>
                            <p class="text-3xl font-bold"><?= $comment['date'] ?></p>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-justify text-2xl md:text-lg"><?= htmlspecialchars($comment['description']) ?></p>
                    </div>
                    <div class="flex gap-5 items-center justify-end p-5 pt-0">
                        <label class="flex items-center gap-2 cursor-pointer"
                            onclick="toggleReply('<?= $comment['id'] ?>-m')">
                            <?= essIcon('reply', 'w-8 h-8') ?>
                            <p class="text-2xl">Reply</p>
                        </label>
                        <div class="vote-container flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3"
                            data-comment-id="<?= $comment['id'] ?>" data-type="comment">
                            <button type="button" class="vote-btn vote-up flex items-center justify-center cursor-pointer"
                                data-vote="up"
                                data-current-vote="<?= $comment['user_vote'] == 1 ? 'up' : ($comment['user_vote'] == -1 ? 'down' : '') ?>">
                                <span style="<?= $comment['user_vote'] == 1 ? 'color: #FFE500' : '' ?>">
                                    <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                                </span>
                            </button>
                            <p class="vote-count text-2xl"><?= $comment['votes'] ?></p>
                            <button type="button" class="vote-btn vote-down flex items-center justify-center cursor-pointer"
                                data-vote="down"
                                data-current-vote="<?= $comment['user_vote'] == 1 ? 'up' : ($comment['user_vote'] == -1 ? 'down' : '') ?>">
                                <span style="<?= $comment['user_vote'] == -1 ? 'color: #FFE500' : '' ?>">
                                    <?= essIcon('arrow', 'w-7 h-7') ?>
                                </span>
                            </button>
                        </div>
                        <?php if (!empty($comment['replies'])): ?>
                            <div class="bg-[#747474] w-9 h-9 flex justify-center items-center rounded-full text-white cursor-pointer transition-transform duration-300"
                                onclick="toggleReplies('<?= $comment['id'] ?>-m')">
                                <?= essIcon('arrow', 'w-7 h-7 transform') ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($comment['account_id'] == $_SESSION['account_id'] || ($_SESSION['is_admin'] ?? 0) == 1): ?>
                            <button type="button"
                                onclick="showConfirmationModal('Delete Reply', 'Are you sure you want to delete this reply? This action cannot be undone.', () => document.getElementById('deleteReplyForm-<?= $reply['id'] ?>').submit())"
                                class="text-red-500 hover:text-red-700 transition red dark:hover:bg-transparent! dark:hover:opacity-60">
                                <?= essIcon('delete', 'w-8 h-8') ?>
                            </button>
                            <form id="deleteReplyForm-<?= $reply['id'] ?>" action="/replies/<?= $reply['id'] ?>/delete"
                                method="POST" class="hidden"></form>
                        <?php endif; ?>
                    </div>
                    <div id="inputReply-<?= $comment['id'] ?>-m"
                        class="hidden px-5 <?= !empty($comment['replies']) ? 'pb-8' : 'pb-5' ?>">
                        <form action="/posts/<?= $post['id'] ?>/comments/<?= $comment['id'] ?>/replies" method="POST"
                            class="flex gap-3 items-center">
                            <input type="text" name="description" placeholder="Replying..."
                                class="p-3 pl-8 w-full text-[#545F71] rounded-full border border-[#545F71] bg-white"
                                required>
                            <button type="submit"
                                class="px-6 py-3 bg-[#2C7CFF] text-white rounded-full shrink-0 font-bold cursor-pointer hover:bg-white hover:text-[#2C7CFF] hover:ring-2 transition">Post</button>
                        </form>
                    </div>
                    <?php if (!empty($comment['replies'])): ?>
                        <div id="replies-<?= $comment['id'] ?>-m">
                            <div class="bg-white p-2 absolute z-1 -translate-y-6 translate-x-5">
                                <p class="text-xl font-bold">Replies</p>
                            </div>
                            <?php foreach ($comment['replies'] as $reply): ?>
                                <div class="border-t-2 border-dashed">
                                    <div class="border-b-2 border-[#545F71]">
                                        <div class="p-5 flex gap-5 items-center justify-between">
                                            <div class="flex gap-5 items-center">
                                                <img src="/assets/image/account/<?= $reply['account_id'] ?>.jpg"
                                                    class="w-14 h-14 object-cover rounded-full drop-shadow-lg">
                                                <div>
                                                    <p class="text-2xl font-bold"><?= htmlspecialchars($reply['account_name']) ?>
                                                    </p>
                                                    <p class="text-lg"><?= htmlspecialchars($reply['class_name']) ?></p>
                                                </div>
                                            </div>
                                            <p class="text-3xl font-bold"><?= $reply['date'] ?></p>
                                        </div>
                                    </div>
                                    <div class="p-5">
                                        <p class="text-justify text-2xl md:text-lg"><?= htmlspecialchars($reply['description']) ?>
                                        </p>
                                    </div>
                                    <div class="flex gap-5 items-center p-5 pt-0 justify-end">
                                        <div class="vote-container flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3"
                                            data-reply-id="<?= $reply['id'] ?>" data-type="reply">
                                            <button type="button"
                                                class="vote-btn vote-up flex items-center justify-center cursor-pointer"
                                                data-vote="up"
                                                data-current-vote="<?= $reply['user_vote'] == 1 ? 'up' : ($reply['user_vote'] == -1 ? 'down' : '') ?>">
                                                <span style="<?= $reply['user_vote'] == 1 ? 'color: #FFE500' : '' ?>">
                                                    <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                                                </span>
                                            </button>
                                            <p class="vote-count text-2xl"><?= $reply['votes'] ?></p>
                                            <button type="button"
                                                class="vote-btn vote-down flex items-center justify-center cursor-pointer"
                                                data-vote="down"
                                                data-current-vote="<?= $reply['user_vote'] == 1 ? 'up' : ($reply['user_vote'] == -1 ? 'down' : '') ?>">
                                                <span style="<?= $reply['user_vote'] == -1 ? 'color: #FFE500' : '' ?>">
                                                    <?= essIcon('arrow', 'w-7 h-7') ?>
                                                </span>
                                            </button>
                                        </div>
                                        <?php if ($reply['account_id'] == $_SESSION['account_id'] || ($_SESSION['is_admin'] ?? 0) == 1): ?>
                                            <button type="button"
                                                onclick="showConfirmationModal('Delete Comment', 'Are you sure you want to delete this comment? This action cannot be undone.', () => document.getElementById('deleteCommentForm-<?= $comment['id'] ?>').submit())"
                                                class="text-red-500 hover:text-red-700 transition red dark:hover:bg-transparent! dark:hover:opacity-60">
                                                <?= essIcon('delete', 'w-8 h-8') ?>
                                            </button>
                                            <form id="deleteCommentForm-<?= $comment['id'] ?>"
                                                action="/comments/<?= $comment['id'] ?>/delete" method="POST" class="hidden"></form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<script src="/js/post/comment.js"></script>
<script src="/js/post/postReply.js"></script>
<script src="/js/post/share.js"></script>
<script src="/js/post/vote.js"></script>
<script src="/js/post/carousel.js"></script>