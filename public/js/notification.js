function deleteNotification(notificationId) {
    fetch('/notification/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'notification_id=' + notificationId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const element = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
            if (element) {
                element.remove();
            }

            const remaining = document.querySelectorAll('.notification-item').length;
            if (remaining === 0) {
                const notificationsList = document.getElementById('notificationsList');
                if (notificationsList) {
                    notificationsList.innerHTML = '<div class="text-center py-10"><p class="text-gray-500">No notifications yet</p></div>';
                }
                const clearAllBtn = document.getElementById('clearAllBtn');
                if (clearAllBtn) clearAllBtn.remove();
            }
        } else {
            alert('Failed to delete notification');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}

function clearAllNotifications() {
    fetch('/notification/clear-all', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notificationsList = document.getElementById('notificationsList');
            if (notificationsList) {
                notificationsList.innerHTML = '<div class="text-center py-10"><p class="text-gray-500">No notifications yet</p></div>';
            }
            const clearAllBtn = document.getElementById('clearAllBtn');
            if (clearAllBtn) clearAllBtn.remove();
        } else {
            alert('Failed to clear notifications');
        }
    });
}

function showDeleteNotifModal(notificationId) {
    window.showConfirmationModal(
        'Remove Notification',
        'Are you sure you want to remove this notification?',
        function() {
            deleteNotification(notificationId);
        }
    );
}

document.addEventListener('DOMContentLoaded', function() {
    const clearAllBtn = document.getElementById('clearAllBtn');
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', function() {
            window.showConfirmationModal(
                'Clear All Notifications',
                'Are you sure you want to clear all notifications? This action cannot be undone.',
                function() {
                    clearAllNotifications();
                }
            );
        });
    }
});