<script type="module" src="/js/animation/post.js"></script>
<script type="importmap">
{
    "imports": {
        "three": "/js/library/three/three.module.js",
        "three/addons/": "/js/library/jsm/"
    }
}
</script>

<?php if (!empty($post['imgs']) || !empty($post['model_3d'])): ?>
    <div class="relative overflow-hidden rounded-4xl carousel-wrapper group" data-post-id="<?= $post['id'] ?>">

        <div class="flex gap-2 absolute top-2 left-1/2 transform -translate-x-1/2 z-10">
    <?php if (!empty($post['imgs']) && !empty($post['model_3d'])): ?>
            <button type="button" class="carousel-tab px-3 py-1 text-white drop-shadow-lg backdrop-blur-md bg-gray-800/25 border border-white z-1 rounded-full text-sm font-medium transition hover:bg-white hover:text-black" data-tab="images">
                Images
            </button>
    <?php endif; ?>
    <?php if (!empty($post['model_3d']) && !empty($post['imgs'])): ?>
            <button type="button" class="carousel-tab px-3 py-1 text-white drop-shadow-lg backdrop-blur-md bg-gray-800/25 border border-white z-1 rounded-full text-sm font-medium transition hover:bg-white hover:text-black" data-tab="model">
                3D Model
            </button>
    <?php endif; ?>
        </div>

    <?php if (!empty($post['imgs'])): ?>
        <div class="carousel-tab-content" data-tab="images" style="display: block;">
            <div class="h-75 max-h-75 relative overflow-hidden">
                <div class="carousel-track flex h-full transition-transform duration-300 ease-in-out" style="width: <?= count($post['imgs']) * 100 ?>%">
            <?php foreach ($post['imgs'] as $index => $img): ?>
                    <div class="carousel-slide h-full" style="width: <?= 100 / count($post['imgs']) ?>%">
                        <img src="/assets/image/post/<?= htmlspecialchars($img['file_name']) ?>"
                            class="w-full h-full object-cover carousel-img cursor-pointer"
                            data-src="/assets/image/post/<?= htmlspecialchars($img['file_name']) ?>"
                            onclick="openOverlay(this.dataset.src)">
                    </div>
            <?php endforeach; ?>
                </div>
        <?php if (count($post['imgs']) > 1): ?>
                <button class="carousel-prev absolute left-4 top-1/2 -translate-y-1/2 p-3 rounded-full text-white drop-shadow-lg backdrop-blur-md bg-gray-800/25 border border-white hover:bg-white hover:text-black z-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 cursor-pointer">
                    <?= essIcon('arrow', 'w-6 h-6 transform rotate-90') ?>
                </button>
                <button class="carousel-next absolute right-4 top-1/2 -translate-y-1/2 p-3 rounded-full text-white drop-shadow-lg backdrop-blur-md bg-gray-800/25 border border-white hover:bg-white hover:text-black z-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 cursor-pointer">
                    <?= essIcon('arrow', 'w-6 h-6 transform -rotate-90') ?>
                </button>
                <div class="absolute left-1/2 -translate-x-1/2 bottom-4 flex gap-2 z-1">
            <?php foreach ($post['imgs'] as $index => $img): ?>
                    <div class="carousel-dot w-3 h-3 rounded-full cursor-pointer transition-opacity duration-200 hover:scale-125 <?= $index === 0 ? 'bg-white opacity-100' : 'bg-white opacity-40' ?>" data-index="<?= $index ?>"></div>
            <?php endforeach; ?>
                </div>
        <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($post['model_3d'])): ?>
        <div class="carousel-tab-content" data-tab="model" style="display: none;">
            <div class="h-75 max-h-75 relative bg-linear-to-br from-gray-900 to-gray-800 flex items-center justify-center model-placeholder cursor-pointer" 
                data-model-url="/assets/models/<?= $post['model_3d'] ?>" 
                data-model-type="<?= pathinfo($post['model_3d'], PATHINFO_EXTENSION) ?>"
                onclick="load3DModel(this)">
                <div class="text-center text-white">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                    <p class="text-lg font-medium">Click to load 3D model</p>
                    <p class="text-sm opacity-70 mt-1">Drag to rotate • Right-click to pan • Scroll to zoom</p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    </div>
<?php endif; ?>


<script src="/js/post/carousel.js"></script>