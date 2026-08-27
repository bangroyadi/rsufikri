@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan | RSU Fikri Medika Karawang')
@section('meta_description', 'Mohon maaf, halaman yang Anda tuju tidak ditemukan atau telah dipindahkan di website RSU Fikri Medika Karawang.')
@section('robots', 'noindex, follow')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl w-full bg-white rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100 text-center space-y-6">
        
        {{-- MEDICAL 404 ICON / BADGE --}}
        <div class="relative w-24 h-24 mx-auto flex items-center justify-center rounded-3xl bg-emerald-50 text-[#0e7c47] border border-emerald-100 shadow-xs">
            <i class="fa-solid fa-hospital-user text-4xl"></i>
            <span class="absolute -top-2 -right-2 px-2.5 py-0.5 rounded-full bg-red-500 text-white font-black text-xs shadow-xs">404</span>
        </div>

        <div class="space-y-2">
            <span class="text-xs font-bold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100 uppercase tracking-wider">
                Halaman Tidak Ditemukan
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                Mohon Maaf, Halaman Belum Tersedia
            </h1>
            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed max-w-md mx-auto">
                Tautan yang Anda tuju mungkin sudah dipindahkan, diubah alamatnya, atau sedang dalam proses pembaruan informasi medis.
            </p>
        </div>

        {{-- QUICK LINKS ACTIONS --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
            <a href="{{ url('/') }}"
               class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-[#0e7c47] text-white font-bold text-xs hover:bg-[#096237] transition-all flex items-center justify-center gap-2 shadow-xs cursor-pointer active:scale-95">
                <i class="fa-solid fa-house"></i>
                <span>Kembali ke Beranda</span>
            </a>
            <a href="{{ url('/jadwal-dokter') }}"
               class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-emerald-50 text-[#0e7c47] hover:bg-emerald-100 font-bold text-xs transition-all flex items-center justify-center gap-2 border border-emerald-200 cursor-pointer active:scale-95">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Jadwal Dokter</span>
            </a>
        </div>

        {{-- HELPFUL EMERGENCY & WHATSAPP SUPPORT --}}
        <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
            <div class="flex items-center gap-2 text-red-600 font-bold">
                <i class="fa-solid fa-phone-volume animate-pulse"></i>
                <span>IGD 24 Jam: (0267) 861-5555</span>
            </div>
            <a href="https://wa.me/6289678211575?text=Halo%20RSU%20Fikri%20Medika,%20saya%20membutuhkan%20bantuan%20informasi%20layanan"
               target="_blank"
               class="text-[#0e7c47] hover:underline font-bold flex items-center gap-1.5">
                <i class="fa-brands fa-whatsapp text-sm"></i>
                <span>WhatsApp Customer Care</span>
            </a>
        </div>

    </div>
</div>
@endsection
