<?php
$currentPath = $_SERVER['REQUEST_URI'] ?? '';
$isIntroPage = $currentPath === '/';
$applyDarkMode = !$isIntroPage && (isset($_SESSION['is_dark']) && $_SESSION['is_dark']);
?>

<!DOCTYPE html>
<html class="<?= $applyDarkMode ? 'dark' : '' ?>" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <link rel="stylesheet" href="/css/responsive/global.css">
    <link rel="icon" type="image/x-icon" href="/assets/image/logo/logo.ico">
    <link rel="stylesheet" href="/assets/font/anonymouspro/index.css">
    <link rel="stylesheet" href="/assets/font/opendyslexic/index.css">
</head>

<body class="m-0 bg-[url('/assets/image/texture/background-l.png')] bg-size-[150%] **:select-none">
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