<title>Home | ImmaSpark</title>
<link rel="stylesheet" href="/css/responsive/main.css">

<?php include __DIR__ . '/../../../app/views/layouts/partials/navbar/navbar.php'; ?>

<main class="md:right-0 md:top-0 md:absolute md:w-[calc(100%-16rem)] p-10 flex flex-col gap-10 grow md:container md:mx-auto">
    <div id="searchBar" class="z-2 sticky top-10 w-full md:block hidden">
        <label for="search">
            <?= essIcon('search', 'w-8 absolute left-4 top-1/2 -translate-y-4 z-2') ?>
        </label>
        <input type="text" id="search" placeholder="Search..." class="p-4 pl-14 w-full text-white placeholder:text-white/60 rounded-full border border-white/20 backdrop-blur-md bg-gray-800/25">
    </div>

<?php foreach ($posts as $index => $post): ?>
    <div class="w-full rounded-4xl bg-white text-[#545F71] drop-shadow-lg post">
        <div class="md:pt-10 md:pr-10 md:pl-10 pb-5 pt-7 pr-7 pl-7 flex flex-col md:gap-3 gap-5">
            <div class="flex justify-between items-center">
                <div class="flex gap-5 items-center">
                    <img src="/assets/image/account/phototest.jpg" class="w-15 h-15 object-cover rounded-full drop-shadow-lg">
                    <div>
                        <p class="text-3xl font-bold">Christopher V. C.</p>
                        <p>XI TKJ 3</p>
                    </div>
                </div>
                <p class="text-3xl font-bold"><?= $post['date'] ?></p>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex gap-5">
                    <div class="px-4 py-2 bg-linear-to-b from-[#8a8a8a] to-[#313131] text-white rounded-full drop-shadow-lg flex gap-2 items-center">
                        <?= icon('tag', 'w-7 h-7') ?>
                        <p>TEMPLATE</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <div class="flex px-4 py-2 bg-[#2C7CFF] text-white rounded-full items-center gap-3">
                        <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                        <p class="text-2xl"><?= $post['votes'] ?></p>
                        <?= essIcon('arrow', 'w-7 h-7') ?>
                    </div>
                    <div class="flex gap-1 items-center">
                        <?= essIcon('eye', 'w-10 h-10') ?>
                        <p class="text-2xl">15</p>
                    </div>
                    <div class="flex gap-1 items-center">
                        <?= essIcon('comment', 'w-10 h-10') ?>
                        <p class="text-2xl">3</p>
                    </div>
                    <?= essIcon('share', 'w-10 h-10') ?>
                </div>
            </div>
            <a href="/posts/<?= $post['id'] ?>" class="flex flex-col gap-3">
                <p class="text-4xl font-bold"><?= $post['title'] ?></p>
                <p class="text-2xl md:text-lg text-justify"><?= $post['description'] ?></p>
            </a>
        </div>
        <?php if ($post['img']): ?>
            <div class="h-75 max-h-75 relative">
                <button class="absolute left-10 top-30 p-4 rounded-full text-white drop-shadow-lg bg-clip-padding backdrop-filter backdrop-blur-md bg-opacity-10 border border-gray-100">
                    <?= essIcon('arrow', 'w-7 h-7 transform rotate-90') ?>
                </button>
                <img src="/assets/image/post/<?= $post['img'] ?>" class="rounded-4xl w-full h-full object-cover">
                <button class="absolute right-10 top-30 p-4 rounded-full text-white drop-shadow-lg bg-clip-padding backdrop-filter backdrop-blur-md bg-opacity-10 border border-gray-100">
                    <?= essIcon('arrow', 'w-7 h-7 transform rotate-270') ?>
                </button>
                <div class="absolute left-1/2 bottom-8">
                    <div class="w-4 h-4 bg-white rounded-full opacity-80"></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

    <div id="endMsg" class="w-full p-3 flex justify-center bg-white rounded-full drop-shadow-lg">
        <p class="text-xl font-bold text-[#545F71]">End of the line!</p>
    </div>
</main>