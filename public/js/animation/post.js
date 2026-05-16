import { animate } from '../library/anime.esm.js';

function initPostAnimations() {
    const posts = document.querySelectorAll('.post:not(.animated)');

    if (posts.length === 0) return;

    posts.forEach(post => {
        post.classList.add('post-animate-ready');
    });

    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && entry.target.classList.contains('post-animate-ready')) {
                entry.target.classList.remove('post-animate-ready');
                entry.target.classList.add('post-animated');

                const direction = entry.target.dataset.animation || 'up';
                let translateY = '50px';
                let translateX = '0px';

                if (direction === 'down') translateY = '-50px';
                if (direction === 'left') {
                    translateX = '-50px';
                    translateY = '0px';
                }
                if (direction === 'right') {
                    translateX = '50px';
                    translateY = '0px';
                }

                animate(entry.target, {
                    opacity: [0, 1],
                    translateY: [translateY, '0px'],
                    translateX: [translateX, '0px'],
                    duration: 500,
                    easing: 'easeOutQuad'
                });
            }
        });
    }, observerOptions);

    posts.forEach(post => observer.observe(post));
}

const style = document.createElement('style');
style.textContent = `
    .post-animate-ready {
        opacity: 0 !important;
        transform: translateY(50px);
        will-change: transform, opacity;
    }
`;
document.head.appendChild(style);

initPostAnimations();
window.initPostAnimations = initPostAnimations;