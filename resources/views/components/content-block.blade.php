{{-- Content Block Component - Dinamikus blokk renderelő --}}

@php
    $blockType = $block->type ?? 'content';
@endphp

<div class="content-block content-block--{{ $blockType }}" data-key="{{ $block->key }}">

    @if($blockType === 'hero')
        {{-- Hero szekció --}}
        <div class="hero bg-gradient-to-br from-blue-600 to-purple-700 rounded-2xl p-12 text-center">
            <div class="prose prose-invert prose-lg mx-auto">
                {!! $block->content !!}
            </div>
        </div>

    @elseif($blockType === 'feature')
        {{-- Feature card --}}
        <div class="feature-card bg-gray-800 rounded-xl p-8 hover:bg-gray-750 transition">
            <div class="prose prose-invert max-w-none">
                {!! $block->content !!}
            </div>
        </div>

    @elseif($blockType === 'cta')
        {{-- Call to Action --}}
        <div class="cta bg-blue-600 rounded-xl p-10 text-center">
            <div class="prose prose-invert prose-xl mx-auto">
                {!! $block->content !!}
            </div>
        </div>

    @elseif($blockType === 'custom')
        {{-- Egyedi HTML --}}
        <div class="custom-block">
            {!! $block->content !!}
        </div>

    @else
        {{-- Alapértelmezett tartalom --}}
        <div class="content-section prose prose-invert prose-lg max-w-none">
            {!! $block->content !!}
        </div>
    @endif

</div>
