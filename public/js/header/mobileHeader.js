document.addEventListener('DOMContentLoaded', function() {
    const mobileNavBtn = document.getElementById('mobileNavBtn');
    const mobileStngBtn = document.getElementById('mobileStngBtn');
    const mobileNav = document.getElementById('mobileNav');
    const mobileStng = document.getElementById('mobileStng');
    const mobileNavClsBtn = document.getElementById('mobileNavClsBtn');
    const mobileStngClsBtn = document.getElementById('mobileStngClsBtn');

    // Mobile navigation
    if (mobileNavBtn && mobileNav) {
        mobileNavBtn.addEventListener('click', function() {
            mobileNav.classList.remove('hidden');
            mobileNav.classList.add('flex');
            setTimeout(() => {
                mobileNav.classList.remove('opacity-0');
            }, 10);
            document.body.style.overflow = 'hidden';
        });
    }

    if (mobileNavClsBtn && mobileNav) {
        mobileNavClsBtn.addEventListener('click', function() {
            mobileNav.classList.add('opacity-0');
            setTimeout(() => {
                mobileNav.classList.add('hidden');
                mobileNav.classList.remove('flex');
                document.body.style.overflow = '';
            }, 300);
        });
    }

    // Mobile settings
    if (mobileStngBtn && mobileStng) {
        mobileStngBtn.addEventListener('click', function() {
            mobileStng.classList.remove('hidden');
            mobileStng.classList.add('flex');
            setTimeout(() => {
                mobileStng.classList.remove('opacity-0');
            }, 10);
            document.body.style.overflow = 'hidden';
        });
    }

    if (mobileStngClsBtn && mobileStng) {
        mobileStngClsBtn.addEventListener('click', function() {
            mobileStng.classList.add('opacity-0');
            setTimeout(() => {
                mobileStng.classList.add('hidden');
                mobileStng.classList.remove('flex');
                document.body.style.overflow = '';
            }, 300);
        });
    }

    if (mobileNav) {
        mobileNav.addEventListener('click', (e) => {
            if (e.target === mobileNav) {
                mobileNav.classList.add('opacity-0');
                setTimeout(() => {
                    mobileNav.classList.add('hidden');
                    mobileNav.classList.remove('flex');
                    document.body.style.overflow = '';
                }, 300);
            }
        });
    }

    if (mobileStng) {
        mobileStng.addEventListener('click', (e) => {
            if (e.target === mobileStng) {
                mobileStng.classList.add('opacity-0');
                setTimeout(() => {
                    mobileStng.classList.add('hidden');
                    mobileStng.classList.remove('flex');
                    document.body.style.overflow = '';
                }, 300);
            }
        });
    }

    const mobileApplyFilters = document.getElementById('mobileApplyFilters');
    if (mobileApplyFilters) {
        mobileApplyFilters.addEventListener('click', function() {
            const currentPath = window.location.pathname;
            const tag = document.getElementById('mobileTag')?.value || '';
            const votesMin = document.getElementById('mobileVotesMin')?.value || '';
            const votesMax = document.getElementById('mobileVotesMax')?.value || '';
            const viewsMin = document.getElementById('mobileViewsMin')?.value || '';
            const viewsMax = document.getElementById('mobileViewsMax')?.value || '';

            const params = new URLSearchParams();
            if (tag) params.append('tag', tag);
            if (votesMin) params.append('votes_min', votesMin);
            if (votesMax) params.append('votes_max', votesMax);
            if (viewsMin) params.append('views_min', viewsMin);
            if (viewsMax) params.append('views_max', viewsMax);

            window.location.href = currentPath + '?' + params.toString();
        });
    }
});