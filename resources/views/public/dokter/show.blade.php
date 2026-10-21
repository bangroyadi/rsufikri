@extends('layouts.app')

@php
    $seoService = app(\App\Services\SeoService::class);
    $specialtyText = $doctor->specialty_name;
    $fullName = $doctor->full_name;
    $canonicalUrl = $canonicalUrl ?? $doctor->route_url;
    $pageTitle = $pageTitle ?? "{$fullName}, {$specialtyText} di Karawang | RSU Fikri Medika";
    $pageH1 = $pageH1 ?? $fullName;
    $pageDescription = $pageDescription ?? "Jadwal praktik dan profil {$fullName}, dokter spesialis {$specialtyText} di RSU Fikri Medika Karawang. Informasi poliklinik, jam praktik, dan pendaftaran janji temu.";
    
    $poliModel = $doctor->polyclinic;
    $poliNameId = $poliModel ? (is_array($poliModel->name) ? ($poliModel->name['id'] ?? $poliModel->name['en'] ?? '') : $poliModel->name) : 'Poliklinik';
    $cleanSpecialtyName = preg_replace('/^Poli\s+/i', '', $poliNameId);
    $specialtyUrl = $poliModel ? url('/dokter/' . $poliModel->slug . '-karawang') : url('/dokter-di-karawang');
    $photoUrl = $doctor->photo;
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDescription)
@section('canonical_url', $canonicalUrl)

@section('schema_jsonld')
<script type="application/ld+json">
{!! json_encode($seoService->generateBreadcrumbSchema([
    'Beranda' => url('/'),
    'Dokter di Karawang' => url('/dokter-di-karawang'),
    "Dokter Spesialis {$cleanSpecialtyName}" => $specialtyUrl,
    $fullName => $canonicalUrl
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<script type="application/ld+json">
{!! json_encode($seoService->generatePhysicianSchema($doctor), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

@section('content')

<!-- BREADCRUMB -->
<nav class="bg-emerald-900/5 border-b border-emerald-900/10 py-3 px-4 sm:px-6 lg:px-8" aria-label="Breadcrumb">
    <div class="max-w-7xl mx-auto flex flex-wrap items-center gap-2 text-xs sm:text-sm text-slate-600 font-medium">
        <a href="{{ url('/') }}" class="hover:text-[#0e7c47] transition-colors flex items-center gap-1.5">
            <i class="fa-solid fa-house text-emerald-600 text-xs"></i>
            <span>{{ __('Beranda') }}</span>
        </a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
        <a href="{{ url('/dokter-di-karawang') }}" class="hover:text-[#0e7c47] transition-colors">
            <span>{{ __('Dokter di Karawang') }}</span>
        </a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
        <a href="{{ $specialtyUrl }}" class="hover:text-[#0e7c47] transition-colors">
            <span>Dokter Spesialis {{ $cleanSpecialtyName }}</span>
        </a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
        <span class="text-[#0e7c47] font-bold truncate max-w-[200px] sm:max-w-none">{{ $fullName }}</span>
    </div>
</nav>

<!-- MAIN DOCTOR DETAIL PROFILE CONTAINER (FULL WIDTH MAX-W-7XL) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-8 sm:space-y-10">

    <!-- TOP DOCTOR HERO CARD -->
    <div class="bg-white rounded-3xl border-2 border-emerald-100/90 p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6 sm:gap-8">
            
            <!-- DOCTOR PHOTO -->
            <div class="shrink-0 flex justify-center">
                <div class="doctor-photo-container relative overflow-hidden rounded-2xl shadow-md bg-slate-100 flex items-center justify-center">
                    @if(!empty($photoUrl))
                        <img src="{{ $photoUrl }}" 
                             alt="{{ $doctor->name }} {{ $doctor->title_degree }} dokter spesialis {{ $specialtyText }} RSU Fikri Medika Karawang" 
                             class="doctor-photo-img"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="w-full h-full bg-gradient-to-tr from-[#096237] to-[#0e7c47] text-white hidden items-center justify-center text-5xl font-bold">
                            <i class="fa-solid fa-user-doctor text-5xl text-white"></i>
                        </div>
                    @else
                        <div class="w-full h-full bg-gradient-to-tr from-[#096237] via-[#0e7c47] to-[#159b5a] text-white flex flex-col items-center justify-center gap-3">
                            <i class="fa-solid fa-user-doctor text-5xl sm:text-6xl text-white drop-shadow-sm"></i>
                            <span class="text-xs font-extrabold text-emerald-100 uppercase tracking-widest">RSU FIKRI MEDIKA</span>
                        </div>
                    @endif
                </div>
            </div>

            <style>
                .doctor-photo-container {
                    width: 280px !important;
                    height: 350px !important;
                    max-width: 100% !important;
                    border: none !important;
                    border-radius: 1rem !important;
                    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
                }
                .doctor-photo-img {
                    width: 100% !important;
                    height: 100% !important;
                    object-fit: cover !important;
                    object-position: center top !important;
                    display: block !important;
                    border: none !important;
                }
                @media (max-width: 640px) {
                    .doctor-photo-container {
                        width: 220px !important;
                        height: 275px !important;
                    }
                }
            </style>

            <!-- DOCTOR MAIN INFO -->
            <div class="space-y-4 flex-1 text-center md:text-left">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-2">
                    <a href="{{ $specialtyUrl }}" class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-emerald-50 hover:bg-emerald-100 text-[#0e7c47] text-xs font-black border border-emerald-200 transition-colors shadow-2xs">
                        <i class="fa-solid fa-stethoscope"></i>
                        <span>{{ $poliNameId }}</span>
                    </a>
                    <span class="px-3.5 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold border border-slate-200">
                        <i class="fa-solid fa-hospital mr-1 text-[#0e7c47]"></i> RSU Fikri Medika Karawang
                    </span>
                </div>

                <div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 leading-tight">
                        {{ $pageH1 }}
                    </h1>
                    <p class="text-sm sm:text-base text-[#0e7c47] font-extrabold mt-1">
                        Spesialis {{ $cleanSpecialtyName }}
                    </p>
                </div>

                <!-- QUICK SUMMARY OR BIO -->
                <div class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-3xl">
                    @if(!empty($doctor->tr('bio')))
                        <p>{!! nl2br(e($doctor->tr('bio'))) !!}</p>
                    @else
                        <p>
                            {{ $fullName }} adalah dokter spesialis {{ strtolower($cleanSpecialtyName) }} yang berpraktik di RSU Fikri Medika Karawang. Melayani pemeriksaan medis, diagnosis klinis, konsultasi kesehatan, serta penanganan keluhan pada {{ strtolower($poliNameId) }}.
                        </p>
                    @endif
                </div>

                <!-- CTA BUTTONS -->
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 pt-2">
                    <a href="{{ url('/buat-janji?dokter_id=' . $doctor->id) }}" class="px-6 py-3 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white font-black text-xs sm:text-sm shadow-md transition-all flex items-center gap-2">
                        <i class="fa-solid fa-calendar-check text-sm"></i>
                        <span>Daftar / Buat Janji Online</span>
                    </a>
                    <a href="https://wa.me/6281287075555?text=Halo%20RSU%20Fikri%20Medika,%20saya%20ingin%20tanya%20jadwal%20praktik%20{{ urlencode($fullName) }}" target="_blank" class="px-5 py-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-[#0e7c47] border border-emerald-300 font-bold text-xs sm:text-sm transition-all flex items-center gap-2 shadow-2xs">
                        <i class="fa-brands fa-whatsapp text-base text-emerald-600"></i>
                        <span>Tanya WhatsApp CS</span>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- 2-COLUMN BALANCED GRID (8 COLS MAIN + 4 COLS SIDEBAR FILLING FULL 12 COLUMNS) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- LEFT 8 COLUMNS: SCHEDULE TABLE, CLINIC DETAILS & STEP GUIDELINE -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- SCHEDULE TABLE (SERVER-SIDE CRAWLABLE HTML TABLE) -->
            <section class="bg-white rounded-3xl p-6 sm:p-8 border border-emerald-100 shadow-sm space-y-5">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#0e7c47] flex items-center justify-center text-base font-black shadow-2xs">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div>
                            <h2 class="text-lg sm:text-xl font-black text-slate-900">
                                Jadwal Praktik Dokter di RSU Fikri Medika
                            </h2>
                            <p class="text-xs text-slate-500">Waktu Indonesia Barat (WIB)</p>
                        </div>
                    </div>
                    <span class="text-xs font-extrabold px-3 py-1 rounded-full bg-emerald-50 text-[#0e7c47] border border-emerald-200">
                        {{ $doctor->schedules->count() }} Hari Praktik
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-700 font-extrabold uppercase text-[11px] tracking-wider border-y border-slate-200">
                                <th class="py-3.5 px-4 rounded-l-xl">HARI PRAKTIK</th>
                                <th class="py-3.5 px-4">JAM PRAKTIK</th>
                                <th class="py-3.5 px-4">POLIKLINIK</th>
                                <th class="py-3.5 px-4 rounded-r-xl text-center">STATUS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                            @forelse($doctor->schedules as $schedule)
                                <tr class="hover:bg-emerald-50/40 transition-colors">
                                    <td class="py-4 px-4 font-black text-[#0e7c47] text-sm sm:text-base">
                                        <span class="inline-flex items-center gap-2">
                                            <i class="fa-regular fa-calendar text-emerald-600 text-xs"></i>
                                            <span>{{ $schedule->day }}</span>
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 font-mono font-bold text-slate-900 text-xs sm:text-sm">
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-200">
                                            <i class="fa-regular fa-clock text-[#0e7c47] text-xs"></i>
                                            <span>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-slate-700 font-semibold">
                                        {{ $poliNameId }}
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-800 uppercase tracking-wide border border-emerald-200">
                                            {{ $schedule->status ?? 'Tersedia' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-slate-500 text-xs sm:text-sm">
                                        <i class="fa-regular fa-calendar-xmark text-2xl text-slate-300 block mb-2"></i>
                                        Jadwal praktik dokter sedang dalam konfirmasi. Silakan hubungi Customer Service untuk informasi terbaru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-emerald-50/70 rounded-2xl p-4 sm:p-5 border border-emerald-200 text-xs sm:text-sm text-slate-700 space-y-1.5">
                    <div class="font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-[#0e7c47]"></i>
                        <span>Ketentuan Pendaftaran & Janji Temu:</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Pasien diharapkan hadir 15-30 menit sebelum jam praktik dimulai untuk proses verifikasi administrasi dan penomoran antrean di Poliklinik RSU Fikri Medika Karawang.
                    </p>
                </div>
            </section>

            <!-- PRACTICE LOCATION & CLINIC INFO -->
            <section class="bg-white rounded-3xl p-6 sm:p-8 border border-emerald-100 shadow-sm space-y-5">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#0e7c47] flex items-center justify-center text-base font-black shadow-2xs">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <h2 class="text-lg sm:text-xl font-black text-slate-900">
                            Lokasi Praktik & Layanan Poliklinik
                        </h2>
                        <p class="text-xs text-slate-500">RSU Fikri Medika Karawang</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs sm:text-sm text-slate-600">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/80 space-y-2">
                        <div class="flex items-center gap-2 font-bold text-slate-900">
                            <i class="fa-solid fa-hospital text-[#0e7c47]"></i>
                            <span>Alamat Rumah Sakit:</span>
                        </div>
                        <p class="text-slate-800 font-semibold">RSU Fikri Medika Karawang</p>
                        <p class="text-slate-600 text-xs leading-relaxed">Jl. Raya Kosambi - Telagasari No. 9, Klari, Karawang, Jawa Barat 41371</p>
                        <div class="pt-1">
                            <a href="{{ url('/lokasi') }}" class="text-[#0e7c47] font-bold hover:underline inline-flex items-center gap-1 text-xs">
                                <span>Petunjuk Arah & Google Maps</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/80 space-y-2">
                        <div class="flex items-center gap-2 font-bold text-slate-900">
                            <i class="fa-solid fa-stethoscope text-[#0e7c47]"></i>
                            <span>Instalasi Pelayanan:</span>
                        </div>
                        <p class="text-slate-800 font-semibold">{{ $poliNameId }}</p>
                        <p class="text-slate-600 text-xs leading-relaxed">Gedung Rawat Jalan, Lantai Poliklinik Spesialis Terpadu RSU Fikri Medika.</p>
                        <div class="pt-1">
                            <a href="{{ $specialtyUrl }}" class="text-[#0e7c47] font-bold hover:underline inline-flex items-center gap-1 text-xs">
                                <span>Lihat Profil Poliklinik {{ $cleanSpecialtyName }}</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- PATIENT REGISTRATION WORKFLOW GUIDE -->
            <section class="bg-white rounded-3xl p-6 sm:p-8 border border-emerald-100 shadow-sm space-y-5">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#0e7c47] flex items-center justify-center text-base font-black shadow-2xs">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <div>
                        <h2 class="text-lg sm:text-xl font-black text-slate-900">
                            Alur Pendaftaran Pasien Rawat Jalan
                        </h2>
                        <p class="text-xs text-slate-500">Langkah mudah konsultasi dokter spesialis</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                        <div class="w-8 h-8 rounded-xl bg-[#0e7c47] text-white flex items-center justify-center text-xs font-black">1</div>
                        <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Pilih Jadwal</h3>
                        <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed">Cek hari dan jam praktik dokter spesialis sesuai kebutuhan konsultasi Anda.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                        <div class="w-8 h-8 rounded-xl bg-[#0e7c47] text-white flex items-center justify-center text-xs font-black">2</div>
                        <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Daftar Online</h3>
                        <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed">Klik tombol Buat Janji Online atau chat WhatsApp CS untuk reservasi nomor antrean.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                        <div class="w-8 h-8 rounded-xl bg-[#0e7c47] text-white flex items-center justify-center text-xs font-black">3</div>
                        <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Konsultasi Medis</h3>
                        <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed">Datang ke RSU Fikri Medika Karawang dan lakukan pemeriksaan dengan dokter spesialis.</p>
                    </div>
                </div>
            </section>

        </div>

        <!-- RIGHT 4 COLUMNS: SIDEBAR WIDGETS -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- PEER DOCTORS IN SAME SPECIALTY -->
            @if(!empty($otherDoctors) && $otherDoctors->count() > 0)
            <div class="bg-white rounded-3xl p-6 border-2 border-emerald-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-user-doctor text-[#0e7c47]"></i>
                        <span>Dokter {{ $cleanSpecialtyName }} Lainnya</span>
                    </h3>
                    <a href="{{ $specialtyUrl }}" class="text-[11px] font-bold text-[#0e7c47] hover:underline">
                        Lihat Semua
                    </a>
                </div>

                <div class="space-y-3">
                    @foreach($otherDoctors as $peer)
                        <a href="{{ $peer->route_url }}" class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50/80 hover:bg-emerald-50 transition-all border border-slate-200/80 hover:border-emerald-300 group">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-emerald-100 border border-emerald-300 shrink-0 flex items-center justify-center">
                                @if(!empty($peer->photo))
                                    <img src="{{ $peer->photo }}" alt="{{ $peer->full_name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-[#0e7c47] flex items-center justify-center text-white text-lg">
                                        <i class="fa-solid fa-user-doctor"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-xs font-extrabold text-slate-900 group-hover:text-[#0e7c47] transition-colors truncate">
                                    {{ $peer->name }}
                                </h4>
                                <span class="text-[11px] text-slate-500 font-semibold block truncate">
                                    {{ $peer->title_degree ?: $cleanSpecialtyName }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- HIGH CONTRAST SCHEDULE ACCESS CARD (FIXED CONTRAST & CLEAR FONT COLOR) -->
            <div class="bg-white rounded-3xl p-6 border-2 border-emerald-200 shadow-sm space-y-4">
                <div class="flex items-center gap-3 pb-3 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#0e7c47] flex items-center justify-center text-lg font-black shrink-0 shadow-2xs">
                        <i class="fa-regular fa-calendar-check"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 leading-tight">Butuh Jadwal Lengkap?</h3>
                        <span class="text-[11px] text-slate-500 font-medium">RSU Fikri Medika Karawang</span>
                    </div>
                </div>

                <p class="text-xs sm:text-sm text-slate-700 font-medium leading-relaxed">
                    Lihat jadwal praktik seluruh dokter spesialis di RSU Fikri Medika Karawang atau reservasi nomor antrean janji temu dokter secara online.
                </p>

                <div class="space-y-2.5 pt-1">
                    <a href="{{ url('/jadwal-dokter') }}" class="w-full py-3 px-4 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white font-extrabold text-xs sm:text-sm text-center block shadow-sm transition-colors">
                        <i class="fa-solid fa-calendar-days mr-1.5"></i> Lihat Jadwal Dokter Lengkap
                    </a>
                    <a href="{{ url('/dokter-di-karawang') }}" class="w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs text-center block transition-colors">
                        <i class="fa-solid fa-stethoscope mr-1.5 text-[#0e7c47]"></i> Direktori Dokter Karawang
                    </a>
                </div>
            </div>

            <!-- HOSPITAL EMERGENCY & CONTACT FAST CARD -->
            <div class="bg-gradient-to-br from-[#096237] via-[#0e7c47] to-[#159b5a] text-white rounded-3xl p-6 space-y-4 shadow-md">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-yellow-400 text-slate-900 flex items-center justify-center text-lg font-black shrink-0">
                        <i class="fa-solid fa-phone-volume text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-white">Call Center & IGD 24 Jam</h3>
                        <span class="text-xs text-emerald-100">Siaga Melayani Anda</span>
                    </div>
                </div>

                <p class="text-xs text-white font-medium leading-relaxed">
                    Untuk keadaan darurat medis, ambulans, atau konfirmasi ketersediaan kamar dan dokter:
                </p>

                <div class="space-y-2 pt-1">
                    <a href="tel:081287075555" class="w-full py-2.5 px-4 rounded-xl bg-yellow-400 hover:bg-yellow-300 text-slate-900 font-black text-xs text-center block shadow-xs transition-colors">
                        <i class="fa-solid fa-truck-medical mr-1.5 text-red-600"></i> IGD 24 Jam: 0812 8707 5555
                    </a>
                    <a href="tel:082280749999" class="w-full py-2.5 px-4 rounded-xl bg-white/15 hover:bg-white/25 text-white font-bold text-xs text-center block transition-colors border border-white/20">
                        <i class="fa-solid fa-headset mr-1.5 text-yellow-300"></i> Call Center: 0822 8074 9999
                    </a>
                </div>
            </div>

            <!-- RELATED HEALTH ARTICLES (IF ANY) -->
            @if(!empty($relatedArticles) && $relatedArticles->count() > 0)
            <div class="bg-white rounded-3xl p-6 border border-emerald-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-regular fa-newspaper text-[#0e7c47]"></i>
                        <span>Artikel Kesehatan Terkait</span>
                    </h3>
                    <a href="{{ url('/artikel') }}" class="text-[11px] font-bold text-[#0e7c47] hover:underline">
                        Lihat Semua
                    </a>
                </div>

                <div class="space-y-3">
                    @foreach($relatedArticles as $art)
                        <a href="{{ route('artikel.show', $art->slug) }}" class="block p-3 rounded-2xl bg-slate-50 hover:bg-emerald-50 transition-colors border border-slate-200/70 hover:border-emerald-300 group">
                            <h4 class="text-xs font-bold text-slate-900 group-hover:text-[#0e7c47] transition-colors line-clamp-2 leading-snug">
                                {{ $art->tr('title') }}
                            </h4>
                            <span class="text-[10px] text-slate-400 mt-1 block">
                                {{ $art->published_at ? $art->published_at->translatedFormat('d M Y') : $art->created_at->translatedFormat('d M Y') }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

    </div>

</div>

@endsection
