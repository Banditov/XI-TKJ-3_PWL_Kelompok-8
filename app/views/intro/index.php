<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="refresh" content="3;url=/test">
        <title>Welcome to ImmaSpark!</title>
		<link rel="icon" type="image/x-icon" href="/assets/image/logo/logo.ico">
        <link rel="stylesheet" href="/css/intro.css">
    </head>

    <body class="bg-black overflow-hidden w-screen h-screen flex items-center justify-center" onclick="window.location.href='/test'">
        <div class="intro-container bg-white flex items-center justify-center w-[50%] h-[50%] rounded-4xl shadow-lg">
            <div id="splash" class="splash-container fixed inset-0 z-9999 flex items-center justify-center overflow-hidden">
                <div id="logoContainer" class="logo-container relative z-10 w-125 flex items-center justify-center">
                    <img src="/assets/image/logo/logo.png"></img>
                </div>
                <canvas id="ballsCanvas" class="balls-canvas absolute top-0 left-0 w-full h-full z-20 pointer-none:"></canvas>
            </div>
        </div>
    </body>
</html>