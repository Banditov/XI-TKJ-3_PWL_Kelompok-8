document.addEventListener('DOMContentLoaded', function () {
    const shareButtons = document.querySelectorAll('.shareBtn');

    shareButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const url = this.dataset.url;

            if (!url) {
                console.error('No URL found');
                return;
            }

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(() => {
                    showToast('Link copied to clipboard!');
                }).catch(err => {
                    console.error('Failed to copy:', err);
                    fallbackCopy(url);
                });
            } else {
                fallbackCopy(url);
            }
        });
    });

    function fallbackCopy(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.top = '0';
        textarea.style.left = '0';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();

        try {
            document.execCommand('copy');
            showToast('Link copied to clipboard!');
        } catch (err) {
            console.error('Fallback copy failed:', err);
            alert('Press Ctrl+C to copy: ' + text);
        }

        document.body.removeChild(textarea);
    }

    function showToast(message) {
        let toast = document.querySelector('.copy-toast');
        if (toast) {
            toast.remove();
        }

        toast = document.createElement('div');
        toast.className = 'copy-toast fixed bottom-20 left-1/2 transform -translate-x-1/2 drop-shadow-lg backdrop-blur-md bg-gray-800/25 text-white px-4 py-2 rounded-full text-sm z-50 animate-fade-in-out ring-2';
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 2000);
    }
});