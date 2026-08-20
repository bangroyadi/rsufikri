@extends('layouts.app')

@section('title', 'Lokasi & Peta RSU Fikri Medika')

@section('content')
<!-- BREADCRUMB & HERO HEADER -->
<div class="bg-gradient-to-b from-emerald-50/70 to-white border-b border-gray-200 py-10 lg:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- BREADCRUMB -->
        <nav class="flex items-center gap-2 text-xs font-bold text-gray-700 mb-4">
            <a href="{{ route('home') }}" class="hover:text-[#0e7c47] transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-house text-[#0e7c47]"></i>
                <span>{{ __('Beranda') }}</span>
            </a>
            <i class="fa-solid fa-chevron-right text-[10px] text-gray-500"></i>
            <span class="text-[#0e7c47] font-extrabold">{{ __('Lokasi & Peta') }}</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-[#0e7c47] mb-2.5">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>{{ __('Lokasi Strategis') }}</span>
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 tracking-tight">
                    {{ __('Lokasi & Petunjuk Arah') }}
                </h1>
                <p class="text-gray-800 text-sm sm:text-base mt-2 max-w-2xl font-medium leading-relaxed">
                    {{ __('Kunjungi RSU Fikri Medika dengan mudah. Terletak strategis di jalur utama Klari - Kosambi dengan akses cepat dan fasilitas parkir yang luas.') }}
                </p>
            </div>

            <!-- DIRECT NAVIGATION ACTION BUTTON -->
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="https://maps.google.com/?q=RSU+Fikri+Medika+Karawang" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white text-xs sm:text-sm font-bold shadow-md shadow-emerald-900/15 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-map-location-dot text-base"></i>
                    <span>{{ __('Buka di Google Maps') }}</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] opacity-80"></i>
                </a>
            </div>
        </div>

    </div>
</div>

<!-- MAIN CONTENT SECTION -->
<div class="py-12 lg:py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
            
            <!-- LEFT INFORMATION CARDS (5 COLS) -->
            <div class="lg:col-span-5 space-y-5">
                
                <!-- CARD 1: ALAMAT LENGKAP -->
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center font-bold text-lg shrink-0 border border-emerald-200 shadow-xs">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div class="space-y-1.5 flex-1">
                            <h3 class="font-black text-gray-900 text-base">
                                {{ __('Alamat Lengkap') }}
                            </h3>
                            <p class="text-sm text-gray-800 leading-relaxed font-semibold">
                                Jl. Raya Kosambi - Telagasari No. 9, Belendung, Kec. Klari, Kabupaten Karawang, Jawa Barat 41371
                            </p>
                            <div class="pt-2">
                                <a href="https://maps.google.com/?q=RSU+Fikri+Medika+Karawang" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-[#0e7c47] hover:underline">
                                    <span>{{ __('Petunjuk Rute') }}</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: JAM OPERASIONAL & LAYANAN -->
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center font-bold text-lg shrink-0 border border-emerald-200 shadow-xs">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div class="space-y-1.5 flex-1">
                            <h3 class="font-black text-gray-900 text-base">
                                {{ __('Jam Operasional') }}
                            </h3>
                            <div class="space-y-2 text-xs sm:text-sm text-gray-800 pt-1 font-semibold">
                                <div class="flex items-center justify-between py-1 border-b border-gray-100">
                                    <span class="font-bold text-gray-900">{{ __('IGD 24 Jam & Rawat Inap') }}</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-[#0e7c47] font-extrabold text-[11px]">{{ __('24 Jam Nonstop') }}</span>
                                </div>
                                <div class="flex items-center justify-between py-1 border-b border-gray-100">
                                    <span class="font-bold text-gray-900">{{ __('Farmasi & Laboratorium') }}</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-[#0e7c47] font-extrabold text-[11px]">{{ __('24 Jam Nonstop') }}</span>
                                </div>
                                <div class="flex items-center justify-between py-1">
                                    <span class="font-bold text-gray-900">{{ __('Poliklinik Spesialis') }}</span>
                                    <a href="{{ url('/jadwal-dokter') }}" class="text-[#0e7c47] font-extrabold hover:underline">{{ __('Lihat Jadwal') }} &rarr;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 3: HUBUNGI KAMI & DARURAT -->
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center font-bold text-lg shrink-0 border border-red-200 shadow-xs">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <div class="space-y-2 flex-1">
                            <h3 class="font-black text-gray-900 text-base">
                                {{ __('Kontak Cepat & Darurat') }}
                            </h3>
                            <div class="space-y-2 text-xs sm:text-sm font-semibold">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">{{ __('Darurat IGD') }}:</span>
                                    <a href="tel:02678454999" class="font-extrabold text-red-600 hover:underline">(0267) 8454999</a>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">{{ __('Telepon Informasi') }}:</span>
                                    <a href="tel:02678454123" class="font-bold text-gray-900 hover:text-[#0e7c47]">(0267) 8454123</a>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">{{ __('WhatsApp Pendaftaran') }}:</span>
                                    <a href="https://wa.me/6281234567890" target="_blank" class="font-extrabold text-[#0e7c47] hover:underline">0812-3456-7890</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 4: PETUNJUK AKSES TRANSPORTASI -->
                <div class="bg-[#0e7c47] text-white p-6 rounded-2xl shadow-md space-y-3">
                    <div class="flex items-center gap-2 text-yellow-300 font-extrabold text-sm">
                        <i class="fa-solid fa-circle-info"></i>
                        <span>{{ __('Akses & Landmark') }}</span>
                    </div>
                    <ul class="space-y-2 text-xs sm:text-sm text-white font-medium leading-relaxed">
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-check text-yellow-300 mt-1 text-xs shrink-0"></i>
                            <span>Dekat Stasiun Kosambi & Pasar Kosambi (± 5 Menit).</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-check text-yellow-300 mt-1 text-xs shrink-0"></i>
                            <span>Akses langsung dari Gerbang Tol Karawang Timur (± 15 Menit).</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-check text-yellow-300 mt-1 text-xs shrink-0"></i>
                            <span>Tersedia area parkir mobil dan motor yang aman dan representatif.</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- RIGHT GOOGLE MAPS EMBED CONTAINER (7 COLS) -->
            <div class="lg:col-span-7 bg-white p-3 sm:p-4 rounded-3xl border border-gray-200 shadow-lg">
                <div class="relative w-full rounded-2xl overflow-hidden shadow-inner bg-gray-100 min-h-[480px] lg:min-h-[560px]">
                    {!! $profile?->maps_embed ?? '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.5132717070197!2d107.36952737503886!3d-6.327471993662121!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6975a5cb3333cd%3A0x2aa7847b3117498c!2sRSU%20Fikri%20Medika!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" width="100%" height="560" style="border:0; width:100%; min-height: 520px;" allowfullscreen="" loading="lazy"></iframe>' !!}
                </div>

                <!-- BOTTOM MAP BAR -->
                <div class="p-3 sm:p-4 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-800 font-semibold">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-compass text-[#0e7c47] text-sm"></i>
                        <span>Koordinat: -6.327472, 107.369527</span>
                    </div>
                    <div>
                        <a href="https://maps.google.com/?q=RSU+Fikri+Medika+Karawang" target="_blank" class="font-extrabold text-[#0e7c47] hover:underline flex items-center gap-1">
                            <span>Perbesar Peta di Google Maps</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
