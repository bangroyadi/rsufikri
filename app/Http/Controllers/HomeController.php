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
        $polyclinics = Polyclinic::where('is_active', true)->get();
        
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
            ->take(3)
            ->get();

        return view('public.home', compact(
            'profile',
            'banners',
            'featuredServices',
            'polyclinics',
            'doctors',
            'schedules',
            'latestNews',
            'latestArticles'
        ));
    }

    public function layananPage($slug)
    {
        $layananTitles = [
            'igd' => 'Instalasi Gawat Darurat (IGD 24 Jam)',
            'rawat-jalan' => 'Instalasi Rawat Jalan',
            'rawat-inap' => 'Instalasi Rawat Inap',
            'penunjang-medik' => 'Penunjang Medik',
            'unggulan' => 'Layanan Unggulan',
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

        if ($slug === 'igd' || $slug === 'igd-24-jam') {
            return view('public.layanan.igd', compact('title', 'category', 'slug', 'profile', 'services', 'service'));
        }

        if ($slug === 'rawat-jalan') {
            $polyclinics = \App\Models\Polyclinic::where('is_active', true)->with('doctors')->get();
            return view('public.layanan.rawat-jalan', compact('title', 'category', 'slug', 'profile', 'services', 'polyclinics', 'service'));
        }

        return view('public.page', compact('title', 'category', 'slug', 'profile', 'services', 'service'));
    }

    public function informasiPage($slug)
    {
        $informasiTitles = [
            'artikel-kesehatan' => 'Artikel Kesehatan',
            'event' => 'Event & Kegiatan Hospital',
            'penawaran-khusus' => 'Penawaran Khusus & Paket Promo',
            'aduan-layanan' => 'Aduan & Layanan Pelanggan',
            'ikm' => 'Indeks Kepuasan Masyarakat (IKM)',
        ];

        $title = $informasiTitles[$slug] ?? ucwords(str_replace('-', ' ', $slug));
        $category = 'Informasi';
        $profile = HospitalProfile::first();
        $articles = Article::where('is_published', true)->orderBy('published_at', 'desc')->get();
        $news = News::where('is_published', true)->orderBy('published_at', 'desc')->get();

        return view('public.page', compact('title', 'category', 'slug', 'profile', 'articles', 'news'));
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

    public function kontakPage()
    {
        $title = 'Kontak & Lokasi';
        $category = 'Kontak';
        $slug = 'kontak';
        $profile = HospitalProfile::first();
        return view('public.page', compact('title', 'category', 'slug', 'profile'));
    }

    public function karirPage()
    {
        $title = 'Karir & Rekrutmen';
        $category = 'Karir';
        $slug = 'karir';
        $profile = HospitalProfile::first();
        return view('public.page', compact('title', 'category', 'slug', 'profile'));
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


