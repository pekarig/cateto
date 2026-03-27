/**
 * Inline Editor System
 * Bejelentkezés után szerkeszthetővé teszi a [data-content-key] elemeket
 */

class InlineEditor {
    constructor() {
        this.API_URL = 'http://localhost:8000/api';
        this.authToken = localStorage.getItem('auth_token');
        this.contentBlocks = {};
        this.currentEditor = null;

        // Csak ha be van jelentkezve
        if (this.authToken) {
            this.init();
        }
    }

    /**
     * Inicializálás
     */
    async init() {
        console.log('🔧 Inline Editor inicializálása...');

        // Quill betöltése
        await WYSIWYGEditor.loadQuill();

        // Content block-ok betöltése
        await this.loadContentBlocks();

        // Szerkeszthető elemek megjelölése
        this.markEditableSections();

        // Event listener-ek
        this.attachEventListeners();

        console.log('✅ Inline Editor kész!');
    }

    /**
     * Content block-ok betöltése az API-ról
     */
    async loadContentBlocks() {
        try {
            const response = await fetch(`${this.API_URL}/content-blocks`);
            const data = await response.json();

            // Key-value párok
            this.contentBlocks = data;

            console.log(`📦 ${Object.keys(data).length} content block betöltve`);
        } catch (error) {
            console.error('❌ Content block-ok betöltése sikertelen:', error);
        }
    }

    /**
     * Szerkeszthető szekciók megjelölése
     */
    markEditableSections() {
        const sections = document.querySelectorAll('[data-content-key]');

        sections.forEach(section => {
            const key = section.dataset.contentKey;

            // NEM töltjük újra a tartalmat - a content-loader.js már betöltötte!
            // Csak megjelöljük szerkeszthetőnek

            // Narancssárga szaggatott keret
            section.classList.add('editable-section');
            section.style.outline = '2px dashed #ff8800';
            section.style.outlineOffset = '4px';
            section.style.position = 'relative';
            section.style.cursor = 'pointer';
            section.style.transition = 'all 0.3s ease';

            // Hover effekt
            section.addEventListener('mouseenter', () => {
                section.style.outline = '3px dashed #ff6600';
                section.style.backgroundColor = 'rgba(255, 136, 0, 0.05)';
            });

            section.addEventListener('mouseleave', () => {
                section.style.outline = '2px dashed #ff8800';
                section.style.backgroundColor = 'transparent';
            });

            // Edit overlay badge
            this.addEditBadge(section, key);
        });

        console.log(`🎨 ${sections.length} szekció megjelölve szerkeszthetőként`);
    }

    /**
     * Edit badge hozzáadása
     */
    addEditBadge(section, key) {
        const badge = document.createElement('div');
        badge.className = 'edit-badge';
        badge.innerHTML = `
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
            <span>Szerkesztés: ${key}</span>
        `;

        badge.style.cssText = `
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(135deg, #ff8800 0%, #ff6600 100%);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(255, 102, 0, 0.3);
        `;

        section.appendChild(badge);

        section.addEventListener('mouseenter', () => {
            badge.style.opacity = '1';
        });

        section.addEventListener('mouseleave', () => {
            badge.style.opacity = '0';
        });
    }

    /**
     * Event listener-ek csatolása
     */
    attachEventListeners() {
        const sections = document.querySelectorAll('[data-content-key]');

        sections.forEach(section => {
            section.addEventListener('dblclick', (e) => {
                e.preventDefault();
                e.stopPropagation();

                const key = section.dataset.contentKey;
                this.openEditor(key, section);
            });
        });
    }

    /**
     * Editor megnyitása
     */
    openEditor(key, element) {
        console.log(`📝 Editor megnyitása: ${key}`);

        // Ha már van editor nyitva, bezárjuk
        if (this.currentEditor) {
            this.currentEditor.close();
        }

        // Új editor példány
        this.currentEditor = new WYSIWYGEditor(key, element, this);
        this.currentEditor.open();
    }

    /**
     * Content block mentése
     */
    async saveContentBlock(key, content) {
        try {
            const block = this.contentBlocks[key];
            const method = block ? 'PUT' : 'POST';
            const url = block
                ? `${this.API_URL}/admin/content-blocks/${key}`
                : `${this.API_URL}/admin/content-blocks`;

            const response = await fetch(url, {
                method,
                headers: {
                    'Authorization': `Bearer ${this.authToken}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    key,
                    content: { html: content }
                })
            });

            if (!response.ok) {
                throw new Error('Mentés sikertelen');
            }

            const data = await response.json();
            console.log('✅ Mentve:', data);

            // Frissítjük a cache-t
            await this.loadContentBlocks();

            return data;
        } catch (error) {
            console.error('❌ Mentési hiba:', error);
            throw error;
        }
    }
}

/**
 * WYSIWYG Editor Modal
 */
class WYSIWYGEditor {
    constructor(key, element, inlineEditor) {
        this.key = key;
        this.element = element;
        this.inlineEditor = inlineEditor;
        this.modal = null;
        this.editorId = 'wysiwyg-editor-' + Date.now();
        this.quill = null;
    }

    /**
     * Editor megnyitása
     */
    open() {
        // Modal létrehozása
        this.modal = this.createModal();
        document.body.appendChild(this.modal);

        // Quill inicializálása
        this.initQuill();

        // Animáció
        setTimeout(() => {
            this.modal.classList.add('active');
        }, 10);
    }

    /**
     * Modal HTML létrehozása
     */
    createModal() {
        const modal = document.createElement('div');
        modal.className = 'wysiwyg-modal';
        modal.innerHTML = `
            <div class="modal-backdrop"></div>
            <div class="modal-content">
                <div class="modal-header">
                    <h2>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        Tartalom szerkesztése
                    </h2>
                    <button class="close-btn" id="close-modal-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="editor-info">
                        <span class="info-label">Szekció kulcs:</span>
                        <code>${this.key}</code>
                    </div>
                    <div id="${this.editorId}" style="height: 450px; background: white;"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" id="cancel-btn">Mégse</button>
                    <button class="btn btn-warning" id="convert-dark-btn" style="margin-right: auto;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                        Világos → Sötét
                    </button>
                    <button class="btn btn-primary" id="save-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        Mentés
                    </button>
                </div>
            </div>
        `;

        // CSS
        this.addModalStyles();

        // Event listeners
        modal.querySelector('#close-modal-btn').addEventListener('click', () => this.close());
        modal.querySelector('#cancel-btn').addEventListener('click', () => this.close());
        modal.querySelector('#save-btn').addEventListener('click', () => this.save());
        modal.querySelector('#convert-dark-btn').addEventListener('click', () => this.convertToDarkMode());
        modal.querySelector('.modal-backdrop').addEventListener('click', () => this.close());

        return modal;
    }

    /**
     * Quill inicializálása
     */
    initQuill() {
        // Eredeti tartalom tisztán (edit badge nélkül)
        const badge = this.element.querySelector('.edit-badge');
        if (badge) badge.remove();
        const currentContent = this.element.innerHTML;

        // Átváltunk azonnal HTML nézetbe összetett tartalmaknál
        const hasComplexContent = this.isComplexHTML(currentContent);

        // Quill toolbar opciók
        const toolbarOptions = [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'font': [] }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'script': 'sub'}, { 'script': 'super' }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            [{ 'align': [] }],
            ['blockquote', 'code-block'],
            ['link', 'image', 'video'],
            ['clean'],
            ['html'] // Custom HTML button
        ];

        // Quill inicializálás
        this.quill = new Quill('#' + this.editorId, {
            theme: 'snow',
            modules: {
                toolbar: {
                    container: toolbarOptions,
                    handlers: {
                        'html': () => this.toggleHTMLView()
                    }
                }
            },
            placeholder: 'Írd ide a tartalmat...'
        });

        // Add custom HTML button to toolbar
        const htmlButton = document.querySelector(`#${this.editorId}`).previousElementSibling.querySelector('.ql-html');
        if (htmlButton) {
            htmlButton.innerHTML = '<svg viewBox="0 0 18 18"><polyline class="ql-stroke" points="5 7 3 9 5 11"></polyline><polyline class="ql-stroke" points="13 7 15 9 13 11"></polyline><line class="ql-stroke" x1="10" x2="8" y1="5" y2="13"></line></svg>';
            htmlButton.setAttribute('title', 'HTML nézet (ajánlott összetett tartalmaknál)');
        }

        // Tartalom beállítása - TISZTA HTML-ként
        this.quill.root.innerHTML = currentContent;

        // FORCE dark text on white background
        this.quill.root.style.backgroundColor = '#ffffff';
        this.quill.root.style.color = '#111827';

        // Add listener to ensure color stays
        this.quill.on('text-change', () => {
            if (this.quill.root.style.color !== 'rgb(17, 24, 39)') {
                this.quill.root.style.color = '#111827';
            }
        });

        // HTML view state
        this.isHTMLView = false;

        // Ha összetett tartalom, egyből HTML nézet + figyelmeztetés
        if (hasComplexContent) {
            setTimeout(() => {
                this.toggleHTMLView();
                this.showNotification('⚠️ Összetett HTML tartalom - HTML nézet használata ajánlott!', 'warning');
            }, 100);
        }
    }

    /**
     * Összetett HTML ellenőrzése
     */
    isComplexHTML(html) {
        return html.includes('<svg') ||
               html.includes('data-') ||
               html.includes('stack-cards') ||
               html.includes('ns-shape-') ||
               html.match(/class="[^"]*\[[^"]*\]/); // Tailwind arbitrary values
    }

    /**
     * Toggle between WYSIWYG and HTML view
     */
    toggleHTMLView() {
        const editorContainer = document.getElementById(this.editorId);
        const toolbar = editorContainer.previousElementSibling;

        if (!this.isHTMLView) {
            // Switch to HTML view
            const html = this.quill.root.innerHTML;

            // Create textarea
            const textarea = document.createElement('textarea');
            textarea.id = 'html-source-' + this.editorId;
            textarea.value = this.formatHTML(html);
            textarea.style.cssText = `
                width: 100%;
                height: 450px;
                padding: 16px;
                font-family: 'Courier New', monospace;
                font-size: 14px;
                line-height: 1.5;
                border: 1px solid #e5e7eb;
                border-radius: 6px;
                background: #1e1e1e;
                color: #d4d4d4;
                resize: none;
                tab-size: 2;
            `;

            // Hide Quill, show textarea
            editorContainer.style.display = 'none';
            editorContainer.parentElement.insertBefore(textarea, editorContainer);

            // Disable toolbar buttons except HTML
            const buttons = toolbar.querySelectorAll('button:not(.ql-html), select');
            buttons.forEach(btn => btn.disabled = true);

            // Highlight HTML button
            const htmlBtn = toolbar.querySelector('.ql-html');
            if (htmlBtn) {
                htmlBtn.style.background = '#ff8800';
                htmlBtn.style.color = 'white';
            }

            this.isHTMLView = true;
        } else {
            // Switch back to WYSIWYG
            const textarea = document.getElementById('html-source-' + this.editorId);
            if (textarea) {
                // Update Quill content from textarea
                this.quill.root.innerHTML = textarea.value;
                textarea.remove();
            }

            // Show Quill
            editorContainer.style.display = 'block';

            // Re-enable toolbar buttons
            const buttons = toolbar.querySelectorAll('button, select');
            buttons.forEach(btn => btn.disabled = false);

            // Remove HTML button highlight
            const htmlBtn = toolbar.querySelector('.ql-html');
            if (htmlBtn) {
                htmlBtn.style.background = '';
                htmlBtn.style.color = '';
            }

            this.isHTMLView = false;
        }
    }

    /**
     * Format HTML for better readability
     */
    formatHTML(html) {
        // Simple HTML formatting
        let formatted = html;

        // Add newlines after closing tags
        formatted = formatted.replace(/>/g, '>\n');

        // Add newlines before opening tags
        formatted = formatted.replace(/</g, '\n<');

        // Remove empty lines
        formatted = formatted.split('\n').filter(line => line.trim()).join('\n');

        // Basic indentation
        let indent = 0;
        const lines = formatted.split('\n');
        const indented = lines.map(line => {
            const trimmed = line.trim();

            // Decrease indent for closing tags
            if (trimmed.startsWith('</')) {
                indent = Math.max(0, indent - 2);
            }

            const indentedLine = ' '.repeat(indent) + trimmed;

            // Increase indent for opening tags (but not self-closing or closing tags)
            if (trimmed.startsWith('<') && !trimmed.startsWith('</') && !trimmed.endsWith('/>')) {
                indent += 2;
            }

            return indentedLine;
        });

        return indented.join('\n');
    }

    /**
     * Quill betöltése CDN-ről
     */
    static loadQuill() {
        return new Promise((resolve, reject) => {
            // Ha már be van töltve
            if (window.Quill) {
                resolve();
                return;
            }

            // CSS betöltése
            const css = document.createElement('link');
            css.rel = 'stylesheet';
            css.href = 'https://cdn.quilljs.com/1.3.6/quill.snow.css';
            document.head.appendChild(css);

            // JS betöltése
            const script = document.createElement('script');
            script.src = 'https://cdn.quilljs.com/1.3.6/quill.js';
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }

    /**
     * Világos téma konvertálása sötétre (Moduláris megközelítés)
     */
    convertToDarkMode() {
        let html = this.getCurrentHTML();

        try {
            // 7 fázisú konverzió
            html = this.phase1_removeDarkPrefixes(html);
            html = this.phase2_convertBackgrounds(html);
            html = this.phase3_convertTextColors(html);
            html = this.phase4_convertBorders(html);
            html = this.phase5_convertSVG(html);
            html = this.phase6_addMissingColors(html);
            html = this.phase7_cleanup(html);

            // Frissítjük a tartalmat
            this.updateEditorContent(html);

            this.showNotification('✅ Konverzió sikeres! Sötét téma alkalmazva.', 'success');
        } catch (error) {
            console.error('Konverziós hiba:', error);
            this.showNotification('⚠️ Konverzió részben sikertelen. Ellenőrizd a HTML-t!', 'warning');
        }
    }

    /**
     * Aktuális HTML tartalom lekérése
     */
    getCurrentHTML() {
        if (this.isHTMLView) {
            const textarea = document.getElementById('html-source-' + this.editorId);
            return textarea ? textarea.value : this.quill.root.innerHTML;
        }
        return this.quill.root.innerHTML;
    }

    /**
     * Editor tartalom frissítése
     */
    updateEditorContent(html) {
        if (this.isHTMLView) {
            const textarea = document.getElementById('html-source-' + this.editorId);
            if (textarea) {
                textarea.value = html;
            }
        } else {
            this.quill.root.innerHTML = html;
        }
    }

    /**
     * FÁZIS 1: Dark prefix kombinációk eltávolítása
     * Eltávolítja a dark: prefixeket és kombinált osztályokat
     */
    phase1_removeDarkPrefixes(html) {
        const rules = [
            // Kombinált text osztályok (FONTOS: ezek elsők!)
            { from: /text-secondary\s+dark:text-accent\/(\d+)/g, to: 'text-accent/$1' },
            { from: /text-secondary\s+dark:text-accent/g, to: 'text-accent' },
            { from: /text-secondary\/(\d+)\s+dark:text-accent\/\1/g, to: 'text-accent/$1' },

            // Kombinált background osztályok
            { from: /bg-background-(\d+)\s+dark:bg-background-(\d+)/g, to: 'bg-background-$2' },
            { from: /bg-stroke-(\d+)\s+dark:bg-stroke-(\d+)/g, to: 'bg-stroke-$2' },

            // Kombinált border osztályok
            { from: /border-stroke-(\d+)\s+dark:border-stroke-(\d+)/g, to: 'border-stroke-$2' },

            // Maradék dark: prefix-ek (amelyek nem kombinációk)
            { from: /dark:bg-background-\d+\s*/g, to: '' },
            { from: /dark:bg-stroke-\d+\s*/g, to: '' },
            { from: /dark:text-accent\/?\d*\s*/g, to: '' },
            { from: /dark:text-white\s*/g, to: '' },
            { from: /dark:border-stroke-\d+\s*/g, to: '' },
            { from: /dark:stroke-accent\s*/g, to: '' },
            { from: /dark:hover:bg-\S+\s*/g, to: '' },
        ];

        return this.applyRules(html, rules);
    }

    /**
     * FÁZIS 2: Háttérszínek konverziója
     * Világos háttérszínek -> Sötét háttérszínek
     */
    phase2_convertBackgrounds(html) {
        const bgMap = {
            'bg-background-1': 'bg-background-8',
            'bg-background-2': 'bg-background-8',
            'bg-background-3': 'bg-background-7',
            'bg-background-4': 'bg-background-6',
            'bg-background-10': 'bg-background-9',
            'bg-stroke-1': 'bg-stroke-6',
            'bg-stroke-2': 'bg-stroke-6',
            'bg-stroke-3': 'bg-stroke-7',
            'bg-stroke-4': 'bg-stroke-7',
            'bg-white': 'bg-background-9',
            'bg-gray-50': 'bg-background-8',
            'bg-gray-100': 'bg-background-8',
        };

        const rules = Object.entries(bgMap).map(([from, to]) => ({
            from: new RegExp(`\\b${from}\\b`, 'g'),
            to: to
        }));

        return this.applyRules(html, rules);
    }

    /**
     * FÁZIS 3: Szövegszínek konverziója
     * Sötét szövegszínek -> Világos szövegszínek
     */
    phase3_convertTextColors(html) {
        const textMap = {
            'text-secondary': 'text-accent',
            'text-secondary/60': 'text-accent/60',
            'text-secondary/70': 'text-accent/70',
            'text-secondary/80': 'text-accent/80',
            'text-black': 'text-white',
            'text-gray-900': 'text-white',
            'text-gray-800': 'text-gray-200',
            'text-gray-700': 'text-gray-300',
            'text-gray-600': 'text-gray-400',
            'text-gray-500': 'text-gray-400',
        };

        const rules = Object.entries(textMap).map(([from, to]) => ({
            from: new RegExp(`\\b${from}\\b`, 'g'),
            to: to
        }));

        return this.applyRules(html, rules);
    }

    /**
     * FÁZIS 4: Keretszínek konverziója
     * Világos keretek -> Sötét keretek
     */
    phase4_convertBorders(html) {
        const borderMap = {
            'border-stroke-1': 'border-stroke-7',
            'border-stroke-2': 'border-stroke-7',
            'border-stroke-3': 'border-stroke-7',
            'border-stroke-4': 'border-stroke-7',
            'border-gray-200': 'border-stroke-7',
            'border-gray-300': 'border-stroke-7',
        };

        const rules = Object.entries(borderMap).map(([from, to]) => ({
            from: new RegExp(`\\b${from}\\b`, 'g'),
            to: to
        }));

        return this.applyRules(html, rules);
    }

    /**
     * FÁZIS 5: SVG színek konverziója
     * Sötét SVG stroke-ok -> Világos SVG stroke-ok
     */
    phase5_convertSVG(html) {
        const rules = [
            { from: /stroke-black\b/g, to: 'stroke-accent' },
            { from: /stroke-secondary\b/g, to: 'stroke-accent' },
            { from: /stroke-gray-900\b/g, to: 'stroke-white' },
            { from: /stroke-gray-800\b/g, to: 'stroke-gray-200' },
            { from: /fill-black\b/g, to: 'fill-white' },
            { from: /fill-secondary\b/g, to: 'fill-accent' },
        ];

        return this.applyRules(html, rules);
    }

    /**
     * FÁZIS 6: Hiányzó színek hozzáadása
     * Elemekhez, amelyek nem rendelkeznek explicit színosztállyal
     */
    phase6_addMissingColors(html) {
        // Helper: Ellenőrzi, hogy van-e COLOR osztály (nem size osztály)
        const hasColorClass = (attrs) => {
            if (!attrs) return false;
            // Kizárjuk a size osztályokat (text-heading-, text-tagline-, text-body-)
            // És csak a valódi szín osztályokat nézzük (text-accent, text-white, text-primary-, stb.)
            const colorPattern = /\btext-(?!heading-|tagline-|body-|xs\b|sm\b|base\b|lg\b|xl\b|2xl\b|3xl\b|4xl\b|5xl\b|6xl\b|7xl\b|8xl\b|9xl\b)\w+/;
            return colorPattern.test(attrs);
        };

        // h1-h6 elemek: text-accent hozzáadása ha nincs COLOR osztály
        html = html.replace(/<(h[1-6])(\s+[^>]*)?>/gi, (match, tag, attrs) => {
            if (!hasColorClass(attrs)) {
                if (attrs && attrs.includes('class="')) {
                    return match.replace(/class="/, 'class="text-accent ');
                } else if (attrs && attrs.trim()) {
                    return `<${tag} class="text-accent"${attrs}>`;
                } else {
                    return `<${tag} class="text-accent">`;
                }
            }
            return match;
        });

        // p elemek: text-accent/60 hozzáadása ha nincs COLOR osztály
        html = html.replace(/<p(\s+[^>]*)?>/gi, (match, attrs) => {
            if (!hasColorClass(attrs)) {
                if (attrs && attrs.includes('class="')) {
                    return match.replace(/class="/, 'class="text-accent/60 ');
                } else if (attrs && attrs.trim()) {
                    return `<p class="text-accent/60"${attrs}>`;
                } else {
                    return `<p class="text-accent/60">`;
                }
            }
            return match;
        });

        return html;
    }

    /**
     * FÁZIS 7: HTML tisztítása
     * Dupla space-ek, üres class-ok és felesleges whitespace eltávolítása
     */
    phase7_cleanup(html) {
        // Dupla space-ek class-okon belül
        html = html.replace(/class="([^"]*)"/g, (match, classes) => {
            const cleaned = classes.split(/\s+/).filter(c => c).join(' ').trim();
            return cleaned ? `class="${cleaned}"` : '';
        });

        // Üres class attribútumok
        html = html.replace(/\s*class=""\s*/g, ' ');

        // Dupla space-ek az attribútumokon belül
        html = html.replace(/\s{2,}/g, ' ');

        // Space a closing tag előtt
        html = html.replace(/\s+>/g, '>');

        return html;
    }

    /**
     * Konverziós szabályok alkalmazása
     */
    applyRules(html, rules) {
        rules.forEach(({ from, to }) => {
            html = html.replace(from, to);
        });
        return html;
    }

    /**
     * Mentés
     */
    async save() {
        // Get content from HTML view if active, otherwise from Quill
        let content;
        if (this.isHTMLView) {
            const textarea = document.getElementById('html-source-' + this.editorId);
            content = textarea ? textarea.value : this.quill.root.innerHTML;
        } else {
            content = this.quill.root.innerHTML;
        }

        // Tisztítsuk meg a tartalmat (ne mentődjön bele semmi extra)
        content = this.cleanContent(content);

        const saveBtn = this.modal.querySelector('#save-btn');
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span>Mentés...</span>';

        try {
            const savedBlock = await this.inlineEditor.saveContentBlock(this.key, content);

            // Elem frissítése
            this.element.innerHTML = content;

            // Globális contentLoader cache frissítése (ha létezik)
            if (window.contentLoader && window.contentLoader.contentBlocks) {
                window.contentLoader.contentBlocks[this.key] = savedBlock.block;
            }

            // Badge újra hozzáadása
            this.inlineEditor.addEditBadge(this.element, this.key);

            // Bezárás
            this.close();

            // Siker üzenet
            this.showNotification('✅ Sikeresen mentve!', 'success');
        } catch (error) {
            saveBtn.disabled = false;
            saveBtn.innerHTML = `
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                Mentés
            `;
            this.showNotification('❌ Mentés sikertelen!', 'error');
        }
    }

    /**
     * Tartalom tisztítása (edit badge és felesleges elemek eltávolítása)
     */
    cleanContent(html) {
        const temp = document.createElement('div');
        temp.innerHTML = html;

        // Edit badge eltávolítása
        const badge = temp.querySelector('.edit-badge');
        if (badge) badge.remove();

        // Inline style-ok eltávolítása ami a Quill-től jön
        const elements = temp.querySelectorAll('[style]');
        elements.forEach(el => {
            // Ha csak Quill által hozzáadott color/background van, távolítsuk el
            const style = el.getAttribute('style');
            if (style && !style.includes('background-image') && !style.includes('position')) {
                // Csak akkor távolítsuk el ha basic formázás
                if (!el.classList.length || el.tagName === 'SPAN') {
                    el.removeAttribute('style');
                }
            }
        });

        return temp.innerHTML;
    }

    /**
     * Bezárás
     */
    close() {
        this.modal.classList.remove('active');

        setTimeout(() => {
            this.modal.remove();
            this.inlineEditor.currentEditor = null;
        }, 300);
    }

    /**
     * Notification
     */
    showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;

        const colors = {
            success: '#10b981',
            error: '#ef4444',
            warning: '#f59e0b'
        };

        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${colors[type] || colors.success};
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 10000;
            animation: slideIn 0.3s ease;
            max-width: 400px;
            font-size: 14px;
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, type === 'warning' ? 5000 : 3000);
    }

    /**
     * Modal CSS
     */
    addModalStyles() {
        if (document.getElementById('wysiwyg-modal-styles')) return;

        const style = document.createElement('style');
        style.id = 'wysiwyg-modal-styles';
        style.textContent = `
            .wysiwyg-modal {
                position: fixed;
                inset: 0;
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .wysiwyg-modal.active {
                opacity: 1;
            }

            .modal-backdrop {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(4px);
            }

            .modal-content {
                position: relative;
                background: white;
                border-radius: 12px;
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
                width: 90%;
                max-width: 900px;
                max-height: 90vh;
                display: flex;
                flex-direction: column;
                transform: scale(0.9);
                transition: transform 0.3s ease;
            }

            .wysiwyg-modal.active .modal-content {
                transform: scale(1);
            }

            .modal-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 20px 24px;
                border-bottom: 1px solid #e5e7eb;
            }

            .modal-header h2 {
                margin: 0;
                font-size: 20px;
                font-weight: 600;
                color: #111827;
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .close-btn {
                background: none;
                border: none;
                padding: 8px;
                cursor: pointer;
                color: #6b7280;
                border-radius: 6px;
                transition: all 0.2s;
            }

            .close-btn:hover {
                background: #f3f4f6;
                color: #111827;
            }

            .modal-body {
                flex: 1;
                padding: 24px;
                overflow-y: auto;
            }

            .editor-info {
                margin-bottom: 16px;
                padding: 12px;
                background: #f9fafb;
                border-radius: 6px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .info-label {
                font-size: 14px;
                font-weight: 500;
                color: #6b7280;
            }

            .editor-info code {
                background: #fff;
                padding: 4px 8px;
                border-radius: 4px;
                font-family: monospace;
                font-size: 13px;
                color: #ff6600;
                border: 1px solid #e5e7eb;
            }

            .modal-footer {
                display: flex;
                justify-content: flex-end;
                gap: 12px;
                padding: 20px 24px;
                border-top: 1px solid #e5e7eb;
            }

            .btn {
                padding: 10px 20px;
                border-radius: 6px;
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s;
                border: none;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .btn-secondary {
                background: #f3f4f6;
                color: #374151;
            }

            .btn-secondary:hover {
                background: #e5e7eb;
            }

            .btn-warning {
                background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
                color: #1f2937;
                font-weight: 600;
            }

            .btn-warning:hover {
                box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
                transform: translateY(-1px);
            }

            .btn-primary {
                background: linear-gradient(135deg, #ff8800 0%, #ff6600 100%);
                color: white;
            }

            .btn-primary:hover {
                box-shadow: 0 4px 12px rgba(255, 102, 0, 0.3);
                transform: translateY(-1px);
            }

            .btn:disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }

            /* Quill Editor Styles - FIX WHITE TEXT ON WHITE BACKGROUND */
            .ql-container {
                background: white !important;
                color: #111827 !important;
            }

            .ql-editor {
                background: white !important;
                color: #111827 !important;
                font-size: 16px;
                line-height: 1.6;
            }

            .ql-editor p,
            .ql-editor h1,
            .ql-editor h2,
            .ql-editor h3,
            .ql-editor h4,
            .ql-editor h5,
            .ql-editor h6,
            .ql-editor ul,
            .ql-editor ol,
            .ql-editor li {
                color: #111827 !important;
            }

            .ql-editor.ql-blank::before {
                color: #9ca3af !important;
                font-style: italic;
            }

            .ql-toolbar {
                background: #f9fafb !important;
                border-bottom: 1px solid #e5e7eb !important;
            }

            .ql-stroke {
                stroke: #374151 !important;
            }

            .ql-fill {
                fill: #374151 !important;
            }

            .ql-picker-label {
                color: #374151 !important;
            }

            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;

        document.head.appendChild(style);
    }
}

// Auto-init amikor a DOM betöltődött ÉS be van jelentkezve
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        // Várunk hogy a content-loader és a komponensek betöltődjenek
        setTimeout(() => {
            if (localStorage.getItem('auth_token')) {
                console.log('🔐 Auth token található, Inline Editor inicializálása...');
                window.inlineEditor = new InlineEditor();
            } else {
                console.log('⚠️ Nincs auth token - Inline Editor nem inicializálódik');
            }
        }, 500); // Növelve 100ms-ról 500ms-ra
    });
} else {
    setTimeout(() => {
        if (localStorage.getItem('auth_token')) {
            console.log('🔐 Auth token található, Inline Editor inicializálása...');
            window.inlineEditor = new InlineEditor();
        } else {
            console.log('⚠️ Nincs auth token - Inline Editor nem inicializálódik');
        }
    }, 500);
}
