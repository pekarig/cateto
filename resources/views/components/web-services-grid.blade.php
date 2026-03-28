{{--
    Web Services Grid Component
    Dinamikus 3 oszlopos grid az Internetes jelenlét oldalhoz
    @param $page - Az oldal, amelyhez a service items-ek tartoznak
--}}

{{-- Grid container: 3 oszlop desktop, 2 oszlop tablet, 1 oszlop mobil --}}
<div class="grid grid-cols-12 md:gap-8 gap-y-5">
        @foreach($page->webServiceItems->sortBy('sort_order') as $index => $item)
            <div class="col-span-12 md:col-span-6 lg:col-span-4">
                <div
                    data-ns-animate=""
                    data-delay="{{ 0.3 + ($index * 0.1) }}"
                    class="sm:p-8 p-5 bg-background-6 rounded-[20px] space-y-8 h-full flex flex-col"
                >
                    {{-- Header: Tagline + Icon --}}
                    <div class="flex items-center justify-between">
                        <p class="text-tagline-2 text-accent">{{ $item->tagline }}</p>

                        @if($item->icon_path)
                            <div class="text-[52px] text-accent">
                                <img src="{{ asset('storage/' . $item->icon_path) }}"
                                     alt="{{ $item->heading }}"
                                     class="w-[52px] h-[52px] object-contain opacity-80">
                            </div>
                        @endif
                    </div>

                    {{-- Content: Heading + Description + Features --}}
                    <div class="space-y-4 flex-1">
                        <h3 class="text-accent sm:text-heading-5 text-heading-6 font-normal">
                            {{ $item->heading }}
                        </h3>

                        <div style="color: rgba(255, 255, 255, 0.6);">
                            {!! str_replace('<p>', '<p style="color: rgba(255, 255, 255, 0.6);">', $item->description) !!}
                        </div>

                        {{-- Features lista --}}
                        @if($item->features && count($item->features) > 0)
                            <ul class="text-tagline-1 font-normal text-accent/60 space-y-2 list-disc list-inside">
                                @foreach($item->features as $feature)
                                    <li>{{ $feature['text'] ?? $feature }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Üres állapot (ha nincs még fel dobozok) --}}
    @if($page->webServiceItems->isEmpty())
        <div class="text-center py-16">
            <div class="bg-background-6 rounded-[20px] p-8 max-w-lg mx-auto">
                <p class="text-accent/60 text-lg">Még nincs felvitt service doboz.</p>
                <p class="text-accent/40 mt-2">Hozz létre újakat az admin felületen!</p>
                <a href="{{ url('/admin/web-service-items/create') }}"
                   class="inline-block mt-4 px-6 py-3 bg-accent hover:bg-accent/80 rounded-lg text-white transition">
                    + Új doboz hozzáadása
                </a>
            </div>
        </div>
    @endif
