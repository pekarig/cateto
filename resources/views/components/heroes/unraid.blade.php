<!-- =========================
   unRAID Hero section (web-hosting style)
   ===========================-->
<section
   class="hero-section relative pt-[180px] sm:pt-[100px] 2xl:pt-[264px] pb-[200px] overflow-hidden"
   >
   <!-- Particle Network Canvas Background -->
   <canvas
      id="particles-canvas"
      class="absolute top-0 left-0 w-full h-full z-[-2]"
      style="pointer-events: auto;"
   ></canvas>

   <figure
      data-ns-animate
      data-delay="0.1"
      data-direction="right"
      data-offset="100"
      class="opacity-0 absolute top-0 right-0 z-[-1] size-[882px]"
      >
      <img
         src="{{ asset('images/ns-img-42.png') }}"
         alt="unraid hero"
         class="w-full h-full object-cover"
         />
   </figure>
   <div class="main-container">
      <div class="grid grid-cols-12 items-start">
         <div class="col-span-12 xl:col-span-6">
            <div class="text-center xl:text-left relative z-[1]">
            <span
               data-ns-animate
               data-delay="0.1"
               class="inline-block text-tagline-2 font-medium backdrop-blur-[18px] rounded-full px-5 py-1.5 bg-accent/10 text-primary-50 dark:text-ns-green"
               >
            unRAID
            </span>
            <div class="space-y-2.5 md:space-y-4">
               <h1 data-ns-animate data-delay="0.2" class="max-w-[666px] leading-[1.2]">
                  <span class="hero-text-gradient hero-text-color-2 block">
                  Egy szerver mind felett..
                  </span>
               </h1>
               <p data-ns-animate data-delay="0.3" class="text-accent/60 max-w-[580px]">
                  Az Unraid egy nagy teljesítményű, könnyen használható operációs rendszer
                  saját üzemeltetésű szerverekhez és hálózatra csatlakoztatott tárolókhoz.
               </p>
            </div>
               <div
                  class="avatar-group-images flex flex-col sm:flex-row items-center justify-center gap-y-4 sm:gap-y-4 sm:gap-x-4 mt-7 xl:justify-start"
                  >
                  <div class="flex -space-x-3.5">
                     <img
                        data-ns-animate
                        data-delay="0.5"
                        data-direction="right"
                        data-offset="50"
                        class="opacity-0 inline-block size-12 rounded-full ring-2 ring-white dark:ring-black bg-ns-yellow"
                        src="{{ asset('images/ns-avatar-1.png') }}"
                        alt="Avatar 1"
                        />
                     <img
                        data-ns-animate
                        data-delay="0.6"
                        data-direction="right"
                        data-offset="50"
                        class="opacity-0 inline-block size-12 rounded-full ring-2 ring-white dark:ring-black bg-ns-red"
                        src="{{ asset('images/ns-avatar-2.png') }}"
                        alt="Avatar 2"
                        />
                     <img
                        data-ns-animate
                        data-delay="0.7"
                        data-direction="right"
                        data-offset="50"
                        class="opacity-0 inline-block size-12 rounded-full ring-2 ring-white dark:ring-black bg-ns-green"
                        src="{{ asset('images/ns-avatar-3.png') }}"
                        alt="Avatar 3"
                        />
                     <div
                        data-ns-animate
                        data-delay="0.8"
                        data-direction="right"
                        data-offset="50"
                        class="opacity-0 inline-flex items-center justify-center size-12 rounded-full ring-2 ring-white dark:ring-black text-secondary/80 bg-ns-cyan text-tagline-3 font-medium dark:text-accent/80"
                        >
                        50+
                     </div>
                  </div>
                  <div
                     data-ns-animate
                     data-delay="0.9"
                     class="opacity-0 flex items-center gap-1 rounded-full px-3 sm:px-4 py-2.5 backdrop-blur-[18px] bg-background-2/10 dark:bg-background-6/10"
                     >

            <button class="btn btn-xl btn-primary md:w-auto w-[90%] h-[52px] hover:btn-secondary dark:hover:btn-accent">
              <a href="#unraid">Na nézzük!</a>
            </button>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-span-12 xl:col-span-6 relative z-[1]">
            <figure class="max-w-[679px] mx-auto xl:mx-0 mt-12 relative xl:-mt-20">
               <img
                  data-ns-animate
                  data-delay="0.5"
                  data-direction="up"
                  src="{{ asset('images/ns-img-43.png') }}"
                  alt="web hosting hero"
                  class="w-full h-full opacity-0"
                  />
            </figure>
         </div>
      </div>
   </div>
</section>
