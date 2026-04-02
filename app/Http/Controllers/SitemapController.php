<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    /**
     * Generate and return the sitemap XML
     */
    public function index(): Response
    {
        $pages = Page::where('is_published', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Főoldal
        $sitemap .= $this->generateUrlEntry(
            url('/'),
            now(),
            '1.0',
            'daily'
        );

        // Minden publikált oldal
        foreach ($pages as $page) {
            $url = $this->getPageUrl($page);
            $sitemap .= $this->generateUrlEntry(
                $url,
                $page->updated_at,
                '0.8',
                'weekly'
            );
        }

        $sitemap .= '</urlset>';

        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Get the full URL for a page
     */
    private function getPageUrl(Page $page): string
    {
        if ($page->parent_id) {
            $parent = Page::find($page->parent_id);
            return url("/{$parent->slug}/{$page->slug}");
        }

        if ($page->slug === 'bemutatkozas') {
            return url('/');
        }

        return url("/{$page->slug}");
    }

    /**
     * Generate a URL entry for the sitemap
     */
    private function generateUrlEntry(
        string $url,
        $lastmod,
        string $priority = '0.5',
        string $changefreq = 'monthly'
    ): string {
        $entry = "  <url>\n";
        $entry .= "    <loc>" . htmlspecialchars($url) . "</loc>\n";
        $entry .= "    <lastmod>" . $lastmod->toAtomString() . "</lastmod>\n";
        $entry .= "    <changefreq>{$changefreq}</changefreq>\n";
        $entry .= "    <priority>{$priority}</priority>\n";
        $entry .= "  </url>\n";

        return $entry;
    }
}
