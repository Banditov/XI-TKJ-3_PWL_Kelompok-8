(function() {
    const isLoggedIn = window.userLoggedIn === true;

    if (!isLoggedIn) {
        localStorage.removeItem('dyslexicMode');
        localStorage.removeItem('darkMode');
        document.documentElement.classList.remove('dyslexic-mode');
        document.documentElement.classList.remove('dark');
        return;
    }

    const sessionDark = window.sessionDark === true;
    const sessionDyslexic = window.sessionDyslexic === true;

    if (sessionDark) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('darkMode', 'true');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('darkMode', 'false');
    }

    if (sessionDyslexic) {
        document.documentElement.classList.add('dyslexic-mode');
        localStorage.setItem('dyslexicMode', 'true');

        if (!document.querySelector('#dyslexic-font')) {
            const link = document.createElement('link');
            link.id = 'dyslexic-font';
            link.rel = 'stylesheet';
            document.head.appendChild(link);
        }
    } else {
        document.documentElement.classList.remove('dyslexic-mode');
        localStorage.setItem('dyslexicMode', 'false');
    }

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

    document.addEventListener('DOMContentLoaded', function() {
        modes.forEach(function(mode) {
            const desktopToggle = document.getElementById(mode.desktopId);
            const mobileToggle  = document.getElementById(mode.mobileId);

            const isEnabled = document.documentElement.classList.contains(mode.className);

            if (desktopToggle) desktopToggle.checked = isEnabled;
            if (mobileToggle) mobileToggle.checked = isEnabled;

            function updateMode(enabled) {
                document.documentElement.classList.toggle(mode.className, enabled);

                if (desktopToggle) desktopToggle.checked = enabled;
                if (mobileToggle)  mobileToggle.checked  = enabled;

                localStorage.setItem(mode.localKey, enabled ? 'true' : 'false');

                fetch(mode.endpoint, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: mode.bodyKey + '=' + (enabled ? 1 : 0)
                }).catch(err => console.error('Failed to save ' + mode.localKey + ':', err));

                if (mode.className === 'dark' && typeof tinymce !== 'undefined') {
                    const editor = tinymce.get('mytextarea');
                    if (editor) {
                        const content = editor.getContent();
                        editor.remove();
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
                                    background-color: ${document.documentElement.classList.contains('dark') ? '#2c2c2c' : '#ffffff'};
                                    color: ${document.documentElement.classList.contains('dark') ? '#cbd5e1' : '#000000'};
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
            }

            if (desktopToggle) desktopToggle.addEventListener('change', e => updateMode(e.target.checked));
            if (mobileToggle)  mobileToggle.addEventListener('change',  e => updateMode(e.target.checked));
        });
    });
})();