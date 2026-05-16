(function() {
    const isLoggedIn = window.userLoggedIn === true;

    const modes = [
        {
            localKey:  'dyslexicMode',
            className: 'dyslexic-mode',
            endpoint:  '/settings/dyslexic',
            bodyKey:   'dyslexic',
            desktopId: 'switch-dyslexic-on',
            mobileId:  'mobileSwitchDyslexic',
        },
        {
            localKey:  'darkMode',
            className: 'dark',
            endpoint:  '/settings/dark',
            bodyKey:   'dark',
            desktopId: 'switch-dark-on',
            mobileId:  'mobileSwitchDark',
        },
    ];

    modes.forEach(function(mode) {
        if (!isLoggedIn) {
            localStorage.removeItem(mode.localKey);
            document.documentElement.classList.remove(mode.className);
            return;
        }

        const isEnabled = localStorage.getItem(mode.localKey) === 'true';

        if (isEnabled) {
            document.documentElement.classList.add(mode.className);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const desktopToggle = document.getElementById(mode.desktopId);
            const mobileToggle  = document.getElementById(mode.mobileId);

            function updateMode(enabled) {
                document.documentElement.classList.toggle(mode.className, enabled);

                if (desktopToggle) desktopToggle.checked = enabled;
                if (mobileToggle)  mobileToggle.checked  = enabled;

                localStorage.setItem(mode.localKey, enabled);

                fetch(mode.endpoint, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: mode.bodyKey + '=' + (enabled ? 1 : 0)
                }).catch(err => console.error('Failed to save ' + mode.localKey + ':', err));

                if (mode.className === 'dark' && typeof tinymce !== 'undefined' && tinymce.get('mytextarea')) {
                    const content = tinymce.get('mytextarea').getContent();
                    tinymce.remove('#mytextarea');
                    tinymce.init({
                        selector: '#mytextarea',
                        resize: false,
                        promotion: false,
                        branding: false,
                        elementpath: false,
                        statusbar: false,
                        license_key: 'gpl',
                        skin: enabled ? 'oxide-dark' : 'oxide',
                        content_css: enabled ? 'dark' : 'default',
                        content_style: `
                            body {
                                background-color: ${enabled ? '#2c2c2c' : '#ffffff'};
                                color: ${enabled ? '#cbd5e1' : '#000000'};
                            }
                        `,
                        setup: function(editor) {
                            editor.on('init', function() {
                                editor.setContent(content);
                            });
                        }
                    });
                }
            }

            if (isEnabled) {
                if (desktopToggle) desktopToggle.checked = true;
                if (mobileToggle)  mobileToggle.checked  = true;
            }

            if (desktopToggle) desktopToggle.addEventListener('change', e => updateMode(e.target.checked));
            if (mobileToggle)  mobileToggle.addEventListener('change',  e => updateMode(e.target.checked));
        });
    });
})();