<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Főoldal megjelenítése
     */
    public function home(): View
    {
        $page = Page::where('slug', 'bemutatkozas')
            ->with('contentBlocks')
            ->firstOrFail();

        return view('pages.show', compact('page'));
    }

    /**
     * Dinamikus oldal megjelenítése slug alapján
     */
    public function show(string $slug): View
    {
        $page = Page::where('slug', $slug)
            ->where('is_published', true)
            ->with('contentBlocks')
            ->firstOrFail();

        return view('pages.show', compact('page'));
    }

    /**
     * Gyerek oldal megjelenítése (pl: unraid/docker-setup)
     */
    public function showChild(string $parentSlug, string $childSlug): View
    {
        $parent = Page::where('slug', $parentSlug)
            ->where('is_published', true)
            ->firstOrFail();

        $page = Page::where('slug', $childSlug)
            ->where('parent_id', $parent->id)
            ->where('is_published', true)
            ->with('contentBlocks')
            ->firstOrFail();

        return view('pages.show', compact('page', 'parent'));
    }
}
