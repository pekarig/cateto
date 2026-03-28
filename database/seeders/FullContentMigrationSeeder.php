<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\ContentBlock;

/**
 * ❌ ARCHIVÁLT SEEDER - NEM JAVASOLT FUTTATNI PRODUCTION KÖRNYEZETBEN!
 *
 * Ez a seeder az eredeti tartalmakkal tölti fel az adatbázist.
 * A tartalmat az admin felületen (Filament) szerkeszd!
 *
 * ⚠️ HA ÚJRAFUTTATNÁD:
 *    - Előbb backup-elyél az adatbázist!
 *    - Az admin felületen módosított tartalmak felülírásra kerülnek!
 *    - Az eredeti HTML fájlok az _archive/original_content_blocks/ mappában vannak
 *
 * Csak akkor futtatd, ha:
 * - Fresh adatbázist szeretnél (clean install)
 * - Vagy tisztán kell indítani
 */
class FullContentMigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ⛔ BIZTONSÁGI MEGELŐZÉS: Ez a seeder az eredeti, archivált tartalmakkal fut.
        // Nem ajánlott futtatni PRODUCTION vagy admin-szerkesztett adatokkal!
        if (app()->environment('production')) {
            throw new \RuntimeException(
                '❌ HIBA: A FullContentMigrationSeeder NEM futtatható production környezetben! ' .
                'Az eredeti HTML tartalmak az _archive/original_content_blocks/ mappában vannak archiválva. ' .
                'A tartalmat az admin felületen (Filament) szerkeszd!'
            );
        }

        // Első futtatásnál: létrehozzuk az összes oldalt
        // Később: csak az admin felületen módosítsd a tartalmakat
        // Először létrehozzuk az összes oldalt
        $pages = [
            [
                'title' => 'Bemutatkozás',
                'slug' => 'bemutatkozas',
                'description' => 'Technológiai megoldások egyedi igényekre szabva',
                'keywords' => 'web development, graphic design, IT megoldások',
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Internetes jelenlét',
                'slug' => 'internetes-jelenlet',
                'description' => 'Webfejlesztés, SEO optimalizálás és konverziófókuszú online kampányok',
                'keywords' => 'webfejlesztés, SEO, Laravel, vanilla JS',
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Grafika',
                'slug' => 'grafika',
                'description' => 'Logótervezés, branding, nyomtatott és digitális grafikai anyagok',
                'keywords' => 'grafikai tervezés, logó, branding, AI grafika',
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'AI a jövő',
                'slug' => 'ai-jovo',
                'description' => 'Mesterséges intelligencia alapú eszközök és automatizálási megoldások',
                'keywords' => 'AI, mesterséges intelligencia, OpenAI, Claude, Ollama',
                'is_published' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'unRAID',
                'slug' => 'unraid',
                'description' => 'Professzionális szerverkezelés és adattárolás',
                'keywords' => 'unRAID, szerver, NAS, Docker, parity',
                'is_published' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'GDPR',
                'slug' => 'gdpr',
                'description' => 'Adatvédelmi irányelvek és információk',
                'keywords' => 'GDPR, adatvédelem',
                'is_published' => true,
                'sort_order' => 6,
            ],
            [
                'title' => 'Kapcsolat',
                'slug' => 'kapcsolat',
                'description' => 'Vedd fel velem a kapcsolatot',
                'keywords' => 'kapcsolat, email, telefon',
                'is_published' => true,
                'sort_order' => 7,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }

        // Most létrehozzuk a content blockokat
        $this->createBemutatkozasBlocks();
        $this->createInternetesJelenletBlocks();
        $this->createGrafikaBlocks();
        $this->createAiJovoBlocks();
        $this->createUnraidBlocks();
        $this->createKapcsolatBlocks();
        $this->createGdprBlocks();

        $this->command->info('✅ Minden content block sikeresen migrálva!');
    }

    private function createBemutatkozasBlocks()
    {
        $page = Page::where('slug', 'bemutatkozas')->first();

        // Content Block 1: Bemutatkozás hero
        ContentBlock::updateOrCreate(
            ['key' => 'bemutatkozas_hero'],
            [
                'page_id' => $page->id,
                'type' => 'custom_html',
                'content' => '<span class="inline-block text-tagline-2 font-medium backdrop-blur-[18px] rounded-full px-5 py-1.5 bg-accent/10 text-primary-50 dark:text-ns-green">Bemutatkozás</span><h1 class="max-w-[666px] leading-[1.2] mt-4"><span class="hero-text-gradient hero-text-color-2 block">Technológiai megoldások egyedi igényekre szabva</span></h1><p class="text-accent/60 max-w-[580px] mt-4">Évtizedes tapasztalattal a hátam mögött, szívesen segítek egyedi IT megoldások fejlesztésében, szerverkezelésben és grafikai munkákban.</p>',
                'sort_order' => 1,
            ]
        );

        // Content Block 2: Bemutatkozás tartalom
        ContentBlock::updateOrCreate(
            ['key' => 'bemutatkozas_tartalom'],
            [
                'page_id' => $page->id,
                'type' => 'custom_html',
                'content' => '<div data-tab-contents-container="" data-ns-animate="" data-delay="0.2" role="tabpanel" aria-live="polite" aria-atomic="true">
   <!-- Payments Content -->
   <div data-tab-content="payments" id="tab-panel-payments" role="tabpanel" aria-labelledby="tab-payments" aria-hidden="false" class="pointer-events-none flex h-auto flex-col items-center justify-center md:flex-row xl:h-[624px]">
      <figure class="h-[380px] w-full max-w-[450px] overflow-hidden rounded-t-[28px] md:rounded-t-none md:rounded-l-[28px] lg:h-[480px] lg:max-w-[500px] xl:h-auto xl:max-w-[645px]" role="img"> <img src="/images/ns-img-562.jpg" alt="Financial management platform showing payment processing dashboard with real-time transaction tracking" class="size-full object-cover" loading="lazy"> </figure>
      <div class="bg-background-6 flex h-[380px] max-w-[450px] items-center justify-center rounded-b-[28px] pr-4 pl-4 md:w-auto md:rounded-r-[28px] md:rounded-b-none md:pr-14 md:pl-[42px] lg:h-[480px] lg:rounded-b-[28px] xl:h-[624px] xl:max-w-[645px]">
         <div class="space-y-12 xl:space-y-39">
            <div class="max-w-[547px] space-y-2 text-center md:text-left">
               <h3 class="text-accent sm:text-heading-5 text-heading-6 font-normal">Különös, hogy a dolgok mennyire leegyszerűsödnek, ha tisztán látja őket az ember. </h3>
               <p class="text-accent/60 line-clamp-4 lg:line-clamp-none">Mindig is csodáltam a lenyűgöző teljesítményt, amikor egy digitális rendszer működését figyeltem.</p>
               <p class="text-accent/60 line-clamp-4 lg:line-clamp-none">Ezekben az algoritmusokban, kódokban és modellekben feltűnően hiányzik két, az emberi világban gyakran jelen lévő tulajdonság: az oktalanság és a céltalanság. Minden szabály és súlyozás választ ad a „miért?" és a „mi célból?" kérdéseire akárcsak azoknak a gondolkodó, felelős alkotóknak az életútja akik ezt a technológiát lehetővé tették. </p>
               <h3 class="text-accent sm:text-heading-5 text-heading-6 font-normal">A jól megtervezett digitális rendszer nem a véletlenek halmaza, hanem           egy logikába és döntésekbe írt erkölcsi kódex.
               </h3>
            </div>
         </div>
      </div>
   </div>
</div>',
                'sort_order' => 2,
            ]
        );

        // Content Block 3: Kapcsolat
        ContentBlock::updateOrCreate(
            ['key' => 'bemutatkozas_kapcsolat'],
            [
                'page_id' => $page->id,
                'type' => 'custom_html',
                'content' => '<div class="main-container"> <div class="flex flex-col md:flex-row items-start max-md:gap-y-18 md:gap-x-[120px] justify-center md:justify-between"> <!-- Left: Intro --> <div class="lg:sticky lg:top-28"> <span data-ns-animate="" data-delay="0.1" class="badge badge-cyan mb-5"> Services overview </span> <div class="space-y-2 md:max-w-[595px] mb-14"> <h2 class="text-accent" data-ns-animate="" data-delay="0.2">Our performance-focused services.</h2> <p data-ns-animate="" data-delay="0.3" class="text-accent/60 max-w-[512px]"> Smart, secure, and designed for simplicity—NextSaaS empowers you to take control effortlessly. </p> </div> <div> <a data-ns-animate="" data-delay="0.4" href="./digital-marketing-services.html" class="btn btn-secondary hover:btn-white dark:btn-transparent btn-md"> <span>View full-service breakdown.</span> </a> </div> </div> <!-- Right: Features List --> <div class="w-full max-w-xl stack-cards js-stack-cards"> <div class="stack-cards__item js-stack-cards__item border border-stroke-7/50 bg-background-8 min-h-[170px] rounded-[20px] space-y-4 p-8 z-0"> <div class="inline-block"> <span class="ns-shape-25 text-[52px] text-accent"> </span> </div> <div> <h3 class="text-accent text-heading-5">SEO</h3> <p class="text-accent/60">Enhance visibility, authority, and important keyword rankings.</p> </div> </div> <div class="stack-cards__item js-stack-cards__item border border-stroke-7/50 bg-background-8 min-h-[170px] rounded-[20px] space-y-4 p-8 relative overflow-hidden z-0"> <div class="inline-block"> <span class="ns-shape-19 text-[52px] text-accent"> </span> </div> <div> <h3 class="text-accent text-heading-5">SEM</h3> <p class="text-accent/60">Data-optimized campaigns designed to attract ready-to-buy audiences.</p> </div> </div> <div class="stack-cards__item js-stack-cards__item border border-stroke-7/50 bg-background-8 min-h-[170px] rounded-[20px] space-y-4 p-8 relative overflow-hidden z-0"> <div class="inline-block"> <span class="ns-shape-17 text-[52px] text-accent"> </span> </div> <div> <h3 class="text-accent text-heading-5">Email marketing &amp; automation</h3> <p class="text-accent/60">Nurture leads and convert subscribers with timely campaigns.</p> </div> </div> <div class="stack-cards__item js-stack-cards__item border border-stroke-7/50 bg-background-8 min-h-[170px] rounded-[20px] space-y-4 p-8 relative overflow-hidden z-0"> <div class="inline-block"> <span class="ns-shape-34 text-[52px] text-accent"> </span> </div> <div> <h3 class="text-accent text-heading-5">Link building &amp; authority outreach .</h3> <p class="text-accent/60">Secure high-quality backlinks that enhance your SEO</p> </div> </div> <div class="stack-cards__item js-stack-cards__item border border-stroke-7/50 bg-background-8 min-h-[170px] rounded-[20px] space-y-4 p-8 relative overflow-hidden z-0"> <span class="inline-block"> <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M47.6693 13.4643L26.0026 0.953125L4.33594 13.4643M47.6693 13.4643L26.0026 25.6406M47.6693 13.4643V18.1908L43.1449 20.8227M26.0026 50.998L47.6693 38.1518V33.1116M26.0026 50.998L4.33594 38.1518V33.1116M26.0026 50.998V46.0505M4.33594 13.4643L26.0026 25.6406M4.33594 13.4643V18.1908L8.86032 20.8227M26.0026 25.6406V30.7947M26.0026 30.7947L8.86032 20.8227M26.0026 30.7947L43.1449 20.8227M26.0026 35.8919L47.6693 23.0099M26.0026 35.8919L4.33594 23.0099M26.0026 35.8919V40.9533M47.6693 23.0099V27.9218L43.1449 30.573M47.6693 23.0099L43.1449 20.8227M4.33594 23.0099V27.9218L8.86032 30.573M4.33594 23.0099L8.86032 20.8227M26.0026 40.9533L8.86032 30.573M26.0026 40.9533L43.1449 30.573M26.0026 46.0505L47.6693 33.1116M26.0026 46.0505L4.33594 33.1116M47.6693 33.1116L43.1449 30.573M4.33594 33.1116L8.86032 30.573" stroke="black" stroke-linecap="round" stroke-linejoin="round" class="stroke-accent"></path> </svg> </span> <div> <h3 class="text-accent text-heading-5">Local SEO &amp; google business optimization</h3> <p class="text-accent/60">Help local customers discover you—first, fast, and frequently.</p> </div> </div> <div class="stack-cards__item js-stack-cards__item border border-stroke-7/50 bg-background-8 min-h-[170px] rounded-[20px] space-y-4 p-8 relative overflow-hidden z-0"> <span class="inline-block"> <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M47.6693 13.4781L26.0026 0.953125L17.317 5.97407M47.6693 13.4781V38.528L26.0026 51.0529M47.6693 13.4781L38.9367 18.5261M26.0026 51.0529V26.003M26.0026 51.0529L17.317 46.032V40.6548M4.33594 13.4781V38.528L12.7853 43.4123M4.33594 13.4781L26.0026 26.003M4.33594 13.4781L12.7853 8.59371L17.317 11.2247M26.0026 26.003L34.4051 21.1458M12.7853 43.4123V29.1393L17.317 32.0697V40.6548M12.7853 43.4123L17.317 40.6548M38.9367 33.6746V18.5261M38.9367 33.6746L34.4051 36.4632V31.0714M38.9367 33.6746L34.4051 31.0714M38.9367 18.5261L17.317 5.97407M34.4051 21.1458V31.0714M34.4051 21.1458L17.317 11.2247M17.317 5.97407V11.2247" stroke="" stroke-linecap="round" stroke-linejoin="round" class="stroke-accent"></path> </svg> </span> <div> <h3 class="text-accent text-heading-5">Analytics &amp; conversion optimization</h3> <p class="text-accent/60">Collect data to convert clicks into customers &amp; optimize every dollar spent.</p> </div> </div> </div> </div> </div>',
                'sort_order' => 3,
            ]
        );
    }

    private function createInternetesJelenletBlocks()
    {
        $page = Page::where('slug', 'internetes-jelenlet')->first();

        ContentBlock::updateOrCreate(
            ['key' => 'web_tartalom'],
            [
                'page_id' => $page->id,
                'type' => 'custom_html',
                'content' => file_get_contents(__DIR__ . '/content_blocks/web_tartalom.html'),
                'sort_order' => 1,
            ]
        );
    }

    private function createGrafikaBlocks()
    {
        $page = Page::where('slug', 'grafika')->first();

        // Grafika tartalom - block 1
        ContentBlock::updateOrCreate(
            ['key' => 'grafika_tartalom'],
            [
                'page_id' => $page->id,
                'type' => 'custom_html',
                'content' => file_get_contents(__DIR__ . '/content_blocks/grafika_tartalom.html'),
                'sort_order' => 1,
            ]
        );

        // Grafika portfolio - block 2
        ContentBlock::updateOrCreate(
            ['key' => 'grafika_portfolio'],
            [
                'page_id' => $page->id,
                'type' => 'custom_html',
                'content' => file_get_contents(__DIR__ . '/content_blocks/grafika_portfolio.html'),
                'sort_order' => 2,
            ]
        );

        // Grafika pozíció - block 3
        ContentBlock::updateOrCreate(
            ['key' => 'grafika_position'],
            [
                'page_id' => $page->id,
                'type' => 'custom_html',
                'content' => file_get_contents(__DIR__ . '/content_blocks/grafika_position.html'),
                'sort_order' => 3,
            ]
        );
    }

    private function createAiJovoBlocks()
    {
        $page = Page::where('slug', 'ai-jovo')->first();

        // AI tartalom - block 1
        ContentBlock::updateOrCreate(
            ['key' => 'ai_tartalom'],
            [
                'page_id' => $page->id,
                'type' => 'custom_html',
                'content' => file_get_contents(__DIR__ . '/content_blocks/ai_tartalom.html'),
                'sort_order' => 1,
            ]
        );

        // AI tools - block 2
        ContentBlock::updateOrCreate(
            ['key' => 'ai_tools'],
            [
                'page_id' => $page->id,
                'type' => 'custom_html',
                'content' => file_get_contents(__DIR__ . '/content_blocks/ai_tools.html'),
                'sort_order' => 2,
            ]
        );
    }

    private function createUnraidBlocks()
    {
        $page = Page::where('slug', 'unraid')->first();

        // CSAK a main page landing block
        ContentBlock::updateOrCreate(
            ['key' => 'unraid_tartalom'],
            [
                'page_id' => $page->id,
                'type' => 'custom_html',
                'content' => file_get_contents(__DIR__ . '/content_blocks/unraid_tartalom.html'),
                'sort_order' => 1,
            ]
        );

        // Hozzáadjuk a többi unRAID aloldal tartalomblokjait
        $this->createUnraidSubpageBlocks();
    }

    private function createUnraidSubpageBlocks()
    {
        $unraidParent = Page::where('slug', 'unraid')->first();

        // OP Rendszer
        $opsystem = Page::where('slug', 'opsystem')->where('parent_id', $unraidParent->id)->first();
        if ($opsystem) {
            ContentBlock::updateOrCreate(
                ['key' => 'tartalom_opsystem'],
                [
                    'page_id' => $opsystem->id,
                    'type' => 'custom_html',
                    'content' => file_get_contents(__DIR__ . '/content_blocks/tartalom_opsystem.html'),
                    'sort_order' => 1,
                ]
            );
        }

        // Hardware
        $hardware = Page::where('slug', 'hardware')->where('parent_id', $unraidParent->id)->first();
        if ($hardware) {
            ContentBlock::updateOrCreate(
                ['key' => 'tartalom_hardware'],
                [
                    'page_id' => $hardware->id,
                    'type' => 'custom_html',
                    'content' => file_get_contents(__DIR__ . '/content_blocks/tartalom_hardware.html'),
                    'sort_order' => 1,
                ]
            );
        }

        // Software
        $software = Page::where('slug', 'software')->where('parent_id', $unraidParent->id)->first();
        if ($software) {
            ContentBlock::updateOrCreate(
                ['key' => 'tartalom_software'],
                [
                    'page_id' => $software->id,
                    'type' => 'custom_html',
                    'content' => file_get_contents(__DIR__ . '/content_blocks/tartalom_software.html'),
                    'sort_order' => 1,
                ]
            );
        }

        // Security
        $security = Page::where('slug', 'security')->where('parent_id', $unraidParent->id)->first();
        if ($security) {
            ContentBlock::updateOrCreate(
                ['key' => 'tartalom_security'],
                [
                    'page_id' => $security->id,
                    'type' => 'custom_html',
                    'content' => file_get_contents(__DIR__ . '/content_blocks/tartalom_security.html'),
                    'sort_order' => 1,
                ]
            );
        }

        // Parity
        $parity = Page::where('slug', 'parity')->where('parent_id', $unraidParent->id)->first();
        if ($parity) {
            ContentBlock::updateOrCreate(
                ['key' => 'tartalom_parity'],
                [
                    'page_id' => $parity->id,
                    'type' => 'custom_html',
                    'content' => file_get_contents(__DIR__ . '/content_blocks/tartalom_parity.html'),
                    'sort_order' => 1,
                ]
            );
        }

        // Servers
        $servers = Page::where('slug', 'servers')->where('parent_id', $unraidParent->id)->first();
        if ($servers) {
            ContentBlock::updateOrCreate(
                ['key' => 'tartalom_servers'],
                [
                    'page_id' => $servers->id,
                    'type' => 'custom_html',
                    'content' => file_get_contents(__DIR__ . '/content_blocks/tartalom_servers.html'),
                    'sort_order' => 1,
                ]
            );
        }

        // Expressions
        $expressions = Page::where('slug', 'expressions')->where('parent_id', $unraidParent->id)->first();
        if ($expressions) {
            ContentBlock::updateOrCreate(
                ['key' => 'tartalom_expressions'],
                [
                    'page_id' => $expressions->id,
                    'type' => 'custom_html',
                    'content' => file_get_contents(__DIR__ . '/content_blocks/tartalom_expressions.html'),
                    'sort_order' => 1,
                ]
            );
        }

        // Updates
        $updates = Page::where('slug', 'updates')->where('parent_id', $unraidParent->id)->first();
        if ($updates) {
            ContentBlock::updateOrCreate(
                ['key' => 'tartalom_updates'],
                [
                    'page_id' => $updates->id,
                    'type' => 'custom_html',
                    'content' => file_get_contents(__DIR__ . '/content_blocks/tartalom_updates.html'),
                    'sort_order' => 1,
                ]
            );
        }

        // License
        $license = Page::where('slug', 'license')->where('parent_id', $unraidParent->id)->first();
        if ($license) {
            ContentBlock::updateOrCreate(
                ['key' => 'tartalom_license'],
                [
                    'page_id' => $license->id,
                    'type' => 'custom_html',
                    'content' => file_get_contents(__DIR__ . '/content_blocks/tartalom_license.html'),
                    'sort_order' => 1,
                ]
            );
        }

        // Community
        $community = Page::where('slug', 'community')->where('parent_id', $unraidParent->id)->first();
        if ($community) {
            ContentBlock::updateOrCreate(
                ['key' => 'tartalom_community'],
                [
                    'page_id' => $community->id,
                    'type' => 'custom_html',
                    'content' => file_get_contents(__DIR__ . '/content_blocks/tartalom_community.html'),
                    'sort_order' => 1,
                ]
            );
        }

        // Support
        $support = Page::where('slug', 'support')->where('parent_id', $unraidParent->id)->first();
        if ($support) {
            ContentBlock::updateOrCreate(
                ['key' => 'tartalom_support'],
                [
                    'page_id' => $support->id,
                    'type' => 'custom_html',
                    'content' => file_get_contents(__DIR__ . '/content_blocks/tartalom_support.html'),
                    'sort_order' => 1,
                ]
            );
        }

        // VM (Virtual Machines)
        $vm = Page::where('slug', 'vm')->where('parent_id', $unraidParent->id)->first();
        if ($vm) {
            ContentBlock::updateOrCreate(
                ['key' => 'tartalom_vm'],
                [
                    'page_id' => $vm->id,
                    'type' => 'custom_html',
                    'content' => file_get_contents(__DIR__ . '/content_blocks/tartalom_vm.html'),
                    'sort_order' => 1,
                ]
            );
        }

        // Network
        $network = Page::where('slug', 'network')->where('parent_id', $unraidParent->id)->first();
        if ($network) {
            ContentBlock::updateOrCreate(
                ['key' => 'tartalom_network'],
                [
                    'page_id' => $network->id,
                    'type' => 'custom_html',
                    'content' => file_get_contents(__DIR__ . '/content_blocks/tartalom_network.html'),
                    'sort_order' => 1,
                ]
            );
        }

        // AI Build
        $aibuild = Page::where('slug', 'aibuild')->where('parent_id', $unraidParent->id)->first();
        if ($aibuild) {
            ContentBlock::updateOrCreate(
                ['key' => 'tartalom_aibuild'],
                [
                    'page_id' => $aibuild->id,
                    'type' => 'custom_html',
                    'content' => file_get_contents(__DIR__ . '/content_blocks/tartalom_aibuild.html'),
                    'sort_order' => 1,
                ]
            );
        }
    }

    private function createKapcsolatBlocks()
    {
        $page = Page::where('slug', 'kapcsolat')->first();

        ContentBlock::updateOrCreate(
            ['key' => 'kapcsolat'],
            [
                'page_id' => $page->id,
                'type' => 'custom_html',
                'content' => file_get_contents(__DIR__ . '/content_blocks/kapcsolat.html'),
                'sort_order' => 1,
            ]
        );
    }

    private function createGdprBlocks()
    {
        $page = Page::where('slug', 'gdpr')->first();

        ContentBlock::updateOrCreate(
            ['key' => 'gdpr'],
            [
                'page_id' => $page->id,
                'type' => 'custom_html',
                'content' => file_get_contents(__DIR__ . '/content_blocks/gdpr.html'),
                'sort_order' => 1,
            ]
        );
    }
}
