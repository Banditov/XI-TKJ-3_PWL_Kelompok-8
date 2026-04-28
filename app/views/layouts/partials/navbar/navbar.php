<aside class="fixed top-0 left-0 w-64 h-full bg-white overflow-y-scroll drop-shadow-lg **:transition-all **:duration-200 hidden md:block">
    <header class="text-[#545F71] flex items-center p-6 flex-col gap-5">
        <div>
            <img src="/assets/image/logo/logo.png" class="object-contain">
            <div class="w-full h-0.75 bg-[#545F71] rounded-full"></div>
        </div>

        <div class="flex flex-col gap-1 w-full">
            <a href="/posts" class="font-bold text-lg bg-[#2C7CFF] text-white p-2 rounded-2xl flex items-center">
                <?= essIcon('explore', 'w-8 mr-2') ?>
                <p>Explore</p>
            </a>
            <a href="/latest" class="font-bold text-lg p-2 rounded-2xl flex items-center hover:outline-2 hover:outline-[#2C7CFF] bg-transparent">
                <?= essIcon('latest', 'w-8 mr-2') ?>
                <p>Latest</p>
            </a>
            <a href="/pinned" class="font-bold text-lg p-2 rounded-2xl flex items-center hover:outline-2 hover:outline-[#2C7CFF] bg-transparent">
                <?= essIcon('pinned', 'w-8 mr-2') ?>
                <p>Pinned</p>
            </a>
            <a href="/popular" class="font-bold text-lg p-2 rounded-2xl flex items-center hover:outline-2 hover:outline-[#2C7CFF] bg-transparent">
                <?= essIcon('popular', 'w-8 mr-2') ?>
                <p>Popular</p>
            </a>
        </div>
        
        <div class="w-full h-0.75 bg-[#545F71] rounded-full"></div>

        <div class="flex flex-col gap-1 w-full">
            <a href="/create" class="font-bold text-lg p-2 rounded-2xl flex items-center hover:outline-2 hover:outline-[#2C7CFF] bg-transparent">
                <?= essIcon('create', 'w-8 mr-2') ?>
                <p>Create a Post</p>
            </a>
            <a href="/mypost" class="font-bold text-lg p-2 rounded-2xl flex items-center hover:outline-2 hover:outline-[#2C7CFF] bg-transparent">
                <?= essIcon('myPost', 'w-8 mr-2') ?>
                <p>Your Posts</p>
            </a>
            <a href="/notification" class="font-bold text-lg p-2 rounded-2xl flex items-center hover:outline-2 hover:outline-[#2C7CFF] bg-transparent">
                <?= essIcon('notif', 'w-8 mr-2') ?>
                <p>Notification</p>
            </a>
        </div>

        <div class="w-full h-0.75 bg-[#545F71] rounded-full"></div>

        <div class="flex flex-col gap-1 w-full">
            <div class="font-bold text-lg rounded-2xl flex items-center">
                <?= essIcon('filter', 'w-8 mr-2') ?>
                <p>Filter</p>
            </div>
            <div class="flex flex-col gap-1">
                <div class="flex flex-col gap-1">
                    <p>Tag</p>
                    <select id="filter" class="w-full p-2 rounded-lg border-2 border-[#545F71]">
                        <option value="">All Tags</option>
                        <option value="technology">Technology</option>
                        <option value="design">Design</option>
                        <option value="business">Business</option>
                    </select>
                </div>
                <div>
                    <p>Votes</p>
                    <div class="flex gap-2">
                        <input type="number" id="votesMin" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71]" placeholder="Min">
                        <input type="number" id="votesMax" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71]" placeholder="Max">
                    </div>
                </div>
                <div>
                    <p>Views</p>
                    <div class="flex gap-2">
                        <input type="number" id="viewsMin" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71]" placeholder="Min">
                        <input type="number" id="viewsMax" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71]" placeholder="Max">
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full h-0.75 bg-[#545F71] rounded-full"></div>

        <div class="flex items-start flex-col w-full gap-2 font-bold">
            <div class="flex items-center gap-2 w-full">
                <?= essIcon('dark', 'w-10') ?>
                <div class="flex items-center justify-between w-full">
                    <label for="switch-dark-on" class="text-xl cursor-pointer">Dark Mode</label>
                    <div class="relative inline-block w-11 h-5">
                        <input id="switch-dark-on" type="checkbox" class="peer appearance-none w-11 h-5 bg-slate-100 rounded-full checked:bg-slate-800 cursor-pointer transition-colors duration-300" />
                        <label for="switch-dark-on" class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow-sm transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-slate-800 cursor-pointer">
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 w-full">
                <?= essIcon('dysl', 'w-10') ?>
                <div class="flex items-center justify-between w-full">
                    <label for="switch-dyslexic-on" class="text-xl cursor-pointer">Dyslexic</label>
                    <div class="relative inline-block w-11 h-5">
                        <input id="switch-dyslexic-on" type="checkbox" class="peer appearance-none w-11 h-5 bg-slate-100 rounded-full checked:bg-slate-800 cursor-pointer transition-colors duration-300" />
                        <label for="switch-dyslexic-on" class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow-sm transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-slate-800 cursor-pointer">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full h-0.75 bg-[#545F71] rounded-full"></div>

        <div class="font-bold text-lg p-2 rounded-2xl flex items-center hover:outline-2 hover:outline-[#2C7CFF] bg-transparent w-full">
            <?= essIcon('logout', 'w-8 mr-2 fill-current') ?>
            <p>Logout</p>
        </div>
    </header>
</aside>

<!-- Mobile Header -->
<aside class="w-full h-25 text-white bg-clip-padding backdrop-filter backdrop-blur-md bg-opacity-10 border-b border-gray-100 drop-shadow-lg **:transition-all **:duration-200 flex justify-center items-center md:hidden sticky top-0 z-10">
    <header class="text-[#545F71] flex items-center p-10 flex-col gap-5 w-full">
        <div class="flex items-center gap-3 w-full">
            <?= essIcon('dropMenu', 'w-12') ?>
            <div id="searchBar" class="w-full">
                <?= essIcon('searchMbl', 'w-8 absolute left-25 top-1/2 -translate-y-4 z-2') ?>
                <input type="text" id="search" placeholder="Search..." class="p-3 pl-13 w-full text-[#545F71] rounded-full border border-[#545F71] bg-white">
            </div>
            <?= essIcon('settings', 'w-12') ?>
            <?= essIcon('logout', 'w-12 fill-[#ffffff]') ?>
        </div>
    </header>
</aside>

<!-- Mobile Navigation -->
<div id="mobileNav" class="p-10 fixed w-full h-full justify-center items-center flex-col bg-clip-padding backdrop-filter backdrop-blur-md bg-opacity-10 z-900 top-0 left-0 overflow-hidden hidden opacity-0 transition-all">
    <div class="text-[#545F71] flex items-center p-6 flex-col gap-8 bg-white overflow-scroll w-80 rounded-3xl drop-shadow-lg">
        <div>
            <img src="/assets/image/logo/logo.png" class="object-contain">
            <div class="w-full h-0.75 bg-[#545F71] rounded-full"></div>
        </div>

        <div class="flex flex-col gap-1 w-full">
            <a href="/home" class="font-bold text-lg bg-[#2C7CFF] text-white p-2 rounded-2xl flex items-center">
                <?= essIcon('explore', 'w-8 mr-2') ?>
                <p>Explore</p>
            </a>
            <a href="/latest" class="font-bold text-lg p-2 rounded-2xl flex items-center hover:outline-2 hover:outline-[#2C7CFF] bg-transparent">
                <?= essIcon('latest', 'w-8 mr-2') ?>
                <p>Latest</p>
            </a>
            <a href="/pinned" class="font-bold text-lg p-2 rounded-2xl flex items-center hover:outline-2 hover:outline-[#2C7CFF] bg-transparent">
                <?= essIcon('pinned', 'w-8 mr-2') ?>
                <p>Pinned</p>
            </a>
            <a href="/popular" class="font-bold text-lg p-2 rounded-2xl flex items-center hover:outline-2 hover:outline-[#2C7CFF] bg-transparent">
                <?= essIcon('popular', 'w-8 mr-2') ?>
                <p>Popular</p>
            </a>
        </div>

        <div class="flex flex-col gap-1 w-full">
            <a href="/create" class="font-bold text-lg p-2 rounded-2xl flex items-center hover:outline-2 hover:outline-[#2C7CFF] bg-transparent">
                <?= essIcon('create', 'w-8 mr-2') ?>
                <p>Create a Post</p>
            </a>
            <a href="/mypost" class="font-bold text-lg p-2 rounded-2xl flex items-center hover:outline-2 hover:outline-[#2C7CFF] bg-transparent">
                <?= essIcon('myPost', 'w-8 mr-2') ?>
                <p>Your Posts</p>
            </a>
            <a href="/notification" class="font-bold text-lg p-2 rounded-2xl flex items-center hover:outline-2 hover:outline-[#2C7CFF] bg-transparent">
                <?= essIcon('notif', 'w-8 mr-2') ?>
                <p>Notification</p>
            </a>
        </div>

        <div class="flex flex-col gap-1 w-full">
            <div class="font-bold text-lg rounded-2xl flex items-center">
                <?= essIcon('filter', 'w-8 mr-2') ?>
                <p>Filter</p>
            </div>
            <div class="flex flex-col gap-1">
                <div class="flex flex-col gap-1">
                    <p>Tag</p>
                    <select id="filter" class="w-full p-2 rounded-lg border-2 border-[#545F71]">
                        <option value="">All Tags</option>
                        <option value="technology">Technology</option>
                        <option value="design">Design</option>
                        <option value="business">Business</option>
                    </select>
                </div>
                <div>
                    <p>Votes</p>
                    <div class="flex gap-2">
                        <input type="number" id="votesMin" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71]" placeholder="Min">
                        <input type="number" id="votesMax" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71]" placeholder="Max">
                    </div>
                </div>
                <div>
                    <p>Views</p>
                    <div class="flex gap-2">
                        <input type="number" id="viewsMin" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71]" placeholder="Min">
                        <input type="number" id="viewsMax" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71]" placeholder="Max">
                    </div>
                </div>
            </div>
        </div>

        <p id="mobileNavClsBtn" class="font-bold">Close</p>
    </div>
</div>

<div id="mobileStng" class="fixed w-full h-full justify-center items-center flex-col bg-clip-padding backdrop-filter backdrop-blur-md bg-opacity-10 z-900 top-0 left-0 overflow-hidden hidden opacity-0 transition-all">
    <div class="text-[#545F71] flex items-center p-6 flex-col gap-8 bg-white w-80 rounded-3xl drop-shadow-lg">
        <div>
            <img src="/assets/image/logo/logo.png" class="object-contain">
            <div class="w-full h-0.75 bg-[#545F71] rounded-full"></div>
        </div>

        <div class="flex items-start flex-col w-full gap-2 font-bold">
            <div class="flex items-center gap-2 w-full">
                <?= essIcon('dark', 'w-10') ?>
                <div class="flex items-center justify-between w-full">
                    <label for="switch-dark-on" class="text-xl cursor-pointer">Dark Mode</label>
                    <div class="relative inline-block w-11 h-5">
                        <input id="switch-dark-on" type="checkbox" class="peer appearance-none w-11 h-5 bg-slate-100 rounded-full checked:bg-slate-800 cursor-pointer transition-colors duration-300" />
                        <label for="switch-dark-on" class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow-sm transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-slate-800 cursor-pointer">
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 w-full">
                <?= essIcon('dyslexic', 'w-10') ?>
                <div class="flex items-center justify-between w-full">
                    <label for="switch-dyslexic-on" class="text-xl cursor-pointer">Dyslexic</label>
                    <div class="relative inline-block w-11 h-5">
                        <input id="switch-dyslexic-on" type="checkbox" class="peer appearance-none w-11 h-5 bg-slate-100 rounded-full checked:bg-slate-800 cursor-pointer transition-colors duration-300" />
                        <label for="switch-dyslexic-on" class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow-sm transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-slate-800 cursor-pointer">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <p id="mobileStngClsBtn" class="font-bold">Close</p>
    </div>
</div>

<script src="/js/header/mobileHeader.js"></script>