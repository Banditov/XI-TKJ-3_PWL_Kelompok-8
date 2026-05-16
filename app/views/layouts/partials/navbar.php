<?php
    $currentPath = strtok($_SERVER['REQUEST_URI'], '?');

    function navLink($href, $label, $icon) {
        $currentPath = strtok($_SERVER['REQUEST_URI'], '?');
        $isActive = $currentPath === $href;
        $class = $isActive
            ? 'bg-[#2C7CFF] text-white'
            : 'bg-transparent hover:outline-2 hover:outline-[#2C7CFF] hover:text-[#2C7CFF]!';
        echo "<a href=\"$href\" class=\"font-bold text-lg p-2 rounded-2xl flex items-center $class\">
                " . essIcon($icon, 'w-8 mr-2') . "
                <p>$label</p>
            </a>";
    }

    $navFilters = $_SESSION['filter_filters'] ?? [];
    $navTags    = $_SESSION['filter_tags']    ?? [];

    $isDark     = isset($_SESSION['is_dark'])     && $_SESSION['is_dark']     == 1;
    $isDyslexic = isset($_SESSION['is_dyslexic']) && $_SESSION['is_dyslexic'] == 1;

    $allowedSearchPages = ['/posts', '/latest', '/popular', '/pinned', '/mypost'];
    $showSearchBar = in_array($currentPath, $allowedSearchPages);
?>

<script>
    window.userLoggedIn = <?= isset($_SESSION['account_id']) ? 'true' : 'false' ?>;
</script>
<script src="/js/modes.js"></script>

<aside class="fixed top-0 left-0 w-64 h-full bg-white overflow-y-scroll drop-shadow-lg **:transition-all **:duration-200 hidden md:block">
    <header class="text-[#545F71] flex items-center p-6 flex-col gap-5">
        <div>
            <img src="/assets/image/logo/logo.png" class="object-contain">
            <div class="w-full h-0.75 bg-[#545F71] rounded-full seperator"></div>
        </div>

        <div class="flex flex-col gap-1 w-full">
            <?= navLink('/posts', 'Explore', 'explore') ?>
            <?= navLink('/latest', 'Latest', 'latest') ?>
            <?= navLink('/pinned', 'Pinned', 'pinned') ?>
            <?= navLink('/popular', 'Popular', 'popular') ?>
        </div>
        
        <div class="w-full h-0.75 bg-[#545F71] rounded-full seperator"></div>

        <div class="flex flex-col gap-1 w-full">
            <?= navLink('/posts/create', 'Create a Post', 'create') ?>
            <?= navLink('/mypost', 'Your Posts', 'myPost') ?>
            <?= navLink('/notification', 'Notification', 'notif') ?>
        </div>

    <?php if (in_array($currentPath, ['/posts', '/latest', '/popular', '/pinned', '/mypost'])): ?>
        <div class="w-full h-0.75 bg-[#545F71] rounded-full seperator"></div>

        <form method="GET" action="" id="filterForm">
            <input type="hidden" name="search" value="<?= htmlspecialchars($navFilters['search'] ?? '') ?>">
            <div class="font-bold text-lg rounded-2xl flex items-center">
                <?= essIcon('filter', 'w-8 mr-2') ?>
                <p>Filter</p>
            </div>
            <div class="flex flex-col gap-1">
                <div class="flex flex-col gap-1">
                    <p>Tag</p>
                    <select name="tag" class="w-full p-2 rounded-lg border-2 border-[#545F71] cursor-pointer hover:border-[#2C7CFF] hover:text-[#2C7CFF]" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Tags</option>
                <?php foreach ($navTags as $t): ?>
                    <?php if (strtolower($t['name']) !== 'pinned'): ?>
                        <option value="<?= htmlspecialchars($t['name']) ?>" <?= ($navFilters['tag'] ?? '') === $t['name'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['name']) ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <p>Votes</p>
                    <div class="flex gap-2">
                        <input type="number" name="votes_min" value="<?= htmlspecialchars($navFilters['votes_min'] ?? '') ?>" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71] cursor-pointer hover:border-[#2C7CFF] hover:placeholder-[#2C7CFF] hover:text-[#2C7CFF]" placeholder="Min" onchange="document.getElementById('filterForm').submit()">
                        <input type="number" name="votes_max" value="<?= htmlspecialchars($navFilters['votes_max'] ?? '') ?>" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71] cursor-pointer hover:border-[#2C7CFF] hover:placeholder-[#2C7CFF] hover:text-[#2C7CFF]" placeholder="Max" onchange="document.getElementById('filterForm').submit()">
                    </div>
                </div>
                <div>
                    <p>Views</p>
                    <div class="flex gap-2">
                        <input type="number" name="views_min" value="<?= htmlspecialchars($navFilters['views_min'] ?? '') ?>" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71] cursor-pointer hover:border-[#2C7CFF] hover:placeholder-[#2C7CFF] hover:text-[#2C7CFF]" placeholder="Min" onchange="document.getElementById('filterForm').submit()">
                        <input type="number" name="views_max" value="<?= htmlspecialchars($navFilters['views_max'] ?? '') ?>" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71] cursor-pointer hover:border-[#2C7CFF] hover:placeholder-[#2C7CFF] hover:text-[#2C7CFF]" placeholder="Max" onchange="document.getElementById('filterForm').submit()">
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>

        <div class="w-full h-0.75 bg-[#545F71] rounded-full seperator"></div>

        <div class="flex items-start flex-col w-full gap-2 font-bold">
            <div class="flex items-center gap-2 w-full hover:text-[#2C7CFF]">
                <?= essIcon('dark', 'w-10') ?>
                <div class="flex items-center justify-between w-full">
                    <label for="switch-dark-on" class="text-xl cursor-pointer textLbl">Dark Mode</label>
                    <div class="relative inline-block w-11 h-5">
                        <input id="switch-dark-on" type="checkbox" class="peer appearance-none w-11 h-5 bg-slate-100 rounded-full checked:bg-[#2C7CFF] cursor-pointer transition-colors duration-300" <?= $isDark ? 'checked' : '' ?>/>
                        <label for="switch-dark-on" class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow-sm transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-[#2C7CFF] cursor-pointer">
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 w-full hover:text-[#2C7CFF]">
                <?= essIcon('dyslexic', 'w-10') ?>
                <div class="flex items-center justify-between w-full">
                    <label for="switch-dyslexic-on" class="text-xl cursor-pointer textLbl">Dyslexic</label>
                    <div class="relative inline-block w-11 h-5">
                        <input id="switch-dyslexic-on" type="checkbox" class="peer appearance-none w-11 h-5 bg-slate-100 rounded-full checked:bg-[#2C7CFF] cursor-pointer transition-colors duration-300" <?= $isDyslexic ? 'checked' : '' ?>/>
                        <label for="switch-dyslexic-on" class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow-sm transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-[#2C7CFF] cursor-pointer">
                        </label>
                    </div>
                </div>
            </div>
        </div>

    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
        <div class="w-full h-0.75 bg-[#545F71] rounded-full seperator"></div>
        <div class="flex flex-col gap-1 w-full">
            <?= navLink('/admin/cleanup', 'Cleanup Images', 'clean') ?>
        </div>
    <?php endif; ?>

        <div class="w-full h-0.75 bg-[#545F71] rounded-full seperator"></div>

        <p class="font-bold text-lg p-2 rounded-2xl flex items-center hover:outline-2 hover:outline-[#2C7CFF] bg-transparent w-full hover:text-[#2C7CFF] cursor-pointer" onclick="showLogoutModal()">
            <?= essIcon('logout', 'w-8 mr-2 fill-current') ?>
            Logout
        </p>
    </header>
</aside>

<!-- Mobile Header -->
<aside class="w-full h-25 text-white border-b border-white/20 drop-shadow-lg **:transition-all **:duration-200 flex justify-center items-center md:hidden sticky top-0 z-10 backdrop-blur-md bg-gray-800/25">
    <header class="text-[#545F71] flex items-center p-10 flex-col gap-5 w-full">
        <div class="flex items-center gap-3 w-full">
            <?= essIcon('dropMenu', 'w-12 cursor-pointer hover:opacity-60') ?>
        <?php if ($showSearchBar): ?>
            <div id="searchBar" class="w-full">
                <form method="GET" action="<?= $currentPath ?>" id="searchFormMobile">
                    <input type="hidden" name="tag"       value="<?= htmlspecialchars($navFilters['tag'] ?? '') ?>">
                    <input type="hidden" name="votes_min" value="<?= htmlspecialchars($navFilters['votes_min'] ?? '') ?>">
                    <input type="hidden" name="votes_max" value="<?= htmlspecialchars($navFilters['votes_max'] ?? '') ?>">
                    <input type="hidden" name="views_min" value="<?= htmlspecialchars($navFilters['views_min'] ?? '') ?>">
                    <input type="hidden" name="views_max" value="<?= htmlspecialchars($navFilters['views_max'] ?? '') ?>">
                    <?= essIcon('searchMbl', 'w-8 absolute left-25 top-1/2 -translate-y-4 z-2 searchMbl') ?>
                    <input type="text" id="searchMobile" name="search" value="<?= htmlspecialchars($navFilters['search'] ?? '') ?>" placeholder="Search..." class="p-3 pl-13 w-full text-[#545F71] rounded-full border border-[#545F71] bg-white/50 hover:bg-white/70" onchange="this.form.submit()">
                </form>
            </div>
        <?php else: ?>
            <div class="w-full"></div>
        <?php endif; ?>
            <?= essIcon('settings', 'w-12 cursor-pointer hover:opacity-60') ?>
            <div onclick="showLogoutModal()">
                <?= essIcon('logout', 'w-10 fill-[#ffffff] cursor-pointer hover:opacity-60') ?>
            </div>
        </div>
    </header>
</aside>

<!-- Mobile Navigation -->
<div id="mobileNav" class="p-10 fixed w-full h-full justify-center items-center flex-col bg-clip-padding backdrop-filter backdrop-blur-md bg-opacity-10 z-900 top-0 left-0 hidden opacity-0 transition-all">
    <div class="text-[#545F71] flex items-center p-6 flex-col gap-8 bg-white overflow-y-auto max-h-[80vh] w-80 rounded-3xl drop-shadow-lg [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
        <div>
            <img src="/assets/image/logo/logo.png" class="object-contain">
            <div class="w-full h-0.75 bg-[#545F71] rounded-full seperator"></div>
        </div>

        <div class="flex flex-col gap-1 w-full">
            <?= navLink('/posts', 'Explore', 'explore') ?>
            <?= navLink('/latest', 'Latest', 'latest') ?>
            <?= navLink('/pinned', 'Pinned', 'pinned') ?>
            <?= navLink('/popular', 'Popular', 'popular') ?>
        </div>

        <div class="flex flex-col gap-1 w-full">
            <?= navLink('/posts/create', 'Create a Post', 'create') ?>
            <?= navLink('/mypost', 'Your Posts', 'myPost') ?>
            <?= navLink('/notification', 'Notification', 'notif') ?>
        </div>

    <?php if (in_array($currentPath, ['/posts', '/latest', '/popular', '/pinned', '/mypost'])): ?>
        <div class="flex flex-col gap-1 w-full">
            <div class="font-bold text-lg rounded-2xl flex items-center">
                <?= essIcon('filter', 'w-8 mr-2') ?>
                <p>Filter</p>
            </div>
            <div class="flex flex-col gap-1">
                <div class="flex flex-col gap-1">
                    <p>Tag</p>
                    <select name="tag" id="mobileTag" class="w-full p-2 rounded-lg border-2 border-[#545F71] cursor-pointer hover:border-[#2C7CFF] hover:text-[#2C7CFF]">
                        <option value="">All Tags</option>
                <?php foreach ($navTags as $t): ?>
                    <?php if (strtolower($t['name']) !== 'pinned'): ?>
                        <option value="<?= htmlspecialchars($t['name']) ?>" <?= ($navFilters['tag'] ?? '') === $t['name'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['name']) ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <p>Votes</p>
                    <div class="flex gap-2">
                        <input type="number" id="mobileVotesMin" name="votes_min" value="<?= htmlspecialchars($navFilters['votes_min'] ?? '') ?>" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71]" placeholder="Min">
                        <input type="number" id="mobileVotesMax" name="votes_max" value="<?= htmlspecialchars($navFilters['votes_max'] ?? '') ?>" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71]" placeholder="Max">
                    </div>
                </div>
                <div>
                    <p>Views</p>
                    <div class="flex gap-2">
                        <input type="number" id="mobileViewsMin" name="views_min" value="<?= htmlspecialchars($navFilters['views_min'] ?? '') ?>" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71]" placeholder="Min">
                        <input type="number" id="mobileViewsMax" name="views_max" value="<?= htmlspecialchars($navFilters['views_max'] ?? '') ?>" class="w-full p-2 rounded-lg border-2 border-[#545F71] placeholder:text-[#545F71]" placeholder="Max">
                    </div>
                </div>
                <button id="mobileApplyFilters" class="mt-2 px-4 py-2 bg-[#2C7CFF] text-white rounded-full w-full hover:bg-white hover:text-[#2C7CFF] hover:ring-2 transition">Apply Filters</button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
        <div class="flex flex-col gap-1 w-full">
            <?= navLink('/admin/cleanup', 'Cleanup Images', 'clean') ?>
        </div>
    <?php endif; ?>

        <p id="mobileNavClsBtn" class="font-bold cursor-pointer hover:underline">Close</p>
    </div>
</div>

<div id="mobileStng" class="fixed w-full h-full justify-center items-center flex-col bg-clip-padding backdrop-filter backdrop-blur-md bg-opacity-10 z-900 top-0 left-0 overflow-hidden hidden opacity-0 transition-all">
    <div class="text-[#545F71] flex items-center p-6 flex-col gap-8 bg-white w-80 rounded-3xl drop-shadow-lg">
        <div>
            <img src="/assets/image/logo/logo.png" class="object-contain">
            <div class="w-full h-0.75 bg-[#545F71] rounded-full seperator"></div>
        </div>

        <div class="flex items-start flex-col w-full gap-2 font-bold">
            <div class="flex items-center gap-2 w-full hover:text-[#2C7CFF]">
                <?= essIcon('dark', 'w-10') ?>
                <div class="flex items-center justify-between w-full">
                    <label for="mobileSwitchDark" class="text-xl cursor-pointer textLbl">Dark Mode</label>
                    <div class="relative inline-block w-11 h-5">
                        <input id="mobileSwitchDark" type="checkbox" class="peer appearance-none w-11 h-5 bg-slate-100 rounded-full checked:bg-[#2C7CFF] cursor-pointer transition-colors duration-300" <?= $isDark ? 'checked' : '' ?>/>
                        <label for="mobileSwitchDark" class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow-sm transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-[#2C7CFF] cursor-pointer">
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 w-full hover:text-[#2C7CFF]">
                <?= essIcon('dyslexic', 'w-10') ?>
                <div class="flex items-center justify-between w-full">
                    <label for="mobileSwitchDyslexic" class="text-xl cursor-pointer textLbl">Dyslexic</label>
                    <div class="relative inline-block w-11 h-5">
                        <input id="mobileSwitchDyslexic" type="checkbox" class="peer appearance-none w-11 h-5 bg-slate-100 rounded-full checked:bg-[#2C7CFF] cursor-pointer transition-colors duration-300" <?= $isDark ? 'checked' : '' ?>/>
                        <label for="mobileSwitchDyslexic" class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow-sm transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-[#2C7CFF] cursor-pointer">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <p id="mobileStngClsBtn" class="font-bold cursor-pointer hover:underline">Close</p>
    </div>
</div>

<!-- Logout Confirmation -->
<div id="logoutModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-all duration-300">
    <div class="w-80 bg-white rounded-3xl p-6 flex flex-col gap-5 text-[#545F71] items-center shadow-2xl transform transition-all duration-300 scale-95 opacity-0" id="logoutModalContent">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
            <?= icon('important', 'w-10 text-red-500'); ?>
        </div>
        <p class="text-xl font-bold text-center">Logout Confirmation</p>
        <p class="text-center text-gray-500">Are you sure you want to logout from ImmaSpark?</p>
        <div class="flex gap-3 w-full mt-2">
            <button id="confirmLogoutBtn" class="flex-1 px-4 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition font-medium cursor-pointer">
                Yes, Logout
            </button>
            <button id="cancelLogoutBtn" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition font-medium cursor-pointer">
                Cancel
            </button>
        </div>
    </div>
</div>

<script src="/js/header/mobileHeader.js"></script>
<script src="/js/header/logout.js"></script>