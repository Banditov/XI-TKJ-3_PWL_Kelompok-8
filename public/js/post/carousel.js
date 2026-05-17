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

function initCarouselTabs() {
    document.querySelectorAll('.carousel-tab').forEach(btn => {
        btn.removeEventListener('click', handleTabClick);
        btn.addEventListener('click', handleTabClick);
    });
}

function handleTabClick(e) {
    const btn = e.currentTarget;
    const wrapper = btn.closest('.carousel-wrapper');
    const tabName = btn.dataset.tab;
    
    // Update active tab style
    wrapper.querySelectorAll('.carousel-tab').forEach(tab => {
        // Remove active classes
        tab.classList.remove('active');
        tab.classList.remove('bg-white/30');
        tab.classList.remove('border-white/60');
        tab.classList.remove('shadow-lg');
        tab.classList.remove('bg-white/20');
        tab.classList.remove('scale-105');
        
        // Reset to default style
        tab.classList.add('bg-white/10');
        tab.classList.add('border-white/20');
        tab.classList.remove('bg-black/60');
    });

    btn.classList.add('active');
    btn.classList.add('bg-white/30');
    btn.classList.add('shadow-lg');
    btn.classList.remove('bg-white/10');

    btn.classList.add('scale-105');
    setTimeout(() => {
        btn.classList.remove('scale-105');
    }, 200);

    wrapper.querySelectorAll('.carousel-tab-content').forEach(content => {
        content.style.display = 'none';
    });
    const activeContent = wrapper.querySelector(`.carousel-tab-content[data-tab="${tabName}"]`);
    if (activeContent) {
        activeContent.style.display = 'block';
    }
}

function initCarousels() {
    initCarouselTabs();

    document.querySelectorAll('.carousel-wrapper').forEach(wrapper => {
        const track = wrapper.querySelector('.carousel-track');
        const slides = wrapper.querySelectorAll('.carousel-slide');
        const total = slides.length;

        if (!track || total === 0) return;

        if (total <= 1) {
            const singleImg = wrapper.querySelector('.carousel-img');
            if (singleImg && singleImg.dataset.src) {
                singleImg.addEventListener('click', () => openOverlay(singleImg.dataset.src));
            }
            return;
        }

        const dots = wrapper.querySelectorAll('.carousel-dot');
        const prev = wrapper.querySelector('.carousel-prev');
        const next = wrapper.querySelector('.carousel-next');

        track.style.transition = 'transform 350ms ease-in-out';
        track.style.transform = 'translateX(0%)';

        let current = 0;
        let animating = false;

        function goTo(index) {
            if (animating || index === current) return;
            animating = true;

            const slideWidth = 100 / total;
            const targetX = -(index * slideWidth);

            track.style.transform = `translateX(${targetX}%)`;

            dots.forEach((dot, i) => {
                dot.classList.toggle('opacity-100', i === index);
                dot.classList.toggle('opacity-40', i !== index);
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

window.load3DModel = async function(element) {
    if (element.dataset.loading === 'true' || element.dataset.loaded === 'true') {
        return;
    }

    const modelUrl = element.dataset.modelUrl;
    const modelType = element.dataset.modelType;

    console.log('Loading model:', modelUrl, modelType);

    if (!modelUrl) {
        console.error('No model URL found');
        return;
    }

    element.dataset.loading = 'true';
    const container = element;

    container.innerHTML = `
        <div class="text-center text-white">
            <div class="loading-spinner w-10 h-10 border-4 border-white/30 border-t-white rounded-full animate-spin mx-auto mb-4"></div>
            <p>Loading 3D model...</p>
        </div>
    `;

    try {
        const module = await import('/js/3d/viewer.js?v=' + Date.now());

        if (typeof module.init3DViewerInContainer === 'function') {
            module.init3DViewerInContainer(container, modelUrl, modelType, () => {
                element.dataset.loaded = 'true';
                element.dataset.loading = 'false';
                element.onclick = null;
            });
        } else {
            console.error('init3DViewerInContainer function not found');
            container.innerHTML = `
                <div class="text-center text-red-400">
                    <p>Viewer function not available</p>
                </div>
            `;
            element.dataset.loading = 'false';
        }
    } catch (err) {
        console.error('Failed to load 3D viewer:', err);
        container.innerHTML = `
            <div class="text-center text-red-400">
                <p>Failed to load 3D viewer: ${err.message}</p>
                <button class="mt-2 px-4 py-2 bg-white/20 rounded-lg hover:bg-white/30 transition" onclick="location.reload()">Retry</button>
            </div>
        `;
        element.dataset.loading = 'false';
    }
};

document.addEventListener('DOMContentLoaded', () => {
    initCarousels();
});

window.initCarousels = initCarousels;
window.initCarouselTabs = initCarouselTabs;
window.load3DModel = load3DModel;