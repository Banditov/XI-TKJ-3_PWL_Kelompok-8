import { animate, stagger, splitText } from './anime.esm.js';

const { chars } = splitText('h1', { words: false, chars: true });

animate(chars, {
    y: [
        { to: '-2.75rem', ease: 'outExpo', duration: 600 },
        { to: 0, ease: 'outBounce', duration: 800, delay: 100 }
    ],
    rotate: {
        from: '-1turn',
        delay: 0
    },
    delay: stagger(50),
    ease: 'inOutCirc',
    loopDelay: 1000,
    loop: true
});

const title = document.querySelector('#title');
const body = document.body;

const rainbow = [
    '#ff0000',
    '#ff7f00',
    '#ffff00',
    '#00ff00',
    '#0000ff',
    '#4b0082',
    '#9400d3'
];

let rainbowAnimation;

title.addEventListener('mouseenter', () => {
    animate(title, {
        scale: 1.3,
        duration: 400,
        ease: 'outExpo'
    });

    rainbowAnimation = animate(title, {
        color: rainbow,
        duration: 1500,
        ease: 'linear',
        loop: true
    });

    body.classList.remove('bg-blue-500');
    body.classList.add('bg-black');
});

title.addEventListener('mouseleave', () => {
    if (rainbowAnimation) {
        rainbowAnimation.pause();
    }

    animate(title, {
        scale: 1,
        color: '#ffffff',
        duration: 400,
        ease: 'outExpo'
    });

    body.classList.remove('bg-black');
    body.classList.add('bg-blue-500');
});