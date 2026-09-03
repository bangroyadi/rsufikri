@extends('layouts.app')

@php
    $seoService = app(\App\Services\SeoService::class);
    $canonicalUrl = $canonicalUrl ?? url('/dokter-di-karawang');
    $pageTitle = $pageTitle ?? 'Dokter di Karawang – Jadwal Dokter | RSU Fikri Medika';
    $pageDescription = $pageDescription ?? 'Temukan dokter spesialis di Karawang di RSU Fikri Medika. Lihat profil dokter, spesialisasi, jadwal praktik, layanan dan informasi pendaftaran.';
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDescription)
@section('canonical_url', $canonicalUrl)

@section('schema_jsonld')
<script type="application/ld+json">
{!! json_encode($seoService->generateBreadcrumbSchema([
    'Beranda' => url('/'),
    'Dokter di Karawang' => $canonicalUrl
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<script type="application/ld+json">
{!! json_encode($seoService->generateDoctorHubSchema($doctors, $polyclinics), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

@section('content')

<!-- BREADCRUMB -->
<nav class="bg-emerald-900/5 border-b border-emerald-900/10 py-3 px-4 sm:px-6 lg:px-8" aria-label="Breadcrumb">
    <div class="max-w-7xl mx-auto flex items-center gap-2 text-xs sm:text-sm text-slate-600 font-medium">
        <a href="{{ url('/') }}" class="hover:text-[#0e7c47] transition-colors flex items-center gap-1.5">
            <i class="fa-solid fa-house text-emerald-600 text-xs"></i>
            <span>{{ __('Beranda') }}</span>
        </a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
        <span class="text-[#0e7c47] font-bold">{{ __('Dokter di Karawang') }}</span>
    </div>
</nav>

<!-- HERO HEADER SECTION (ELEGANT & PREMIUM DEEP EMERALD GRADIENT) -->
<section class="relative text-white py-12 sm:py-16 px-4 sm:px-6 lg:px-8 overflow-hidden shadow-inner" style="background: linear-gradient(135deg, #063a20 0%, #094d2c 50%, #0e7c47 100%) !important; color: #ffffff !important;">
    <!-- Ambient Glow & Subtle Decorative Mesh -->
    <div class="absolute -right-24 -bottom-24 w-[420px] h-[420px] rounded-full blur-3xl pointer-events-none" style="background: rgba(52, 211, 153, 0.15) !important;"></div>
    <div class="absolute -left-20 -top-20 w-80 h-80 rounded-full blur-3xl pointer-events-none" style="background: rgba(45, 212, 191, 0.12) !important;"></div>
    <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>

    <div class="max-w-7xl mx-auto relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8 lg:gap-12">
        
        <!-- LEFT COLUMN: TITLE & CTA -->
        <div class="space-y-4 max-w-2xl text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-black tracking-wider uppercase shadow-xs" style="background: rgba(255, 255, 255, 0.15) !important; border: 1px solid rgba(255, 255, 255, 0.25) !important; color: #fef08a !important;">
                <i class="fa-solid fa-stethoscope" style="color: #6ee7b7 !important;"></i>
                <span>DIREKTORI DOKTER SPESIALIS KARAWANG</span>
            </div>
            
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-[1.15]" style="color: #ffffff !important;">
                Dokter di Karawang
            </h1>
            
            <p class="text-sm sm:text-base leading-relaxed font-normal" style="color: #e6f7ef !important;">
                Temukan dokter spesialis terbaik di Karawang di RSU Fikri Medika. Akses informasi profil dokter, jadwal praktik harian, poliklinik, dan pendaftaran janji temu dengan mudah dan terpercaya.
            </p>

            <div class="flex flex-wrap items-center gap-3 pt-2 justify-center lg:justify-start">
                <a href="#daftar-dokter" class="px-5 py-3 rounded-2xl font-extrabold text-xs sm:text-sm hover:scale-105 transition-all shadow-lg flex items-center gap-2" style="background-color: #facc15 !important; color: #0f172a !important;">
                    <i class="fa-solid fa-user-doctor" style="color: #0f172a !important;"></i>
                    <span>Lihat Daftar Dokter</span>
                </a>
                <a href="{{ url('/jadwal-dokter') }}" class="px-5 py-3 rounded-2xl font-bold text-xs sm:text-sm hover:scale-105 transition-all flex items-center gap-2" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.3) !important; color: #ffffff !important;">
                    <i class="fa-regular fa-calendar-check" style="color: #a7f3d0 !important;"></i>
                    <span>Jadwal Harian</span>
                </a>
                <a href="{{ url('/buat-janji') }}" class="px-5 py-3 rounded-2xl font-bold text-xs sm:text-sm hover:scale-105 transition-all shadow-lg flex items-center gap-2" style="background-color: #e31e24 !important; color: #ffffff !important;">
                    <i class="fa-solid fa-calendar-plus" style="color: #ffffff !important;"></i>
                    <span>Buat Janji Online</span>
                </a>
            </div>
        </div>

        <!-- RIGHT COLUMN: STATS BADGE CARDS -->
        <div class="grid grid-cols-2 gap-4 w-full sm:w-auto shrink-0 max-w-md">
            <!-- Stat 1: Dokter -->
            <div class="p-5 sm:p-6 rounded-3xl text-center shadow-xl hover:scale-105 transition-all" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.25) !important; backdrop-filter: blur(16px);">
                <div class="w-10 h-10 rounded-2xl mx-auto flex items-center justify-center text-lg mb-2" style="background: rgba(250, 204, 21, 0.2) !important; border: 1px solid rgba(250, 204, 21, 0.4) !important; color: #fde047 !important;">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
                <div class="text-3xl sm:text-4xl font-black tracking-tight" style="color: #fef08a !important;">{{ $doctors->count() }}+</div>
                <div class="text-[11px] sm:text-xs font-extrabold uppercase tracking-wider mt-1" style="color: #d1fae5 !important;">Dokter Spesialis</div>
            </div>

            <!-- Stat 2: Poliklinik -->
            <div class="p-5 sm:p-6 rounded-3xl text-center shadow-xl hover:scale-105 transition-all" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.25) !important; backdrop-filter: blur(16px);">
                <div class="w-10 h-10 rounded-2xl mx-auto flex items-center justify-center text-lg mb-2" style="background: rgba(52, 211, 153, 0.2) !important; border: 1px solid rgba(52, 211, 153, 0.4) !important; color: #6ee7b7 !important;">
                    <i class="fa-solid fa-hospital"></i>
                </div>
                <div class="text-3xl sm:text-4xl font-black tracking-tight" style="color: #fef08a !important;">{{ $polyclinics->count() }}</div>
                <div class="text-[11px] sm:text-xs font-extrabold uppercase tracking-wider mt-1" style="color: #d1fae5 !important;">Poliklinik Medis</div>
            </div>

            <!-- Stat 3: IGD & Lokasi -->
            <div class="p-4 sm:p-5 rounded-3xl text-center col-span-2 shadow-xl hover:scale-105 transition-all" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.25) !important; backdrop-filter: blur(16px);">
                <div class="text-xs sm:text-sm font-black flex items-center justify-center gap-2" style="color: #ffffff !important;">
                    <span class="w-2.5 h-2.5 rounded-full" style="background-color: #34d399 !important; box-shadow: 0 0 8px #34d399;"></span>
                    <i class="fa-solid fa-shield-heart" style="color: #fde047 !important;"></i>
                    <span>Layanan Medis 24 Jam & IGD</span>
                </div>
                <div class="text-[11px] sm:text-xs font-medium mt-1" style="color: #d1fae5 !important;">Jl. Raya Kosambi - Telagasari, Klari, Karawang</div>
            </div>
        </div>

    </div>
</section>

<!-- SPECIALTY QUICK NAV CLUSTER -->
<section class="py-10 bg-white border-b border-emerald-100/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2">
            <div>
                <h2 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight">
                    Pilih Spesialisasi Dokter di Karawang
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">
                    Jelajahi dokter spesialis RSU Fikri Medika berdasarkan bidang keahlian medis.
                </p>
            </div>
            <span class="text-xs font-bold text-[#0e7c47] bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full self-start sm:self-auto">
                {{ $polyclinics->count() }} Spesialisasi Tersedia
            </span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
            @foreach($polyclinics as $poli)
                @php
                    $poliNameId = is_array($poli->name) ? ($poli->name['id'] ?? $poli->name['en'] ?? '') : $poli->name;
                    $cleanName = preg_replace('/^Poli\s+/i', '', $poliNameId);
                    $docCount = $poli->doctors ? $poli->doctors->count() : 0;
                @endphp
                <a href="{{ url('/dokter/' . $poli->slug . '-karawang') }}" 
                   class="group p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-slate-200/80 hover:border-emerald-300 transition-all shadow-2xs hover:shadow-sm flex flex-col items-center text-center space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100/80 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shadow-2xs">
                        <i class="fa-solid fa-{{ $poli->icon ?: 'stethoscope' }}"></i>
                    </div>
                    <div class="space-y-0.5">
                        <h3 class="text-xs font-extrabold text-slate-900 group-hover:text-[#0e7c47] transition-colors line-clamp-1 leading-snug">
                            {{ $cleanName }}
                        </h3>
                        <span class="text-[10px] text-slate-500 font-semibold block">
                            {{ $docCount }} Dokter
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- MAIN DOCTORS DIRECTORY & SEARCH SECTION -->
<section id="daftar-dokter" class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8" x-data="{
    searchName: '',
    selectedPoli: '',
    selectedDay: '',
    doctorsData: [
        @foreach($doctors as $d)
        {
            id: {{ $d->id }},
            name: '{{ addslashes($d->name) }}',
            poliId: '{{ $d->polyclinic_id }}',
            days: [ @foreach($d->schedules as $s)'{{ addslashes($s->day) }}', @endforeach ]
        },
        @endforeach
    ],
    isMatch(docId) {
        let d = this.doctorsData.find(item => item.id === docId);
        if (!d) return false;
        let matchName = !this.searchName || d.name.toLowerCase().includes(this.searchName.toLowerCase());
        let matchPoli = !this.selectedPoli || d.poliId == this.selectedPoli;
        let matchDay = !this.selectedDay || d.days.includes(this.selectedDay);
        return matchName && matchPoli && matchDay;
    }
}">

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b border-gray-200 pb-4">
        <div>
            <h2 class="text-xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Daftar Dokter Spesialis & Praktik di Karawang
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">
                Informasi profil resmi, spesialisasi, poliklinik, dan jadwal praktik harian di RSU Fikri Medika Karawang.
            </p>
        </div>
    </div>

    <!-- FILTER & SEARCH BAR -->
    <div class="bg-white p-5 rounded-2xl border border-emerald-100 shadow-sm grid grid-cols-1 sm:grid-cols-3 gap-3">
        <!-- SEARCH -->
        <div class="relative">
            <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">{{ __('Cari Nama Dokter') }}</label>
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" 
                       x-model="searchName" 
                       placeholder="Contoh: dr. Ahmad, dr. Adam..." 
                       class="w-full pl-9 pr-3 py-2 text-xs sm:text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#0e7c47] focus:border-[#0e7c47] outline-none text-gray-800">
            </div>
        </div>

        <!-- FILTER POLI -->
        <div>
            <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">{{ __('Poliklinik / Spesialisasi') }}</label>
            <select x-model="selectedPoli" class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#0e7c47] focus:border-[#0e7c47] outline-none text-gray-800 bg-white">
                <option value="">-- Semua Spesialisasi --</option>
                @foreach($polyclinics as $p)
                    @php $pName = is_array($p->name) ? ($p->name['id'] ?? $p->name['en'] ?? '') : $p->name; @endphp
                    <option value="{{ $p->id }}">{{ $pName }}</option>
                @endforeach
            </select>
        </div>

        <!-- FILTER HARI -->
        <div>
            <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">{{ __('Hari Praktik') }}</label>
            <select x-model="selectedDay" class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#0e7c47] focus:border-[#0e7c47] outline-none text-gray-800 bg-white">
                <option value="">-- Semua Hari --</option>
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                    <option value="{{ $day }}">{{ $day }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- DOCTOR CARDS GRID (SERVER-SIDE RENDERED HTML FOR FULL GOOGLE CRAWLABILITY) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($doctors as $doc)
            @php
                $specTitle = $doc->specialty_name;
                $poliTitle = is_array($doc->polyclinic?->name) ? ($doc->polyclinic?->name['id'] ?? $doc->polyclinic?->name['en'] ?? '') : ($doc->polyclinic?->name ?? 'Poliklinik');
                $photoUrl = $doc->photo;
                $doctorUrl = $doc->route_url;
                $specialtyUrl = $doc->polyclinic ? url('/dokter/' . $doc->polyclinic->slug . '-karawang') : url('/dokter-di-karawang');
            @endphp

            <div x-show="isMatch({{ $doc->id }})" 
                 class="bg-white rounded-3xl border-2 border-emerald-100/90 p-5 sm:p-6 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all flex flex-col justify-between space-y-5">
                
                <!-- TOP INFO ROW -->
                <div class="flex items-start gap-4">
                    <!-- DOCTOR PHOTO -->
                    <a href="{{ $doctorUrl }}" class="shrink-0 group">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl overflow-hidden border-2 border-emerald-500 p-0.5 bg-emerald-50 shadow-sm relative">
                            @if(!empty($photoUrl))
                                <img src="{{ $photoUrl }}" 
                                     alt="{{ $doc->name }} {{ $doc->title_degree }} dokter spesialis {{ $specTitle }} RSU Fikri Medika Karawang" 
                                     loading="lazy"
                                     class="w-full h-full object-cover rounded-xl group-hover:scale-105 transition-transform"
                                     style="object-fit: cover; object-position: center 10%;"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-full rounded-xl bg-gradient-to-tr from-[#0e7c47] to-emerald-500 text-white hidden items-center justify-center text-2xl font-bold">
                                    <i class="fa-solid fa-user-doctor"></i>
                                </div>
                            @else
                                <div class="w-full h-full rounded-xl bg-gradient-to-tr from-[#0e7c47] to-emerald-500 text-white flex items-center justify-center text-2xl font-bold">
                                    <i class="fa-solid fa-user-doctor"></i>
                                </div>
                            @endif
                        </div>
                    </a>

                    <!-- DOCTOR BASIC META -->
                    <div class="space-y-1.5 flex-1 min-w-0">
                        <a href="{{ $specialtyUrl }}" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 hover:bg-emerald-100 text-[#0e7c47] text-[11px] font-extrabold border border-emerald-200 transition-colors">
                            <i class="fa-solid fa-{{ $doc->polyclinic?->icon ?: 'stethoscope' }} text-[10px]"></i>
                            <span class="truncate">{{ $poliTitle }}</span>
                        </a>

                        <h3 class="text-base sm:text-lg font-black text-slate-900 leading-snug">
                            <a href="{{ $doctorUrl }}" class="hover:text-[#0e7c47] transition-colors">
                                {{ $doc->name }}
                            </a>
                        </h3>

                        <p class="text-xs text-slate-500 font-semibold line-clamp-1">
                            Spesialisasi: <span class="text-slate-800 font-bold">{{ $specTitle }}</span>
                        </p>
                    </div>
                </div>

                <!-- CRAWLABLE PRACTICE SCHEDULES -->
                <div class="space-y-2 bg-slate-50/80 rounded-2xl p-3.5 border border-slate-200/70">
                    <div class="text-[11px] font-extrabold text-slate-700 uppercase tracking-wider flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar-days text-[#0e7c47]"></i>
                            <span>Jadwal Praktik Dokter</span>
                        </span>
                        <span class="text-[10px] text-slate-500 font-semibold">RSU Fikri Medika</span>
                    </div>

                    @if($doc->schedules->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach($doc->schedules as $sched)
                                <div class="flex items-center justify-between px-2.5 py-1.5 rounded-xl bg-white border border-emerald-100 text-xs shadow-2xs">
                                    <span class="font-extrabold text-[#0e7c47] uppercase text-[11px]">
                                        {{ $sched->day }}
                                    </span>
                                    <span class="font-mono font-bold text-slate-800 text-[11px]">
                                        {{ \Carbon\Carbon::parse($sched->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($sched->end_time)->format('H:i') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-xs text-amber-700 bg-amber-50 border border-amber-200 px-3 py-1.5 rounded-xl">
                            <i class="fa-regular fa-clock mr-1"></i> Jadwal praktik saat ini dapat dikonfirmasi melalui CS.
                        </div>
                    @endif
                </div>

                <!-- ACTION BUTTONS -->
                <div class="flex items-center gap-2 pt-1">
                    <a href="{{ $doctorUrl }}" class="flex-1 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-extrabold text-center transition-colors">
                        Lihat Profil
                    </a>
                    <a href="{{ url('/jadwal-dokter?spesialis=' . ($doc->polyclinic?->slug ?? '')) }}" class="px-3.5 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-[#0e7c47] border border-emerald-200 text-xs font-extrabold text-center transition-colors">
                        Jadwal
                    </a>
                    <a href="{{ url('/buat-janji?dokter_id=' . $doc->id) }}" class="flex-1 py-2 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white text-xs font-black text-center shadow-xs transition-colors">
                        Buat Janji
                    </a>
                </div>

            </div>
        @endforeach
    </div>

</section>

<!-- LOCAL SEO & HOSPITAL COMMITMENT SECTION -->
<section class="py-12 bg-gradient-to-b from-white to-emerald-50/50 border-t border-emerald-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <h2 class="text-xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Layanan Dokter Spesialis Terpercaya di Karawang
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                RSU Fikri Medika Karawang berkomitmen menghadirkan pelayanan kesehatan komprehensif didukung oleh dokter spesialis berpengalaman, fasilitas poliklinik modern, IGD 24 Jam, serta laboratorium dan radiologi terpadu.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-emerald-100 shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#0e7c47] flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-hospital-user"></i>
                </div>
                <h3 class="text-base font-extrabold text-slate-900">Dokter Spesialis Lengkap</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Tersedia dokter spesialis anak, kandungan (obgyn), penyakit dalam (Sp.PD), bedah, jantung, saraf, mata, THT, ortopedi, gigi, kulit, dan spesialis lainnya di Karawang.
                </p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-emerald-100 shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#0e7c47] flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-truck-medical"></i>
                </div>
                <h3 class="text-base font-extrabold text-slate-900">IGD 24 Jam & Layanan Darurat</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Siap melayani penanganan gawat darurat medis setiap saat dengan tim medis cepat tanggap dan ambulans siaga di kawasan Klari - Karawang Timur.
                </p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-emerald-100 shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#0e7c47] flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <h3 class="text-base font-extrabold text-slate-900">Pendaftaran Online Mudah</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Pendaftaran janji temu dokter dapat dilakukan secara online melalui website resmi atau WhatsApp Call Center RSU Fikri Medika.
                </p>
            </div>
        </div>

        <!-- LOCAL KARAWANG ADDRESS & CONTACT BANNER -->
        <div class="bg-gradient-to-r from-[#096237] to-[#0e7c47] text-white p-6 sm:p-8 rounded-3xl shadow-md flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center md:text-left">
                <h3 class="text-lg sm:text-xl font-black text-white">Butuh Informasi Jadwal atau Konsultasi Dokter di Karawang?</h3>
                <p class="text-xs sm:text-sm text-emerald-100">
                    Alamat: Jl. Raya Kosambi - Telagasari, Klari, Karawang, Jawa Barat 41371 | Telepon: (0267) 861-5555
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="https://wa.me/6281287075555?text=Halo%20RSU%20Fikri%20Medika,%20saya%20ingin%20tanya%20jadwal%20dokter" target="_blank" class="px-5 py-2.5 rounded-xl bg-yellow-400 text-slate-900 font-black text-xs sm:text-sm hover:bg-yellow-300 transition-colors shadow-sm flex items-center gap-2">
                    <i class="fa-brands fa-whatsapp text-base"></i>
                    <span>Chat WhatsApp CS</span>
                </a>
                <a href="{{ url('/buat-janji') }}" class="px-5 py-2.5 rounded-xl bg-white text-[#0e7c47] font-black text-xs sm:text-sm hover:bg-emerald-50 transition-colors shadow-sm">
                    Buat Janji Online
                </a>
            </div>
        </div>

    </div>
</section>

<!-- RELATED HEALTH ARTICLES SECTION -->
@if(!empty($featuredArticles) && $featuredArticles->count() > 0)
<section class="py-12 bg-white border-t border-emerald-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight">
                    Edukasi Kesehatan & Rekomendasi Dokter
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">
                    Informasi medis dan tips kesehatan dari tim medis RSU Fikri Medika Karawang.
                </p>
            </div>
            <a href="{{ url('/artikel') }}" class="text-xs sm:text-sm font-bold text-[#0e7c47] hover:underline flex items-center gap-1">
                <span>Lihat Semua</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($featuredArticles as $art)
                <a href="{{ route('artikel.show', $art->slug) }}" class="group bg-slate-50 rounded-2xl p-4 border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/40 transition-all space-y-3 flex flex-col justify-between">
                    <div class="space-y-2">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#0e7c47] bg-emerald-100/70 px-2.5 py-0.5 rounded-full inline-block">
                            Edukasi Medis
                        </span>
                        <h3 class="text-sm font-extrabold text-slate-900 group-hover:text-[#0e7c47] transition-colors line-clamp-2 leading-snug">
                            {{ $art->tr('title') }}
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $art->tr('excerpt') ?: strip_tags($art->tr('content')) }}
                        </p>
                    </div>
                    <div class="text-xs font-bold text-[#0e7c47] flex items-center gap-1 pt-1">
                        <span>Baca Selengkapnya</span>
                        <i class="fa-solid fa-chevron-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
