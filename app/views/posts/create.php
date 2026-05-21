<title>Create Post | ImmaSpark</title>
<link rel="stylesheet" href="/css/responsive/main.css">
<link rel="stylesheet" href="/css/responsive/iconPick.css">

<script type="module" src="/js/animation/post.js"></script>

<?php include __DIR__ . '/../../../app/views/layouts/partials/navbar.php'; ?>
<?php include __DIR__ . '/../../../app/helpers/basehelper.php'; ?>

<main class="md:right-0 md:top-0 md:absolute md:w-[calc(100%-16rem)] p-10 flex flex-col gap-10 grow md:mx-auto">
    <div class="w-full rounded-4xl bg-white text-[#545F71] drop-shadow-lg p-10 flex flex-col gap-5 create post">
        <p class="text-4xl font-bold text-center">Share Us Your Ideas!</p>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= $_SESSION['error'];
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'duplicate_title'): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                A post with this title already exists. Please use a different title.
            </div>
        <?php endif; ?>
        <form action="/posts" method="POST" id="postForm" class="flex flex-col gap-5">
            <div class="flex flex-col gap-2">
                <p class="text-2xl font-bold">Title</p>
                <input type="text" name="title" placeholder="Suatu Title"
                    class="p-4 w-full text-gray-700 rounded-full border border-gray-500" required>
            </div>
            <div class="flex flex-col gap-2">
                <p class="text-2xl font-bold">Tag</p>
                <div class="flex flex-wrap gap-3 items-center">
                    <input type="text" id="tagName" placeholder="New Tag"
                        class="p-4 flex-1 min-w-30 text-gray-700 rounded-full border border-gray-500">
                    <div class="flex items-center gap-4">
                        <input type="color" id="colorTop" value="#CCCCCC"
                            class="w-16 h-16 border-gray-500 cursor-pointer rounded-color-picker">
                        <input type="color" id="colorBottom" value="#CCCCCC"
                            class="w-16 h-16 border-gray-500 cursor-pointer rounded-color-picker">
                        <div class="flex flex-col gap-2 ml-2">
                            <div class="color-preview w-16 h-16 rounded-full border border-gray-500"
                                style="background: linear-gradient(to bottom, #CCCCCC, #CCCCCC)"></div>
                        </div>
                    </div>
                    <div class="text-gray-700 border border-gray-500 rounded-xl flex items-center justify-center w-24 h-14 gap-2 shrink-0 cursor-pointer"
                        id="iconBtn">
                        <div id="iconPreview" class="w-6 h-6">
                            <?= icon('tag', 'w-6 h-6') ?>
                        </div>
                        <p>Icon</p>
                        <input type="hidden" id="iconInput" value="tag">
                    </div>
                    <button type="button" id="addTagBtn"
                        class="px-6 py-4 bg-[#2C7CFF] text-white rounded-full self-start hover:bg-white hover:text-[#2C7CFF] hover:ring-2 transition cursor-pointer">Add
                        Tag</button>
                </div>
                <div id="tagPreview" class="flex gap-3 flex-wrap mt-2"></div>
            </div>
            <textarea name="description" id="mytextarea" placeholder="Enter your ideas here!"></textarea>
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-5">
                    <div class="flex items-center gap-2">
                        <?= essIcon('linked', 'w-6 h-6') ?>
                        <p class="text-2xl font-bold">Links, Images, & 3D Model</p>
                    </div>
                    <button type="button" id="openAddLinkImg"
                        class="px-4 py-2 bg-[#2C7CFF] text-white rounded-full text-sm hover:bg-white hover:text-[#2C7CFF] hover:ring-2 transition cursor-pointer">Add
                        +</button>
                </div>
                <div id="mediaPreview" class="flex flex-col gap-2 mt-1"></div>
            </div>
            <button type="submit"
                class="px-6 py-3 bg-[#2C7CFF] text-white rounded-full w-full cursor-pointer hover:bg-white hover:text-[#2C7CFF] hover:ring-2 transition">Post</button>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../../../app/views/layouts/partials/iconPicker.php'; ?>

<!-- Link & Image -->
<div class="w-screen h-screen bg-black/50 backdrop-blur-2xl z-10 flex justify-center items-center fixed top-0 left-0 hidden"
    id="addLinkImg">
    <div
        class="w-75 bg-white rounded-4xl p-5 flex flex-col gap-5 text-[#545F71] items-center max-h-[90vh] overflow-y-auto">
        <div class="w-full flex justify-between items-center border-b-2 border-[#545F71] pb-3">
            <b>Links, Images & 3D Model</b>
            <?= essIcon('x', 'w-6 h-6 cursor-pointer close-media-picker') ?>
        </div>

        <!-- Image upload -->
        <div class="w-full flex flex-col gap-3">
            <b class="text-left">Add Image</b>
            <div id="imageUploadArea"
                class="flex flex-col items-center justify-center text-[#545F71] p-10 rounded-lg bg-gray-100 hover:bg-gray-200 border-2 border-dashed border-[#545F71] cursor-pointer w-full gap-1">
                <?= essIcon('x', 'w-8 h-8 transform rotate-45') ?>
                <p>Add Image</p>
            </div>
            <input type="file" id="imageFileInput" accept="image/*" class="hidden" multiple>
        </div>

        <!-- 3D Model upload -->
        <div class="w-full flex flex-col gap-3 border-t-2 border-[#545F71] pt-3">
            <b class="text-left">Add 3D Model (Max 1)</b>
            <div id="modelUploadArea"
                class="flex flex-col items-center justify-center text-[#545F71] p-10 rounded-lg bg-gray-100 hover:bg-gray-200 border-2 border-dashed border-[#545F71] cursor-pointer w-full gap-1 text-center">
                <?= icon('cube', 'w-8 h-8') ?>
                <p>Add 3D Model (.glb, .gltf, .obj)</p>
                <p class="text-xs text-gray-400">Max 10MB. Only one model allowed.</p>
            </div>
            <input type="file" id="modelFileInput" accept=".glb,.gltf,.obj" class="hidden">
            <div id="modelPreview" class="w-full text-sm text-gray-500"></div>
        </div>

        <!-- Link add -->
        <div class="w-full flex flex-col gap-3 border-t-2 border-[#545F71] pt-3">
            <b class="text-left">Add Link</b>
            <input type="text" id="linkUrl" placeholder="https://example.com"
                class="p-2 w-full text-gray-700 rounded-xl border border-gray-500">
            <input type="text" id="linkText" placeholder="Display text (optional)"
                class="p-2 w-full text-gray-700 rounded-xl border border-gray-500">
            <button type="button" id="addLinkBtn"
                class="px-6 py-3 bg-[#2C7CFF] text-white rounded-full w-full hover:bg-white hover:text-[#2C7CFF] hover:ring-2 transition">Add
                Link</button>
        </div>
    </div>
</div>

<script src="/js/library/tinymce/tinymce.min.js"></script>
<script src="/js/tinymce.js"></script>
<script src="/js/3d/create_edit.js"></script>