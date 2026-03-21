document.addEventListener('DOMContentLoaded', function() {
    const replyButton = document.getElementById('replyBtnC1');
    const inputContainer = document.getElementById('inputReplyC1');
    const replyInput = document.getElementById('replyC1');

    function showInput() {
        if (inputContainer) {
            inputContainer.classList.remove('hidden');
            inputContainer.classList.add('block');
            if (replyInput) {
                replyInput.focus();
            }
        }
    }

    function hideInput() {
        if (inputContainer) {
            inputContainer.classList.remove('block');
            inputContainer.classList.add('hidden');
            if (replyInput) {
                replyInput.value = '';
            }
        }
    }

    if (replyButton && inputContainer && replyInput) {
        replyButton.addEventListener('click', function(e) {
            e.preventDefault();
            showInput();
        });

        function submitReply() {
            const replyText = replyInput.value.trim();
            if (replyText !== '') {
                console.log('Reply submitted:', replyText);
                alert('Reply posted: ' + replyText);
                hideInput();
            } else {
                hideInput();
            }
        }

        replyInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                submitReply();
            }
        });

        replyInput.addEventListener('blur', function() {
            if (replyInput.value.trim() === '') {
                hideInput();
            }
        });

        replyInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                e.preventDefault();
                hideInput();
            }
        });
    } else {
        console.warn('Required elements not found: replyBtnC1, inputReplyC1, or replyC1');
    }
});