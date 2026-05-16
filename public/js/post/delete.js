const deletePostModal = document.getElementById('deletePostModal');
const deletePostModalContent = document.getElementById('deletePostModalContent');
const confirmDeletePostBtn = document.getElementById('confirmDeletePostBtn');
const cancelDeletePostBtn = document.getElementById('cancelDeletePostBtn');
let currentPostId = null;

function showDeletePostModal(postId) {
    if (!deletePostModal) return;

    currentPostId = postId;

    deletePostModal.classList.remove('hidden');
    deletePostModal.classList.add('flex');

    setTimeout(() => {
        if (deletePostModalContent) {
            deletePostModalContent.classList.remove('scale-95', 'opacity-0');
            deletePostModalContent.classList.add('scale-100', 'opacity-100');
        }
    }, 10);
}

function hideDeletePostModal() {
    if (!deletePostModal || !deletePostModalContent) return;

    deletePostModalContent.classList.remove('scale-100', 'opacity-100');
    deletePostModalContent.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        deletePostModal.classList.remove('flex');
        deletePostModal.classList.add('hidden');
        currentPostId = null;
    }, 300);
}

if (confirmDeletePostBtn) {
    confirmDeletePostBtn.addEventListener('click', async () => {
        if (!currentPostId) return;

        try {
            const response = await fetch(`/posts/${currentPostId}/delete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.redirected) {
                window.location.href = response.url;
            } else {
                window.location.href = '/posts';
            }
        } catch (error) {
            console.error('Delete error:', error);
            window.location.href = '/posts';
        }
    });
}

if (cancelDeletePostBtn) {
    cancelDeletePostBtn.addEventListener('click', hideDeletePostModal);
}

if (deletePostModal) {
    deletePostModal.addEventListener('click', (e) => {
        if (e.target === deletePostModal) {
            hideDeletePostModal();
        }
    });
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && deletePostModal && !deletePostModal.classList.contains('hidden')) {
        hideDeletePostModal();
    }
});

window.showDeletePostModal = showDeletePostModal;