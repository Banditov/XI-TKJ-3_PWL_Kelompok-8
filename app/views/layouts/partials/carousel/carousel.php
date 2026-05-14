<?php if (!empty($post['imgs'])): ?>
    <div class="h-75 max-h-75 relative overflow-hidden rounded-4xl carousel-wrapper group" data-post-id="<?= $post['id'] ?>">
        <div class="carousel-track flex h-full transition-transform duration-300 ease-in-out" style="width: <?= count($post['imgs']) * 100 ?>%">
    <?php foreach ($post['imgs'] as $index => $img): ?>
            <div class="carousel-slide h-full" style="width: <?= 100 / count($post['imgs']) ?>%">
                <img src="/assets/image/post/<?= htmlspecialchars($img['file_name']) ?>"
                    class="w-full h-full object-cover carousel-img cursor-pointer"
                    data-src="/assets/image/post/<?= htmlspecialchars($img['file_name']) ?>">
            </div>
    <?php endforeach; ?>
        </div>
<?php if (count($post['imgs']) > 1): ?>
        <button class="carousel-prev absolute left-4 top-1/2 -translate-y-1/2 p-3 rounded-full text-white drop-shadow-lg backdrop-blur-md bg-gray-800/25 border border-gray-100 z-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 cursor-pointer">
            <?= essIcon('arrow', 'w-6 h-6 transform rotate-90') ?>
        </button>
        <button class="carousel-next absolute right-4 top-1/2 -translate-y-1/2 p-3 rounded-full text-white drop-shadow-lg backdrop-blur-md bg-gray-800/25 border border-gray-100 z-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 cursor-pointer">
            <?= essIcon('arrow', 'w-6 h-6 transform -rotate-90') ?>
        </button>
        <div class="absolute left-1/2 -translate-x-1/2 bottom-4 flex gap-2 z-1">
    <?php foreach ($post['imgs'] as $index => $img): ?>
            <div class="carousel-dot w-3 h-3 rounded-full cursor-pointer transition-opacity duration-200 <?= $index === 0 ? 'bg-white opacity-100' : 'bg-white opacity-40' ?>"
                data-index="<?= $index ?>">
            </div>
    <?php endforeach; ?>
        </div>
<?php endif; ?>
    </div>
<?php endif; ?>