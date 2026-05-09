document.addEventListener('DOMContentLoaded', function() {
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
        const button  = document.querySelector(`[onclick="toggleReplies('${commentId}')"]`);

        if (replies) {
            replies.classList.toggle('hidden');
        }

        if (button) {
            button.classList.toggle('rotate-180');
        }
    }

    document.querySelectorAll('[id^="inputReply-"] input').forEach(input => {
        input.addEventListener('blur', function() {
            if (input.value.trim() === '') {
                input.closest('[id^="inputReply-"]').classList.add('hidden');
            }
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                input.value = '';
                input.closest('[id^="inputReply-"]').classList.add('hidden');
            }
            if (e.key === 'Enter') {
                e.preventDefault()
                console.log('Reply submitted:', input.value.trim());
            }
        });
    });

    window.toggleReply   = toggleReply;
    window.toggleReplies = toggleReplies;
});