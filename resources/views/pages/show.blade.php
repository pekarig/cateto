@extends('layouts.app')

@section('title', $page->title)
@section('description', $page->description ?? '')
@section('keywords', $page->keywords ?? '')

@php
    // WebPage Schema
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => $page->title,
        'description' => $page->description,
        'url' => url()->current(),
        'inLanguage' => 'hu-HU',
        'isPartOf' => [
            '@type' => 'WebSite',
            'name' => 'Cateto',
            'url' => url('/'),
        ],
        'datePublished' => $page->created_at->toIso8601String(),
        'dateModified' => $page->updated_at->toIso8601String(),
        'author' => [
            '@type' => 'Organization',
            'name' => 'Cateto',
            'url' => url('/'),
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Cateto',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('images/logo.png'),
            ],
        ],
    ];

    // Breadcrumb hozzáadása
    if (isset($parent)) {
        $schema['breadcrumb'] = [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Főoldal', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => $parent->title, 'item' => url('/' . $parent->slug)],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $page->title, 'item' => url()->current()],
            ],
        ];
    } elseif ($page->slug !== 'bemutatkozas') {
        $schema['breadcrumb'] = [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Főoldal', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => $page->title, 'item' => url()->current()],
            ],
        ];
    }

    // ItemList Schema (ha van webServiceItems vagy aiToolItems)
    $itemListSchema = null;
    $totalItems = $page->webServiceItems->count() + $page->aiToolItems->count();
    if ($totalItems > 0) {
        $itemListElements = [];
        $position = 1;
        foreach ($page->webServiceItems as $service) {
            $item = [
                '@type' => 'ListItem',
                'position' => $position++,
                'item' => array_filter([
                    '@type' => 'Service',
                    'name' => $service->name,
                    'description' => $service->description,
                    'provider' => ['@type' => 'Organization', 'name' => 'Cateto'],
                    'url' => $service->url ?? null,
                ]),
            ];
            $itemListElements[] = $item;
        }
        foreach ($page->aiToolItems as $tool) {
            $item = [
                '@type' => 'ListItem',
                'position' => $position++,
                'item' => array_filter([
                    '@type' => 'SoftwareApplication',
                    'name' => $tool->name,
                    'description' => $tool->description,
                    'applicationCategory' => 'AI Tool',
                    'provider' => ['@type' => 'Organization', 'name' => 'Cateto'],
                    'url' => $tool->url ?? null,
                ]),
            ];
            $itemListElements[] = $item;
        }
        $itemListSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'numberOfItems' => $totalItems,
            'itemListElement' => $itemListElements,
        ];
    }
@endphp

@section('schema')
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@if($itemListSchema)
<script type="application/ld+json">
{!! json_encode($itemListSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif
@endsection

@section('content')
@include('components.header')

@php
    // Hero section alapján a slug-ból
    $heroComponent = 'components.heroes.' . $page->slug;
@endphp

<div class="@if(!view()->exists($heroComponent)) pt-16 md:pt-20 lg:pt-28 @endif">
    @if(view()->exists($heroComponent))
        @include($heroComponent)
    @endif

    <main>
        <!-- Tartalom blokkok renderelése -->
        @if($page->contentBlocks->isNotEmpty())
        <section class="py-16 md:py-20 lg:py-28">
            <div class="main-container">
                <div class="space-y-16 md:space-y-20 lg:space-y-28">
                    @foreach($page->contentBlocks->sortBy('sort_order') as $block)
                        {{-- Web Services Grid: dinamikus komponens --}}
                        @if($block->key === 'web_services')
                            @include('components.web-services-grid', ['page' => $page])
                        {{-- AI Tools Grid: dinamikus komponens --}}
                        @elseif($block->key === 'ai_tools')
                            @include('components.ai-tools-grid', ['page' => $page])
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
</div>

@include('components.footer')
@endsection
