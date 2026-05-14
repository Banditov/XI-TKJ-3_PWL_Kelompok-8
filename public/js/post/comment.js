document.addEventListener('DOMContentLoaded', () => {
    initCommentHandlers();
    initReplyToggles();
});

function initReplyToggles() {
    if (typeof window.toggleReply === 'undefined') {
        window.toggleReply = function(id) {
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
        window.toggleReplies = function(id) {
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
            addCommentToPage(data.comment, postId);
            form.reset();
            updateCommentCount();
        } else {
            alert(data.error || 'Failed to post comment');
        }
    } catch (error) {
        console.error('Comment error:', error);
        alert('Failed to post comment');
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
            addReplyToPage(data.reply, commentId, postId);
            form.reset();

            const replyInputDesktop = document.getElementById(`inputReply-${commentId}-d`);
            if (replyInputDesktop) replyInputDesktop.classList.add('hidden');

            const replyInputMobile = document.getElementById(`inputReply-${commentId}-m`);
            if (replyInputMobile) replyInputMobile.classList.add('hidden');

            updateCommentCount();
        } else {
            alert(data.error || 'Failed to post reply');
        }
    } catch (error) {
        console.error('Reply error:', error);
        alert('Failed to post reply');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    }
}

function addCommentToPage(comment, postId) {
    const commentsContainer = document.querySelector('.comments-list-desktop');
    const mobileCommentsContainer = document.querySelector('.comments-list-mobile');

    const replyToggleId = `${comment.id}-d`;
    const replyToggleIdMobile = `${comment.id}-m`;
    const repliesId = `${comment.id}`;
    const repliesIdMobile = `${comment.id}-m`;

    const commentHtmlDesktop = `
        <div class="hidden md:flex flex-col border-2 border-[#545F71] rounded-4xl comment-item mb-5" data-comment-id="${comment.id}">
            <div class="flex items-center justify-between p-5 border-b-2 border-[#545F71]">
                <div class="flex gap-5 items-center">
                    <img src="/assets/image/account/${comment.account_id}.jpg" class="w-10 h-10 object-cover rounded-full drop-shadow-lg" onerror="this.src='/assets/image/account/default.jpg'">
                    <div>
                        <p class="text-2xl font-bold">${escapeHtml(comment.account_name)}</p>
                        <p class="text-sm">${escapeHtml(comment.class_name)}</p>
                    </div>
                    <div class="w-2 h-2 bg-[#545F71] rounded-full"></div>
                    <p class="text-2xl font-bold">${comment.date}</p>
                </div>
                <div class="flex gap-5 items-center">
                    <label class="flex items-center gap-2 cursor-pointer" onclick="window.toggleReply('${replyToggleId}')">
                        ${getReplyIcon()}
                        <p class="text-2xl">Reply</p>
                    </label>
                    <div class="vote-container flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3" data-type="comment" data-comment-id="${comment.id}">
                        <button type="button" class="vote-btn vote-up flex items-center justify-center" data-vote="up" data-current-vote="">
                            <span>${getArrowUpIcon()}</span>
                        </button>
                        <p class="vote-count text-2xl">0</p>
                        <button type="button" class="vote-btn vote-down flex items-center justify-center" data-vote="down" data-current-vote="">
                            <span>${getArrowDownIcon()}</span>
                        </button>
                    </div>
                    <!-- No toggle replies button because no replies exist yet -->
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
                    <button type="button" class="vote-btn vote-up flex items-center justify-center" data-vote="up" data-current-vote="">
                        <span>${getArrowUpIcon()}</span>
                    </button>
                    <p class="vote-count text-2xl">0</p>
                    <button type="button" class="vote-btn vote-down flex items-center justify-center" data-vote="down" data-current-vote="">
                        <span>${getArrowDownIcon()}</span>
                    </button>
                </div>
                <!-- No toggle replies button -->
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
                            <div class="w-2 h-2 bg-[#545F71] rounded-full"></div>
                            <p class="text-2xl font-bold">${reply.date}</p>
                        </div>
                        <div class="vote-container flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3" data-type="reply" data-reply-id="${reply.id}">
                            <button type="button" class="vote-btn vote-up flex items-center justify-center" data-vote="up" data-current-vote="">
                                <span>${getArrowUpIcon()}</span>
                            </button>
                            <p class="vote-count text-2xl">0</p>
                            <button type="button" class="vote-btn vote-down flex items-center justify-center" data-vote="down" data-current-vote="">
                                <span>${getArrowDownIcon()}</span>
                            </button>
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
                    <div class="border-b-2 border-[#545F71]">
                        <div class="p-5 flex gap-5 items-center justify-between">
                            <div class="flex gap-5 items-center">
                                <img src="/assets/image/account/${reply.account_id}.jpg" class="w-14 h-14 object-cover rounded-full drop-shadow-lg" onerror="this.src='/assets/image/account/default.jpg'">
                                <div>
                                    <p class="text-2xl font-bold">${escapeHtml(reply.account_name)}</p>
                                    <p class="text-lg">${escapeHtml(reply.class_name)}</p>
                                </div>
                            </div>
                            <p class="text-3xl font-bold">${reply.date}</p>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-justify text-2xl md:text-lg">${escapeHtml(reply.description)}</p>
                    </div>
                    <div class="flex gap-5 items-center p-5 pt-0 justify-end">
                        <div class="vote-container flex px-4 py-1 bg-[#2C7CFF] text-white rounded-full items-center gap-3" data-type="reply" data-reply-id="${reply.id}">
                            <button type="button" class="vote-btn vote-up flex items-center justify-center" data-vote="up" data-current-vote="">
                                <span>${getArrowUpIcon()}</span>
                            </button>
                            <p class="vote-count text-2xl">0</p>
                            <button type="button" class="vote-btn vote-down flex items-center justify-center" data-vote="down" data-current-vote="">
                                <span>${getArrowDownIcon()}</span>
                            </button>
                        </div>
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

window.initCommentHandlers = initCommentHandlers;
window.initReplyToggles = initReplyToggles;
window.handleCommentSubmit = handleCommentSubmit;
window.handleReplySubmit = handleReplySubmit;