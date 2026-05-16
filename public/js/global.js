function goBack() {
    window.history.back();
}

// Confirmation
const confirmationModal = document.getElementById('confirmationModal');
const confirmationModalContent = document.getElementById('confirmationModalContent');
const confirmActionBtn = document.getElementById('confirmActionBtn');
const cancelActionBtn = document.getElementById('cancelActionBtn');
let currentAction = null;

function showConfirmationModal(title, message, onConfirm) {
    const titleEl = document.getElementById('confirmationTitle');
    const messageEl = document.getElementById('confirmationMessage');
    
    if (titleEl) titleEl.textContent = title;
    if (messageEl) messageEl.textContent = message;
    
    currentAction = onConfirm;
    
    confirmationModal.classList.remove('hidden');
    confirmationModal.classList.add('flex');
    setTimeout(() => {
        confirmationModalContent.classList.remove('scale-95', 'opacity-0');
        confirmationModalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function hideConfirmationModal() {
    confirmationModalContent.classList.remove('scale-100', 'opacity-100');
    confirmationModalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        confirmationModal.classList.remove('flex');
        confirmationModal.classList.add('hidden');
        currentAction = null;
    }, 300);
}

if (confirmActionBtn) {
    confirmActionBtn.addEventListener('click', () => {
        if (currentAction) {
            currentAction();
        }
        hideConfirmationModal();
    });
}

if (cancelActionBtn) {
    cancelActionBtn.addEventListener('click', hideConfirmationModal);
}

if (confirmationModal) {
    confirmationModal.addEventListener('click', (e) => {
        if (e.target === confirmationModal) hideConfirmationModal();
    });
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && confirmationModal && !confirmationModal.classList.contains('hidden')) {
        hideConfirmationModal();
    }
});

window.showConfirmationModal = showConfirmationModal;