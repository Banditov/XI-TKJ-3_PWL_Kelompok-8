<title>Edit Post | ImmaSpark</title>
<link rel="stylesheet" href="/css/responsive/main.css">

<?php include __DIR__ . '/../../../app/views/layouts/partials/navbar/navbar.php'; ?>
<?php include __DIR__ . '/../../../app/helpers/tagText.php'; ?>

<main class="md:right-0 md:top-0 md:absolute md:w-[calc(100%-16rem)] p-10 flex flex-col gap-10 grow md:mx-auto">
    <div class="w-full rounded-4xl bg-white text-[#545F71] drop-shadow-lg p-10 flex flex-col gap-5 create post">
        <form action="/posts/<?= $post['id'] ?>/update" method="POST" id="postForm" class="flex flex-col gap-5">
            <div class="flex flex-col gap-2">
                <p class="text-2xl font-bold">Title</p>
                <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" placeholder="Suatu Title" class="p-4 w-full text-gray-700 rounded-full border border-gray-500" required>
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
                <div id="tagPreview" class="flex gap-3 flex-wrap mt-2">
            <?php if (!empty($post['tags']) && is_array($post['tags'])): ?>
                <?php foreach ($post['tags'] as $tag): ?>
                    <div class="tag-preview-item px-4 py-2 rounded-full flex gap-2 items-center" 
                        style="background: linear-gradient(to bottom, #<?= $tag['color_top'] ?? 'CCCCCC' ?>, #<?= $tag['color_bottom'] ?? 'CCCCCC' ?>); 
                                color: <?= tagTextColor($tag['color_top'] ?? 'CCCCCC', $tag['color_bottom'] ?? 'CCCCCC') ?>">
                        <?= icon($tag['icon'] ?? 'tag', 'w-5 h-5') ?>
                        <span><?= htmlspecialchars($tag['name'] ?? '') ?></span>
                        <button type="button" class="remove-tag ml-1 text-white hover:opacity-60">✕</button>
                        <input type="hidden" name="tag_name[]" value="<?= htmlspecialchars($tag['name'] ?? '') ?>">
                        <input type="hidden" name="tag_color_top[]" value="<?= $tag['color_top'] ?? 'CCCCCC' ?>">
                        <input type="hidden" name="tag_color_bottom[]" value="<?= $tag['color_bottom'] ?? 'CCCCCC' ?>">
                        <input type="hidden" name="tag_icon[]" value="<?= $tag['icon'] ?? 'tag' ?>">
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
                </div>
            </div>
            <textarea name="description" id="mytextarea"><?= htmlspecialchars($post['description']) ?></textarea>
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-5">
                    <div class="flex items-center gap-2">
                        <?= essIcon('linked', 'w-6 h-6') ?>
                        <p class="text-2xl font-bold">Links & Images</p>
                    </div>
                    <button type="button" id="openAddLinkImg" class="px-4 py-2 bg-[#2C7CFF] text-white rounded-full text-sm">Add +</button>
                </div>
                <div id="mediaPreview" class="flex flex-col gap-2 mt-1">
            <?php if (!empty($post['imgs'])): ?>
                <?php foreach ($post['imgs'] as $img): ?>
                    <div class="media-item flex items-center gap-2">
                        <span>📷 <?= htmlspecialchars($img['file_name']) ?></span>
                        <button type="button" class="remove-media text-red-500">&times;</button>
                        <input type="hidden" name="existing_images[]" value="<?= $img['file_name'] ?>">
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (!empty($post['links'])): ?>
                <?php foreach ($post['links'] as $link): ?>
                    <div class="media-item flex items-center gap-2">
                        <span>🔗 <?= htmlspecialchars($link['link']) ?></span>
                        <button type="button" class="remove-media text-red-500">&times;</button>
                        <input type="hidden" name="existing_links[]" value="<?= htmlspecialchars($link['link']) ?>">
                        <input type="hidden" name="existing_link_texts[]" value="<?= htmlspecialchars($link['link_text'] ?? $link['link']) ?>">
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
                </div>
            </div>
            <div class="flex gap-4 w-full flex-col">
                <button type="submit" class="px-6 py-3 bg-[#2C7CFF] text-white rounded-full w-full">Update Post</button>
                <button type="button" id="deletePostBtn" class="px-6 py-3 bg-red-600 text-white rounded-full w-full hover:bg-red-700 transition">DELETE POST</button>
                <a href="/posts/<?= $post['id'] ?>" class="text-[#545F71] rounded-full w-full text-center">Cancel</a>
            </div>
        </form>
    </div>
</main>

<!-- Icon Picker -->
<div class="w-screen h-screen bg-black/50 backdrop-blur-2xl z-10 flex justify-center items-center fixed top-0 left-0 hidden" id="iconPicker">
    <div class="w-50 bg-white rounded-4xl p-5 flex flex-col gap-5 text-[#545F71] items-center">
        <div class="flex justify-between border-b-2 border-[#545F71] pb-2 w-full">
            <p>Icons</p>
            <?= essIcon('x', 'w-6 h-6 cursor-pointer close-icon-picker') ?>
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

<!-- Link & Image -->
<div class="w-screen h-screen bg-black/50 backdrop-blur-2xl z-10 flex justify-center items-center fixed top-0 left-0 hidden" id="addLinkImg">
    <div class="w-75 bg-white rounded-4xl p-5 flex flex-col gap-5 text-[#545F71] items-center">
        <div class="w-full flex justify-between items-center border-b-2 border-[#545F71] pb-3">
            <b>Links & Images</b>
            <?= essIcon('x', 'w-6 h-6 cursor-pointer close-media-picker') ?>
        </div>

        <!-- Image upload -->
        <div class="w-full flex flex-col gap-3">
            <b class="text-left">Add Image</b>
            <div id="imageUploadArea" class="flex flex-col items-center justify-center text-[#545F71] p-10 rounded-lg bg-gray-100 hover:bg-gray-200 border-2 border-dashed border-[#545F71] cursor-pointer w-full gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <p>Add Image</p>
            </div>
            <input type="file" id="imageFileInput" accept="image/*" class="hidden" multiple>
        </div>

        <!-- Link add -->
        <div class="w-full flex flex-col gap-3 border-t-2 border-[#545F71] pt-3">
            <b class="text-left">Add Link</b>
            <input type="text" id="linkUrl" placeholder="https://example.com" class="p-2 w-full text-gray-700 rounded-xl border border-gray-500">
            <input type="text" id="linkText" placeholder="Display text (optional)" class="p-2 w-full text-gray-700 rounded-xl border border-gray-500">
            <button type="button" id="addLinkBtn" class="px-6 py-3 bg-[#2C7CFF] text-white rounded-full w-full">Add Link</button>
        </div>
    </div>
</div>

<script src="/js/library/tinymce/tinymce.min.js"></script>
<script src="/js/tinymce.js"></script>
<script src="/js/post/edit.js"></script>