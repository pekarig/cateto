<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\WebServiceItem;
use App\Models\ContentBlock;
use Illuminate\Database\Seeder;

class WebServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Internetes jelenlét oldal ID
        $page = Page::where('slug', 'internetes-jelenlet')->firstOrFail();

        // Létrehozunk egy "web_services" content block-ot (üres, csak jelölés)
        ContentBlock::updateOrCreate(
            ['key' => 'web_services'],
            [
                'page_id' => $page->id,
                'type' => 'custom',
                'content' => '<!-- Web Services Grid: Dinamikus tartalom az admin felületről -->',
                'sort_order' => 2, // web_tartalom után
            ]
        );

        // 6 db Service doboz a tesztelek.html alapján
        $services = [
            [
                'tagline' => 'Stack',
                'icon_path' => null, // ns-shape-36 - később SVG-t lehet feltölteni
                'heading' => 'Az alkalmazásban használt technológiák összessége',
                'description' => '<p>Laravel 11 backend + vanilla JS frontend felállás, ahol a szerveroldali MVC + RESTful API kezeli az üzleti logikát, míg a kliensoldalon DOM-driven, event-based UI fut SPA framework overhead nélkül.</p>',
                'features' => [
                    ['text' => 'Laravel 11'],
                    ['text' => 'Vanilla JS'],
                    ['text' => 'Tailwind CSS'],
                    ['text' => 'Yarn csomagkezelő'],
                ],
                'sort_order' => 0,
            ],
            [
                'tagline' => 'Backend',
                'icon_path' => null, // ns-shape-10
                'heading' => 'Laravel',
                'description' => '<p>A Laravel egy PHP backend keretrendszer, amelyet modern, robusztus webalkalmazások hatékony fejlesztésére terveztek, megkönnyítve az olyan gyakori feladatokat, mint az autentikáció, routing, és adatbázis-kezelés; MVC (Model-View-Controller) blade template-k használatával.</p>',
                'features' => [
                    ['text' => 'Üzleti logikát kezel'],
                    ['text' => 'Felhasználókat azonosít'],
                    ['text' => 'API-t szolgál ki'],
                    ['text' => 'Biztonságot ad'],
                ],
                'sort_order' => 1,
            ],
            [
                'tagline' => 'Frontend',
                'icon_path' => null, // ns-shape-17
                'heading' => 'Vanilla JS',
                'description' => '<p>Frontend oldalon Vanilla JS fut JSON payloadokkal, nincs globális state management, nincs hydration, cserébe full kontroll, zero framework lock-in és predictálható runtime.</p>',
                'features' => [
                    ['text' => 'Tiszta, modern JavaScript'],
                    ['text' => 'DOM (Document Object Model)'],
                    ['text' => 'DOM manipulation'],
                ],
                'sort_order' => 2,
            ],
            [
                'tagline' => 'Styling',
                'icon_path' => null, // ns-shape-93
                'heading' => 'Tailwind CSS',
                'description' => '<p>Tailwind CSS egy utility-first CSS keretrendszer, amely gyors és testreszabható stílusokat tesz lehetővé.</p>',
                'features' => [
                    ['text' => 'Prototyping'],
                    ['text' => 'Highly customizable'],
                    ['text' => 'CSS footprint'],
                ],
                'sort_order' => 3,
            ],
            [
                'tagline' => 'Build',
                'icon_path' => null, // ns-shape-66
                'heading' => 'Build & tooling',
                'description' => '<p>A vite egy modern build eszköz, amely gyors fejlesztési környezetet és optimalizált produkciós buildet biztosít. A Yarn pedig egy népszerű csomagkezelő és build eszköz JavaScript projektekhez.</p>',
                'features' => [
                    ['text' => 'Yarn csomagkezelő'],
                    ['text' => 'HMR (Hot Module Replacement)'],
                    ['text' => 'ES6+ JavaScript (2015 utáni nyelvi feature-ök)'],
                    ['text' => 'Import/export-alapú kódszervezés'],
                ],
                'sort_order' => 4,
            ],
            [
                'tagline' => 'eDM',
                'icon_path' => null, // ns-shape-62
                'heading' => 'HTML hírlevél',
                'description' => '<p>Az eDM (electronic Direct Marketing) régi jól bevállt formája a hírlevél. A statikus hírlevél-sablonok egy legacy, de kőkeményen valós környezetben futnak. Nincs JavaScript, nincs modern CSS, nincs DOM-API, csak inline CSS és táblázatok. Itt nem a technológiai „stack" számít, hanem a kompatibilitás (Gmail, Outlook, Apple Mail, Thunderbird), az elegáns dizájn, valamint az, hogy a HTML bombabiztos legyen minden mail kliensben. Ez nem modern frontend, hanem defenzív UI, ahol a stabilitás, a kézbesíthetőség és a vizuális konzisztencia fontosabb, mint a DX vagy az elegancia — és pont ezért szükségszerű még napjainkban is. Nem kompromisszum, nem visszalépés, hanem egy másik műfaj.</p>',
                'features' => [],
                'sort_order' => 5,
            ],
        ];

        // Beszúrás/frissítés
        foreach ($services as $serviceData) {
            WebServiceItem::updateOrCreate(
                [
                    'page_id' => $page->id,
                    'heading' => $serviceData['heading'],
                ],
                $serviceData
            );
        }

        $this->command->info('✅ 6 db Web Service doboz létrehozva/frissítve!');
    }
}
