document.addEventListener('DOMContentLoaded', () => {
    const postsContainer = document.getElementById('postsContainer');
    const filterForm = document.getElementById('filterForm');
    const searchForm = document.getElementById('searchForm');
    const searchMobile = document.getElementById('searchFormMobile');

    let controller = null;
    let debounce = null;

    const currentPath = window.location.pathname;
    const baseUrl = currentPath;

    async function applyFilters(params) {
        try {
            if (window.showLoading) window.showLoading();

            if (controller) {
                controller.abort();
            }

            controller = new AbortController();

            const url = baseUrl + '?' + new URLSearchParams(params).toString();

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

            postsContainer.style.minHeight = postsContainer.offsetHeight + 'px';

            const fragment = document.createRange()
                .createContextualFragment(newPosts.innerHTML);

            postsContainer.replaceChildren(fragment);

            if (window.initVoteHandlers) {
                window.initVoteHandlers();
            }

            if (window.initCarousels) {
                window.initCarousels();
            }

            if (window.initPostAnimations) {
                window.initPostAnimations();
            }

            if (window.initImagePreviewOnMedia) {
                window.initImagePreviewOnMedia();
            }

            requestAnimationFrame(() => {
                postsContainer.style.opacity = '1';
                postsContainer.style.minHeight = '';
            });

            if (window.hideLoading) window.hideLoading();

        } catch (err) {
            if (err.name !== 'AbortError') {
                console.error(err);
            }

            postsContainer.style.opacity = '1';

            if (window.hideLoading) window.hideLoading();
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

    if (searchForm) {
        const input = searchForm.querySelector('#search');

        if (input) {
            input.addEventListener('input', () => {
                debounceSearch(() => {
                    applyFilters(
                        getFormData(searchForm, filterForm)
                    );
                });
            });
        }

        searchForm.addEventListener('submit', e => {
            e.preventDefault();
            applyFilters(
                getFormData(searchForm, filterForm)
            );
        });
    }

    if (searchMobile) {
        const input = searchMobile.querySelector('#searchMobile');

        if (input) {
            input.addEventListener('input', () => {
                debounceSearch(() => {
                    applyFilters(
                        getFormData(searchMobile, filterForm)
                    );
                });
            });
        }

        searchMobile.addEventListener('submit', e => {
            e.preventDefault();
            applyFilters(
                getFormData(searchMobile, filterForm)
            );
        });
    }

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