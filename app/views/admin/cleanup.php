<title>Cleanup Unused Images | Admin Panel</title>
<link rel="stylesheet" href="/css/responsive/main.css">

<?php include __DIR__ . '/../../../app/views/layouts/partials/navbar.php'; ?>

<main class="md:right-0 md:top-0 md:absolute md:w-[calc(100%-16rem)] p-10 flex flex-col gap-10 grow md:mx-auto">
    <div class="w-full rounded-4xl bg-white text-[#545F71] drop-shadow-lg p-10">
        <h1 class="text-4xl font-bold mb-6">Cleanup Unused Images</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-50 dark:bg-blue-900 p-6 rounded-xl text-center">
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-200"><?= $totalImages ?></p>
                <p class="text-gray-600">Total Images</p>
            </div>
            <div class="bg-green-50 dark:bg-green-900 p-6 rounded-xl text-center">
                <p class="text-3xl font-bold text-green-600 dark:text-green-200"><?= $usedImages ?></p>
                <p class="text-gray-600">Used Images</p>
            </div>
            <div class="bg-red-50 dark:bg-red-900 p-6 rounded-xl text-center">
                <p class="text-3xl font-bold text-red-600 dark:text-red-200"><?= $unusedCount ?></p>
                <p class="text-gray-600">Unused Images</p>
            </div>
        </div>

        <?php if ($unusedCount > 0): ?>
            <div class="mb-6">
                <h2 class="text-2xl font-bold mb-3">Unused Images</h2>
                <div class="max-h-96 overflow-y-auto border rounded-lg p-4">
                    <?php foreach ($unusedImages as $img): ?>
                        <div class="flex items-center gap-3 p-2 border-b">
                            <img src="/assets/image/post/<?= htmlspecialchars($img) ?>" class="w-12 h-12 object-cover rounded">
                            <span class="flex-1"><?= htmlspecialchars($img) ?></span>
                            <span class="text-xs text-gray-500"><?= round(filesize(__DIR__ . '/../../../public/assets/image/post/' . $img) / 1024, 2) ?> KB</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <form action="/admin/cleanup/run" method="POST" onsubmit="return confirm('Are you sure you want to delete <?= $unusedCount ?> unused image(s)? This action cannot be undone.')">
                <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-full hover:bg-white hover:text-red-600 red hover:ring-2 transition cursor-pointer w-full">
                    Delete <?= $unusedCount ?> Unused Image(s)
                </button>
            </form>
        <?php else: ?>
            <div class="bg-green-100 dark:bg-green-950 border border-green-400 dark:border-green-200 dark:text-green-200 text-green-700 px-4 py-3 rounded">
                No unused images found! All images are being used.
            </div>
        <?php endif; ?>
    </div>
</main>