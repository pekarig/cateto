/**
 * Particle Network Animation
 * Interactive particle system with mouse interaction
 */

class ParticleNetwork {
    constructor(canvasId, options = {}) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) {
            console.error(`Canvas element with id "${canvasId}" not found`);
            return;
        }

        this.ctx = this.canvas.getContext('2d');

        // Configuration
        this.config = {
            numberOfParticles: options.numberOfParticles || 100,
            particleColor: options.particleColor || '#667eea',
            lineColor: options.lineColor || 'rgba(102, 126, 234, 1)',
            maxDistance: options.maxDistance || 150,
            particleSpeed: options.particleSpeed || 0.4,
            mouseRadius: options.mouseRadius || 150,
            ...options
        };

        this.particlesArray = [];
        this.mouse = {
            x: null,
            y: null,
            radius: this.config.mouseRadius
        };

        this.init();
    }

    init() {
        this.setCanvasSize();
        this.createParticles();
        this.setupEventListeners();
        this.animate();
    }

    setCanvasSize() {
        this.canvas.width = this.canvas.offsetWidth;
        this.canvas.height = this.canvas.offsetHeight;
    }

    setupEventListeners() {
        // Mouse move tracking
        this.canvas.addEventListener('mousemove', (event) => {
            const rect = this.canvas.getBoundingClientRect();
            this.mouse.x = event.clientX - rect.left;
            this.mouse.y = event.clientY - rect.top;
        });

        // Mouse leave event
        this.canvas.addEventListener('mouseleave', () => {
            this.mouse.x = null;
            this.mouse.y = null;
        });

        // Window resize
        window.addEventListener('resize', () => {
            this.setCanvasSize();
            this.createParticles();
        });
    }

    createParticles() {
        this.particlesArray = [];
        const numberOfParticles = this.config.numberOfParticles;

        for (let i = 0; i < numberOfParticles; i++) {
            const size = (Math.random() * 3) + 1;
            const x = (Math.random() * ((this.canvas.width - size * 2) - (size * 2)) + size * 2);
            const y = (Math.random() * ((this.canvas.height - size * 2) - (size * 2)) + size * 2);
            const directionX = (Math.random() * this.config.particleSpeed) - (this.config.particleSpeed / 2);
            const directionY = (Math.random() * this.config.particleSpeed) - (this.config.particleSpeed / 2);

            this.particlesArray.push(new Particle(
                x, y, directionX, directionY, size,
                this.config.particleColor,
                this.canvas,
                this.ctx
            ));
        }
    }

    connectParticles() {
        for (let a = 0; a < this.particlesArray.length; a++) {
            for (let b = a; b < this.particlesArray.length; b++) {
                const dx = this.particlesArray[a].x - this.particlesArray[b].x;
                const dy = this.particlesArray[a].y - this.particlesArray[b].y;
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < this.config.maxDistance) {
                    const opacity = 1 - (distance / this.config.maxDistance);
                    this.ctx.strokeStyle = this.config.lineColor.replace('1)', `${opacity})`);
                    this.ctx.lineWidth = 1;
                    this.ctx.beginPath();
                    this.ctx.moveTo(this.particlesArray[a].x, this.particlesArray[a].y);
                    this.ctx.lineTo(this.particlesArray[b].x, this.particlesArray[b].y);
                    this.ctx.stroke();
                }
            }
        }
    }

    animate() {
        requestAnimationFrame(() => this.animate());
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        for (let i = 0; i < this.particlesArray.length; i++) {
            this.particlesArray[i].update(this.mouse);
        }

        this.connectParticles();
    }
}

class Particle {
    constructor(x, y, directionX, directionY, size, color, canvas, ctx) {
        this.x = x;
        this.y = y;
        this.directionX = directionX;
        this.directionY = directionY;
        this.size = size;
        this.color = color;
        this.canvas = canvas;
        this.ctx = ctx;
    }

    draw() {
        this.ctx.beginPath();
        this.ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2, false);
        this.ctx.fillStyle = this.color;
        this.ctx.fill();
    }

    update(mouse) {
        // Bounce off edges
        if (this.x + this.size > this.canvas.width || this.x - this.size < 0) {
            this.directionX = -this.directionX;
        }
        if (this.y + this.size > this.canvas.height || this.y - this.size < 0) {
            this.directionY = -this.directionY;
        }

        // Mouse interaction - repel particles
        if (mouse.x !== null && mouse.y !== null) {
            const dx = mouse.x - this.x;
            const dy = mouse.y - this.y;
            const distance = Math.sqrt(dx * dx + dy * dy);

            if (distance < mouse.radius) {
                if (mouse.x < this.x && this.x < this.canvas.width - this.size * 10) {
                    this.x += 3;
                }
                if (mouse.x > this.x && this.x > this.size * 10) {
                    this.x -= 3;
                }
                if (mouse.y < this.y && this.y < this.canvas.height - this.size * 10) {
                    this.y += 3;
                }
                if (mouse.y > this.y && this.y > this.size * 10) {
                    this.y -= 3;
                }
            }
        }

        // Move particle
        this.x += this.directionX;
        this.y += this.directionY;

        // Draw particle
        this.draw();
    }
}

// Auto-initialize if canvas exists
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('particles-canvas');
    if (canvas) {
        new ParticleNetwork('particles-canvas', {
            numberOfParticles: 100,
            particleColor: '#667eea',
            lineColor: 'rgba(102, 126, 234, 1)',
            maxDistance: 150,
            particleSpeed: 0.4,
            mouseRadius: 150
        });
    }
});
