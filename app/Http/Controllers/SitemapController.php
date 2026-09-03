<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Service;
use App\Models\Article;
use App\Models\HospitalEvent;
use App\Models\Promo;
use App\Models\Career;

class SitemapController extends Controller
{
    /**
     * Generate XML Sitemap dynamically
     */
    public function index(): Response
    {
        $urls = [];

        // 1. Static Pages with High Priority
        $staticPages = [
            ['url' => url('/'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['url' => url('/dokter-di-karawang'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'daily', 'priority' => '0.95'],
            ['url' => url('/jadwal-dokter'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'daily', 'priority' => '0.9'],
            ['url' => url('/buat-janji'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'daily', 'priority' => '0.9'],
            ['url' => url('/profil'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['url' => url('/lokasi'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['url' => url('/kontak'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['url' => url('/artikel'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'daily', 'priority' => '0.8'],
            ['url' => url('/informasi/event'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['url' => url('/informasi/penawaran-khusus'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['url' => url('/karir'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['url' => url('/layanan/unggulan'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['url' => url('/layanan/rawat-inap'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['url' => url('/layanan/rawat-jalan'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['url' => url('/layanan/igd'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['url' => url('/layanan/rehabilitasi-medik'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['url' => url('/layanan/farmasi-24-jam'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['url' => url('/layanan/penunjang-medis'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['url' => url('/layanan/radiologi-24-jam'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['url' => url('/layanan/laboratorium-klinik'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['url' => url('/layanan/laboratorium-patologi'), 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.8'],
        ];

        foreach ($staticPages as $page) {
            $urls[] = $page;
        }

        // 2. Dynamic Doctor Specialty Hub Pages (/dokter/{spesialisasi}-karawang)
        $polyclinics = \App\Models\Polyclinic::where('is_active', true)->get();
        foreach ($polyclinics as $poli) {
            $urls[] = [
                'url' => $poli->route_url,
                'lastmod' => $poli->updated_at ? $poli->updated_at->format('Y-m-d') : date('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.90',
            ];
        }

        // 2b. Dynamic Individual Doctor Profile Pages (/dokter/{slug})
        $doctors = \App\Models\Doctor::where('is_active', true)->get();
        foreach ($doctors as $doc) {
            $urls[] = [
                'url' => $doc->route_url,
                'lastmod' => $doc->updated_at ? $doc->updated_at->format('Y-m-d') : date('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.88',
            ];
        }

        // 2c. Dynamic Services
        $services = Service::where('is_active', true)->get();
        foreach ($services as $service) {
            $serviceUrl = url('/layanan/' . $service->slug);
            if (!in_array($serviceUrl, array_column($urls, 'url'))) {
                $urls[] = [
                    'url' => $serviceUrl,
                    'lastmod' => $service->updated_at ? $service->updated_at->format('Y-m-d') : date('Y-m-d'),
                    'changefreq' => 'weekly',
                    'priority' => '0.85',
                ];
            }
        }

        // 3. Dynamic Articles (Health Education & News)
        $articles = Article::where('is_published', true)->orderBy('published_at', 'desc')->get();
        foreach ($articles as $article) {
            $urls[] = [
                'url' => route('artikel.show', $article->slug),
                'lastmod' => $article->updated_at ? $article->updated_at->format('Y-m-d') : ($article->published_at ? $article->published_at->format('Y-m-d') : date('Y-m-d')),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // 4. Dynamic Hospital Events
        $events = HospitalEvent::where('is_active', true)->orderBy('event_date', 'desc')->get();
        foreach ($events as $event) {
            $urls[] = [
                'url' => route('event.show', $event->slug),
                'lastmod' => $event->updated_at ? $event->updated_at->format('Y-m-d') : date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.75',
            ];
        }

        // 5. Dynamic Promos & Penawaran Khusus
        $promos = Promo::where('is_active', true)->get();
        foreach ($promos as $promo) {
            $urls[] = [
                'url' => route('promo.show', $promo->slug),
                'lastmod' => $promo->updated_at ? $promo->updated_at->format('Y-m-d') : date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.75',
            ];
        }

        // 6. Dynamic Careers (Lowongan Kerja)
        $careers = Career::where('is_active', true)->where('status', 'open')->get();
        foreach ($careers as $career) {
            $urls[] = [
                'url' => route('karir.show', $career->slug),
                'lastmod' => $career->updated_at ? $career->updated_at->format('Y-m-d') : date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        // Build XML Content
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $item) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($item['url']) . "</loc>\n";
            $xml .= "    <lastmod>" . $item['lastmod'] . "</lastmod>\n";
            $xml .= "    <changefreq>" . $item['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $item['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'X-Robots-Tag' => 'noindex', // Sitemap XML itself doesn't need to be indexed as a search result, but is used by crawlers
        ]);
    }
}
