@extends('layouts.app')

@section('title', $page->title)
@section('description', $page->description)

@section('content')
@include('components.header')

<main>
    @php
        // Hero section alapján a slug-ból
        $heroComponent = 'components.heroes.' . $page->slug;
    @endphp
    @if(view()->exists($heroComponent))
        @include($heroComponent)
    @endif

    <!-- Tartalom blokkok renderelése -->
    @if($page->contentBlocks->isNotEmpty())
        <section class="py-16 md:py-20 lg:py-28">
            <div class="main-container">
                <div class="space-y-16 md:space-y-20 lg:space-y-28">
                    @foreach($page->contentBlocks->sortBy('sort_order') as $block)
                        {{-- Web Services Grid: dinamikus komponens --}}
                        @if($block->key === 'web_services')
                            @include('components.web-services-grid', ['page' => $page])
                        @else
                            {{-- Normál HTML blokk --}}
                            <div data-content-block="{{ $block->key }}">
                                {!! $block->content !!}
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Nincs tartalom -->
    @if($page->contentBlocks->isEmpty())
        <div class="py-16 md:py-20 lg:py-28">
            <div class="main-container">
                <div class="bg-background-7 rounded-lg p-8 text-center text-accent/60">
                    <p class="text-xl">Ez az oldal még nem tartalmaz tartalmakat.</p>
                    <p class="mt-2">Hozz létre tartalom blokkokat az admin felületen!</p>
                    <a href="{{ url('/admin/content-blocks/create') }}" class="inline-block mt-4 px-6 py-3 bg-accent hover:bg-accent/80 rounded-lg text-white">
                        Tartalom létrehozása
                    </a>
                </div>
            </div>
        </div>
    @endif
</main>

@include('components.footer')
@endsection
