(function() {
    const loadingScreen = document.getElementById('loadingScreen');
    let startTime = Date.now();
    let isHidden = false;

    window.showLoading = function() {
        if (!loadingScreen) return;
        startTime = Date.now();
        isHidden = false;
        loadingScreen.style.display = 'flex';
        loadingScreen.style.opacity = '1';
        document.body.style.overflow = 'hidden';
    };

    window.hideLoading = function() {
        if (!loadingScreen || isHidden) return;
        isHidden = true;
        const elapsed = Date.now() - startTime;
        const minDisplayTime = 800;
        const remaining = minDisplayTime - elapsed;

        const hide = () => {
            loadingScreen.style.opacity = '0';
            setTimeout(() => {
                loadingScreen.style.display = 'none';
                document.body.style.overflow = '';
            }, 300);
        };

        if (remaining > 0) {
            setTimeout(hide, remaining);
        } else {
            hide();
        }
    };

    window.addEventListener('load', () => {
        window.hideLoading();
    });

    window.showLoading = window.showLoading;
    window.hideLoading = window.hideLoading;
})();