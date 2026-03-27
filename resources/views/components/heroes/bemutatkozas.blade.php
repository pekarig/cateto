<!-- ============================
   Bemutatkozás Hero Section (time-tracking style)
   ============================= -->
<section class="md:mt-4 lg:mt-6 xl:mt-[30px]">
   <div
      class="max-w-[1860px] mx-auto pt-[170px] sm:pt-[190px] md:pt-[210px] lg:pt-[220px] pb-[80px] sm:pb-[100px] lg:pb-[200px] max-h-[940px] md:rounded-[30px] xl:rounded-[50px] relative overflow-hidden"
      >
      <!-- Video Background -->
      <video
         class="size-full absolute top-0 left-0 object-cover object-center z-[-1] min-h-[100%] scale-[1.1]"
         autoplay
         muted
         loop
         poster="{{ asset('images/fallback/bemutatkozas-hero.jpg') }}"
         >
         <source src="{{ asset('video/getty-watch.mp4') }}" type="video/mp4" />
         A te böngésződ nem támogatja a videó elemet. Bocs!
      </video>
      <div class="main-container">
         <div class="space-y-3 md:space-y-5 text-center md:text-left max-lg:max-w-[500px]">
            <span
               data-ns-animate
               data-delay="0.1"
               class="inline-block text-tagline-2 font-medium backdrop-blur-[18px] rounded-full px-5 py-1.5 bg-accent/10 text-primary-50 dark:text-ns-green"
               >
            Bemutatkozás (helyett)
            </span>
            <div class="space-y-2.5 md:space-y-4">
               <h1 data-ns-animate data-delay="0.2" class="max-w-[666px] leading-[1.2]">
                  <span class="hero-text-gradient hero-text-color-2 block">
                  Rajtad múlik, hogy az idő neked, vagy ellened dolgozik
                  </span>
               </h1>
               <p data-ns-animate data-delay="0.3" class="text-accent/60 max-w-[580px]">
                  Web development & graphic design SINCE 1999.
               </p>
            </div>
         </div>
      </div>
   </div>
</section>
