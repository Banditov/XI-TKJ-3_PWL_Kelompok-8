const overlay = document.createElement('div');
const xIcon   = document.getElementById('xIconSvg').innerHTML;
overlay.id        = 'imgOverlay';
overlay.className = 'fixed inset-0 z-50 backdrop-blur-md bg-gray-900/70 items-center justify-center transition-opacity duration-200';
overlay.style.display = 'none';
overlay.style.opacity = '0';
overlay.innerHTML = `
    <button id="overlayClose" class="absolute top-6 right-6 text-white font-bold hover:opacity-70">
        ${xIcon}
    </button>
    <img id="overlayImg" src="" class="max-w-[80vw] max-h-[80vh] object-contain rounded-2xl drop-shadow-2xl">
`;
document.body.appendChild(overlay);

const overlayImg   = document.getElementById('overlayImg');
const overlayClose = document.getElementById('overlayClose');

function openOverlay(src) {
    overlayImg.src = src;
    overlay.style.display = 'flex';
    requestAnimationFrame(() => { overlay.style.opacity = '1'; });
}

function closeOverlay() {
    overlay.style.opacity = '0';
    setTimeout(() => {
        overlay.style.display = 'none';
        overlayImg.src = '';
    }, 200);
}

overlayClose.addEventListener('click', closeOverlay);
overlay.addEventListener('click', (e) => { if (e.target === overlay) closeOverlay(); });

function initCarousels() {
    document.querySelectorAll('.carousel-wrapper').forEach(wrapper => {
    const track  = wrapper.querySelector('.carousel-track');
    const dots   = wrapper.querySelectorAll('.carousel-dot');
    const prev   = wrapper.querySelector('.carousel-prev');
    const next   = wrapper.querySelector('.carousel-next');
    const total  = wrapper.querySelectorAll('.carousel-slide').length;

    if (total <= 1) return;

    track.style.transition = 'transform 350ms ease-in-out';
    track.style.transform  = 'translateX(0%)';

    let current   = 0;
    let animating = false;

    function goTo(index) {
        if (animating || index === current) return;
        animating = true;

        const slideWidth = 100 / total;
        const targetX    = -(index * slideWidth);

        track.style.transform = `translateX(${targetX}%)`;

        dots.forEach((dot, i) => {
            dot.classList.toggle('opacity-100', i === index);
            dot.classList.toggle('opacity-40',  i !== index);
        });

        current = index;

        setTimeout(() => { animating = false; }, 350);
    }

    if (prev) prev.addEventListener('click', () => goTo(current === 0 ? total - 1 : current - 1));
    if (next) next.addEventListener('click', () => goTo(current === total - 1 ? 0 : current + 1));
    dots.forEach((dot, i) => dot.addEventListener('click', () => goTo(i)));

    wrapper.querySelectorAll('.carousel-img').forEach(img => {
        img.addEventListener('click', () => openOverlay(img.dataset.src));
    });
});
}

initCarousels();
window.initCarousels = initCarousels;