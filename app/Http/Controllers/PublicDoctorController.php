<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Doctor;
use App\Models\Polyclinic;
use App\Models\DoctorSchedule;
use App\Models\HospitalProfile;
use App\Models\Article;
use App\Services\SeoService;

class PublicDoctorController extends Controller
{
    protected SeoService $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * FASE 4: Doctor SEO Hub Page
     * URL: /dokter-di-karawang
     */
    public function hub(Request $request)
    {
        $profile = HospitalProfile::first();
        
        $polyclinics = Polyclinic::where('is_active', true)
            ->with(['doctors' => function($q) {
                $q->where('is_active', true)->with('schedules');
            }])
            ->get();

        $doctors = Doctor::where('is_active', true)
            ->with(['polyclinic', 'schedules'])
            ->orderBy('name', 'asc')
            ->get();

        $featuredArticles = Article::where('is_published', true)
            ->where(function($q) {
                $q->where('slug', 'like', '%dokter%')
                  ->orWhere('title->id', 'like', '%dokter%')
                  ->orWhere('category->id', 'like', '%dokter%');
            })
            ->take(3)
            ->get();

        if ($featuredArticles->isEmpty()) {
            $featuredArticles = Article::where('is_published', true)->latest()->take(3)->get();
        }

        $pageTitle = 'Dokter di Karawang – Jadwal Dokter | RSU Fikri Medika';
        $pageDescription = 'Temukan dokter spesialis di Karawang di RSU Fikri Medika. Lihat profil dokter, spesialisasi, jadwal praktik, layanan dan informasi pendaftaran.';
        $canonicalUrl = url('/dokter-di-karawang');

        return view('public.dokter.hub', compact(
            'profile',
            'polyclinics',
            'doctors',
            'featuredArticles',
            'pageTitle',
            'pageDescription',
            'canonicalUrl'
        ));
    }

    /**
     * Smart Route Resolver for /dokter/{slug}
     * Resolves between Specialty Hub Pages and Individual Doctor Profile Pages
     */
    public function resolveDoctorRoute(Request $request, string $slug)
    {
        $cleanSlug = trim($slug);

        // 1. Check if slug matches a Specialty / Polyclinic pattern
        // Normalize slug: strip '-karawang' or '-di-karawang' if present to check base slug
        $baseSpecialtySlug = preg_replace('/-(di-)?karawang$/', '', $cleanSlug);

        // Polyclinic alias mapping for common local search keywords
        $specialtyAliases = [
            'penyakit-dalam' => 'penyakit-dalam',
            'sp-pd' => 'penyakit-dalam',
            'sppd' => 'penyakit-dalam',
            'anak' => 'anak',
            'pediatrik' => 'anak',
            'sp-a' => 'anak',
            'spa' => 'anak',
            'kandungan' => 'obgyn-kandungan',
            'kebidanan' => 'obgyn-kandungan',
            'obgyn' => 'obgyn-kandungan',
            'obgyn-kandungan' => 'obgyn-kandungan',
            'sp-og' => 'obgyn-kandungan',
            'spog' => 'obgyn-kandungan',
            'bedah' => 'bedah',
            'bedah-umum' => 'bedah',
            'sp-b' => 'bedah',
            'spb' => 'bedah',
            'mata' => 'mata',
            'sp-m' => 'mata',
            'spm' => 'mata',
            'jantung' => 'jantung',
            'kardiologi' => 'jantung',
            'sp-jp' => 'jantung',
            'spjp' => 'jantung',
            'paru' => 'paru',
            'pulmonologi' => 'paru',
            'sp-p' => 'paru',
            'spp' => 'paru',
            'ortopedi' => 'orthopedi',
            'orthopedi' => 'orthopedi',
            'tulang' => 'orthopedi',
            'sp-ot' => 'orthopedi',
            'spot' => 'orthopedi',
            'tht' => 'tht-kl',
            'tht-kl' => 'tht-kl',
            'sp-tht' => 'tht-kl',
            'sp-tht-kl' => 'tht-kl',
            'sptht-kl' => 'tht-kl',
            'saraf' => 'neurologi-saraf',
            'neurologi' => 'neurologi-saraf',
            'neurologi-saraf' => 'neurologi-saraf',
            'sp-n' => 'neurologi-saraf',
            'spn' => 'neurologi-saraf',
            'bedah-saraf' => 'bedah-saraf',
            'sp-bs' => 'bedah-saraf',
            'spbs' => 'bedah-saraf',
            'jiwa' => 'jiwa',
            'psikiatri' => 'jiwa',
            'sp-kj' => 'jiwa',
            'spkj' => 'jiwa',
            'kulit' => 'kulit-dan-kelamin',
            'kulit-kelamin' => 'kulit-dan-kelamin',
            'kulit-dan-kelamin' => 'kulit-dan-kelamin',
            'sp-dve' => 'kulit-dan-kelamin',
            'spdve' => 'kulit-dan-kelamin',
            'rehab-medik' => 'rehab-medik',
            'rehabilitasi-medik' => 'rehab-medik',
            'sp-kfr' => 'rehab-medik',
            'gigi' => 'gigi',
            'dokter-gigi' => 'gigi',
            'gigi-periodonti' => 'spesialis-gigi-periodonti',
            'spesialis-gigi-periodonti' => 'spesialis-gigi-periodonti',
            'periodonti' => 'spesialis-gigi-periodonti',
            'bedah-mulut' => 'bedah-mulut',
            'sp-bm' => 'bedah-mulut',
            'spbm' => 'bedah-mulut',
            'urologi' => 'urologi',
            'sp-u' => 'urologi',
            'spu' => 'urologi',
            'radiologi' => 'radiologi',
            'sp-rad' => 'radiologi',
        ];

        $targetPoliSlug = $specialtyAliases[$baseSpecialtySlug] ?? null;

        if (!$targetPoliSlug) {
            // Check direct match in Polyclinics table
            $directPoli = Polyclinic::where('slug', $baseSpecialtySlug)->first();
            if ($directPoli) {
                $targetPoliSlug = $directPoli->slug;
            }
        }

        if ($targetPoliSlug) {
            $polyclinic = Polyclinic::where('slug', $targetPoliSlug)
                ->where('is_active', true)
                ->first();

            if ($polyclinic) {
                return $this->specialtyView($request, $polyclinic, $cleanSlug);
            }
        }

        // 2. Check if slug matches an Individual Doctor
        $hasSlugColumn = \Illuminate\Support\Facades\Schema::hasColumn('doctors', 'slug');
        $doctor = null;

        if ($hasSlugColumn) {
            $doctor = Doctor::where('slug', $cleanSlug)
                ->where('is_active', true)
                ->with(['polyclinic', 'schedules', 'articles'])
                ->first();
        }

        if (!$doctor) {
            // Normalize slug by removing duplicate repeated suffixes (e.g. -spdve-spdve -> -spdve)
            $normalizedSlug = preg_replace('/(-[a-z0-9]+)\1+$/i', '$1', $cleanSlug);
            if ($hasSlugColumn && $normalizedSlug !== $cleanSlug) {
                $doctor = Doctor::where('slug', $normalizedSlug)
                    ->where('is_active', true)
                    ->with(['polyclinic', 'schedules', 'articles'])
                    ->first();

                if ($doctor) {
                    return redirect()->to($doctor->route_url, 301);
                }
            }

            // Fallback: search in-memory by name, title, or ID
            $doctor = Doctor::where('is_active', true)
                ->with(['polyclinic', 'schedules', 'articles'])
                ->get()
                ->first(function($d) use ($cleanSlug, $hasSlugColumn) {
                    $slugAttr = $hasSlugColumn ? $d->slug : null;
                    return $slugAttr === $cleanSlug 
                        || Str::slug($d->name) === $cleanSlug 
                        || Str::slug($d->name . ' ' . $d->title_degree) === $cleanSlug
                        || (string)$d->id === $cleanSlug;
                });
        }

        if ($doctor) {
            return $this->doctorShowView($request, $doctor);
        }

        // If not found in doctors or specialties
        abort(404, 'Halaman dokter atau spesialisasi di Karawang tidak ditemukan.');
    }

    /**
     * FASE 6: Dynamic Specialty Page View
     */
    protected function specialtyView(Request $request, Polyclinic $polyclinic, string $requestedSlug)
    {
        $profile = HospitalProfile::first();
        $doctors = Doctor::where('polyclinic_id', $polyclinic->id)
            ->where('is_active', true)
            ->with('schedules')
            ->orderBy('name', 'asc')
            ->get();

        $allPolyclinics = Polyclinic::where('is_active', true)
            ->where('id', '!=', $polyclinic->id)
            ->get();

        // Relevant articles
        $poliNameId = is_array($polyclinic->name) ? ($polyclinic->name['id'] ?? $polyclinic->name['en'] ?? '') : $polyclinic->name;
        $relatedArticles = Article::where('is_published', true)
            ->where(function($q) use ($poliNameId, $polyclinic) {
                $q->where('title->id', 'like', "%{$poliNameId}%")
                  ->orWhere('content->id', 'like', "%{$poliNameId}%")
                  ->orWhere('category->id', 'like', "%{$polyclinic->slug}%");
            })
            ->take(3)
            ->get();

        if ($relatedArticles->isEmpty()) {
            $relatedArticles = Article::where('is_published', true)->latest()->take(3)->get();
        }

        // Canonical URL always points to /dokter/{slug}-karawang
        $canonicalUrl = url('/dokter/' . $polyclinic->slug . '-karawang');

        $cleanPoliName = $poliNameId;
        // Strip prefix "Poli " for nice title
        $cleanPoliNameOnly = preg_replace('/^Poli\s+/i', '', $cleanPoliName);

        $pageTitle = "Dokter Spesialis {$cleanPoliNameOnly} di Karawang | RSU Fikri Medika";
        $pageH1 = "Dokter Spesialis {$cleanPoliNameOnly} di Karawang";
        $pageDescription = "Temukan dokter spesialis {$cleanPoliNameOnly} di RSU Fikri Medika Karawang beserta profil, jadwal praktik harian, poliklinik dan informasi pendaftaran janji temu.";

        return view('public.dokter.specialty', compact(
            'polyclinic',
            'doctors',
            'allPolyclinics',
            'relatedArticles',
            'profile',
            'pageTitle',
            'pageH1',
            'pageDescription',
            'cleanPoliNameOnly',
            'canonicalUrl'
        ));
    }

    /**
     * FASE 7: Doctor Detail Profile Page View
     */
    protected function doctorShowView(Request $request, Doctor $doctor)
    {
        $profile = HospitalProfile::first();
        
        // Peer doctors in the same polyclinic
        $otherDoctors = Doctor::where('polyclinic_id', $doctor->polyclinic_id)
            ->where('id', '!=', $doctor->id)
            ->where('is_active', true)
            ->with('schedules')
            ->take(4)
            ->get();

        // Related articles by doctor or category
        $relatedArticles = $doctor->articles()->where('is_published', true)->take(3)->get();
        if ($relatedArticles->isEmpty()) {
            $specName = $doctor->specialty_name;
            $relatedArticles = Article::where('is_published', true)
                ->where(function($q) use ($specName) {
                    $q->where('title->id', 'like', "%{$specName}%")
                      ->orWhere('content->id', 'like', "%{$specName}%");
                })
                ->take(3)
                ->get();
        }
        if ($relatedArticles->isEmpty()) {
            $relatedArticles = Article::where('is_published', true)->latest()->take(3)->get();
        }

        $canonicalUrl = $doctor->route_url;
        $specialtyText = $doctor->specialty_name;
        $fullName = $doctor->full_name;

        $pageTitle = "{$fullName}, {$specialtyText} di Karawang | RSU Fikri Medika";
        $pageH1 = $fullName;
        $pageDescription = "Jadwal praktik dan profil {$fullName}, dokter spesialis {$specialtyText} di RSU Fikri Medika Karawang. Informasi poliklinik, jam praktik, dan pendaftaran janji temu.";

        return view('public.dokter.show', compact(
            'doctor',
            'profile',
            'otherDoctors',
            'relatedArticles',
            'pageTitle',
            'pageH1',
            'pageDescription',
            'canonicalUrl'
        ));
    }
}
