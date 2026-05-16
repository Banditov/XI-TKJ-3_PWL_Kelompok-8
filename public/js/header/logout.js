const logoutModal = document.getElementById('logoutModal');
const logoutModalContent = document.getElementById('logoutModalContent');
const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
const cancelLogoutBtn = document.getElementById('cancelLogoutBtn');

function showLogoutModal() {
    if (!logoutModal) return;
    
    logoutModal.classList.remove('hidden');
    logoutModal.classList.add('flex');

    setTimeout(() => {
        if (logoutModalContent) {
            logoutModalContent.classList.remove('scale-95', 'opacity-0');
            logoutModalContent.classList.add('scale-100', 'opacity-100');
        }
    }, 10);
}

function hideLogoutModal() {
    if (!logoutModal || !logoutModalContent) return;
    
    logoutModalContent.classList.remove('scale-100', 'opacity-100');
    logoutModalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        logoutModal.classList.remove('flex');
        logoutModal.classList.add('hidden');
    }, 300);
}

if (confirmLogoutBtn) {
    confirmLogoutBtn.addEventListener('click', () => {
        localStorage.removeItem('darkMode');
        localStorage.removeItem('dyslexicMode');

        window.location.href = '/logout';
    });
}

if (cancelLogoutBtn) {
    cancelLogoutBtn.addEventListener('click', hideLogoutModal);
}

if (logoutModal) {
    logoutModal.addEventListener('click', (e) => {
        if (e.target === logoutModal) {
            hideLogoutModal();
        }
    });
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && logoutModal && !logoutModal.classList.contains('hidden')) {
        hideLogoutModal();
    }
});

window.showLogoutModal = showLogoutModal;