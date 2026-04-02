<!-- Header / Navigation -->
<header>
  <div
    data-ns-animate
    data-direction="up"
    data-offset="20"
    class="header-two rounded-full lp:!max-w-[1290px] xl:max-w-[1140px] lg:max-w-[960px] md:max-w-[720px] sm:max-w-[540px] min-[500px]:max-w-[450px] min-[425px]:max-w-[380px] max-w-[350px] mx-auto w-full fixed left-1/2 -translate-x-1/2 z-50 top-14 flex items-center justify-between px-2.5 xl:py-0 py-2.5 dark:bg-background-7 bg-background-7 backdrop-blur-[25px] max-md:!top-8"
  >
    <div>
      <a href="{{ url('/') }}">
        <span class="sr-only">Főoldal</span>
        <figure class="lg:max-w-[198px] lg:block hidden">
          <img src="{{ asset('images/shared/dark-logo.svg') }}" alt="Cateto" />
        </figure>
        <figure class="max-w-[44px] lg:hidden block">
          <img src="{{ asset('images/shared/logo.svg') }}" alt="Cateto" class="w-full dark:hidden block" />
          <img
            src="{{ asset('images/shared/logo-dark.svg') }}"
            alt="Cateto"
            class="w-full dark:block hidden"
          />
        </figure>
      </a>
    </div>
    <nav class="hidden md:flex items-center">
      <ul class="flex items-center gap-2">
        <li>
          <a
            href="{{ url('/bemutatkozas') }}"
            class="px-4 py-2 border {{ request()->is('bemutatkozas') ? 'border-accent' : 'border-transparent hover:border-accent dark:hover:border-stroke-7' }} rounded-full text-tagline-1 {{ request()->is('bemutatkozas') ? 'font-medium text-accent' : 'font-normal text-accent/60 hover:text-accent' }} transition-all duration-200"
          >
            Bemutatkozás
          </a>
        </li>
        <li class="relative nav-item" data-menu="unraid-mega-menu">
          <a
            href="{{ url('/unraid') }}"
            class="flex items-center gap-1 px-4 py-2 border {{ request()->is('unraid*') ? 'border-accent' : 'border-transparent hover:border-accent dark:hover:border-stroke-7' }} rounded-full text-tagline-1 {{ request()->is('unraid*') ? 'font-medium text-accent' : 'font-normal text-accent/60 hover:text-accent' }} transition-all duration-200"
          >
            <span>unRAID</span>
            <span class="nav-arrow">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          </a>
          @include('components.unraid.unraid-menu')
        </li>
        <li>
          <a
            href="{{ url('/grafika') }}"
            class="px-4 py-2 border {{ request()->is('grafika') ? 'border-accent' : 'border-transparent hover:border-accent dark:hover:border-stroke-7' }} rounded-full text-tagline-1 {{ request()->is('grafika') ? 'font-medium text-accent' : 'font-normal text-accent/60 hover:text-accent' }} transition-all duration-200"
          >
            Grafikai szemlélet az AI korában
          </a>
        </li>
        <li>
          <a
            href="{{ url('/internetes-jelenlet') }}"
            class="px-4 py-2 border {{ request()->is('internetes-jelenlet') ? 'border-accent' : 'border-transparent hover:border-accent dark:hover:border-stroke-7' }} rounded-full text-tagline-1 {{ request()->is('internetes-jelenlet') ? 'font-medium text-accent' : 'font-normal text-accent/60 hover:text-accent' }} transition-all duration-200"
          >
            Internetes jelenlét
          </a>
        </li>
        <li>
          <a
            href="{{ url('/ai-jovo') }}"
            class="px-4 py-2 border {{ request()->is('ai-jovo') ? 'border-accent' : 'border-transparent hover:border-accent dark:hover:border-stroke-7' }} rounded-full text-tagline-1 {{ request()->is('ai-jovo') ? 'font-medium text-accent' : 'font-normal text-accent/60 hover:text-accent' }} transition-all duration-200"
          >
            AI a jövő
          </a>
        </li>
        <li>
          <a
            href="{{ url('/kapcsolat') }}"
            class="px-4 py-2 border {{ request()->is('kapcsolat') ? 'border-accent' : 'border-transparent hover:border-accent dark:hover:border-stroke-7' }} rounded-full text-tagline-1 {{ request()->is('kapcsolat') ? 'font-medium text-accent' : 'font-normal text-accent/60 hover:text-accent' }} transition-all duration-200"
          >
            Kapcsolat
          </a>
        </li>
      </ul>
    </nav>
    <!-- Mobile Menu Button -->
    <button
      class="md:hidden flex items-center justify-center size-10 rounded-full bg-accent/10 text-accent"
      onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
    >
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
      </svg>
    </button>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="hidden md:hidden fixed inset-0 z-40 bg-background-7 pt-32 px-6">
    <nav>
      <ul class="flex flex-col gap-4">
        <li>
          <a href="{{ url('/bemutatkozas') }}" class="block py-3 px-4 rounded-lg {{ request()->is('bemutatkozas') ? 'bg-accent text-black font-medium' : 'bg-accent/10 text-accent' }} text-center">
            Bemutatkozás
          </a>
        </li>
        <li>
          <a href="{{ url('/unraid') }}" class="block py-3 px-4 rounded-lg {{ request()->is('unraid*') ? 'bg-accent text-black font-medium' : 'bg-accent/10 text-accent' }} text-center">
            unRAID
          </a>
        </li>
        <li>
          <a href="{{ url('/grafika') }}" class="block py-3 px-4 rounded-lg {{ request()->is('grafika') ? 'bg-accent text-black font-medium' : 'bg-accent/10 text-accent' }} text-center">
            Grafikai szemlélet az AI korában
          </a>
        </li>
        <li>
          <a href="{{ url('/internetes-jelenlet') }}" class="block py-3 px-4 rounded-lg {{ request()->is('internetes-jelenlet') ? 'bg-accent text-black font-medium' : 'bg-accent/10 text-accent' }} text-center">
            Internetes jelenlét
          </a>
        </li>
        <li>
          <a href="{{ url('/ai-jovo') }}" class="block py-3 px-4 rounded-lg {{ request()->is('ai-jovo') ? 'bg-accent text-black font-medium' : 'bg-accent/10 text-accent' }} text-center">
            AI a jövő
          </a>
        </li>
        <li>
          <a href="{{ url('/kapcsolat') }}" class="block py-3 px-4 rounded-lg {{ request()->is('kapcsolat') ? 'bg-accent text-black font-medium' : 'bg-accent/10 text-accent' }} text-center">
            Kapcsolat
          </a>
        </li>
      </ul>
    </nav>
  </div>
</header>
