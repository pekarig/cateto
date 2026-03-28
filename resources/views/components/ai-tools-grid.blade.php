{{--
    AI Tools Grid Component
    Dinamikus 3 oszlopos grid az AI jövő oldalhoz
    @param $page - Az oldal, amelyhez az AI tool items-ek tartoznak
--}}

{{-- Grid container: 3 oszlop desktop, 2 oszlop tablet, 1 oszlop mobil --}}
<div class="grid grid-cols-12 md:gap-8 gap-y-5">
    @foreach($page->aiToolItems->sortBy('sort_order') as $index => $item)
        <div data-ns-animate="" data-delay="{{ 0.5 + ($index * 0.1) }}" class="col-span-12 md:col-span-6 xl:col-span-4">
            <div class="sm:p-8 p-5 bg-background-7 rounded-[20px] space-y-6 h-full flex flex-col text-center hover:translate-y-[-10px] transition-transform duration-500 ease-in-out"
            >
                {{-- Header: Icon --}}
                <div class="flex items-center justify-center">
                    @if($item->icon_path)
                        <div class="text-[52px]">
                            <img src="{{ asset('storage/' . $item->icon_path) }}"
                                 alt="{{ $item->name }}"
                                 class="w-[52px] h-[52px] object-contain">
                        </div>
                    @endif
                </div>

                {{-- Content: Name + Description --}}
                <div class="space-y-4 flex-1 text-center">
                    <h3 class="text-accent sm:text-heading-5 text-heading-6 font-normal">
                        {{ $item->name }}
                    </h3>

                    <div style="color: rgba(255, 255, 255, 0.6);">
                        {!! str_replace('<p>', '<p style="color: rgba(255, 255, 255, 0.6);">', $item->description) !!}
                    </div>
                </div>

                {{-- Button --}}
                @if($item->button_url)
                    <div class="flex justify-center pt-2">
                        <a href="{{ $item->button_url }}"
                           @if($item->button_target_blank) target="_blank" rel="noopener noreferrer" @endif
                           class="btn btn-white dark:btn-transparent dark:hover:btn-accent hover:btn-secondary btn-md">
                            <span>{{ $item->button_text ?? 'Megnyitás' }}</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
