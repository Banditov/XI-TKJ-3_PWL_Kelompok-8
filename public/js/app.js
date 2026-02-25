import { animate } from './anime.esm.js';

const splash = document.getElementById('splash');
const canvas = document.getElementById('ballsCanvas');
const ctx = canvas.getContext('2d');
const logoContainer = document.getElementById('logoContainer');

let width, height, centerX, centerY;
let balls = [];
let animationId = null;
const gravity = 0.3;

const COLORS = ['#1D7BC5', '#FFCD56', '#FF4040'];

class Ball {
constructor(angle, distance) {
    this.angle = angle;
    this.distance = distance;
    this.initialDistance = distance;
    this.x = centerX + Math.cos(angle) * distance;
    this.y = centerY + Math.sin(angle) * distance;
    this.radius = Math.random() * 100 + 70; // 25–60px
    this.color = COLORS[Math.floor(Math.random() * COLORS.length)];
    this.opacity = 1;
    this.vx = 0;
    this.vy = 0;
    this.hasGravity = false;
    this.active = true;
}

explode() {
    this.hasGravity = true;
    const speed = Math.random() * 10 + 6;
    const angle = Math.atan2(this.y - centerY, this.x - centerX);
    const upwardBias = Math.random() * 0.6;
    this.vx = Math.cos(angle) * speed * (Math.random() + 0.5);
    this.vy = Math.sin(angle) * speed * (Math.random() + 0.5) - upwardBias * 6;
    this.vx += (Math.random() - 0.5) * 3;
    this.vy += (Math.random() - 0.5) * 2;
}

applyGravity() {
    if (!this.hasGravity) return;
        this.vy += gravity;
        this.x += this.vx;
        this.y += this.vy;
    if (this.y - this.radius > height) {
        this.active = false;
    }
}

update() {
    if (this.hasGravity && this.active) {
        this.applyGravity();
        this.opacity = Math.max(0, this.opacity - 0.002);
    }
}

draw() {
    if (!this.active) return;
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = this.color;
        ctx.globalAlpha = this.opacity;
        ctx.fill();

        // glow
        ctx.shadowColor = this.color;
        ctx.shadowBlur = 20;
        ctx.fill();
        ctx.shadowBlur = 0;
        ctx.globalAlpha = 1;
    }
}

function initCanvas() {
    width = window.innerWidth;
    height = window.innerHeight;
    centerX = width / 2;
    centerY = height / 2;
    canvas.width = width;
    canvas.height = height;

    balls = [];
    const count = 40;
    for (let i = 0; i < count; i++) {
        const angle = (i / count) * Math.PI * 2 + (Math.random() * 0.4 - 0.2);
        const distance = Math.random() * 120 + 20;
        balls.push(new Ball(angle, distance));
    }
    for (let i = 0; i < 15; i++) {
        const angle = Math.random() * Math.PI * 2;
        const distance = Math.random() * 140 + 10;
        balls.push(new Ball(angle, distance));
    }
}

function drawScene() {
    ctx.clearRect(0, 0, width, height);
    balls = balls.filter(b => {
        if (b.active) {
            b.update();
            b.draw();
        return true;
        }
        return false;
    });
}

function sceneLoop() {
    drawScene();
    animationId = requestAnimationFrame(sceneLoop);
}

initCanvas();
sceneLoop();

window.addEventListener('resize', initCanvas);

setTimeout(() => {
    balls.forEach(b => b.explode());
    animate(logoContainer, {
        scale: [
            { to: 1, duration: 0 },
            { to: 1.05, duration: 200 },
            { to: 1, duration: 150 }
        ],
        ease: 'outElastic(1, .5)',
        duration: 350
    });
}, 800);

function checkAllBallsGone() {
    if (balls.length === 0) {
        cancelAnimationFrame(animationId);
    } else {
        setTimeout(checkAllBallsGone, 200);
    }
}
setTimeout(checkAllBallsGone, 3000);