<!-- =========================
    Grafikai szemlélet az AI korában Hero section (social-media-management style)
    ===========================-->
<section
  class="lg:pt-[230px] pt-[180px] lg:pb-[200px] pb-[100px] bg-background-5 relative"
>
  <div class="main-container relative z-10">
    <div class="space-y-5 text-center">
      <span data-ns-animate data-delay="0.1" class="badge badge-gray-light"
        >Grafikai kihívások</span
      >
      <div class="space-y-3">
        <h1
          data-ns-animate
          data-delay="0.2"
          class="xl:max-w-[1110px] md:max-w-[900px] sm:max-w-[600px] max-w-[400px] mx-auto leading-[1.3]"
        >
          <span class="hero-text-gradient hero-text-color-2 block">
            Emeld új szintre a vizuális megjelenést!
          </span>
        </h1>
        <p
          data-ns-animate
          data-delay="0.3"
          class="lg:max-w-full md:max-w-[600px] max-w-[400px] mx-auto"
        >
          Graphic design SINCE 1999
        </p>
      </div>
    </div>
    <div class="flex justify-center items-end relative z-10 -space-x-28 mt-16">
      <figure
        data-ns-animate
        data-delay="0.5"
        data-direction="right"
        data-offset="100"
        data-instant
        class="lg:max-w-[326px] md:max-w-[250px] max-w-[200px] w-full rounded-[20px] overflow-hidden relative -z-10"
      >
        <img
          src="{{ asset('images/ns-img-245.png') }}"
          alt="hero"
          class="w-full h-full object-cover rounded-[20px]"
        />
      </figure>
      <figure
        data-ns-animate
        data-delay="0.2"
        data-offset="100"
        data-instant
        class="lg:max-w-[370px] md:max-w-[300px] max-w-[250px] w-full rounded-[30px] overflow-hidden relative z-10 shadow-6"
      >
        <img src="{{ asset('images/ns-img-243.png') }}" alt="hero" class="w-full h-full object-cover" />
      </figure>
      <figure
        data-ns-animate
        data-delay="0.5"
        data-direction="left"
        data-offset="100"
        data-instant
        class="lg:max-w-[326px] md:max-w-[250px] max-w-[200px] w-full rounded-[20px] overflow-hidden relative -z-10"
      >
        <img
          src="{{ asset('images/ns-img-244.png') }}"
          alt="hero"
          class="w-full h-full object-cover rounded-[20px]"
        />
      </figure>
    </div>
  </div>

  <figure
    data-ns-animate
    data-delay="0.6"
    data-offset="0"
    class="absolute top-0 left-1/2 -translate-x-1/2 max-w-[1390px] w-full h-full z-0"
  >
    @include('components.shared.animate-gradient')
  </figure>
</section>
