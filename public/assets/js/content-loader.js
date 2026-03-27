/**
 * Public Content Loader
 * Bejelentkezés NÉLKÜL is betölti a mentett content block-okat
 */

class ContentLoader {
    constructor() {
        // Csak az /api-ig, a /content-blocks-ot ne add hozz� itt!
        this.API_URL = `${window.location.origin}/api`;
        this.contentBlocks = {};
        this.init();
    }

    /**
     * Inicializálás
     */
    async init() {
        console.log('📦 Content Loader inicializálása...');

        // Content block-ok betöltése
        await this.loadContentBlocks();

        // Tartalmak beillesztése
        this.populateContent();

        // Jelezzük hogy betöltődött
        document.body.classList.add('content-loaded');

        console.log('✅ Content Loader kész!');
    }

    /**
     * Content block-ok betöltése az API-ról
     */
    async loadContentBlocks() {
        try {
            const response = await fetch(`${this.API_URL}/content-blocks`);
            const data = await response.json();

            this.contentBlocks = data;

            console.log(`📦 ${Object.keys(data).length} content block betöltve`);
        } catch (error) {
            console.error('❌ Content block-ok betöltése sikertelen:', error);
        }
    }

    /**
     * Tartalmak beillesztése a DOM-ba
     */
    populateContent() {
        const sections = document.querySelectorAll('[data-content-key]');

        sections.forEach(section => {
            const key = section.dataset.contentKey;

            // Ha van mentett tartalom, beillesztjük
            if (this.contentBlocks[key]) {
                const content = this.contentBlocks[key].content;
                // JSON check - ha még JSON formátum, akkor .html property-t használ
                // Ha már sima TEXT, akkor közvetlenül használja
                const html = typeof content === 'string' ? content : (content.html || '');

                if (html) {
                    section.innerHTML = html;

                    // KRITIKUS: Az új tartalmat azonnal láthatóvá tesszük
                    // Ez felülbírálja a GSAP animációkat
                    this.makeContentVisible(section);
                }
            }
        });

        console.log(`🎨 ${sections.length} szekció tartalma betöltve`);

        // Újrainicializáljuk a GSAP animációkat az új tartalomhoz
        this.reinitializeAnimations();
    }

    /**
     * Tartalom láthatóvá tétele (GSAP animációk felülbírálása)
     */
    makeContentVisible(container) {
        // A container és az összes gyerek elemét láthatóvá tesszük
        const allElements = [container, ...container.querySelectorAll('*')];

        allElements.forEach(elem => {
            // Fontos inline style-ok hogy felülbírálják a GSAP-ot
            elem.style.opacity = '1';
            elem.style.visibility = 'visible';
            elem.style.transform = 'none';
            elem.style.filter = 'none';
        });
    }

    /**
     * GSAP animációk újrainicializálása
     */
    reinitializeAnimations() {
        // Várunk egy kicsit, hogy a DOM stabilizálódjon
        setTimeout(() => {
            // Ha van ScrollTrigger, frissítjük
            if (window.ScrollTrigger) {
                window.ScrollTrigger.refresh();
            }

            // Ha van custom animation init funkció, hívjuk meg
            if (window.initAnimations && typeof window.initAnimations === 'function') {
                window.initAnimations();
            }

            console.log('🔄 Animációk újrainicializálva');
        }, 100);
    }
}

// Auto-init amikor a DOM betöltődött
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.contentLoader = new ContentLoader();
    });
} else {
    window.contentLoader = new ContentLoader();
}
