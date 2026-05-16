const deleteNotifModal = document.getElementById('deleteNotifModal');
const deleteNotifModalContent = document.getElementById('deleteNotifModalContent');
const confirmDeleteNotifBtn = document.getElementById('confirmDeleteNotifBtn');
const cancelDeleteNotifBtn = document.getElementById('cancelDeleteNotifBtn');
let currentNotificationId = null;

function showDeleteNotifModal(notificationId) {
    currentNotificationId = notificationId;
    deleteNotifModal.classList.remove('hidden');
    deleteNotifModal.classList.add('flex');
    setTimeout(() => {
        deleteNotifModalContent.classList.remove('scale-95', 'opacity-0');
        deleteNotifModalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function hideDeleteNotifModal() {
    deleteNotifModalContent.classList.remove('scale-100', 'opacity-100');
    deleteNotifModalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        deleteNotifModal.classList.remove('flex');
        deleteNotifModal.classList.add('hidden');
        currentNotificationId = null;
    }, 300);
}

if (confirmDeleteNotifBtn) {
    confirmDeleteNotifBtn.addEventListener('click', function() {
        if (currentNotificationId) {
            fetch('/notification/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'notification_id=' + currentNotificationId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const element = document.querySelector(`.notification-item[data-id="${currentNotificationId}"]`);
                    if (element) {
                        element.remove();
                    }
                    const remaining = document.querySelectorAll('.notification-item').length;
                    if (remaining === 0) {
                        document.getElementById('notificationsList').innerHTML = '<div class="text-center py-10"><p class="text-gray-500">No notifications yet</p></div>';
                        const clearAllBtn = document.getElementById('clearAllBtn');
                        if (clearAllBtn) clearAllBtn.remove();
                    }
                    hideDeleteNotifModal();
                } else {
                    alert('Failed to delete notification');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
            });
        }
    });
}

if (cancelDeleteNotifBtn) {
    cancelDeleteNotifBtn.addEventListener('click', hideDeleteNotifModal);
}

const clearAllModal = document.getElementById('clearAllModal');
const clearAllModalContent = document.getElementById('clearAllModalContent');
const confirmClearAllBtn = document.getElementById('confirmClearAllBtn');
const cancelClearAllBtn = document.getElementById('cancelClearAllBtn');

function showClearAllModal() {
    clearAllModal.classList.remove('hidden');
    clearAllModal.classList.add('flex');
    setTimeout(() => {
        clearAllModalContent.classList.remove('scale-95', 'opacity-0');
        clearAllModalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function hideClearAllModal() {
    clearAllModalContent.classList.remove('scale-100', 'opacity-100');
    clearAllModalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        clearAllModal.classList.remove('flex');
        clearAllModal.classList.add('hidden');
    }, 300);
}

if (confirmClearAllBtn) {
    confirmClearAllBtn.addEventListener('click', function() {
        fetch('/notification/clear-all', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('notificationsList').innerHTML = '<div class="text-center py-10"><p class="text-gray-500">No notifications yet</p></div>';
                const clearAllBtn = document.getElementById('clearAllBtn');
                if (clearAllBtn) clearAllBtn.remove();
                hideClearAllModal();
            } else {
                alert('Failed to clear notifications');
            }
        });
    });
}

if (cancelClearAllBtn) {
    cancelClearAllBtn.addEventListener('click', hideClearAllModal);
}

const clearAllBtn = document.getElementById('clearAllBtn');
if (clearAllBtn) {
    clearAllBtn.addEventListener('click', showClearAllModal);
}

if (deleteNotifModal) {
    deleteNotifModal.addEventListener('click', (e) => {
        if (e.target === deleteNotifModal) hideDeleteNotifModal();
    });
}

if (clearAllModal) {
    clearAllModal.addEventListener('click', (e) => {
        if (e.target === clearAllModal) hideClearAllModal();
    });
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        if (deleteNotifModal && !deleteNotifModal.classList.contains('hidden')) hideDeleteNotifModal();
        if (clearAllModal && !clearAllModal.classList.contains('hidden')) hideClearAllModal();
    }
});