document.addEventListener('DOMContentLoaded', () => {
    const postsContainer = document.getElementById('postsContainer');
    const filterForm = document.getElementById('filterForm');
    const searchForm = document.getElementById('searchForm');
    const searchMobile = document.getElementById('searchFormMobile');

    let controller = null;
    let debounce = null;

    async function applyFilters(params) {
        try {
            if (controller) {
                controller.abort();
            }

            controller = new AbortController();

            const url = '/posts?' + new URLSearchParams(params).toString();

            postsContainer.style.opacity = '0.5';

            const res = await fetch(url, {
                signal: controller.signal,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const html = await res.text();

            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            const newPosts = doc.getElementById('postsContainer');

            if (!newPosts) return;

            postsContainer.style.minHeight =
                postsContainer.offsetHeight + 'px';

            const fragment = document.createRange()
                .createContextualFragment(newPosts.innerHTML);

            postsContainer.replaceChildren(fragment);

            if (window.initVoteHandlers) {
                window.initVoteHandlers();
            }

            requestAnimationFrame(() => {
                postsContainer.style.opacity = '1';
                postsContainer.style.minHeight = '';
            });

            if (window.initCarousels) {
                window.initCarousels();
            }

        } catch (err) {
            if (err.name !== 'AbortError') {
                console.error(err);
            }

            postsContainer.style.opacity = '1';
        }
    }

    function getFormData(...forms) {
        const params = {};

        forms.forEach(form => {
            if (!form) return;

            const data = new FormData(form);

            for (const [key, value] of data.entries()) {
                if (value) {
                    params[key] = value;
                }
            }
        });

        return params;
    }

    function debounceSearch(callback, delay = 300) {
        clearTimeout(debounce);

        debounce = setTimeout(callback, delay);
    }

    // Desktop search
    if (searchForm) {
        const input = searchForm.querySelector('#search');

        input?.addEventListener('input', () => {
            debounceSearch(() => {
                applyFilters(
                    getFormData(searchForm, filterForm)
                );
            });
        });

        searchForm.addEventListener('submit', e => {
            e.preventDefault();

            applyFilters(
                getFormData(searchForm, filterForm)
            );
        });
    }

    // Mobile search
    if (searchMobile) {
        const input = searchMobile.querySelector('#searchMobile');

        input?.addEventListener('input', () => {
            debounceSearch(() => {
                applyFilters(
                    getFormData(searchMobile, filterForm)
                );
            });
        });

        searchMobile.addEventListener('submit', e => {
            e.preventDefault();

            applyFilters(
                getFormData(searchMobile, filterForm)
            );
        });
    }

    // Filters
    if (filterForm) {
        const inputs = filterForm.querySelectorAll(
            'select, input[type="number"]'
        );

        inputs.forEach(input => {
            input.addEventListener('change', () => {
                applyFilters(
                    getFormData(searchForm, searchMobile, filterForm)
                );
            });
        });
    }
});