document.addEventListener('DOMContentLoaded', function () {
    function toggleReply(commentId) {
        const input = document.getElementById(`inputReply-${commentId}`);
        if (input) {
            input.classList.toggle('hidden');
            const field = input.querySelector('input');
            if (field && !input.classList.contains('hidden')) {
                field.focus();
            }
        }
    }

    function toggleReplies(commentId) {
        const replies = document.getElementById(`replies-${commentId}`);
        const button = document.querySelector(`[onclick*="toggleReplies('${commentId}')"]`);

        if (replies) {
            replies.classList.toggle('hidden');
        }

        if (button) {
            button.classList.toggle('rotate-180');
        }
    }

    function attachReplyInputListeners() {
        document.querySelectorAll('[id^="inputReply-"] input').forEach(input => {
            input.removeEventListener('blur', handleBlur);
            input.removeEventListener('keydown', handleKeydown);

            input.addEventListener('blur', handleBlur);
            input.addEventListener('keydown', handleKeydown);
        });
    }

    function handleBlur() {
        if (this.value.trim() === '') {
            const container = this.closest('[id^="inputReply-"]');
            if (container) {
                container.classList.add('hidden');
            }
        }
    }

    function handleKeydown(e) {
        if (e.key === 'Escape') {
            this.value = '';
            const container = this.closest('[id^="inputReply-"]');
            if (container) {
                container.classList.add('hidden');
            }
        }
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            console.log('Reply submitted:', this.value.trim());
            const form = this.closest('form');
            if (form && this.value.trim()) {
                form.dispatchEvent(new Event('submit', { bubbles: true }));
            }
        }
    }

    function initReplySystem() {
        attachReplyInputListeners();
    }

    initReplySystem();

    window.toggleReply = toggleReply;
    window.toggleReplies = toggleReplies;
    window.initReplySystem = initReplySystem;

    window.attachReplyInputListeners = attachReplyInputListeners;
});