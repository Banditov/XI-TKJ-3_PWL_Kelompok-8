<title>Pinned Posts | ImmaSpark</title>
<link rel="stylesheet" href="/css/responsive/main.css">

<script type="module" src="/js/animation/post.js"></script>

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
    <div id="searchBar"
        class="z-2 sticky top-10 w-full md:block hidden opacity-60 hover:opacity-100 transition rounded-full">
        <form method="GET" action="/pinned" id="searchForm">
            <input type="hidden" name="tag" value="<?= htmlspecialchars($filters['tag'] ?? '') ?>">
            <input type="hidden" name="votes_min" value="<?= htmlspecialchars($filters['votes_min'] ?? '') ?>">
            <input type="hidden" name="votes_max" value="<?= htmlspecialchars($filters['votes_max'] ?? '') ?>">
            <input type="hidden" name="views_min" value="<?= htmlspecialchars($filters['views_min'] ?? '') ?>">
            <input type="hidden" name="views_max" value="<?= htmlspecialchars($filters['views_max'] ?? '') ?>">
            <label for="search">
                <?= essIcon('search', 'w-8 absolute left-4 top-1/2 -translate-y-4 z-2') ?>
            </label>
            <input type="text" id="search" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
                placeholder="Search pinned posts..."
                class="p-4 pl-14 w-full text-white placeholder:text-white/60 rounded-full border border-white/20 backdrop-blur-md bg-gray-900/25">
        </form>
    </div>

    <div id="postsContainer" class="flex flex-col gap-10">
        <?php if (empty($posts)): ?>
            <div class="w-full rounded-4xl bg-white text-[#545F71] drop-shadow-lg p-10 text-center">
                <p class="text-2xl">No pinned posts yet</p>
                <p class="text-gray-500 mt-2">Admins can pin important posts by adding the "Pinned" tag</p>
            </div>
        <?php else: ?>
            <?php foreach ($posts as $index => $post): ?>
                <div
                    class="w-full rounded-4xl bg-white text-[#545F71] drop-shadow-lg post hover:drop-shadow-[0_0_10px_rgba(0,0,0,0.5)] transition relative">
                    <div class="md:pt-10 md:pr-10 md:pl-10 pb-7 pt-7 pr-7 pl-7 flex flex-col md:gap-3 gap-5">
                        <div class="flex justify-between items-center">
                            <div class="flex gap-5 items-center">
                                <img src="/assets/image/account/<?= htmlspecialchars($post['account_id']) ?>.jpg"
                                    class="w-15 h-15 object-cover rounded-full drop-shadow-lg"
                                    onerror="this.src='/assets/image/account/default.jpg'">
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
                                        <?php if (strtolower($tag['name']) === 'pinned')
                                            continue; ?>
                                        <?php $textColor = tagTextColor($tag['color_top'], $tag['color_bottom']); ?>
                                        <div class="px-4 py-2 rounded-full drop-shadow-lg flex gap-2 items-center"
                                            style="background: linear-gradient(to bottom, #<?= $tag['color_top'] ?>, #<?= $tag['color_bottom'] ?>); color: <?= $textColor ?>;">
                                            <?= icon(!empty($tag['icon']) ? $tag['icon'] : 'tag', 'w-7 h-7') ?>
                                            <p><?= $tag['name'] ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div></div>
                                <?php endif; ?>
                            </div>
                            <div class="flex items-center gap-5">
                                <div class="flex px-4 py-2 bg-[#2C7CFF] text-white rounded-full items-center gap-3 vote-container"
                                    data-type="post" data-post-id="<?= $post['id'] ?>">
                                    <button type="button"
                                        class="vote-btn vote-up flex items-center justify-center cursor-pointer" data-vote="up"
                                        data-current-vote="<?= ($post['user_vote'] ?? 0) == 1 ? 'up' : (($post['user_vote'] ?? 0) == -1 ? 'down' : '') ?>">
                                        <span style="<?= ($post['user_vote'] ?? 0) == 1 ? 'color: #FFE500' : '' ?>">
                                            <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                                        </span>
                                    </button>
                                    <p class="vote-count text-2xl"><?= $post['votes'] ?></p>
                                    <button type="button"
                                        class="vote-btn vote-down flex items-center justify-center cursor-pointer"
                                        data-vote="down"
                                        data-current-vote="<?= ($post['user_vote'] ?? 0) == 1 ? 'up' : (($post['user_vote'] ?? 0) == -1 ? 'down' : '') ?>">
                                        <span style="<?= ($post['user_vote'] ?? 0) == -1 ? 'color: #FFE500' : '' ?>">
                                            <?= essIcon('arrow', 'w-7 h-7') ?>
                                        </span>
                                    </button>
                                </div>
                                <div class="flex gap-1 items-center">
                                    <?= essIcon('eye', 'w-10 h-10') ?>
                                    <p class="text-2xl"><?= $post['views'] ?></p>
                                </div>
                                <div class="flex gap-1 items-center">
                                    <?= essIcon('comment', 'w-10 h-10') ?>
                                    <p class="text-2xl"><?= $post['comment_count'] ?></p>
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
                        <a href="/posts/<?= $post['id'] ?>" class="flex flex-col gap-3">
                            <p class="text-4xl font-bold"><?= $post['title'] ?></p>
                            <div class="revert-tailwind">
                                <?= $post['description'] ?>
                            </div>
                        </a>
                    </div>
                    <?php include __DIR__ . '/../layouts/partials/carousel.php'; ?>
                </div>
            <?php endforeach; ?>
            <div id="endMsg" class="w-full p-3 flex justify-center bg-white rounded-full drop-shadow-lg">
                <p class="text-xl font-bold text-[#545F71]">End of pinned posts</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<script src="/js/post/share.js"></script>
<script src="/js/post/filter.js"></script>
<script src="/js/post/vote.js"></script>
<script src="/js/post/carousel.js"></script>