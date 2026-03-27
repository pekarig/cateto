<!-- =========================
Footer
===========================-->
<footer class="bg-secondary dark:bg-background-8 relative z-0 overflow-hidden border-t border-t-[#303032] dark:border-t-0">
  <figure
    data-ns-animate
    data-delay="0.3"
    data-direction="up"
    data-offset="50"
    class="pointer-events-none absolute -top-[1320px] left-1/2 -z-1 size-[1635px] -translate-x-1/2 select-none"
  >
    <img src="{{ asset('images/ns-img-532.png') }}" alt="footer-gradient" class="size-full object-cover" />
  </figure>
  <div class="main-container px-5">
    <div class="grid grid-cols-12 justify-between gap-x-8 gap-y-16 pt-16 pb-12 xl:pt-[90px]">
      <!-- 1. Oszlop: Főoldalak -->
      <div class="col-span-12 md:col-span-6 lg:col-span-4">
        <div data-ns-animate data-delay="0.3">
          <h3 class="text-accent font-semibold mb-6">Oldalak</h3>
          <ul class="space-y-3">
            <li><a href="{{ url('/bemutatkozas') }}" class="text-accent/60 hover:text-accent transition">Bemutatkozás</a></li>
            <li><a href="{{ url('/grafika') }}" class="text-accent/60 hover:text-accent transition">Grafikai szemlélet az AI korában</a></li>
            <li><a href="{{ url('/internetes-jelenlet') }}" class="text-accent/60 hover:text-accent transition">Internetes jelenlét</a></li>
            <li><a href="{{ url('/ai-jovo') }}" class="text-accent/60 hover:text-accent transition">AI a jövő</a></li>
            <li><a href="{{ url('/kapcsolat') }}" class="text-accent/60 hover:text-accent transition">Kapcsolat</a></li>
            <li><a href="{{ url('/gdpr') }}" class="text-accent/60 hover:text-accent transition">GDPR</a></li>
          </ul>
        </div>
      </div>

      <!-- 2-3. Oszlop: unRAID -->
      <div class="col-span-12 md:col-span-6 lg:col-span-8">
        <div data-ns-animate data-delay="0.4">
          <h3 class="text-accent font-semibold mb-6">unRAID</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3">
            <ul class="space-y-3">
              <li><a href="{{ url('/unraid') }}" class="text-accent/60 hover:text-accent transition">unRAID Főoldal</a></li>
              <li><a href="{{ url('/unraid/opsystem') }}" class="text-accent/60 hover:text-accent transition">OP Rendszer</a></li>
              <li><a href="{{ url('/unraid/hardware') }}" class="text-accent/60 hover:text-accent transition">Hardware</a></li>
              <li><a href="{{ url('/unraid/software') }}" class="text-accent/60 hover:text-accent transition">Software</a></li>
              <li><a href="{{ url('/unraid/security') }}" class="text-accent/60 hover:text-accent transition">Security</a></li>
              <li><a href="{{ url('/unraid/updates') }}" class="text-accent/60 hover:text-accent transition">Updates</a></li>
              <li><a href="{{ url('/unraid/servers') }}" class="text-accent/60 hover:text-accent transition">Servers</a></li>
              <li><a href="{{ url('/unraid/license') }}" class="text-accent/60 hover:text-accent transition">License</a></li>
            </ul>
            <ul class="space-y-3">
              <li><a href="{{ url('/unraid/community') }}" class="text-accent/60 hover:text-accent transition">Community</a></li>
              <li><a href="{{ url('/unraid/support') }}" class="text-accent/60 hover:text-accent transition">Support</a></li>
              <li><a href="{{ url('/unraid/vm') }}" class="text-accent/60 hover:text-accent transition">VM</a></li>
              <li><a href="{{ url('/unraid/network') }}" class="text-accent/60 hover:text-accent transition">Network</a></li>
              <li><a href="{{ url('/unraid/expressions') }}" class="text-accent/60 hover:text-accent transition">Expressions</a></li>
              <li><a href="{{ url('/unraid/aibuild') }}" class="text-accent/60 hover:text-accent transition">AI Build</a></li>
              <li><a href="{{ url('/unraid/parity') }}" class="text-accent/60 hover:text-accent transition">Parity</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="border-t border-stroke-1/20 py-8">
      <p class="text-center text-accent/60 text-sm">
        © 1999 - {{ date('Y') }} Ragnar | Minden jog fenntartva.
      </p>
    </div>
  </div>
</footer>
