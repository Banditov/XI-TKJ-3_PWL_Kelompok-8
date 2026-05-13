<title>Create Post | ImmaSpark</title>
<link rel="stylesheet" href="/css/responsive/main.css">

<?php include __DIR__ . '/../../../app/views/layouts/partials/navbar/navbar.php'; ?>
<?php include __DIR__ . '/../../../app/helpers/tagText.php'; ?>

<main class="md:right-0 md:top-0 md:absolute md:w-[calc(100%-16rem)] p-10 flex flex-col gap-10 grow md:mx-auto">
    <div class="w-full rounded-4xl bg-white text-[#545F71] drop-shadow-lg p-10 flex flex-col gap-5 create post">
        <p class="text-4xl font-bold text-center">Share Us Your Ideas!</p>
        <form action="/posts" method="POST" id="postForm" class="flex flex-col gap-5">
            <div class="flex flex-col gap-2">
                <p class="text-2xl font-bold">Title</p>
                <input type="text" name="title" placeholder="Suatu Title" class="p-4 w-full text-gray-700 rounded-full border border-gray-500" required>
            </div>
            <div class="flex flex-col gap-2">
                <p class="text-2xl font-bold">Tag</p>
                <div class="flex flex-wrap gap-3 items-center">
                    <input type="text" id="tagName" placeholder="New Tag" class="p-4 flex-1 min-w-30 text-gray-700 rounded-full border border-gray-500">
                    <div class="flex items-center gap-2">
                        <input type="text" id="colorTop" placeholder="Warna Atas" class="p-4 w-36 text-gray-700 rounded-full border border-gray-500">
                        <div class="h-14 w-14 shrink-0 border border-gray-500 rounded-xl flex items-center justify-center">
                            <div class="color-top w-12 h-12 rounded-xl"></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="text" id="colorBottom" placeholder="Warna Bawah" class="p-4 w-36 text-gray-700 rounded-full border border-gray-500">
                        <div class="h-14 w-14 shrink-0 border border-gray-500 rounded-xl flex items-center justify-center">
                            <div class="color-bottom w-12 h-12 rounded-xl"></div>
                        </div>
                    </div>
                    <div class="h-14 w-14 shrink-0 border border-gray-500 rounded-xl flex items-center justify-center">
                        <div class="color-preview w-12 h-12 rounded-xl"></div>
                    </div>
                    <div class="text-gray-700 border border-gray-500 rounded-xl flex items-center justify-center w-24 h-14 gap-2 shrink-0 cursor-pointer" id="iconBtn">
                        <div id="iconPreview" class="w-6 h-6">
                            <?= icon('tag', 'w-6 h-6') ?>
                        </div>
                        <p>Icon</p>
                        <input type="hidden" id="iconInput" value="tag">
                    </div>
                    <button type="button" id="addTagBtn" class="px-6 py-4 bg-[#2C7CFF] text-white rounded-full self-start">Add Tag</button>
                </div>
                <div id="tagPreview" class="flex gap-3 flex-wrap mt-2"></div>
            </div>
            <textarea name="description" id="mytextarea" placeholder="Enter your ideas here!"></textarea>
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <?= essIcon('linked', 'w-6 h-6') ?>
                    <p class="text-2xl font-bold">Links & Images</p>
                </div>
                <ul class="list-disc ml-5">
                    <li>Add +</li>
                </ul>
            </div>
            <button type="submit" class="px-6 py-3 bg-[#2C7CFF] text-white rounded-full w-full">POST</button>
        </form>
    </div>
</main>

<div class="w-screen h-screen bg-black/50 backdrop-blur-2xl z-10 flex justify-center items-center fixed top-0 left-0 hidden" id="iconPicker">
    <div class="w-50 bg-white rounded-4xl p-5 flex flex-col gap-5 text-[#545F71] items-center">
        <div class="flex justify-between border-b-2 border-[#545F71] pb-2 w-full">
            <p>Icons</p>
            <?= essIcon('x', 'w-6 h-6 cursor-pointer close-picker') ?>
        </div>
        <div class="flex flex-wrap gap-2">
            <?php foreach (icon() as $i): ?>
                <div class="iconOption cursor-pointer p-1 rounded-lg hover:bg-gray-100" data-icon="<?= $i ?>">
                    <?= icon($i, 'w-6 h-6') ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script src="/js/library/tinymce/tinymce.min.js"></script>
<script src="/js/tinymce.js"></script>
<script src="/js/post/create.js"></script>