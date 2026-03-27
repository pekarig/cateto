<div>
  <div
    class="dropdown-menu-bridge fixed left-1/2 -translate-x-1/2 top-full w-full h-3 z-40 lg:w-[1290px] pointer-events-none bg-transparent opacity-0"
  ></div>
  <div
    id="unraid-mega-menu"
    class="dropdown-menu fixed left-1/2 -translate-x-1/2 top-full mt-2 pointer-events-none transition-all duration-300 opacity-0 lg:w-[1290px] w-full bg-background-6 z-50 rounded-[20px] p-4 border border-white/10"
  >
    <div class="grid grid-cols-12 items-start md:gap-x-6 gap-y-6">
      {{-- BAL OLDALI OSZLOP: Általános Menüpontok --}}
      <div class="col-span-12 lg:col-span-6 grid grid-cols-12 gap-x-6">
        <div class="col-span-12 xl:col-span-6">
          <div>
            <p class="text-tagline-2 font-medium text-accent/60 p-3">
              Áttekintés
            </p>
            <ul>
              <li>
                <a href="{{ url('/unraid/opsystem') }}" class="relative block group p-3">
                  @include('components.shared.hover-bg-transform')
                  <span class="text-tagline-1 font-normal text-accent relative z-10">
                    OP Rendszer
                  </span>
                </a>
              </li>
              <li>
                <a href="{{ url('/unraid/hardware') }}" class="relative block group p-3">
                  @include('components.shared.hover-bg-transform')
                  <span class="text-tagline-1 font-normal text-accent relative z-10">
                    Hardver
                  </span>
                </a>
              </li>
              <li>
                <a href="{{ url('/unraid/software') }}" class="relative block group p-3">
                  @include('components.shared.hover-bg-transform')
                  <span class="text-tagline-1 font-normal text-accent relative z-10">
                    Szoftverek & Alkalmazások
                  </span>
                </a>
              </li>
              <li>
                <a href="{{ url('/unraid/security') }}" class="relative block group p-3">
                  @include('components.shared.hover-bg-transform')
                  <span class="text-tagline-1 font-normal text-accent relative z-10">
                    Biztonság & Adatmentés
                  </span>
                </a>
              </li>
              <li>
                <a href="{{ url('/unraid/updates') }}" class="relative block group p-3">
                  @include('components.shared.hover-bg-transform')
                  <span class="text-tagline-1 font-normal text-accent relative z-10">
                    Frissítés & Karbantartás
                  </span>
                </a>
              </li>
              <li>
                <a href="{{ url('/unraid/servers') }}" class="relative block group p-3">
                  @include('components.shared.hover-bg-transform')
                  <span class="text-tagline-1 font-normal text-accent relative z-10">
                    Serverek
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </div>

        {{-- JOBB OLDALI OSZLOP: Kiemelt Menüpontok --}}
        <div class="col-span-12 xl:col-span-6">
          <div>
            <p class="text-tagline-2 font-medium text-accent/60 p-3">
              Szolgáltatások
            </p>
            <ul>
              <li>
                <a href="{{ url('/unraid/license') }}" class="relative flex items-center gap-2 group p-3">
                  @include('components.shared.hover-bg-transform')
                  <span class="relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <path d="M15.8333 9.16667H4.16667C3.24619 9.16667 2.5 9.91286 2.5 10.8333V16.6667C2.5 17.5871 3.24619 18.3333 4.16667 18.3333H15.8333C16.7538 18.3333 17.5 17.5871 17.5 16.6667V10.8333C17.5 9.91286 16.7538 9.16667 15.8333 9.16667Z" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M5.83301 9.16667V5.83333C5.83301 4.72826 6.27199 3.66846 7.05339 2.88706C7.83479 2.10565 8.89459 1.66667 9.99967 1.66667C11.1048 1.66667 12.1646 2.10565 12.946 2.88706C13.7274 3.66846 14.1663 4.72826 14.1663 5.83333V9.16667" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  <span class="text-tagline-1 font-normal text-accent relative z-10">
                    Licenszelés
                  </span>
                </a>
              </li>
              <li>
                <a href="{{ url('/unraid/community') }}" class="relative flex items-center gap-2 group p-3">
                  @include('components.shared.hover-bg-transform')
                  <span class="relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <g clip-path="url(#clip0_unraid_community)">
                        <path d="M19.167 17.5001V15.8334C19.1664 15.0948 18.9206 14.3774 18.4681 13.7937C18.0156 13.2099 17.3821 12.793 16.667 12.6084" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M14.1663 17.5V15.8333C14.1663 14.9493 13.8152 14.1014 13.19 13.4763C12.5649 12.8512 11.7171 12.5 10.833 12.5H4.16634C3.28229 12.5 2.43444 12.8512 1.80932 13.4763C1.1842 14.1014 0.833008 14.9493 0.833008 15.8333V17.5" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13.333 2.6084C14.05 2.79198 14.6855 3.20898 15.1394 3.79366C15.5932 4.37833 15.8395 5.09742 15.8395 5.83757C15.8395 6.57771 15.5932 7.2968 15.1394 7.88147C14.6855 8.46615 14.05 8.88315 13.333 9.06673" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7.50033 9.16667C9.34127 9.16667 10.8337 7.67428 10.8337 5.83333C10.8337 3.99238 9.34127 2.5 7.50033 2.5C5.65938 2.5 4.16699 3.99238 4.16699 5.83333C4.16699 7.67428 5.65938 9.16667 7.50033 9.16667Z" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                      </g>
                      <defs><clipPath id="clip0_unraid_community"><rect width="20" height="20" fill="white"/></clipPath></defs>
                    </svg>
                  </span>
                  <span class="text-tagline-1 font-normal text-accent relative z-10">
                    Közösség
                  </span>
                </a>
              </li>
              <li>
                <a href="{{ url('/unraid/support') }}" class="relative flex items-center gap-2 group p-3">
                  @include('components.shared.hover-bg-transform')
                  <span class="relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M1.54912 11.8217C0.617298 10.2509 0.290965 8.3939 0.631402 6.59948C0.971839 4.80507 1.95563 3.19666 3.39803 2.07627C4.84044 0.955873 6.64224 0.400575 8.46509 0.514644C10.2879 0.628714 12.0065 1.4043 13.2979 2.69577C14.5894 3.98725 15.365 5.70576 15.4791 7.52861C15.5932 9.35147 15.0379 11.1533 13.9175 12.5957C12.7971 14.0381 11.1887 15.0219 9.39429 15.3623C7.59988 15.7028 5.74291 15.3765 4.17207 14.4446L4.17209 14.4446L1.58173 15.1847C1.47456 15.2153 1.36115 15.2167 1.25325 15.1887C1.14536 15.1608 1.0469 15.1045 0.968086 15.0257C0.889272 14.9468 0.832968 14.8484 0.80501 14.7405C0.777051 14.6326 0.778456 14.5192 0.809077 14.412L1.54918 11.8216L1.54912 11.8217Z" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 7.55615C8.24162 7.55615 8.4375 7.75203 8.4375 7.99365C8.4375 8.23528 8.24162 8.43115 8 8.43115C7.75838 8.43115 7.5625 8.23528 7.5625 7.99365C7.5625 7.75203 7.75838 7.55615 8 7.55615Z" fill="#12161F" class="stroke-accent"/>
                      <path d="M4.25 7.55615C4.49162 7.55615 4.6875 7.75203 4.6875 7.99365C4.6875 8.23528 4.49162 8.43115 4.25 8.43115C4.00838 8.43115 3.8125 8.23528 3.8125 7.99365C3.8125 7.75203 4.00838 7.55615 4.25 7.55615Z" fill="#12161F" class="stroke-accent"/>
                      <path d="M11.75 7.55615C11.9916 7.55615 12.1875 7.75203 12.1875 7.99365C12.1875 8.23528 11.9916 8.43115 11.75 8.43115C11.5084 8.43115 11.3125 8.23528 11.3125 7.99365C11.3125 7.75203 11.5084 7.55615 11.75 7.55615Z" fill="#12161F" class="stroke-accent"/>
                    </svg>
                  </span>
                  <span class="text-tagline-1 font-normal text-accent relative z-10">
                    Támogatás
                  </span>
                </a>
              </li>
              <li>
                <a href="{{ url('/unraid/vm') }}" class="relative flex items-center gap-2 group p-3">
                  @include('components.shared.hover-bg-transform')
                  <span class="relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <path d="M16.6667 2.5H3.33333C2.8731 2.5 2.5 2.8731 2.5 3.33333V13.3333C2.5 13.7936 2.8731 14.1667 3.33333 14.1667H16.6667C17.1269 14.1667 17.5 13.7936 17.5 13.3333V3.33333C17.5 2.8731 17.1269 2.5 16.6667 2.5Z" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M6.66699 17.5H13.3337" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M10 14.1665V17.4998" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  <span class="text-tagline-1 font-normal text-accent relative z-10">
                    Virtuális Gépek
                  </span>
                </a>
              </li>
              <li>
                <a href="{{ url('/unraid/network') }}" class="relative flex items-center gap-2 group p-3">
                  @include('components.shared.hover-bg-transform')
                  <span class="relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <path d="M2.5 7.5C3.88071 7.5 5 6.38071 5 5C5 3.61929 3.88071 2.5 2.5 2.5C1.11929 2.5 0 3.61929 0 5C0 6.38071 1.11929 7.5 2.5 7.5Z" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M17.5 7.5C18.8807 7.5 20 6.38071 20 5C20 3.61929 18.8807 2.5 17.5 2.5C16.1193 2.5 15 3.61929 15 5C15 6.38071 16.1193 7.5 17.5 7.5Z" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M10 17.5C11.3807 17.5 12.5 16.3807 12.5 15C12.5 13.6193 11.3807 12.5 10 12.5C8.61929 12.5 7.5 13.6193 7.5 15C7.5 16.3807 8.61929 17.5 10 17.5Z" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M4.6416 6.3584L8.3583 13.6417" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M11.6416 13.6417L15.3583 6.3584" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  <span class="text-tagline-1 font-normal text-accent relative z-10">
                    Hálózat
                  </span>
                </a>
              </li>
              <li>
                <a href="{{ url('/unraid/expressions') }}" class="relative flex items-center gap-2 group p-3">
                  @include('components.shared.hover-bg-transform')
                  <span class="relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <path d="M18.3333 2.5H13.3333C12.4493 2.5 11.6014 2.85119 10.9763 3.47631C10.3512 4.10143 10 4.94928 10 5.83333V17.5C10 16.837 10.2634 16.2011 10.7322 15.7322C11.2011 15.2634 11.837 15 12.5 15H18.3333V2.5Z" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M1.66699 2.5H6.66699C7.55105 2.5 8.39889 2.85119 9.02401 3.47631C9.64914 4.10143 10.0003 4.94928 10.0003 5.83333V17.5C10.0003 16.837 9.73693 16.2011 9.26809 15.7322C8.79925 15.2634 8.16337 15 7.50033 15H1.66699V2.5Z" class="stroke-accent" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  <span class="text-tagline-1 font-normal text-accent relative z-10">
                    Fogalomtár
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      {{-- FEATURE CARD-OK --}}
      <div class="col-span-12 lg:col-span-6 grid grid-cols-12 gap-x-6">
        <div class="col-span-12 xl:col-span-6">
          <a href="{{ url('/unraid/aibuild') }}" class="block">
            <article class="p-3 border border-stroke-1 dark:border-background-7 rounded-2xl space-y-3 group">
              <figure class="rounded-lg overflow-hidden">
                <img src="{{ asset('images/ns-img-424.jpg') }}" alt="AI Build" class="w-full h-full object-cover rounded-lg group-hover:scale-105 transition-transform duration-500 ease-in-out"/>
              </figure>
              <div class="space-y-14">
                <div>
                  <p class="text-heading-6 font-normal text-accent">AI Build</p>
                  <p class="text-tagline-1 font-normal text-accent/60">AI-centrikus unRAID build<br/>(GPU + Docker stack)</p>
                </div>
                <div>
                  <a href="{{ url('/unraid/aibuild') }}" class="bg-secondary group group-hover:bg-primary-500 transition-all duration-500 ease-in-out ring-[6px] ring-background-12 dark:ring-background-7 rounded-full w-16 relative overflow-hidden flex items-center justify-center space-y-5 h-9.5 px-5 py-2">
                    <figure class="size-6 relative items-center justify-center overflow-hidden">
                      <img src="{{ asset('images/icons/new-arrow-white.svg') }}" alt="new-arrow" class="size-full absolute inset-0 -translate-x-6 object-cover group-hover:translate-x-1 transition-transform duration-400 ease-in-out"/>
                      <img src="{{ asset('images/icons/new-arrow-white.svg') }}" alt="new-arrow" class="size-full object-cover group-hover:translate-x-6 transition-transform duration-400 ease-in-out"/>
                    </figure>
                  </a>
                </div>
              </div>
            </article>
          </a>
        </div>
        <div class="col-span-12 xl:col-span-6">
          <a href="{{ url('/unraid/parity') }}" class="block">
            <article class="p-3 border border-stroke-1 dark:border-background-7 rounded-2xl space-y-3 group">
              <figure class="rounded-lg overflow-hidden">
                <img src="{{ asset('images/ns-img-425.jpg') }}" alt="Paritás működése" class="w-full h-full object-cover rounded-lg group-hover:scale-105 transition-transform duration-500 ease-in-out"/>
              </figure>
              <div class="space-y-14">
                <div>
                  <p class="text-heading-6 font-normal text-accent">Paritás működése</p>
                  <p class="text-tagline-1 font-normal text-accent/60">Parity lemez működése –<br/>Részletes magyarázat</p>
                </div>
                <div>
                  <a href="{{ url('/unraid/parity') }}" class="bg-secondary group group-hover:bg-primary-500 transition-all duration-500 ease-in-out ring-[6px] ring-background-12 dark:ring-background-7 rounded-full w-16 relative overflow-hidden flex items-center justify-center space-y-5 h-9.5 px-5 py-2">
                    <figure class="size-6 relative items-center justify-center overflow-hidden">
                      <img src="{{ asset('images/icons/new-arrow-white.svg') }}" alt="new-arrow" class="size-full absolute inset-0 -translate-x-6 object-cover group-hover:translate-x-1 transition-transform duration-400 ease-in-out"/>
                      <img src="{{ asset('images/icons/new-arrow-white.svg') }}" alt="new-arrow" class="size-full object-cover group-hover:translate-x-6 transition-transform duration-400 ease-in-out"/>
                    </figure>
                  </a>
                </div>
              </div>
            </article>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
