<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $home = filemtime(resource_path('views/home.blade.php'));

        // Seules les vraies URLs vont dans un sitemap (les ancres #tarifs, #faq… ne sont pas indexées à part).
        // Ajoute ici /terms, /privacy, etc. quand ces pages existent.
        $urls = [
            ['loc' => url('/'), 'priority' => '1.0', 'freq' => 'weekly', 'mod' => $home, 'image' => asset('logo.png')],
            ['loc' => Route::has('register') ? route('register') : url('/register'), 'priority' => '0.8', 'freq' => 'monthly'],
            ['loc' => Route::has('login') ? route('login') : url('/login'), 'priority' => '0.5', 'freq' => 'monthly'],
            // ['loc' => url('/terms'), 'priority' => '0.3', 'freq' => 'yearly'],
            // ['loc' => url('/privacy'), 'priority' => '0.3', 'freq' => 'yearly'],
        ];

        $e = fn ($s) => htmlspecialchars($s, ENT_XML1 | ENT_QUOTES, 'UTF-8');

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
            . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" '
            . 'xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

        foreach ($urls as $u) {
            $xml .= "  <url>\n    <loc>{$e($u['loc'])}</loc>\n";
            if (!empty($u['mod'])) {
                $xml .= '    <lastmod>' . date('c', $u['mod']) . "</lastmod>\n";
            }
            $xml .= "    <changefreq>{$u['freq']}</changefreq>\n    <priority>{$u['priority']}</priority>\n";
            if (!empty($u['image'])) {
                $xml .= "    <image:image><image:loc>{$e($u['image'])}</image:loc></image:image>\n";
            }
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type'  => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}