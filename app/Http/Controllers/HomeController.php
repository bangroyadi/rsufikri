<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\HospitalProfile;
use App\Models\Banner;
use App\Models\Service;
use App\Models\Polyclinic;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\News;
use App\Models\Article;
use App\Models\TiktokPost;
use App\Models\Promo;
use App\Models\HospitalEvent;
use App\Models\Career;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $profile = HospitalProfile::first();
        $banners = Banner::where('is_active', true)->orderBy('order', 'asc')->get();
        $featuredServices = Service::where('is_active', true)->where('is_featured', true)->orderBy('order', 'asc')->get();
        if ($featuredServices->isEmpty()) {
            $featuredServices = Service::where('is_active', true)->orderBy('order', 'asc')->get();
        }
        $polyclinics = Polyclinic::where('is_active', true)->with(['doctors' => function($q) {
            $q->where('is_active', true)->with('schedules');
        }])->get();
        
        $doctors = Doctor::with(['polyclinic', 'schedules'])
            ->where('is_active', true)
            ->get();
            
        $schedules = DoctorSchedule::with(['doctor', 'polyclinic'])
            ->where('status', 'active')
            ->get();

        $latestNews = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $latestArticles = Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->get();

        $tiktokPosts = TiktokPost::where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        return view('public.home', compact(
            'profile',
            'banners',
            'featuredServices',
            'polyclinics',
            'doctors',
            'schedules',
            'latestNews',
            'latestArticles',
            'tiktokPosts'
        ));
    }

    public function layananPage($slug)
    {
        $layananTitles = [
            'unggulan' => 'Layanan Unggulan RSU Fikri Medika',
            'kemilau-cinta-layanan-ibu-anak' => 'Program Unggulan Kemilau Cinta (Layanan Ibu & Anak)',
            'kemilau-cinta' => 'Program Unggulan Kemilau Cinta (Layanan Ibu & Anak)',
            'rawat-inap' => 'Instalasi Rawat Inap',
            'rawat-jalan' => 'Klinik Rawat Jalan',
            'igd' => 'Instalasi Gawat Darurat (IGD 24 Jam)',
            'igd-24-jam' => 'Instalasi Gawat Darurat (IGD 24 Jam)',
            'rehabilitasi-medik' => 'Instalasi Rehabilitasi Medik',
            'farmasi-24-jam' => 'Pelayanan Farmasi 24 Jam',
            'penunjang-medis' => 'Layanan Penunjang Medis',
            'penunjang-medik' => 'Layanan Penunjang Medis',
            'radiologi-24-jam' => 'Radiologi 24 Jam',
            'laboratorium-klinik' => 'Laboratorium Klinik 24 Jam',
            'laboratorium-patologi' => 'Laboratorium Patologi Anatomi',
        ];

        $service = Service::where('slug', $slug)->first();
        if (!$service) {
            // Try searching case-insensitive or without order
            $service = Service::where('is_active', true)->get()->first(function($s) use ($slug) {
                return $s->slug === $slug || Str::slug($s->tr('name')) === $slug;
            });
        }

        if ($service) {
            $title = $service->tr('name');
        } else {
            $title = $layananTitles[$slug] ?? ucwords(str_replace('-', ' ', $slug));
        }

        $category = 'Layanan';
        $profile = HospitalProfile::first();
        $services = Service::where('is_active', true)->orderBy('order', 'asc')->get();

        if ($slug === 'unggulan') {
            return view('public.layanan.unggulan', compact('title', 'category', 'slug', 'profile', 'services'));
        }

        if ($slug === 'igd' || $slug === 'igd-24-jam') {
            return view('public.layanan.igd', compact('title', 'category', 'slug', 'profile', 'services', 'service'));
        }

        if ($slug === 'rawat-jalan') {
            $polyclinics = \App\Models\Polyclinic::where('is_active', true)->with('doctors')->get();
            return view('public.layanan.rawat-jalan', compact('title', 'category', 'slug', 'profile', 'services', 'polyclinics', 'service'));
        }

        // Layanan Unggulan (Trauma Center, Kemilau Cinta, Spesialis Mata, Antar Jemput Pasien, dll)
        $isFeatured = ($service && $service->is_featured) || in_array($slug, [
            'trauma-center',
            'kemilau-cinta',
            'kemilau-cinta-layanan-ibu-anak',
            'layanan-spesialis-mata',
            'spesialis-mata',
            'layanan-antar-jemput-pasien',
            'antar-jemput-pasien'
        ]);

        if ($isFeatured) {
            return view('public.layanan.unggulan-detail', compact('title', 'category', 'slug', 'profile', 'services', 'service'));
        }

        return view('public.page', compact('title', 'category', 'slug', 'profile', 'services', 'service'));
    }

    public function informasiPage(Request $request, $slug)
    {
        if ($slug === 'artikel-kesehatan' || $slug === 'artikel') {
            return $this->artikelIndex($request);
        }

        if ($slug === 'penawaran-khusus' || $slug === 'promo') {
            return $this->promoPage($request);
        }

        if ($slug === 'event' || $slug === 'agenda') {
            return $this->eventPage($request);
        }

        // Check if slug matches an article
        $article = Article::where('slug', $slug)->where('is_published', true)->first();
        if ($article) {
            return $this->artikelShow($slug);
        }

        if ($slug === 'aduan-layanan' || $slug === 'ikm') {
            abort(404);
        }

        $informasiTitles = [
            'artikel-kesehatan' => 'Artikel Kesehatan',
            'event' => 'Event & Kegiatan Hospital',
            'penawaran-khusus' => 'Penawaran Khusus & Paket Promo',
        ];

        $title = $informasiTitles[$slug] ?? ucwords(str_replace('-', ' ', $slug));
        $category = 'Informasi';
        $profile = HospitalProfile::first();
        $articles = Article::where('is_published', true)->orderBy('published_at', 'desc')->get();
        $news = News::where('is_published', true)->orderBy('published_at', 'desc')->get();

        return view('public.page', compact('title', 'category', 'slug', 'profile', 'articles', 'news'));
    }

    public function eventPage(Request $request)
    {
        $profile = HospitalProfile::first();
        $category = $request->query('kategori', 'all');
        $query = $request->query('q');

        $eventsQuery = HospitalEvent::where('is_active', true)->orderBy('event_date', 'desc')->orderBy('order', 'asc');

        if (!empty($category) && $category !== 'all') {
            $eventsQuery->where('category', $category);
        }

        if (!empty($query)) {
            $eventsQuery->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('category', 'like', "%{$query}%")
                  ->orWhere('location', 'like', "%{$query}%")
                  ->orWhere('short_description', 'like', "%{$query}%");
            });
        }

        $events = $eventsQuery->get();

        // Featured spotlight event: prioritas is_featured, lalu event terbaru (pasca event)
        $featuredEvent = HospitalEvent::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('event_date', 'desc')
            ->first();

        if (!$featuredEvent) {
            $featuredEvent = HospitalEvent::where('is_active', true)
                ->orderBy('event_date', 'desc')
                ->first();
        }

        $categories = HospitalEvent::where('is_active', true)->pluck('category')->unique()->values();

        return view('public.event.index', compact('events', 'featuredEvent', 'categories', 'profile', 'category', 'query'));
    }

    public function eventShow($slug)
    {
        $event = HospitalEvent::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $profile = HospitalProfile::first();

        // Event lainnya (exclude current, ambil 3 terbaru)
        $relatedEvents = HospitalEvent::where('is_active', true)
            ->where('id', '!=', $event->id)
            ->orderBy('event_date', 'desc')
            ->limit(3)
            ->get();

        return view('public.event.show', compact('event', 'profile', 'relatedEvents'));
    }

    public function promoPage(Request $request)
    {
        $profile = HospitalProfile::first();
        $category = $request->query('kategori', 'all');
        $query = $request->query('q');

        $promosQuery = Promo::where('is_active', true)->orderBy('order', 'asc')->orderBy('created_at', 'desc');

        if (!empty($category) && $category !== 'all') {
            $promosQuery->where('category', $category);
        }

        if (!empty($query)) {
            $promosQuery->where(function($q) use ($query) {
                $q->where('title->id', 'like', "%{$query}%")
                  ->orWhere('title->en', 'like', "%{$query}%")
                  ->orWhere('short_description->id', 'like', "%{$query}%")
                  ->orWhere('description->id', 'like', "%{$query}%")
                  ->orWhere('category', 'like', "%{$query}%");
            });
        }

        $promos = $promosQuery->get();
        $featuredPromos = Promo::where('is_active', true)->where('is_featured', true)->orderBy('order', 'asc')->get();
        $categories = Promo::where('is_active', true)->distinct()->pluck('category')->filter()->values();

        return view('public.promo.index', compact('promos', 'featuredPromos', 'categories', 'profile', 'category', 'query'));
    }

    public function promoShow($slug)
    {
        $profile = HospitalProfile::first();
        $promo = Promo::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $otherPromos = Promo::where('is_active', true)->where('id', '!=', $promo->id)->take(3)->get();

        return view('public.promo.index', [
            'promos' => Promo::where('is_active', true)->orderBy('order', 'asc')->get(),
            'featuredPromos' => Promo::where('is_active', true)->where('is_featured', true)->get(),
            'categories' => Promo::where('is_active', true)->distinct()->pluck('category')->filter()->values(),
            'profile' => $profile,
            'category' => 'all',
            'query' => '',
            'activePromoSlug' => $slug,
            'selectedPromo' => $promo,
        ]);
    }

    public function artikelIndex(Request $request)
    {
        $category = $request->query('kategori');
        $query = $request->query('q');

        $articlesQuery = Article::where('is_published', true)->orderBy('published_at', 'desc');

        if (!empty($category) && $category !== 'all') {
            $articlesQuery->where(function($q) use ($category) {
                $q->where('category->id', 'like', "%{$category}%")
                  ->orWhere('category->en', 'like', "%{$category}%");
            });
        }

        if (!empty($query)) {
            $articlesQuery->where(function($q) use ($query) {
                $q->where('title->id', 'like', "%{$query}%")
                  ->orWhere('title->en', 'like', "%{$query}%")
                  ->orWhere('content->id', 'like', "%{$query}%")
                  ->orWhere('content->en', 'like', "%{$query}%")
                  ->orWhere('excerpt->id', 'like', "%{$query}%")
                  ->orWhere('excerpt->en', 'like', "%{$query}%");
            });
        }

        $articles = $articlesQuery->paginate(9)->withQueryString();
        $profile = HospitalProfile::first();

        return view('public.artikel.index', compact('articles', 'profile'));
    }

    public function artikelShow($slug)
    {
        $article = Article::where('slug', $slug)->where('is_published', true)->first();

        if (!$article) {
            // fallback check
            $article = Article::where('is_published', true)->get()->first(function($a) use ($slug) {
                return $a->slug === $slug || Str::slug($a->tr('title')) === $slug;
            });
        }

        if (!$article) {
            abort(404, 'Artikel kesehatan tidak ditemukan');
        }

        $profile = HospitalProfile::first();
        return view('public.artikel.show', compact('article', 'profile'));
    }

    public function profilPage()
    {
        $title = 'Profil RSU Fikri Medika';
        $category = 'Profil';
        $slug = 'profil';
        $profile = HospitalProfile::first();
        return view('public.profil', compact('title', 'category', 'slug', 'profile'));
    }

    public function jadwalDokterPage()
    {
        $title = 'Jadwal Dokter Spesialis';
        $category = 'Jadwal Dokter';
        $slug = 'jadwal-dokter';
        $profile = HospitalProfile::first();
        $doctors = Doctor::with(['polyclinic', 'schedules'])->where('is_active', true)->get();
        $polyclinics = Polyclinic::where('is_active', true)->get();
        return view('public.jadwal-dokter', compact('title', 'category', 'slug', 'profile', 'doctors', 'polyclinics'));
    }

    public function lokasiPage()
    {
        $title = 'Lokasi Strategis & Petunjuk Arah';
        $category = 'Lokasi';
        $slug = 'lokasi';
        $profile = HospitalProfile::first();
        return view('public.lokasi', compact('title', 'category', 'slug', 'profile'));
    }

    public function kontakPage()
    {
        return $this->lokasiPage();
    }

    public function karirPage(Request $request)
    {
        $profile = HospitalProfile::first();
        $department = $request->query('dept', 'all');
        $type = $request->query('type', 'all');
        $query = $request->query('q');

        $careersQuery = Career::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');

        if (!empty($department) && $department !== 'all') {
            $careersQuery->where('department', $department);
        }

        if (!empty($type) && $type !== 'all') {
            $careersQuery->where('employment_type', $type);
        }

        if (!empty($query)) {
            $careersQuery->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('department', 'like', "%{$query}%")
                  ->orWhere('location', 'like', "%{$query}%")
                  ->orWhere('education_level', 'like', "%{$query}%")
                  ->orWhere('short_description', 'like', "%{$query}%");
            });
        }

        $careers = $careersQuery->get();
        $departments = Career::where('is_active', true)->pluck('department')->unique()->values();
        $types = Career::where('is_active', true)->pluck('employment_type')->unique()->values();

        return view('public.karir.index', compact('careers', 'departments', 'types', 'profile', 'department', 'type', 'query'));
    }

    public function karirShow($slug)
    {
        $career = Career::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $profile = HospitalProfile::first();

        // Other open vacancies
        $otherCareers = Career::where('is_active', true)
            ->where('id', '!=', $career->id)
            ->where('status', 'open')
            ->orderBy('order', 'asc')
            ->limit(3)
            ->get();

        return view('public.karir.show', compact('career', 'profile', 'otherCareers'));
    }

    public function karirApply(Request $request, $slug)
    {
        $career = Career::where('slug', $slug)->where('is_active', true)->firstOrFail();

        if (!$career->is_open) {
            return back()->withErrors(['msg' => 'Mohon maaf, lowongan posisi ini sudah ditutup.'])->withInput();
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'last_education' => 'required|string|max:100',
            'experience_years' => 'nullable|string|max:100',
            'str_number' => 'nullable|string|max:100',
            'portfolio_url' => 'nullable|string|max:500',
            'cover_letter' => 'nullable|string|max:3000',
            'cv_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:15360', // Maks 15MB
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email aktif wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor WhatsApp / HP wajib diisi.',
            'last_education.required' => 'Pendidikan terakhir wajib dipilih.',
            'cv_file.required' => 'Berkas CV / Resume wajib diunggah.',
            'cv_file.mimes' => 'Format file CV harus berupa PDF, DOC, atau DOCX.',
            'cv_file.max' => 'Ukuran file CV maksimal adalah 15 MB.',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv_file') && $request->file('cv_file')->isValid()) {
            $file = $request->file('cv_file');
            $filename = 'CV_' . Str::slug($validated['full_name']) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('applications/cv', $filename, 'public');
            $cvPath = 'storage/' . $path;
        }

        JobApplication::create([
            'career_id' => $career->id,
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'last_education' => $validated['last_education'],
            'experience_years' => $validated['experience_years'] ?? 'Fresh Graduate',
            'str_number' => $validated['str_number'] ?? null,
            'cv_file' => $cvPath,
            'portfolio_url' => $validated['portfolio_url'] ?? null,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('karir.show', $career->slug)
            ->with('apply_success', 'Lamaran Anda untuk posisi ' . $career->tr('title') . ' berhasil dikirimkan! Tim HRD RSU Fikri Medika akan meninjau berkas Anda.');
    }

    public function buatJanjiPage(Request $request)
    {
        $title = 'Daftar / Buat Janji Temu Dokter';
        $category = 'Pendaftaran';
        $slug = 'buat-janji';
        $profile = HospitalProfile::first();
        $doctors = Doctor::with(['polyclinic', 'schedules'])->where('is_active', true)->get();
        $polyclinics = Polyclinic::where('is_active', true)->get();
        $selectedDoctorId = $request->query('dokter_id') ?? $request->query('dokter');
        $selectedPoliId = $request->query('poli_id') ?? $request->query('poli');

        return view('public.buat-janji', compact('title', 'category', 'slug', 'profile', 'doctors', 'polyclinics', 'selectedDoctorId', 'selectedPoliId'));
    }
}


