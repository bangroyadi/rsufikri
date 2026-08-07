@extends('layouts.admin')

@section('title', 'Dashboard Summary')

@section('content')
<div class="space-y-8">
    
    <!-- WELCOME CARD -->
    <div class="bg-gradient-to-r from-[#1b4332] to-[#2d6a4f] rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10 space-y-2">
            <h2 class="text-2xl font-extrabold">Selamat Datang, {{ Auth::user()?->name }}!</h2>
            <p class="text-emerald-100 text-sm max-w-2xl">
                Sistem Manajemen Konten (CMS) RSU Fikri Medika. Kelola data dokter, jadwal praktik, fasilitas layanan, berita, artikel, dan profil rumah sakit.
            </p>
        </div>
    </div>

    <!-- STATS METRIC CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Dokter</div>
                <div class="text-3xl font-extrabold text-[#1b4332] mt-1">{{ $totalDoctors }}</div>
                <div class="text-xs text-emerald-600 font-semibold mt-1">Dokter Aktif</div>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-[#1b4332] flex items-center justify-center text-2xl font-bold">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Jadwal Praktik</div>
                <div class="text-3xl font-extrabold text-[#1b4332] mt-1">{{ $totalSchedules }}</div>
                <div class="text-xs text-amber-600 font-semibold mt-1">Slot Jadwal</div>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center text-2xl font-bold">
                <i class="fa-regular fa-calendar-check"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Layanan RS</div>
                <div class="text-3xl font-extrabold text-[#1b4332] mt-1">{{ $totalServices }}</div>
                <div class="text-xs text-emerald-600 font-semibold mt-1">Fasilitas Medis</div>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-[#1b4332] flex items-center justify-center text-2xl font-bold">
                <i class="fa-solid fa-briefcase-medical"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Poliklinik</div>
                <div class="text-3xl font-extrabold text-[#1b4332] mt-1">{{ $totalPolyclinics }}</div>
                <div class="text-xs text-emerald-600 font-semibold mt-1">Spesialisasi</div>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-[#1b4332] flex items-center justify-center text-2xl font-bold">
                <i class="fa-solid fa-clinic-medical"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Berita</div>
                <div class="text-3xl font-extrabold text-[#1b4332] mt-1">{{ $totalNews }}</div>
                <div class="text-xs text-[#2d6a4f] font-semibold mt-1">Publikasi RS</div>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-[#1b4332] flex items-center justify-center text-2xl font-bold">
                <i class="fa-regular fa-newspaper"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Artikel Kesehatan</div>
                <div class="text-3xl font-extrabold text-[#1b4332] mt-1">{{ $totalArticles }}</div>
                <div class="text-xs text-emerald-600 font-semibold mt-1">Edukasi Medis</div>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-[#1b4332] flex items-center justify-center text-2xl font-bold">
                <i class="fa-solid fa-file-medical"></i>
            </div>
        </div>

    </div>

</div>
@endsection
