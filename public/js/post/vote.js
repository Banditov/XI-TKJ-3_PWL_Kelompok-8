document.addEventListener('DOMContentLoaded', () => {
    initVoteHandlers();
});

async function handleVoteClick(event) {
    event.preventDefault();
    event.stopPropagation();

    const btn = event.currentTarget;
    const container = btn.closest('.vote-container');
    const type = container.dataset.type;
    const id = container.dataset.postId || container.dataset.commentId || container.dataset.replyId;
    const voteType = btn.dataset.vote;
    const currentVote = btn.dataset.currentVote;

    const voteCountSpan = container.querySelector('.vote-count');
    const upSpan = container.querySelector('.vote-up span');
    const downSpan = container.querySelector('.vote-down span');

    if (!voteCountSpan) {
        console.error('Vote count span not found');
        return;
    }

    let currentCount = parseInt(voteCountSpan.textContent);
    let newCount = currentCount;

    if (voteType === 'up') {
        if (currentVote === 'up') {
            newCount = currentCount - 1;
        } else {
            newCount = currentCount + (currentVote === 'down' ? 2 : 1);
        }
    } else if (voteType === 'down') {
        if (currentVote === 'down') {
            newCount = currentCount + 1;
        } else {
            newCount = currentCount - (currentVote === 'up' ? 2 : 1);
        }
    }

    voteCountSpan.textContent = newCount;

    if (voteType === 'up') {
        if (currentVote === 'up') {
            if (upSpan) upSpan.style.setProperty('color', '', 'important');
        } else {
            if (upSpan) upSpan.style.setProperty('color', '#FFE500', 'important');
            if (downSpan && currentVote === 'down') downSpan.style.setProperty('color', '', 'important');
        }
    } else {
        if (currentVote === 'down') {
            if (downSpan) downSpan.style.setProperty('color', '', 'important');
        } else {
            if (downSpan) downSpan.style.setProperty('color', '#FFE500', 'important');
            if (upSpan && currentVote === 'up') upSpan.style.setProperty('color', '', 'important');
        }
    }

    let url = '';
    if (type === 'post') url = `/posts/${id}/vote`;
    else if (type === 'comment') url = `/comments/${id}/vote`;
    else if (type === 'reply') url = `/replies/${id}/vote`;

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `vote=${voteType === 'up' ? '1' : '-1'}&current_vote=${currentVote || ''}`
        });

        const contentType = response.headers.get('content-type');

        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.error('Not JSON response:', text.substring(0, 200));
            throw new Error('Server did not return JSON');
        }

        const data = await response.json();

        if (data.success) {
            voteCountSpan.textContent = data.new_votes;

            const newUserVote = data.new_user_vote;

            if (upSpan) {
                upSpan.style.color = newUserVote === 1 ? '#FFE500' : '';
            }
            if (downSpan) {
                downSpan.style.color = newUserVote === -1 ? '#FFE500' : '';
            }

            const newCurrentVote = newUserVote === 1 ? 'up' : (newUserVote === -1 ? 'down' : '');
            container.querySelectorAll('.vote-btn').forEach(btn => {
                btn.dataset.currentVote = newCurrentVote;
            });
        } else {
            console.error('Vote failed:', data.error);
            voteCountSpan.textContent = currentCount;
            if (upSpan) upSpan.style.color = currentVote === 'up' ? '#FFE500' : '';
            if (downSpan) downSpan.style.color = currentVote === 'down' ? '#FFE500' : '';
        }
    } catch (error) {
        console.error('Vote error:', error);
        voteCountSpan.textContent = currentCount;
        if (upSpan) upSpan.style.color = currentVote === 'up' ? '#FFE500' : '';
        if (downSpan) downSpan.style.color = currentVote === 'down' ? '#FFE500' : '';
    }
}

function initVoteHandlers() {
    document.querySelectorAll('.vote-btn').forEach(btn => {
        btn.removeEventListener('click', handleVoteClick);
        btn.addEventListener('click', handleVoteClick);
    });
}

window.initVoteHandlers = initVoteHandlers;