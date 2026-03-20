<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="refresh" content="3;url=redirect.php">
        <title>Welcome to ImmaSpark!</title>
        <link rel="stylesheet" href="/css/responsive.css">
    </head>

    <script type="module" src="/js/intro.js"></script>

    <body class="bg-[#1865a0] overflow-hidden w-screen h-screen flex items-center justify-center" onclick="window.location.href='redirect.php'">
        <div id="introContainer" class="intro-container bg-white flex items-center justify-center w-200 h-150 rounded-4xl shadow-lg">
            <div class="splash-container fixed inset-0 z-9999 flex items-center justify-center overflow-hidden ">
                <div id="logoContainer" class="logo-container relative z-10 w-200 flex items-center justify-center">
                    <img src="/assets/image/logo/logo.png"></img>
                </div>
                <canvas id="ballsCanvas" class="balls-canvas absolute top-0 left-0 w-full h-full z-20 pointer-none:"></canvas>
            </div>
        </div>
    </body>
</html>