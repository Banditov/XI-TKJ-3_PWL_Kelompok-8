import { animate } from '../library/anime.esm.js';

function initPostAnimations() {
    const posts = document.querySelectorAll('.post:not(.animated)');

    if (posts.length === 0) return;

    posts.forEach(post => {
        post.classList.add('post-animate-ready');
        post.dataset.originalOpacity = '1';
    });

    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -30px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.classList.contains('post-animate-ready')) {
                    entry.target.classList.remove('post-animate-ready');
                    entry.target.classList.add('post-animated');

                    const direction = entry.target.dataset.animation || 'up';
                    let translateY = '30px';
                    let translateX = '0px';

                    if (direction === 'down') translateY = '-30px';
                    if (direction === 'left') {
                        translateX = '-30px';
                        translateY = '0px';
                    }
                    if (direction === 'right') {
                        translateX = '30px';
                        translateY = '0px';
                    }

                    animate(entry.target, {
                        opacity: [0, 1],
                        translateY: [translateY, '0px'],
                        translateX: [translateX, '0px'],
                        duration: 600,
                        easing: 'cubicBezier(0.25, 0.1, 0.25, 1)',
                        elasticity: 0
                    });
                } else if (entry.target.classList.contains('post-animated')) {
                    animate(entry.target, {
                        opacity: 1,
                        duration: 300,
                        easing: 'easeOutQuad'
                    });
                }
            } else {
                if (entry.target.classList.contains('post-animated')) {
                    animate(entry.target, {
                        opacity: 0.3,
                        duration: 300,
                        easing: 'easeOutQuad'
                    });
                }
            }
        });
    }, observerOptions);

    posts.forEach(post => observer.observe(post));
}

const style = document.createElement('style');
style.textContent = `
    .post-animate-ready {
        opacity: 0 !important;
        transform: translateY(30px);
        will-change: transform, opacity;
    }

    .post-animated {
        opacity: 1;
        transition: opacity 0.3s ease;
    }

    /* Stagger animation */
    .post:nth-child(1) { transition-delay: 0ms; }
    .post:nth-child(2) { transition-delay: 50ms; }
    .post:nth-child(3) { transition-delay: 100ms; }
    .post:nth-child(4) { transition-delay: 150ms; }
    .post:nth-child(5) { transition-delay: 200ms; }
    .post:nth-child(6) { transition-delay: 250ms; }
    .post:nth-child(7) { transition-delay: 300ms; }
    .post:nth-child(8) { transition-delay: 350ms; }
    .post:nth-child(9) { transition-delay: 400ms; }
    .post:nth-child(10) { transition-delay: 450ms; }

    /* Hardware acceleration */
    .post {
        transform: translateZ(0);
        backface-visibility: hidden;
        perspective: 1000px;
    }
`;
document.head.appendChild(style);

initPostAnimations();
window.initPostAnimations = initPostAnimations;