<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home | ImmaSpark</title>
		<link rel="icon" type="image/x-icon" href="/assets/image/logo/logo.ico">
        <link rel="stylesheet" href="/css/responsive.css">
    </head>

    <body class="grow md:container m-0 md:mx-auto bg-[image:url('/assets/image/texture/background-l.png')] bg-cover bg-size-[150%] [&_*]:select-none">
        <?php include __DIR__ . '/../../../app/views/component/error/error.php'; ?>
        <?php include __DIR__ . '/../../../app/views/component/header/header.php'; ?>

        <main class="md:right-0 md:top-0 md:absolute md:w-[calc(100%-16rem)] p-10 flex flex-col gap-10">
            <div id="searchBar" class="z-2 sticky top-10 w-full md:block hidden">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" id="searchBarIcon" class="w-8 absolute left-4 top-1/2 -translate-y-4 z-2" viewBox="100 100 700 700">
                    <path fill="#FFF" stroke="#FFF" stroke-width="8" d="M384.8 206.1c-106 8.5-186.7 102-178.7 207.1 11.5 152.7 183.7 233.4 307.8 144.3l9.3-6.7 71.2 71c68.6 68.5 71.3 71 75.9 72 14.7 3 26.5-8.8 23.5-23.6-1-4.5-3.5-7.2-72-75.8l-71-71.2 6.7-9.3c96.3-134.2-8.4-321-172.7-307.8zm49.2 42.2c92.4 21.9 144.3 117.8 111.5 206.2-29.5 79.7-119.7 120.8-200 91-79.7-29.5-120.8-119.7-91-200 19.8-53.5 67.2-91.1 126-99.9 9.6-1.4 43.2.3 53.5 2.7z"/>
                </svg>
                <input type="text" placeholder="Search..." class="p-4 pl-14 w-full text-white rounded-full bg-clip-padding backdrop-filter backdrop-blur-md bg-opacity-10 border border-gray-100">
            </div>

            <div class="w-full rounded-4xl bg-white text-[#545F71] drop-shadow-lg post">
                <div class="md:pt-10 md:pr-10 md:pl-10 pb-5 pt-7 pr-7 pl-7 flex flex-col md:gap-3 gap-5">
                    <div class="flex justify-between items-center">
                        <div class="flex gap-5 items-center">
                            <img src="/assets/image/account/phototest.jpg" class="w-15 h-15 object-cover rounded-full drop-shadow-lg">
                            <div>
                                <p class="text-3xl font-bold">Christopher V. C.</p>
                                <p>XI TKJ 3</p>
                            </div>
                        </div>
                        <p class="text-3xl font-bold">16/03/2026</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex gap-5">
                            <p class="px-6 py-3 bg-gradient-to-b from-stone-500 to-stone-700 text-white rounded-full drop-shadow-lg">TEMPLATE</p>
                        </div>
                        <div class="flex items-center gap-5">
                            <div class="flex px-4 py-2 bg-[#2C7CFF] text-white rounded-full items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="100 100 700 700" fill="#ffffff" stroke="#ffffff" class="w-7 h-7 transform rotate-180">
                                    <path stroke-width="20" d="M270.1 356.2c-9.7 2.1-16.1 12.9-13.9 23.5 1.5 7.5 181.6 187.6 189.1 189.1 11.8 2.4 3.5 9.7 105.9-92.6 88.8-88.9 91.6-91.8 92.6-96.5 3-14.7-8.8-26.5-23.5-23.5-4.6 1-7.5 3.7-87.5 83.6L450 522.5l-82.7-82.7C297 369.6 284 357.1 281 356.5c-1.9-.3-4.2-.8-5-1-.8-.1-3.5.2-5.9.7z"/>
                                </svg>
                                <p class="text-2xl">1</p>
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="100 100 700 700" fill="#ffffff" stroke="#ffffff" class="w-7 h-7">
                                    <path stroke-width="20" d="M270.1 356.2c-9.7 2.1-16.1 12.9-13.9 23.5 1.5 7.5 181.6 187.6 189.1 189.1 11.8 2.4 3.5 9.7 105.9-92.6 88.8-88.9 91.6-91.8 92.6-96.5 3-14.7-8.8-26.5-23.5-23.5-4.6 1-7.5 3.7-87.5 83.6L450 522.5l-82.7-82.7C297 369.6 284 357.1 281 356.5c-1.9-.3-4.2-.8-5-1-.8-.1-3.5.2-5.9.7z"/>
                                </svg>
                            </div>
                            <div class="flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="100 100 700 700" fill="#545F71" stroke="#545F71" class="w-10 h-10">
                                    <g stroke-width="8">
                                        <path d="M433 256c-107.3 7.3-200.1 76.9-236.4 177.2-5.4 15.1-5.6 17.9-1.5 29.3 48.7 138 193.3 211.9 333.2 170.4 80-23.8 146.3-86.7 175.2-166.3 5.5-15.3 5.5-17.6.6-31.3C663.2 321.4 552.2 247.9 433 256zm46.7 40.5c82.6 10.7 155 67.1 184.7 143.7 4.4 11.4 4.1 13-9.1 39.3-84 168.1-329.5 166.5-412.1-2.8-11.5-23.6-11.8-25.1-7.9-35.4 37.9-98.1 139.6-158.4 244.4-144.8z"/><path d="M443.5 355.7c-79.6 6.5-116.5 100.9-62.2 159 40 42.7 109.8 38.6 144.6-8.5 38.7-52.6 14.2-126.8-48.6-146.5-6.6-2.1-26.6-5.2-29.2-4.5-.3.1-2.4.3-4.6.5zm21 40.8c40.6 10.6 54.4 62.5 24.5 92.5-34.7 34.9-94 10.3-94-39 0-36.5 34-62.7 69.5-53.5z"/>
                                    </g>
                                </svg>
                                <p class="text-2xl">15</p>
                            </div>
                            <div class="flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="100 100 700 700" fill="#545F71" stroke="#545F71" class="w-10 h-10">
                                    <g stroke-width="8">
                                        <path d="M433 231c-176 11.9-281.3 181.4-199.4 321.1 4.4 7.6 4.4 7.6-11.1 49-20.1 53.4-20.1 53.4-11 62.4 7.8 7.8 5.5 8 71.4-5.2 57.6-11.5 57.6-11.5 62.1-9.7 130.7 51.3 274.4 2.6 329.5-111.8C746.8 386.8 614 218.7 433 231zm43.5 40c128.8 14.7 210.1 130.5 167.4 238.4-40.5 102.3-174.7 150.3-285.4 102.1-13.4-5.8-10.7-6-60 3.9-23.1 4.6-42.1 8.3-42.3 8.1-.2-.1 4.9-14.1 11.3-31 12.7-34.1 13.5-37.7 9.2-44.7-1.2-2-4.6-7.5-7.5-12.2-79.5-128 42.2-283.3 207.3-264.6z"/><path d="M345.1 431.2c-6.1 1.4-12.5 7.9-13.9 14.2-4.2 19.6 19.8 32.4 33.1 17.7 13.2-14.6.2-36.2-19.2-31.9zm100 0c-6.1 1.4-12.5 7.9-13.9 14.2-4.2 19.6 19.8 32.4 33.1 17.7 13.2-14.6.2-36.2-19.2-31.9zm100 0c-6.1 1.4-12.5 7.9-13.9 14.2-4.2 19.6 19.8 32.4 33.1 17.7 13.2-14.6.2-36.2-19.2-31.9z"/>
                                    </g>
                                </svg>
                                <p class="text-2xl">3</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="100 100 700 700" fill="#545F71" stroke="#545F71" class="w-10 h-10">
                                <path stroke-width="8" d="M222.9 211c-7.9 4.2-12 12.7-10.1 21 .6 2.5 15.7 52.1 33.6 110.2 17.9 58.2 32.6 106.6 32.6 107.7s-15 50.5-33.2 109.8c-35.4 114.8-35.3 114.4-31.3 121.3 7.1 11.9 13.6 12.5 42.5 3.7 150.1-45.9 294.2-116.1 423.6-206.3 25.2-17.5 28.1-21.2 25.4-32.6-1.7-7-4.1-9.3-22.3-22.1C554.5 333.1 410.4 262.6 259.2 216c-24.8-7.6-30-8.3-36.3-5zm56.3 52.4c109.9 36.4 219.7 88.1 318.3 149.9 16 10 55.5 36.1 55.5 36.7 0 .7-34.5 23.6-56.3 37.3-82 51.4-175.7 97.6-268.6 132.2-27.9 10.4-65 22.9-65.8 22.1-.3-.3 11.2-39.1 25.7-86.1l26.3-85.5h86.6c47.6 0 88.3-.4 90.4-.9 17.4-4.1 21.2-26.9 5.9-35.9-4.7-2.7-4.7-2.7-93.9-3-83.4-.2-89.2-.4-89.7-2-.3-.9-12-39.1-26.1-84.8-14-45.7-25.5-83.6-25.5-84.3 0-1.5-1.1-1.8 17.2 4.3z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-4xl font-bold">POST TITLE</p>
                    <p class="text-2xl md:text-lg text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dignissim malesuada ullamcorper. Phasellus lobortis augue quis consectetur lacinia. Suspendisse sed dolor quis nibh dictum hendrerit. Donec ac dolor consequat, egestas ligula eget, fringilla leo. Phasellus viverra libero id accumsan rhoncus.</p>
                </div>
                <div class="h-75 max-h-75 relative">
                    <button class="absolute left-10 top-30 p-4 rounded-full text-white drop-shadow-lg bg-clip-padding backdrop-filter backdrop-blur-md bg-opacity-10 border border-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="100 100 700 700" fill="#ffffff" stroke="#ffffff" class="w-7 h-7 transform rotate-90">
                            <path stroke-width="20" d="M270.1 356.2c-9.7 2.1-16.1 12.9-13.9 23.5 1.5 7.5 181.6 187.6 189.1 189.1 11.8 2.4 3.5 9.7 105.9-92.6 88.8-88.9 91.6-91.8 92.6-96.5 3-14.7-8.8-26.5-23.5-23.5-4.6 1-7.5 3.7-87.5 83.6L450 522.5l-82.7-82.7C297 369.6 284 357.1 281 356.5c-1.9-.3-4.2-.8-5-1-.8-.1-3.5.2-5.9.7z"/>
                        </svg>
                    </button>
                    <img src="/assets/image/post/posttest.png" class="rounded-4xl w-full h-full object-cover">
                    <button class="absolute right-10 top-30 p-4 rounded-full text-white drop-shadow-lg bg-clip-padding backdrop-filter backdrop-blur-md bg-opacity-10 border border-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="100 100 700 700" fill="#ffffff" stroke="#ffffff" class="w-7 h-7 transform rotate-270">
                            <path stroke-width="20" d="M270.1 356.2c-9.7 2.1-16.1 12.9-13.9 23.5 1.5 7.5 181.6 187.6 189.1 189.1 11.8 2.4 3.5 9.7 105.9-92.6 88.8-88.9 91.6-91.8 92.6-96.5 3-14.7-8.8-26.5-23.5-23.5-4.6 1-7.5 3.7-87.5 83.6L450 522.5l-82.7-82.7C297 369.6 284 357.1 281 356.5c-1.9-.3-4.2-.8-5-1-.8-.1-3.5.2-5.9.7z"/>
                        </svg>
                    </button>
                    <div class="absolute left-1/2 bottom-8">
                        <div class="w-4 h-4 bg-white rounded-full opacity-80"></div>
                    </div>
                </div>
            </div>

            <div id="endMsg" class="w-full p-3 flex justify-center bg-white rounded-full drop-shadow-lg">
                <p class="text-xl font-bold">End of the line!</p>
            </div>
        </main>
    </body>
</html>