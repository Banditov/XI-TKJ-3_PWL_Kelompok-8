function checkSize() {
    const errScreen = document.getElementById('errScreenRatio');
    const mainContent = document.querySelector('main');

    if (!errScreen || !mainContent) return;

    if (window.innerWidth < 320 || window.innerHeight < 568) {
        errScreen.style.display = 'flex';
        mainContent.style.display = 'none';
    } else {
        errScreen.style.display = 'none';
        mainContent.style.display = '';
    }
}

window.addEventListener('resize', checkSize);
checkSize();