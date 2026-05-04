<title>Post Title | ImmaSpark</title>
<link rel="stylesheet" href="/css/responsive/main.css">

<?php include __DIR__ . '/../../../app/views/layouts/partials/navbar/navbar.php'; ?>

<main class="md:right-0 md:top-0 md:absolute md:w-[calc(100%-16rem)] p-10 flex flex-col gap-10 grow md:mx-auto">
<!-- Post Detail -->
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
        <?php if (!empty($post['tags'])): ?>
            <?php foreach ($post['tags'] as $tag): ?>
                <div class="px-4 py-2 text-white rounded-full drop-shadow-lg flex gap-2 items-center"
                    style="background: linear-gradient(to bottom, #<?= $tag['color_top'] ?>, #<?= $tag['color_bottom'] ?>)">
                    <?= icon(!empty($tag['icon']) ? $tag['icon'] : 'tag', 'w-7 h-7') ?>
                    <p><?= strtoupper($tag['name']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
                <div class="px-4 py-2"></div>
        <?php endif; ?>
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
            <p class="text-4xl font-bold"><?= $post['title'] ?></p>
        </div>
    <?php if (!empty($post['imgs'])): ?>
        <div class="h-75 max-h-75 relative">
            <button class="absolute left-10 top-30 p-4 rounded-full text-white drop-shadow-lg bg-clip-padding backdrop-filter backdrop-blur-md bg-opacity-10 border border-gray-100">
                <?= essIcon('arrow', 'w-7 h-7 transform rotate-90') ?>
            </button>
            <img src="/assets/image/post/<?= $post['imgs'][0]['file_name'] ?>" class="rounded-4xl w-full h-full object-cover">
            <button class="absolute right-10 top-30 p-4 rounded-full text-white drop-shadow-lg bg-clip-padding backdrop-filter backdrop-blur-md bg-opacity-10 border border-gray-100">
                <?= essIcon('arrow', 'w-7 h-7 transform rotate-270') ?>
            </button>
            <div class="absolute left-1/2 bottom-8 flex gap-2">
                <?php foreach ($post['imgs'] as $index => $img): ?>
                    <div class="w-4 h-4 bg-white rounded-full opacity-80"></div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
        <div class="md:p-10 p-7 <?= ($post['imgs']) ? '' : 'pt-0!' ?> flex flex-col md:gap-7 gap-5">
            <p class="text-2xl md:text-xl text-justify"><?= $post['description'] ?></p>
    <?php if (!empty($post['links'])): ?>
            <div class="text-lg">
                <div class="flex items-center gap-2">
                    <?= essIcon('linked', 'w-6 h-6') ?>
                    <p class="font-bold">Links</p>
                </div>
                <ul class="list-disc ml-5">
                    <?php foreach ($post['links'] as $link): ?>
                        <li><a href="https://<?= $link['link'] ?>"><?= $link['link'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
    <?php endif; ?>
        </div>
    </div>

<!-- Comment Section -->
    <div class="w-full rounded-4xl bg-white text-[#545F71] drop-shadow-lg post md:p-10 p-7 flex flex-col md:gap-5 gap-3">
        <input type="text" id="searchComment" placeholder="Share your thoughts!" class="p-3 pl-8 w-full text-[#545F71] rounded-full border border-[#545F71] bg-white">

        <div class="w-full h-0.75 bg-[#545F71] rounded-full"></div>

        <div class="flex gap-1 items-center">
            <?= essIcon('comment', 'w-10 h-10') ?>
            <p class="text-2xl">3</p>
        </div>

<!-- Comment desktop -->
        <div id="comment1" class="hidden md:flex flex-col border-2 border-[#545F71] rounded-4xl">
            <div class="flex items-center justify-between p-5 border-b-2 border-[#545F71]">
                <div class="flex gap-5 items-center">
                    <div class="flex gap-5 items-center">
                        <img src="/assets/image/account/phototest.jpg" class="w-10 h-10 object-cover rounded-full drop-shadow-lg">
                        <div>
                            <p class="text-2xl font-bold">Christopher V. C.</p>
                            <p class="text-sm">XI TKJ 3</p>
                        </div>
                    </div>
                    <div class="w-2 h-2 bg-[#545F71] rounded-full"></div>
                    <p class="text-2xl font-bold"></p>
                </div>
                <div class="flex gap-5 items-center">
                    <label id="replyBtnC1" for="replyC1" class="flex items-center gap-2" onclick="replyComment()">
                        <?= essIcon('reply', 'w-8 h-8') ?>
                        <p class="text-2xl">Reply</p>
                    </label>
                    <div class="flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3">
                        <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                        <p class="text-2xl">1</p>
                        <?= essIcon('arrow', 'w-7 h-7') ?>
                    </div>
                    <div class="bg-[#747474] w-9 h-9 flex justify-center items-center rounded-full text-white">
                        <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                    </div>
                </div>
            </div>
            <div class="p-5">
                <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dignissim malesuada ullamcorper. Phasellus lobortis augue quis consectetur lacinia. Suspendisse sed dolor quis nibh dictum hendrerit. Donec ac dolor consequat, egestas ligula eget, fringilla leo. Phasellus viverra libero id accumsan rhoncus.</p>
            </div>
            <div class="border-t-2 border-dashed">
                <div>
                    <div class="bg-white p-2 absolute z-1 -translate-y-6 translate-x-3">
                        <p class="font-bold">Replies</p>
                    </div>
                    <div id="inputReplyC1" class="hidden p-5 pb-0">
                        <input type="text" id="replyC1" placeholder="Replying" class="p-3 pl-8 w-full text-[#545F71] rounded-full border border-[#545F71] bg-white">
                    </div>
                    <div id="reply1">
                        <div class="border-b-2 border-[#545F71] flex justify-between items-center">
                            <div class="p-5 flex gap-5 items-center ">
                                <div class="flex gap-5 items-center">
                                    <img src="/assets/image/account/phototest.jpg" class="w-10 h-10 object-cover rounded-full drop-shadow-lg">
                                    <div>
                                        <p class="text-2xl font-bold">Christopher V. C.</p>
                                        <p class="text-sm">XI TKJ 3</p>
                                    </div>
                                </div>
                                <div class="w-2 h-2 bg-[#545F71] rounded-full"></div>
                                <p class="text-2xl font-bold">16/03/2026</p>
                            </div>
                            <div class="flex gap-5 items-center p-5">
                                <div class="flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3">
                                    <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                                    <p class="text-2xl">1</p>
                                    <?= essIcon('arrow', 'w-7 h-7') ?>
                                </div>
                                <div class="bg-[#747474] w-9 h-9 flex justify-center items-center rounded-full text-white">
                                    <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                                </div>
                            </div>
                        </div>
                        <div class="p-5">
                            <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dignissim malesuada ullamcorper. Phasellus lobortis augue quis consectetur lacinia. Suspendisse sed dolor quis nibh dictum hendrerit. Donec ac dolor consequat, egestas ligula eget, fringilla leo. Phasellus viverra libero id accumsan rhoncus.</p>
                        </div>
                    </div>
                    <div id="reply2" class="border-t-2 border-[#545F71] border-dashed">
                        <div class="border-b-2 border-[#545F71] flex justify-between items-center">
                            <div class="p-5 flex gap-5 items-center ">
                                <div class="flex gap-5 items-center">
                                    <img src="/assets/image/account/phototest.jpg" class="w-10 h-10 object-cover rounded-full drop-shadow-lg">
                                    <div>
                                        <p class="text-2xl font-bold">Christopher V. C.</p>
                                        <p class="text-sm">XI TKJ 3</p>
                                    </div>
                                </div>
                                <div class="w-2 h-2 bg-[#545F71] rounded-full"></div>
                                <p class="text-2xl font-bold">16/03/2026</p>
                            </div>
                            <div class="flex gap-5 items-center p-5">
                                <div class="flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3">
                                    <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                                    <p class="text-2xl">1</p>
                                    <?= essIcon('arrow', 'w-7 h-7') ?>
                                </div>
                                <div class="bg-[#747474] w-9 h-9 flex justify-center items-center rounded-full text-white">
                                    <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                                </div>
                            </div>
                        </div>
                        <div class="p-5">
                            <p class="text-justify text-2xl md:text-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dignissim malesuada ullamcorper. Phasellus lobortis augue quis consectetur lacinia. Suspendisse sed dolor quis nibh dictum hendrerit. Donec ac dolor consequat, egestas ligula eget, fringilla leo. Phasellus viverra libero id accumsan rhoncus.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- Comment mobile -->
        <div id="comment1" class="flex md:hidden flex-col border-2 border-[#545F71] rounded-4xl">
            <div class="p-5 border-b-2 border-[#545F71]">
                <div class="flex gap-5 items-center justify-between w-full">
                    <div class="flex gap-5 items-center">
                        <img src="/assets/image/account/phototest.jpg" class="w-14 h-14 object-cover rounded-full drop-shadow-lg">
                        <div>
                            <p class="text-2xl font-bold">Christopher V. C.</p>
                            <p class="text-lg">XI TKJ 3</p>
                        </div>
                    </div>
                    <p class="text-3xl font-bold">16/03/2026</p>
                </div>
            </div>
            <div class="p-5">
                <p class="text-justify text-2xl md:text-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dignissim malesuada ullamcorper. Phasellus lobortis augue quis consectetur lacinia. Suspendisse sed dolor quis nibh dictum hendrerit. Donec ac dolor consequat, egestas ligula eget, fringilla leo. Phasellus viverra libero id accumsan rhoncus.</p>
            </div>
            <div class="flex gap-5 items-center justify-end p-5 pt-0">
                <label id="replyBtnC1" for="replyC1" class="flex items-center gap-2" onclick="replyComment()">
                    <?= essIcon('reply', 'w-8 h-8') ?>
                    <p class="text-2xl">Reply</p>
                </label>
                <div class="flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3">
                    <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                    <p class="text-2xl">1</p>
                    <?= essIcon('arrow', 'w-7 h-7 transform') ?>
                </div>
                <div class="bg-[#747474] w-9 h-9 flex justify-center items-center rounded-full">
                    <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                </div>
            </div>
            <div class="border-t-2 border-dashed">
                <div>
                    <div class="bg-white p-2 absolute z-1 -translate-y-6 translate-x-5">
                        <p class="text-xl font-bold">Replies</p>
                    </div>
                    <div id="inputReplyC1" class="hidden p-5 pb-0">
                        <input type="text" id="replyC1" placeholder="Replying" class="p-3 pl-8 w-full text-[#545F71] rounded-full border border-[#545F71] bg-white">
                    </div>
                    <div id="reply1">
                        <div class="border-b-2 border-[#545F71]">
                            <div class="p-5 flex gap-5 items-center justify-between">
                                <div class="flex gap-5 items-center">
                                    <img src="/assets/image/account/phototest.jpg" class="w-14 h-14 object-cover rounded-full drop-shadow-lg">
                                    <div>
                                        <p class="text-2xl font-bold">Christopher V. C.</p>
                                        <p class="text-lg">XI TKJ 3</p>
                                    </div>
                                </div>
                                <p class="text-3xl font-bold">16/03/2026</p>
                            </div>
                        </div>
                        <div class="p-5">
                            <p class="text-justify text-2xl md:text-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dignissim malesuada ullamcorper. Phasellus lobortis augue quis consectetur lacinia. Suspendisse sed dolor quis nibh dictum hendrerit. Donec ac dolor consequat, egestas ligula eget, fringilla leo. Phasellus viverra libero id accumsan rhoncus.</p>
                        </div>
                        <div class="flex gap-5 items-center p-5 pt-0 justify-end">
                            <div class="flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3">
                                <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                                <p class="text-2xl">1</p>
                                <?= essIcon('arrow', 'w-7 h-7 transform') ?>
                            </div>
                            <div class="bg-[#747474] w-9 h-9 flex justify-center items-center rounded-full">
                                <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                            </div>
                        </div>
                    </div>
                    <div id="reply2" class="border-t-2 border-[#545F71] border-dashed">
                        <div class="border-b-2 border-[#545F71]">
                            <div class="p-5 flex gap-5 items-center justify-between">
                                <div class="flex gap-5 items-center">
                                    <img src="/assets/image/account/phototest.jpg" class="w-14 h-14 object-cover rounded-full drop-shadow-lg">
                                    <div>
                                        <p class="text-2xl font-bold">Christopher V. C.</p>
                                        <p class="text-lg">XI TKJ 3</p>
                                    </div>
                                </div>
                                <p class="text-3xl font-bold">16/03/2026</p>
                            </div>
                        </div>
                        <div class="p-5">
                            <p class="text-justify text-2xl md:text-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dignissim malesuada ullamcorper. Phasellus lobortis augue quis consectetur lacinia. Suspendisse sed dolor quis nibh dictum hendrerit. Donec ac dolor consequat, egestas ligula eget, fringilla leo. Phasellus viverra libero id accumsan rhoncus.</p>
                        </div>
                        <div class="flex gap-5 items-center p-5 pt-0 justify-end">
                            <div class="flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3">
                                <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                                <p class="text-2xl">1</p>
                                <?= essIcon('arrow', 'w-7 h-7 transform') ?>
                            </div>
                            <div class="bg-[#747474] w-9 h-9 flex justify-center items-center rounded-full">
                                <?= essIcon('arrow', 'w-7 h-7 transform rotate-180') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="/js/post/postReply.js"></script>