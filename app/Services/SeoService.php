<?php

namespace App\Services;

use App\Models\HospitalProfile;
use App\Models\Article;
use App\Models\HospitalEvent;
use App\Models\Service;
use App\Models\Doctor;
use App\Models\Career;
use App\Models\Promo;
use Illuminate\Support\Str;

class SeoService
{
    protected ?HospitalProfile $profile = null;

    public function __construct()
    {
        $this->profile = HospitalProfile::first();
    }

    /**
     * Get site default name
     */
    public function getSiteName(): string
    {
        return $this->profile?->name ?: 'RSU Fikri Medika Karawang';
    }

    /**
     * Clean & sanitize plain text for meta tags
     */
    public function sanitizeText(?string $text, int $limit = 160): string
    {
        if (empty($text)) {
            return '';
        }
        $plain = strip_tags($text);
        $plain = preg_replace('/\s+/', ' ', $plain);
        $plain = trim($plain);
        return Str::limit($plain, $limit);
    }

    /**
     * Build standard Page Title
     */
    public function formatTitle(?string $title = null): string
    {
        $siteName = 'RSU Fikri Medika Karawang';
        $tagline = 'Rumah Sakit & Layanan Kesehatan Terpercaya';

        if (empty($title) || $title === $siteName) {
            return "{$siteName} | {$tagline}";
        }

        // If title already contains brand, return as is
        if (Str::contains($title, 'RSU Fikri Medika') || Str::contains($title, 'RS Fikri Medika')) {
            return $title;
        }

        return "{$title} | {$siteName}";
    }

    /**
     * Build standard Meta Description
     */
    public function formatDescription(?string $desc = null): string
    {
        if (!empty($desc)) {
            return $this->sanitizeText($desc, 160);
        }

        $about = $this->profile?->tr('about');
        if (!empty($about)) {
            return $this->sanitizeText($about, 160);
        }

        return 'RSU Fikri Medika Karawang menyediakan layanan kesehatan terpadu 24 jam, dokter spesialis, IGD, rawat inap, laboratorium, farmasi, dan penunjang medis modern berorientasi Islami.';
    }

    /**
     * Build Canonical URL safely (strips tracking query parameters, normalizes scheme/domain)
     */
    public function getCanonicalUrl(?string $customUrl = null): string
    {
        if (!empty($customUrl)) {
            return $customUrl;
        }

        // Normalize current URL without unnecessary query parameters like ref, fbclid, utm_*, etc.
        $url = url()->current();
        return preg_replace('/\/+$/', '', $url);
    }

    /**
     * Format Image URL for Open Graph & Twitter Card
     */
    public function formatImageUrl(?string $image = null): string
    {
        if (empty($image)) {
            return asset('gedung1_web.jpg');
        }

        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $image;
        }

        $cleanPath = ltrim($image, '/');
        if (Str::startsWith($cleanPath, 'storage/')) {
            $cleanPath = substr($cleanPath, 8);
            return asset('storage/' . $cleanPath);
        }

        if (file_exists(public_path($cleanPath))) {
            return asset($cleanPath);
        }

        if (file_exists(public_path('storage/' . $cleanPath))) {
            return asset('storage/' . $cleanPath);
        }

        return asset($cleanPath);
    }

    /**
     * Generate Schema.org JSON-LD for Hospital Organization
     */
    public function generateHospitalSchema(): array
    {
        $siteUrl = url('/');
        $logoUrl = $this->profile?->logo ? $this->formatImageUrl($this->profile->logo) : asset('logodasboard.png');
        $phone = $this->profile?->phone ?: '(0267) 861-5555';
        $emergencyPhone = $this->profile?->emergency_phone ?: $phone;
        $address = $this->profile?->address ?: 'Jl. Raya Kosambi - Telagasari, Klari, Karawang, Jawa Barat 41371';

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Hospital',
            '@id' => "{$siteUrl}/#hospital",
            'name' => 'RSU Fikri Medika Karawang',
            'legalName' => 'Rumah Sakit Umum Fikri Medika',
            'alternateName' => ['RS Fikri Medika', 'RSU Fikri Medika', 'Fikri Medika Hospital'],
            'url' => $siteUrl,
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $logoUrl,
                'caption' => 'Logo RSU Fikri Medika Karawang'
            ],
            'image' => asset('gedung1_web.jpg'),
            'description' => $this->formatDescription(),
            'telephone' => $phone,
            'emergencyTelephone' => $emergencyPhone,
            'priceRange' => '$$',
            'isAcceptingNewPatients' => true,
            'medicalSpecialty' => [
                'EmergencyMedicine',
                'GeneralPractice',
                'Pediatrics',
                'Obstetrics',
                'Gynecology',
                'Surgery',
                'InternalMedicine',
                'Ophthalmology',
                'Cardiology',
                'Orthopedics'
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $address,
                'addressLocality' => 'Karawang',
                'addressRegion' => 'Jawa Barat',
                'postalCode' => '41371',
                'addressCountry' => 'ID'
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => -6.3475,
                'longitude' => 107.3688
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    'opens' => '00:00',
                    'closes' => '23:59'
                ]
            ],
            'sameAs' => array_values(array_filter([
                $this->profile?->social_links['facebook'] ?? 'https://www.facebook.com/rsufikrimedika',
                $this->profile?->social_links['instagram'] ?? 'https://www.instagram.com/rsufikrimedika',
                $this->profile?->social_links['tiktok'] ?? 'https://www.tiktok.com/@rsufikrimedika',
                $this->profile?->social_links['youtube'] ?? null,
            ]))
        ];
    }

    /**
     * Generate Schema.org JSON-LD for Article
     */
    public function generateArticleSchema(Article $article): array
    {
        $url = route('artikel.show', $article->slug);
        $imageUrl = $this->formatImageUrl($article->thumbnail);
        $publishedAt = $article->published_at ? $article->published_at->toIso8601String() : $article->created_at->toIso8601String();
        $modifiedAt = $article->updated_at ? $article->updated_at->toIso8601String() : $publishedAt;

        return [
            '@context' => 'https://schema.org',
            '@type' => 'MedicalWebPage',
            'headline' => $article->tr('title'),
            'description' => $this->sanitizeText($article->tr('excerpt') ?: $article->tr('content'), 200),
            'url' => $url,
            'image' => [
                '@type' => 'ImageObject',
                'url' => $imageUrl,
            ],
            'datePublished' => $publishedAt,
            'dateModified' => $modifiedAt,
            'inLanguage' => 'id-ID',
            'author' => [
                '@type' => 'Organization',
                'name' => 'Tim Medis RSU Fikri Medika Karawang',
                'url' => url('/')
            ],
            'publisher' => [
                '@type' => 'Hospital',
                'name' => 'RSU Fikri Medika Karawang',
                'url' => url('/'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $this->formatImageUrl($this->profile?->logo ?: asset('logodasboard.png'))
                ]
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $url
            ]
        ];
    }

    /**
     * Generate Schema.org JSON-LD for Event
     */
    public function generateEventSchema(HospitalEvent $event): array
    {
        $url = route('event.show', $event->slug);
        $imageUrl = $this->formatImageUrl($event->image);
        $startDate = $event->event_date ? $event->event_date->format('Y-m-d') : date('Y-m-d');
        if (!empty($event->start_time)) {
            $startDate .= 'T' . $event->start_time;
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Event',
            'name' => $event->tr('title'),
            'description' => $this->sanitizeText($event->tr('short_description') ?: $event->tr('description'), 200),
            'startDate' => $startDate,
            'eventStatus' => 'https://schema.org/EventScheduled',
            'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
            'location' => [
                '@type' => 'Place',
                'name' => $event->location ?: 'RSU Fikri Medika Karawang',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $this->profile?->address ?: 'Jl. Raya Kosambi - Telagasari, Klari',
                    'addressLocality' => 'Karawang',
                    'addressRegion' => 'Jawa Barat',
                    'addressCountry' => 'ID'
                ]
            ],
            'image' => $imageUrl,
            'url' => $url,
            'organizer' => [
                '@type' => 'Organization',
                'name' => 'RSU Fikri Medika Karawang',
                'url' => url('/')
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => ($event->price_type === 'free' || empty($event->price)) ? '0' : (string)$event->price,
                'priceCurrency' => 'IDR',
                'availability' => 'https://schema.org/InStock',
                'url' => $url,
                'validFrom' => $event->created_at->format('Y-m-d')
            ]
        ];

        return $schema;
    }

    /**
     * Generate Schema.org JSON-LD for Physician (Doctor)
     */
    public function generatePhysicianSchema(Doctor $doctor): array
    {
        $specialty = $doctor->specialty_name;
        $docUrl = $doctor->route_url;
        $phone = $this->profile?->phone ?: '(0267) 861-5555';
        $address = $this->profile?->address ?: 'Jl. Raya Kosambi - Telagasari, Klari, Karawang, Jawa Barat 41371';

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Physician',
            '@id' => $docUrl . '#physician',
            'name' => $doctor->full_name,
            'url' => $docUrl,
            'medicalSpecialty' => $specialty,
            'image' => $this->formatImageUrl($doctor->photo),
            'telephone' => $phone,
            'description' => $this->sanitizeText($doctor->tr('bio') ?: "Jadwal dan profil {$doctor->full_name}, {$specialty} di RSU Fikri Medika Karawang."),
            'worksFor' => [
                '@type' => 'Hospital',
                'name' => 'RSU Fikri Medika Karawang',
                'url' => url('/'),
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $address,
                    'addressLocality' => 'Karawang',
                    'addressRegion' => 'Jawa Barat',
                    'postalCode' => '41371',
                    'addressCountry' => 'ID'
                ]
            ],
            'hospitalAffiliation' => [
                '@type' => 'Hospital',
                'name' => 'RSU Fikri Medika Karawang',
                'url' => url('/')
            ]
        ];

        return $schema;
    }

    /**
     * Generate Schema.org JSON-LD for Specialty / Polyclinic Page
     */
    public function generateSpecialtySchema($polyclinic, $doctors = []): array
    {
        $poliName = is_array($polyclinic->name) ? ($polyclinic->name[app()->getLocale()] ?? $polyclinic->name['id'] ?? 'Poliklinik') : $polyclinic->name;
        $specUrl = $polyclinic->route_url;
        $phone = $this->profile?->phone ?: '(0267) 861-5555';

        $physicianList = [];
        foreach ($doctors as $doc) {
            $physicianList[] = [
                '@type' => 'Physician',
                'name' => $doc->full_name,
                'url' => $doc->route_url,
                'image' => $this->formatImageUrl($doc->photo),
                'medicalSpecialty' => $doc->specialty_name
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'MedicalClinic',
            '@id' => $specUrl . '#clinic',
            'name' => "Poli {$poliName} RSU Fikri Medika Karawang",
            'url' => $specUrl,
            'telephone' => $phone,
            'parentOrganization' => [
                '@type' => 'Hospital',
                'name' => 'RSU Fikri Medika Karawang',
                'url' => url('/')
            ],
            'medicalSpecialty' => $poliName,
            'description' => "Layanan dokter spesialis {$poliName} di RSU Fikri Medika Karawang dengan jadwal praktik dan informasi pendaftaran.",
            'employee' => $physicianList
        ];
    }

    /**
     * Generate Schema.org JSON-LD for Doctor Hub Page
     */
    public function generateDoctorHubSchema($doctors = [], $polyclinics = []): array
    {
        $hubUrl = url('/dokter-di-karawang');
        $siteUrl = url('/');
        $phone = $this->profile?->phone ?: '(0267) 861-5555';

        $departments = [];
        foreach ($polyclinics as $poli) {
            $pName = is_array($poli->name) ? ($poli->name[app()->getLocale()] ?? $poli->name['id'] ?? 'Poliklinik') : $poli->name;
            $departments[] = [
                '@type' => 'MedicalClinic',
                'name' => "Poli {$pName}",
                'url' => $poli->route_url
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'MedicalOrganization',
            '@id' => $hubUrl . '#medicalorg',
            'name' => 'Direktori Dokter Spesialis RSU Fikri Medika Karawang',
            'url' => $hubUrl,
            'parentOrganization' => [
                '@type' => 'Hospital',
                'name' => 'RSU Fikri Medika Karawang',
                'url' => $siteUrl
            ],
            'telephone' => $phone,
            'description' => 'Direktori lengkap dokter spesialis dan jadwal praktik dokter di Karawang pada RSU Fikri Medika.',
            'department' => $departments
        ];
    }

    /**
     * Generate Schema.org JSON-LD for Breadcrumbs
     */
    public function generateBreadcrumbSchema(array $items): array
    {
        $itemListElement = [];
        $position = 1;

        foreach ($items as $name => $url) {
            $itemListElement[] = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $name,
                'item' => $url ?: url()->current()
            ];
            $position++;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $itemListElement
        ];
    }
}
