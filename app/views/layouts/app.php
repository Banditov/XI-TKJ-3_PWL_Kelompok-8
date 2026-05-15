<?php 
    $currentPath = $_SERVER['REQUEST_URI'] ?? '';
    $isIntroPage = ($currentPath === '/' || $currentPath === '/intro'); 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/output.css">
        <link rel="stylesheet" href="/css/responsive/global.css">
		<link rel="icon" type="image/x-icon" href="/assets/image/logo/logo.ico">
        <link rel="stylesheet" href="/assets/font/anonymouspro/index.css">
    </head>
    <body class="m-0 bg-[url('/assets/image/texture/background-l.png')] bg-size-[150%] **:select-none">
        <script src="/js/modes.js"></script>
        <!-- Loading Screen -->
        <?php if (!$isIntroPage): ?>
            <?php require_once __DIR__ . '/../../../app/views/layouts/partials/loading.php'; ?>
        <?php endif; ?>

        <!-- Error Screen -->
        <?php require_once __DIR__ . '/../../../app/views/error/screen/error.php'; ?>

        <!-- Content -->
        <?= $content ?>

        <!-- Scripts -->
        <script src="/js/global.js"></script>
    </body>
</html>