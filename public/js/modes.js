(function() {
    const savedMode = localStorage.getItem('dyslexicMode');
    const isEnabled = savedMode === 'true';

    if (isEnabled) {
        document.documentElement.classList.add('dyslexic-mode');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const dyslexicToggleDesktop = document.getElementById('switch-dyslexic-on');
        const dyslexicToggleMobile = document.getElementById('mobileSwitchDyslexic');

        function updateMode(enabled) {
            if (enabled) {
                document.documentElement.classList.add('dyslexic-mode');
            } else {
                document.documentElement.classList.remove('dyslexic-mode');
            }

            if (dyslexicToggleDesktop) dyslexicToggleDesktop.checked = enabled;
            if (dyslexicToggleMobile) dyslexicToggleMobile.checked = enabled;

            localStorage.setItem('dyslexicMode', enabled);

            fetch('/settings/dyslexic', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'dyslexic=' + (enabled ? 1 : 0)
            }).catch(err => console.error('Failed to save:', err));
        }

        if (isEnabled) {
            if (dyslexicToggleDesktop) dyslexicToggleDesktop.checked = true;
            if (dyslexicToggleMobile) dyslexicToggleMobile.checked = true;
        }

        if (dyslexicToggleDesktop) {
            dyslexicToggleDesktop.addEventListener('change', function(e) {
                updateMode(e.target.checked);
            });
        }

        if (dyslexicToggleMobile) {
            dyslexicToggleMobile.addEventListener('change', function(e) {
                updateMode(e.target.checked);
            });
        }
    });
})();