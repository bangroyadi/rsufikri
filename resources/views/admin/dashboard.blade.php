@extends('layouts.admin')

@section('title', 'Dashboard Summary')

@section('content')
<div class="space-y-8">
    
    <!-- WELCOME HERO BANNER -->
    <div style="background: linear-gradient(135deg, #062c19 0%, #0e7c47 60%, #159b5a 100%); color: #ffffff;" class="relative rounded-3xl p-8 shadow-xl overflow-hidden">
        <div class="relative z-10 space-y-3 max-w-3xl">
            <div style="background-color: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); color: #fde047;" class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-extrabold">
                <i class="fa-solid fa-sparkles"></i>
                <span>Selamat Datang Kembali</span>
            </div>
            
            <h2 class="text-3xl font-black tracking-tight text-white">
                Halo, {{ Auth::user()?->name ?? 'Administrator' }}! 👋
            </h2>
            
            <p style="color: #d1fae5;" class="text-sm leading-relaxed">
                Sistem Manajemen Konten (CMS) RSU Fikri Medika. Kelola data dokter, jadwal praktik, fasilitas medis, hingga publikasi berita dan artikel kesehatan dari satu tempat.
            </p>
        </div>
    </div>

    <!-- METRIC CARDS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- CARD 1: DOKTER -->
        <a href="{{ route('admin.doctors.index') }}" style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl p-6 shadow-xs hover:shadow-lg transition-all duration-300 flex items-center justify-between group">
            <div class="space-y-1">
                <div class="text-xs font-black text-slate-400 uppercase tracking-wider">Dokter Spesialis</div>
                <div style="color: #0f172a;" class="text-3xl font-black">{{ $totalDoctors }}</div>
                <div style="color: #0e7c47;" class="text-xs font-bold flex items-center gap-1.5">
                    <span style="background-color: #0e7c47;" class="w-2 h-2 rounded-full inline-block"></span>
                    <span>Aktif Melayani</span>
                </div>
            </div>
            <div style="background: linear-gradient(135deg, #0e7c47 0%, #159b5a 100%); color: #ffffff;" class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl font-bold shadow-md shrink-0 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
        </a>

        <!-- CARD 2: JADWAL -->
        <a href="{{ route('admin.schedules.index') }}" style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl p-6 shadow-xs hover:shadow-lg transition-all duration-300 flex items-center justify-between group">
            <div class="space-y-1">
                <div class="text-xs font-black text-slate-400 uppercase tracking-wider">Jadwal Praktik</div>
                <div style="color: #0f172a;" class="text-3xl font-black">{{ $totalSchedules }}</div>
                <div style="color: #d97706;" class="text-xs font-bold flex items-center gap-1.5">
                    <span style="background-color: #d97706;" class="w-2 h-2 rounded-full inline-block"></span>
                    <span>Slot Mingguan</span>
                </div>
            </div>
            <div style="background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); color: #022c22;" class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl font-bold shadow-md shrink-0 group-hover:scale-105 transition-transform">
                <i class="fa-regular fa-calendar-check"></i>
            </div>
        </a>

        <!-- CARD 3: POLIKLINIK -->
        <a href="{{ route('admin.polyclinics.index') }}" style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl p-6 shadow-xs hover:shadow-lg transition-all duration-300 flex items-center justify-between group">
            <div class="space-y-1">
                <div class="text-xs font-black text-slate-400 uppercase tracking-wider">Poli / Departemen</div>
                <div style="color: #0f172a;" class="text-3xl font-black">{{ $totalPolyclinics }}</div>
                <div style="color: #0e7c47;" class="text-xs font-bold flex items-center gap-1.5">
                    <span style="background-color: #0e7c47;" class="w-2 h-2 rounded-full inline-block"></span>
                    <span>Poliklinik Spesialis</span>
                </div>
            </div>
            <div style="background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%); color: #ffffff;" class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl font-bold shadow-md shrink-0 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-clinic-medical"></i>
            </div>
        </a>

        <!-- CARD 4: LAYANAN -->
        <a href="{{ route('admin.services.index') }}" style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl p-6 shadow-xs hover:shadow-lg transition-all duration-300 flex items-center justify-between group">
            <div class="space-y-1">
                <div class="text-xs font-black text-slate-400 uppercase tracking-wider">Fasilitas & Layanan</div>
                <div style="color: #0f172a;" class="text-3xl font-black">{{ $totalServices }}</div>
                <div style="color: #2563eb;" class="text-xs font-bold flex items-center gap-1.5">
                    <span style="background-color: #2563eb;" class="w-2 h-2 rounded-full inline-block"></span>
                    <span>Layanan Medis</span>
                </div>
            </div>
            <div style="background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); color: #ffffff;" class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl font-bold shadow-md shrink-0 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-briefcase-medical"></i>
            </div>
        </a>

        <!-- CARD 5: BERITA -->
        <a href="{{ route('admin.news.index') }}" style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl p-6 shadow-xs hover:shadow-lg transition-all duration-300 flex items-center justify-between group">
            <div class="space-y-1">
                <div class="text-xs font-black text-slate-400 uppercase tracking-wider">Berita RS</div>
                <div style="color: #0f172a;" class="text-3xl font-black">{{ $totalNews }}</div>
                <div style="color: #9333ea;" class="text-xs font-bold flex items-center gap-1.5">
                    <span style="background-color: #9333ea;" class="w-2 h-2 rounded-full inline-block"></span>
                    <span>Publikasi Aktif</span>
                </div>
            </div>
            <div style="background: linear-gradient(135deg, #9333ea 0%, #a855f7 100%); color: #ffffff;" class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl font-bold shadow-md shrink-0 group-hover:scale-105 transition-transform">
                <i class="fa-regular fa-newspaper"></i>
            </div>
        </a>

        <!-- CARD 6: ARTIKEL -->
        <a href="{{ route('admin.articles.index') }}" style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl p-6 shadow-xs hover:shadow-lg transition-all duration-300 flex items-center justify-between group">
            <div class="space-y-1">
                <div class="text-xs font-black text-slate-400 uppercase tracking-wider">Artikel Kesehatan</div>
                <div style="color: #0f172a;" class="text-3xl font-black">{{ $totalArticles }}</div>
                <div style="color: #0e7c47;" class="text-xs font-bold flex items-center gap-1.5">
                    <span style="background-color: #0e7c47;" class="w-2 h-2 rounded-full inline-block"></span>
                    <span>Edukasi Medis</span>
                </div>
            </div>
            <div style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: #ffffff;" class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl font-bold shadow-md shrink-0 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-file-medical"></i>
            </div>
        </a>

    </div>

    <!-- CLEAN QUICK ACTIONS SECTION -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl p-6 sm:p-8 shadow-xs space-y-6">
        <div style="border-bottom: 1px solid #f1f5f9;" class="pb-4 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-black text-slate-900">Aksi Cepat Tambah Data</h3>
                <p class="text-xs text-slate-500 mt-0.5">Pintasan cepat untuk menambahkan konten baru ke sistem.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <a href="{{ route('admin.doctors.index') }}" style="background-color: #f0fdf4; border: 1px solid #bbf7d0;" class="p-5 rounded-2xl transition-all hover:shadow-md hover:scale-[1.02] flex items-center gap-4 group">
                <div style="background-color: #0e7c47; color: #ffffff;" class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-xl shrink-0 shadow-sm">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div>
                    <h4 style="color: #0e7c47;" class="font-extrabold text-sm">Dokter Baru</h4>
                    <p class="text-xs text-slate-600 mt-0.5">Tambah data dokter</p>
                </div>
            </a>

            <a href="{{ route('admin.schedules.index') }}" style="background-color: #fffbeb; border: 1px solid #fde68a;" class="p-5 rounded-2xl transition-all hover:shadow-md hover:scale-[1.02] flex items-center gap-4 group">
                <div style="background-color: #d97706; color: #ffffff;" class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-xl shrink-0 shadow-sm">
                    <i class="fa-regular fa-calendar-plus"></i>
                </div>
                <div>
                    <h4 style="color: #b45309;" class="font-extrabold text-sm">Slot Jadwal</h4>
                    <p class="text-xs text-slate-600 mt-0.5">Buat jadwal praktik</p>
                </div>
            </a>

            <a href="{{ route('admin.news.index') }}" style="background-color: #faf5ff; border: 1px solid #e9d5ff;" class="p-5 rounded-2xl transition-all hover:shadow-md hover:scale-[1.02] flex items-center gap-4 group">
                <div style="background-color: #9333ea; color: #ffffff;" class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-xl shrink-0 shadow-sm">
                    <i class="fa-regular fa-paper-plane"></i>
                </div>
                <div>
                    <h4 style="color: #7e22ce;" class="font-extrabold text-sm">Tulis Berita</h4>
                    <p class="text-xs text-slate-600 mt-0.5">Publikasi berita RS</p>
                </div>
            </a>

            <a href="{{ route('admin.articles.index') }}" style="background-color: #f0fdf4; border: 1px solid #a7f3d0;" class="p-5 rounded-2xl transition-all hover:shadow-md hover:scale-[1.02] flex items-center gap-4 group">
                <div style="background-color: #059669; color: #ffffff;" class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-xl shrink-0 shadow-sm">
                    <i class="fa-solid fa-file-circle-plus"></i>
                </div>
                <div>
                    <h4 style="color: #047857;" class="font-extrabold text-sm">Artikel Baru</h4>
                    <p class="text-xs text-slate-600 mt-0.5">Edukasi kesehatan</p>
                </div>
            </a>
        </div>
    </div>

</div>
@endsection
