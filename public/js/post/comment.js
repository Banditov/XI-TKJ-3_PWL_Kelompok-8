document.addEventListener('DOMContentLoaded', () => {
    initCommentHandlers();
    initReplyToggles();
});

function initReplyToggles() {
    if (typeof window.toggleReply === 'undefined') {
        window.toggleReply = function (id) {
            const element = document.getElementById(`inputReply-${id}`);
            if (element) {
                element.classList.toggle('hidden');
                const field = element.querySelector('input');
                if (field && !element.classList.contains('hidden')) {
                    field.focus();
                }
            }
        };
    }

    if (typeof window.toggleReplies === 'undefined') {
        window.toggleReplies = function (id) {
            const element = document.getElementById(`replies-${id}`);
            const button = document.querySelector(`[onclick*="toggleReplies('${id}')"]`);
            if (element) {
                element.classList.toggle('hidden');
            }
            if (button) {
                button.classList.toggle('rotate-180');
            }
        };
    }
}

function initCommentHandlers() {
    const commentForm = document.querySelector('#commentForm');
    if (commentForm) {
        commentForm.removeEventListener('submit', handleCommentSubmit);
        commentForm.addEventListener('submit', handleCommentSubmit);
    }

    document.querySelectorAll('.reply-form').forEach(form => {
        form.removeEventListener('submit', handleReplySubmit);
        form.addEventListener('submit', handleReplySubmit);
    });
}

async function handleCommentSubmit(event) {
    event.preventDefault();

    const form = event.currentTarget;
    const postId = form.dataset.postId;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    const input = form.querySelector('input[name="description"]');

    if (!input.value.trim()) {
        alert('Please enter a comment');
        return;
    }

    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Posting...';

    try {
        const response = await fetch(`/posts/${postId}/comments`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            if (data.comment && !data.comment.hasOwnProperty('can_delete')) {
                data.comment.can_delete = true;
            }
            addCommentToPage(data.comment, postId);
            form.reset();
            updateCommentCount();

            initReplyToggles();
            initCommentHandlers();
        } else {
            alert(data.error || 'Failed to post comment');
        }
    } catch (error) {
        console.error('Comment error:', error);
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    }
}

async function handleReplySubmit(event) {
    event.preventDefault();

    const form = event.currentTarget;
    const postId = form.dataset.postId;
    const commentId = form.dataset.commentId;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    const input = form.querySelector('input[name="description"]');

    if (!input.value.trim()) {
        alert('Please enter a reply');
        return;
    }

    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Posting...';

    try {
        const response = await fetch(`/posts/${postId}/comments/${commentId}/replies`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            if (data.reply && !data.reply.hasOwnProperty('can_delete')) {
                data.reply.can_delete = true;
            }
            addReplyToPage(data.reply, commentId, postId);
            form.reset();

            const replyInputDesktop = document.getElementById(`inputReply-${commentId}-d`);
            if (replyInputDesktop) replyInputDesktop.classList.add('hidden');

            const replyInputMobile = document.getElementById(`inputReply-${commentId}-m`);
            if (replyInputMobile) replyInputMobile.classList.add('hidden');

            updateCommentCount();

            initReplyToggles();
            initCommentHandlers();
        } else {
            alert(data.error || 'Failed to post reply');
        }
    } catch (error) {
        console.error('Reply error:', error);
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    }
}

window.deleteComment = function (commentId) {
    if (!window.showConfirmationModal) return;
    window.showConfirmationModal(
        'Delete Comment',
        'Are you sure you want to delete this comment? This action cannot be undone.',
        () => {
            fetch(`/comments/${commentId}/delete`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).then(response => {
                if (response.ok) location.reload();
            });
        }
    );
};

window.deleteReply = function (replyId) {
    if (!window.showConfirmationModal) return;
    window.showConfirmationModal(
        'Delete Reply',
        'Are you sure you want to delete this reply? This action cannot be undone.',
        () => {
            fetch(`/replies/${replyId}/delete`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).then(response => {
                if (response.ok) location.reload();
            });
        }
    );
};

function getDeleteIcon() {
    return `<svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="100 100 700 700" class="fill-current stroke-current w-7 h-7">
                <g stroke-width="8">
                    <path d="M399.8 151.5c-27.1 6.7-42.5 27.4-43.6 58.7l-.5 14.7-56.6.3c-64.6.3-61.6 0-74.4 9.6-16.3 12.5-18.1 18.8-18.5 65.7-.5 50.9 1.3 55.5 21.7 55.5 8.5 0 7.2-7.5 10.6 66 9.5 209.9 13.2 280.8 15.1 287 5.7 19.5 22 34.9 41.7 39.5 9.5 2.2 300.1 2.2 309.6 0 19.5-4.6 35.8-20.1 41.5-39.5 1.8-5.7 2.7-21.5 8.1-136.5 1.4-29.7 3.8-82.1 5.5-116.5 1.6-34.4 3.2-68.6 3.5-76 1-25.3.6-24 8.6-24 20.4 0 22.2-4.6 21.7-55.5-.4-46.9-2.2-53.2-18.5-65.7-12.8-9.6-9.8-9.3-74.4-9.6l-56.6-.3-.6-14.7c-1-29.3-12.7-47.1-37.5-57-8.1-3.3-94.5-4.6-106.4-1.7zm93 37c9.2 1.7 13.2 9.2 13.2 25V225H394v-11.5c0-16.1 4-23.4 13.7-25 2.1-.4 4.1-.7 4.5-.8 2.1-.5 77.8.3 80.6.8zm156 74.5c6.5 0 7.2 2.8 7.2 30.6V319H244v-25.4c0-28.3.2-29.1 6.8-30.4 1.8-.4 91.6-.6 199.5-.5 107.9.2 197.2.3 198.5.3zM627 359.2c0 1.8-.7 17-1.5 33.8s-3.1 63.6-5 104c-10.2 214.1-9.4 199.9-11.4 204.5-2.4 5.5-7.5 9.2-14.1 10.5-7.2 1.4-282.8 1.4-290 0-15.4-2.9-15.4-3.2-18.5-67.2-6.7-141-8.7-184.1-11-231-1.4-27.9-2.5-52.3-2.5-54.3 0-3.5 0-3.5 177-3.5s177 0 177 3.2z"/>
                    <path d="M348.5 395.3c-4.3 2-9.3 8-10.2 12.4-1 4.9-1 248.6 0 253.6 3.6 16.9 31 17.6 35.7.8 2.3-8.4 1.3-252.9-1.1-257.9-4-8.2-16.1-12.6-24.4-8.9zm94 .1c-3.9 1.8-8 6.2-9.9 10.8-2 4.6-2.4 248.2-.6 255 5 17.8 31 17.8 36 0 2.1-7.7 1.3-251-.9-255.7-4.5-9.8-15.4-14.2-24.6-10.1zm92.7.7c-10.5 5.2-9.7-5.9-10 136.3-.3 139.1-.7 131.2 6.4 137.5 9.5 8.3 23.6 5.7 28.8-5.3 2-4.2 2.5-254 .5-259.3-3.7-9.8-15.8-14.1-25.7-9.2z"/>
                </g>
            </svg>`;
}

function getReplyIcon() {
    return `<svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
        <path d="M10 9V5l-7 7 7 7v-4.5c5 0 8.5 1.5 11 5 .5-2 .5-5-2-8.5-2.5-3-6-4.5-11-4.5z"/>
    </svg>`;
}

function getArrowUpIcon() {
    return `<svg class="w-7 h-7 transform rotate-180" fill="currentColor" viewBox="0 0 24 24">
        <path d="M7 14l5-5 5 5z"/>
    </svg>`;
}

function getArrowDownIcon() {
    return `<svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
        <path d="M7 10l5 5 5-5z"/>
    </svg>`;
}

function addCommentToPage(comment, postId) {
    const commentsContainer = document.querySelector('.comments-list-desktop');
    const mobileCommentsContainer = document.querySelector('.comments-list-mobile');

    const replyToggleId = `${comment.id}-d`;
    const replyToggleIdMobile = `${comment.id}-m`;
    const repliesId = `${comment.id}`;
    const repliesIdMobile = `${comment.id}-m`;

    const deleteCommentBtn = comment.can_delete
        ? `<button type="button" onclick="window.deleteComment(${comment.id})" class="text-red-500 hover:text-red-700 transition">
               ${getDeleteIcon()}
           </button>`
        : '';

    const commentHtmlDesktop = `
        <div class="hidden md:flex flex-col border-2 border-[#545F71] rounded-4xl comment-item mb-5" data-comment-id="${comment.id}">
            <div class="flex items-center justify-between p-5 border-b-2 border-[#545F71]">
                <div class="flex gap-5 items-center">
                    <img src="/assets/image/account/${comment.account_id}.jpg" class="w-10 h-10 object-cover rounded-full drop-shadow-lg" onerror="this.src='/assets/image/account/default.jpg'">
                    <div>
                        <p class="text-2xl font-bold">${escapeHtml(comment.account_name)}</p>
                        <p class="text-sm">${escapeHtml(comment.class_name)}</p>
                    </div>
                    <div class="w-2 h-2 bg-[#545F71] rounded-full dark:bg-white"></div>
                    <p class="text-2xl font-bold">${comment.date}</p>
                </div>
                <div class="flex gap-5 items-center">
                    <label class="flex items-center gap-2 cursor-pointer" onclick="window.toggleReply('${replyToggleId}')">
                        ${getReplyIcon()}
                        <p class="text-2xl">Reply</p>
                    </label>
                    <div class="vote-container flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3" data-type="comment" data-comment-id="${comment.id}">
                        <button type="button" class="vote-btn vote-up flex items-center justify-center cursor-pointer" data-vote="up" data-current-vote="">
                            <span>${getArrowUpIcon()}</span>
                        </button>
                        <p class="vote-count text-2xl">0</p>
                        <button type="button" class="vote-btn vote-down flex items-center justify-center cursor-pointer" data-vote="down" data-current-vote="">
                            <span>${getArrowDownIcon()}</span>
                        </button>
                    </div>
                    ${deleteCommentBtn}
                </div>
            </div>
            <div class="p-5">
                <p class="text-justify">${escapeHtml(comment.description)}</p>
            </div>
            <div id="inputReply-${replyToggleId}" class="hidden px-5 pb-5">
                <form action="/posts/${postId}/comments/${comment.id}/replies" method="POST" class="reply-form flex gap-3 items-center" data-post-id="${postId}" data-comment-id="${comment.id}">
                    <input type="text" name="description" placeholder="Replying..." class="p-3 pl-8 w-full text-[#545F71] rounded-full border border-[#545F71] bg-white" required>
                    <button type="submit" class="px-6 py-3 bg-[#2C7CFF] text-white rounded-full shrink-0 font-bold">Post</button>
                </form>
            </div>
            <div id="replies-${repliesId}" class="hidden relative mt-4"></div>
        </div>
    `;

    const commentHtmlMobile = `
        <div class="flex md:hidden flex-col border-2 border-[#545F71] rounded-4xl comment-item mb-5" data-comment-id="${comment.id}">
            <div class="p-5 border-b-2 border-[#545F71]">
                <div class="flex gap-5 items-center justify-between w-full">
                    <div class="flex gap-5 items-center">
                        <img src="/assets/image/account/${comment.account_id}.jpg" class="w-14 h-14 object-cover rounded-full drop-shadow-lg" onerror="this.src='/assets/image/account/default.jpg'">
                        <div>
                            <p class="text-2xl font-bold">${escapeHtml(comment.account_name)}</p>
                            <p class="text-lg">${escapeHtml(comment.class_name)}</p>
                        </div>
                    </div>
                    <p class="text-3xl font-bold">${comment.date}</p>
                </div>
            </div>
            <div class="p-5">
                <p class="text-justify text-2xl md:text-lg">${escapeHtml(comment.description)}</p>
            </div>
            <div class="flex gap-5 items-center justify-end p-5 pt-0">
                <label class="flex items-center gap-2 cursor-pointer" onclick="window.toggleReply('${replyToggleIdMobile}')">
                    ${getReplyIcon()}
                    <p class="text-2xl">Reply</p>
                </label>
                <div class="vote-container flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3" data-type="comment" data-comment-id="${comment.id}">
                    <button type="button" class="vote-btn vote-up flex items-center justify-center cursor-pointer" data-vote="up" data-current-vote="">
                        <span>${getArrowUpIcon()}</span>
                    </button>
                    <p class="vote-count text-2xl">0</p>
                    <button type="button" class="vote-btn vote-down flex items-center justify-center cursor-pointer" data-vote="down" data-current-vote="">
                        <span>${getArrowDownIcon()}</span>
                    </button>
                </div>
                ${deleteCommentBtn}
            </div>
            <div id="inputReply-${replyToggleIdMobile}" class="hidden px-5 pb-5">
                <form action="/posts/${postId}/comments/${comment.id}/replies" method="POST" class="reply-form flex gap-3 items-center" data-post-id="${postId}" data-comment-id="${comment.id}">
                    <input type="text" name="description" placeholder="Replying..." class="p-3 pl-8 w-full text-[#545F71] rounded-full border border-[#545F71] bg-white" required>
                    <button type="submit" class="px-6 py-3 bg-[#2C7CFF] text-white rounded-full shrink-0 font-bold">Post</button>
                </form>
            </div>
            <div id="replies-${repliesIdMobile}" class="hidden relative mt-4"></div>
        </div>
    `;

    if (commentsContainer) {
        commentsContainer.insertAdjacentHTML('afterbegin', commentHtmlDesktop);
    }
    if (mobileCommentsContainer) {
        mobileCommentsContainer.insertAdjacentHTML('afterbegin', commentHtmlMobile);
    }

    const noCommentsMsg = document.querySelector('.no-comments');
    if (noCommentsMsg) {
        noCommentsMsg.remove();
    }

    if (window.initVoteHandlers) {
        window.initVoteHandlers();
    }

    const newFormDesktop = document.querySelector(`#inputReply-${replyToggleId} .reply-form`);
    const newFormMobile = document.querySelector(`#inputReply-${replyToggleIdMobile} .reply-form`);

    if (newFormDesktop) {
        newFormDesktop.removeEventListener('submit', handleReplySubmit);
        newFormDesktop.addEventListener('submit', handleReplySubmit);
    }
    if (newFormMobile) {
        newFormMobile.removeEventListener('submit', handleReplySubmit);
        newFormMobile.addEventListener('submit', handleReplySubmit);
    }

    if (window.initReplySystem) {
        window.initReplySystem();
    }
}

function addReplyToPage(reply, commentId, postId) {
    const commentDesktop = document.querySelector(`.comment-item[data-comment-id="${commentId}"]:not(.flex.md\\:hidden)`);
    const commentMobile = document.querySelector(`.flex.md\\:hidden.comment-item[data-comment-id="${commentId}"]`);

    if (commentDesktop) {
        let repliesContainer = commentDesktop.querySelector(`#replies-${commentId}`);

        const existingReplies = repliesContainer?.querySelectorAll('.reply-item').length || 0;

        if (existingReplies === 0) {
            const actionButtons = commentDesktop.querySelector('.flex.gap-5.items-center:last-child');
            if (actionButtons && !actionButtons.querySelector('.toggle-replies-btn')) {
                const toggleButton = document.createElement('div');
                toggleButton.className = 'bg-[#747474] w-9 h-9 flex justify-center items-center rounded-full text-white cursor-pointer transition-transform duration-300 toggle-replies-btn';
                toggleButton.setAttribute('onclick', `window.toggleReplies('${commentId}')`);
                toggleButton.innerHTML = getArrowDownIcon();
                actionButtons.appendChild(toggleButton);
            }
        }

        if (repliesContainer) {
            repliesContainer.classList.remove('hidden');

            const replyHtmlDesktop = `
                <div class="border-t-2 border-dashed reply-item mt-2" data-reply-id="${reply.id}">
                    <div class="flex justify-between items-center p-5 border-b-2 border-[#545F71]">
                        <div class="flex gap-5 items-center">
                            <img src="/assets/image/account/${reply.account_id}.jpg" class="w-10 h-10 object-cover rounded-full drop-shadow-lg" onerror="this.src='/assets/image/account/default.jpg'">
                            <div>
                                <p class="text-2xl font-bold">${escapeHtml(reply.account_name)}</p>
                                <p class="text-sm">${escapeHtml(reply.class_name)}</p>
                            </div>
                            <div class="w-2 h-2 bg-[#545F71] rounded-full dark:bg-white"></div>
                            <p class="text-2xl font-bold">${reply.date}</p>
                        </div>
                        <div class="flex gap-5 items-center">
                            <div class="vote-container flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3"
                                data-reply-id="${reply.id}" data-type="reply">
                                <button type="button"
                                    class="vote-btn vote-up flex items-center justify-center cursor-pointer"
                                    data-vote="up"
                                    data-current-vote="${reply.user_vote == 1 ? 'up' : (reply.user_vote == -1 ? 'down' : '')}">
                                    <span style="${reply.user_vote == 1 ? 'color: #FFE500' : ''}">
                                        ${getArrowUpIcon()}
                                    </span>
                                </button>
                                <p class="vote-count text-2xl">${reply.votes || 0}</p>
                                <button type="button"
                                    class="vote-btn vote-down flex items-center justify-center cursor-pointer"
                                    data-vote="down"
                                    data-current-vote="${reply.user_vote == 1 ? 'up' : (reply.user_vote == -1 ? 'down' : '')}">
                                    <span style="${reply.user_vote == -1 ? 'color: #FFE500' : ''}">
                                        ${getArrowDownIcon()}
                                    </span>
                                </button>
                            </div>
                            ${reply.can_delete ? `
                            <button type="button" onclick="window.showConfirmationModal && window.showConfirmationModal('Delete Reply', 'Are you sure you want to delete this reply? This action cannot be undone.', () => {
                                fetch('/replies/${reply.id}/delete', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    }
                                }).then(response => {
                                    if(response.ok) {
                                        location.reload();
                                    }
                                });
                            })" class="text-red-500 hover:text-red-700 transition">
                                ${getDeleteIcon()}
                            </button>
                            ` : ''}
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-justify">${escapeHtml(reply.description)}</p>
                    </div>
                </div>
            `;
            repliesContainer.insertAdjacentHTML('beforeend', replyHtmlDesktop);
        }
    }

    if (commentMobile) {
        let repliesContainerMobile = commentMobile.querySelector(`#replies-${commentId}-m`);

        const existingRepliesMobile = repliesContainerMobile?.querySelectorAll('.reply-item').length || 0;

        if (existingRepliesMobile === 0) {
            const actionButtons = commentMobile.querySelector('.flex.gap-5.items-center.justify-end');
            if (actionButtons && !actionButtons.querySelector('.toggle-replies-btn-mobile')) {
                const toggleButton = document.createElement('div');
                toggleButton.className = 'bg-[#747474] w-9 h-9 flex justify-center items-center rounded-full text-white cursor-pointer transition-transform duration-300 toggle-replies-btn-mobile';
                toggleButton.setAttribute('onclick', `window.toggleReplies('${commentId}-m')`);
                toggleButton.innerHTML = getArrowDownIcon();
                actionButtons.appendChild(toggleButton);
            }
        }

        if (repliesContainerMobile) {
            repliesContainerMobile.classList.remove('hidden');

            const replyHtmlMobile = `
                <div class="border-t-2 border-dashed reply-item mt-2" data-reply-id="${reply.id}">
                    <div class="flex justify-between items-center p-5 border-b-2 border-[#545F71]">
                        <div class="flex gap-5 items-center">
                            <img src="/assets/image/account/${reply.account_id}.jpg" class="w-10 h-10 object-cover rounded-full drop-shadow-lg" onerror="this.src='/assets/image/account/default.jpg'">
                            <div>
                                <p class="text-2xl font-bold">${escapeHtml(reply.account_name)}</p>
                                <p class="text-sm">${escapeHtml(reply.class_name)}</p>
                            </div>
                            <div class="w-2 h-2 bg-[#545F71] rounded-full dark:bg-white"></div>
                            <p class="text-2xl font-bold">${reply.date}</p>
                        </div>
                        <div class="flex gap-5 items-center">
                            <div class="vote-container flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3"
                                data-reply-id="${reply.id}" data-type="reply">
                                <button type="button"
                                    class="vote-btn vote-up flex items-center justify-center cursor-pointer"
                                    data-vote="up"
                                    data-current-vote="${reply.user_vote == 1 ? 'up' : (reply.user_vote == -1 ? 'down' : '')}">
                                    <span style="${reply.user_vote == 1 ? 'color: #FFE500' : ''}">
                                        ${getArrowUpIcon()}
                                    </span>
                                </button>
                                <p class="vote-count text-2xl">${reply.votes || 0}</p>
                                <button type="button"
                                    class="vote-btn vote-down flex items-center justify-center cursor-pointer"
                                    data-vote="down"
                                    data-current-vote="${reply.user_vote == 1 ? 'up' : (reply.user_vote == -1 ? 'down' : '')}">
                                    <span style="${reply.user_vote == -1 ? 'color: #FFE500' : ''}">
                                        ${getArrowDownIcon()}
                                    </span>
                                </button>
                            </div>
                            ${reply.can_delete ? `
                            <button type="button" onclick="window.showConfirmationModal && window.showConfirmationModal('Delete Reply', 'Are you sure you want to delete this reply? This action cannot be undone.', () => {
                                fetch('/replies/${reply.id}/delete', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    }
                                }).then(response => {
                                    if(response.ok) {
                                        location.reload();
                                    }
                                });
                            })" class="text-red-500 hover:text-red-700 transition">
                                ${getDeleteIcon()}
                            </button>
                            ` : ''}
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-justify">${escapeHtml(reply.description)}</p>
                    </div>
                </div>
            `;
            repliesContainerMobile.insertAdjacentHTML('beforeend', replyHtmlMobile);
        }
    }

    if (window.initVoteHandlers) {
        window.initVoteHandlers();
    }

    if (window.initReplySystem) {
        window.initReplySystem();
    }
}

function updateCommentCount() {
    const commentCount = document.querySelectorAll('.comment-item').length;
    const commentCountSpans = document.querySelectorAll('.comment-count, .comment-count-mobile');

    commentCountSpans.forEach(span => {
        span.textContent = commentCount;
    });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

window.initCommentHandlers = initCommentHandlers;
window.initReplyToggles = initReplyToggles;
window.handleCommentSubmit = handleCommentSubmit;
window.handleReplySubmit = handleReplySubmit;