<title>Create Post | ImmaSpark</title>
<link rel="stylesheet" href="/css/responsive/main.css">

<?php include __DIR__ . '/../../../app/views/layouts/partials/navbar/navbar.php'; ?>

<main class="md:right-0 md:top-0 md:absolute md:w-[calc(100%-16rem)] p-10 flex flex-col gap-10 grow md:mx-auto">
    <div class="w-full rounded-4xl bg-white text-[#545F71] drop-shadow-lg p-10 flex flex-col gap-5 create">
        <p class="text-4xl font-bold text-center">Share Us Your Ideas!</p>
        <form action="/posts" method="POST" class="flex flex-col gap-5">
            <div class="flex flex-col gap-2">
                <p class="text-2xl font-bold">Title</p>
                <input type="text" name="title" placeholder="Suatu Title" class="p-4 w-full text-gray-700 rounded-full border border-gray-500" required>
            </div>
            <div class="flex flex-col gap-2">
                <p class="text-2xl font-bold">Tag</p>
                <div class="flex flex-wrap gap-3 items-center">
                    <input type="text" name="tag_name[]" placeholder="New Tag" class="p-4 flex-1 min-w-50 text-gray-700 rounded-full border border-gray-500">
                    <div class="flex items-center gap-2">
                        <input type="text" name="color_top[]" placeholder="Warna Atas" class="p-4 w-36 text-gray-700 rounded-full border border-gray-500">
                        <div class="h-14 w-14 shrink-0 border border-gray-500 rounded-xl flex items-center justify-center">
                            <div class="color-top w-12 h-12 rounded-xl"></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="text" name="color_bottom[]" placeholder="Warna Bawah" class="p-4 w-36 text-gray-700 rounded-full border border-gray-500">
                        <div class="h-14 w-14 shrink-0 border border-gray-500 rounded-xl flex items-center justify-center">
                            <div class="color-bottom w-12 h-12 rounded-xl"></div>
                        </div>
                    </div>
                    <div class="h-14 w-14 shrink-0 border border-gray-500 rounded-xl flex items-center justify-center">
                        <div class="color-preview w-12 h-12 rounded-xl"></div>
                    </div>
                    <div class="text-gray-700 border border-gray-500 rounded-xl flex items-center justify-center w-24 h-14 shrink-0">
                        <p>Icon</p>
                    </div>
                </div>
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

<script src="/js/library/tinymce/tinymce.min.js"></script>
<script src="/js/tinymce.js"></script>
<script src="/js/create.js"></script>