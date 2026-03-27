<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\ContentBlock;

class MigratePagesSeeder extends Seeder
{
    public function run(): void
    {
        // Töröljük a meglévő oldalakat
        Page::whereIn('slug', ['bemutatkozas', 'web'])->delete();

        // Bemutatkozás oldal létrehozása
        $bemutatkozas = Page::create([
            'title' => 'Bemutatkozás',
            'slug' => 'bemutatkozas',
            'description' => 'Technológiai megoldások egyedi igényekre szabva. Évtizedes tapasztalattal a hátam mögött.',
            'keywords' => 'bemutatkozás, portfolio, web development, design, technológia',
            'is_published' => true,
            'sort_order' => 1,
        ]);

        // Bemutatkozás Hero block
        ContentBlock::create([
            'page_id' => $bemutatkozas->id,
            'key' => 'bemutatkozas_hero',
            'type' => 'hero',
            'content' => '<span class="inline-block text-tagline-2 font-medium backdrop-blur-[18px] rounded-full px-5 py-1.5 bg-accent/10 text-primary-50 dark:text-ns-green">Bemutatkozás</span><h1 class="max-w-[666px] leading-[1.2] mt-4"><span class="hero-text-gradient hero-text-color-2 block">Technológiai megoldások egyedi igényekre szabva</span></h1><p class="text-accent/60 max-w-[580px] mt-4">Évtizedes tapasztalattal a hátam mögött, szívesen segítek egyedi IT megoldások fejlesztésében, szerverkezelésben és grafikai munkákban.</p>',
            'sort_order' => 1,
        ]);

        // Bemutatkozás Tartalom block
        ContentBlock::create([
            'page_id' => $bemutatkozas->id,
            'key' => 'bemutatkozás_tartalom',
            'type' => 'content',
            'content' => '<div data-tab-contents-container="" data-ns-animate="" data-delay="0.2" role="tabpanel" aria-live="polite" aria-atomic="true">
   <div data-tab-content="payments" id="tab-panel-payments" role="tabpanel" aria-labelledby="tab-payments" aria-hidden="false" class="pointer-events-none flex h-auto flex-col items-center justify-center md:flex-row xl:h-[624px]">
      <figure class="h-[380px] w-full max-w-[450px] overflow-hidden rounded-t-[28px] md:rounded-t-none md:rounded-l-[28px] lg:h-[480px] lg:max-w-[500px] xl:h-auto xl:max-w-[645px]" role="img">
         <img src="/images/ns-img-562.jpg" alt="Digital systems visualization" class="size-full object-cover" loading="lazy">
      </figure>
      <div class="bg-background-6 flex h-[380px] max-w-[450px] items-center justify-center rounded-b-[28px] pr-4 pl-4 md:w-auto md:rounded-r-[28px] md:rounded-b-none md:pr-14 md:pl-[42px] lg:h-[480px] lg:rounded-b-[28px] xl:h-[624px] xl:max-w-[645px]">
         <div class="space-y-12 xl:space-y-39">
            <div class="max-w-[547px] space-y-2 text-center md:text-left">
               <h3 class="text-accent sm:text-heading-5 text-heading-6 font-normal">Különös, hogy a dolgok mennyire leegyszerűsödnek, ha tisztán látja őket az ember.</h3>
               <p class="text-accent/60 line-clamp-4 lg:line-clamp-none">Mindig is csodáltam a lenyűgöző teljesítményt, amikor egy digitális rendszer működését figyeltem.</p>
               <p class="text-accent/60 line-clamp-4 lg:line-clamp-none">Ezekben az algoritmusokban, kódokban és modellekben feltűnően hiányzik két, az emberi világban gyakran jelen lévő tulajdonság: az oktalanság és a céltalanság.</p>
               <h3 class="text-accent sm:text-heading-5 text-heading-6 font-normal">A jól megtervezett digitális rendszer nem a véletlenek halmaza, hanem egy logikába és döntésekbe írt erkölcsi kódex.</h3>
            </div>
         </div>
      </div>
   </div>
</div>',
            'sort_order' => 2,
        ]);

        // Web oldal létrehozása
        $web = Page::create([
            'title' => 'Web Development',
            'slug' => 'web',
            'description' => 'Webfejlesztés, SEO optimalizálás és konverziófókuszú online kampányok',
            'keywords' => 'web development, Laravel, JavaScript, Tailwind CSS, SEO',
            'is_published' => true,
            'sort_order' => 4,
        ]);

        // Web Hero block
        ContentBlock::create([
            'page_id' => $web->id,
            'key' => 'web_hero',
            'type' => 'hero',
            'content' => '<h1 class="text-secondary font-medium mb-4 max-w-[1000px]">Erősítsd növekedésed adatvezérelt digitális marketing-gel</h1><p class="text-secondary/60 max-w-[850px]">Webfejlesztés, SEO optimalizálás és konverziófókuszú online kampányok. Hozd ki a maximumot digitális jelenlétedből!</p>',
            'sort_order' => 1,
        ]);

        // Web Tartalom block
        ContentBlock::create([
            'page_id' => $web->id,
            'key' => 'web_tartalom',
            'type' => 'content',
            'content' => '<div class="main-container">
   <div class="text-center space-y-3 mb-[72px]">
      <h2 data-ns-animate="" data-delay="0.3" class="text-accent max-w-[552px] mx-auto">Egy teljesen legitim, profi architektúra és skálázható infrastruktúra.</h2>
      <p data-ns-animate="" data-delay="0.4" class="text-accent/60 max-w-[692px] mx-auto">Ez egy olyan webes rendszer, ahol a háttérben a szerver intézi az adatok kezelését és a szabályokat, az oldalon pedig egyszerű JavaScript frissíti a megjelenést felhasználói műveletek alapján.</p>
   </div>
   <div class="grid grid-cols-12 md:gap-8 gap-y-5">
      <!-- Stack Card -->
      <div class="col-span-12 md:col-span-6 lg:col-span-4">
         <div data-ns-animate="" data-delay="0.3" class="sm:p-8 p-5 bg-background-6 rounded-[20px] space-y-8 h-full flex flex-col">
            <div class="flex items-center justify-between">
               <p class="text-tagline-2 text-accent">Stack</p>
               <span class="ns-shape-36 text-[52px] text-accent"></span>
            </div>
            <div class="space-y-4 flex-1">
               <h3 class="text-accent sm:text-heading-5 text-heading-6 font-normal">Az alkalmazásban használt technológiák összessége</h3>
               <p class="text-accent/60">Laravel 11 backend + vanilla JS frontend felállás.</p>
               <ul class="text-tagline-1 font-normal text-accent/60 space-y-2 list-disc list-inside">
                  <li>Laravel 11</li>
                  <li>Vanilla JS</li>
                  <li>Tailwind CSS</li>
                  <li>Yarn csomagkezelő</li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>',
            'sort_order' => 2,
        ]);

        // Web Services block
        ContentBlock::create([
            'page_id' => $web->id,
            'key' => 'web_services',
            'type' => 'feature',
            'content' => '<h2 class="text-3xl md:text-4xl font-bold text-accent mb-12 text-center">Szolgáltatásaim</h2>',
            'sort_order' => 3,
        ]);

        $this->command->info('Pages és content blocks sikeresen migrálva!');
    }
}
