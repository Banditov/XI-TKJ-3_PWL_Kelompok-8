<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login | ImmaSpark</title>
		<link rel="icon" type="image/x-icon" href="/assets/image/logo/logo.ico">
        <link rel="stylesheet" href="/css/responsive/login.css">
    </head>

    <body class="m-0 h-screen bg-[url('/assets/image/texture/background-l.png')] bg-size-[150%] **:select-none">
        <main class="w-full h-full flex">
            <div id="decorBox" class="p-10 hidden md:flex w-[60%] h-full justify-center items-center">
                <div id="decor" class="**:text-center **:drop-shadow-lg p-4 w-full h-[70%] text-white rounded-3xl bg-clip-padding backdrop-filter backdrop-blur-md bg-opacity-10 border border-gray-100 flex flex-col items-center justify-between">
                    <div class="flex flex-col items-center gap-5 mt-2">
                        <img src="/assets/image/logo/schoolLogo.png" class="w-12.5 h-12.5">
                        <p class="text-[50px] font-bold leading-10">Welcome To</p>
                        <p class="text-[80px] font-bold leading-heading-none name">ImmaSpark</p>
                    </div>
                    <div class="flex flex-col gap-5">
                        <div>
                            <p class="text-2xl">Here lies hundreds of ideas from the school of</p>
                            <p class="font-bold text-4xl">SMK Kristen Immanuel Pontianak</p>
                        </div>
                        <div>
                            <p class="text-2xl"><b>Built</b> by <b>Students</b></p>
                            <p class="text-2xl"><b>Strengthened</b> by <b>Teachers</b></p>
                            <p class="text-2xl"><b>Developed</b> by <b>Everyone</b></p>
                        </div>
                    </div>
                    <b>Virtue In Creativity</b>
                </div>
            </div>
            <div class="bg-white w-full md:w-[40%] h-full p-10 drop-shadow-lg flex flex-col items-center justify-between **:text-[#545F71]">
                <div id="form" class="flex flex-col items-center justify-between h-[70%]">
                    <img src="/assets/image/logo/logo.png" class="w-100">
                    <div class="**:drop-shadow-lg **:text-center flex flex-col items-center mb-7">
                        <b class="text-4xl">Share us your <b class="text-[#2C7CFF]!">ideas</b></b>
                        <p class="text-2xl"><b class="text-[#2C7CFF]!">Together</b>, we’ll help you develop it!</p>
                    </div>
                    <form class="flex flex-col items-center w-full gap-5" action="/posts">
                        <div class="flex flex-col w-full">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="rounded border p-2" placeholder="Enter your email" required>
                        </div>
                        <div class="flex flex-col w-full">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="rounded border p-2" placeholder="Enter your password" required>
                        </div>
                        <div class="flex w-full justify-between">
                            <div class="flex items-center">
                                <input id="keep" type="checkbox">
                                <label for="keep" class="select-none ms-2 text-sm font-medium text-heading">Keep me logged in</label>
                            </div>
                            <a href="/recovery" class="text-[#2C7CFF]! underline">Forgot password?</a>
                        </div>
                        <button type="submit" class="mt-10 bg-linear-to-b from-[#1D7BC5] to-[#004881] w-50 p-3 rounded-full text-white! text-2xl font-bold drop-shadow-2xl">Login</button>
                    </form>
                </div>
                <p class="text-gray-500 text-sm text-center">© 2026 Copyright. All rights reserved.</p>
            </div>
        </main>
    </body>
</html>