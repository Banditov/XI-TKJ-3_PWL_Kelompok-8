function deletePost(postId) {
    const form = document.getElementById('deletePostForm');
    if (form) {
        form.submit();
    } else {
        fetch('/posts/' + postId + '/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(response => {
            window.location.href = '/posts';
        }).catch(error => {
            console.error('Delete error:', error);
            window.location.href = '/posts';
        });
    }
}

function showDeletePostModal(postId) {
    window.showConfirmationModal(
        'Delete Post',
        'Are you sure you want to delete this post? This action cannot be undone and will delete all comments, replies, images, and links associated with this post.',
        function() {
            deletePost(postId);
        }
    );
}