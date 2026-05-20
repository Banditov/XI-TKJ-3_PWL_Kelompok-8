tinymce.init({
    selector: '#mytextarea:not(.mceNoEditor)',
    resize: false,
    promotion: false,
    branding: false,
    elementpath: false,
    statusbar: false,
    license_key: 'gpl',
    skin: document.documentElement.classList.contains('dark') ? 'oxide-dark' : 'oxide',
    content_css: document.documentElement.classList.contains('dark') ? 'dark' : 'default',
    content_style: `
        body {
            background-color: ${document.documentElement.classList.contains('dark') ? '#2c2c2c' : '#ffffff'};
            color: ${document.documentElement.classList.contains('dark') ? '#cbd5e1' : '#000000'};
        }
    `
});