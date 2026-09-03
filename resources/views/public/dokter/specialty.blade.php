@extends('layouts.app')

@php
    $seoService = app(\App\Services\SeoService::class);
    $poliNameId = is_array($polyclinic->name) ? ($polyclinic->name['id'] ?? $polyclinic->name['en'] ?? '') : $polyclinic->name;
    $cleanSpecialtyName = $cleanPoliNameOnly ?? preg_replace('/^Poli\s+/i', '', $poliNameId);
    $canonicalUrl = $canonicalUrl ?? url('/dokter/' . $polyclinic->slug . '-karawang');
    $pageTitle = $pageTitle ?? "Dokter Spesialis {$cleanSpecialtyName} di Karawang | RSU Fikri Medika";
    $pageH1 = $pageH1 ?? "Dokter Spesialis {$cleanSpecialtyName} di Karawang";
    $pageDescription = $pageDescription ?? "Temukan dokter spesialis {$cleanSpecialtyName} di RSU Fikri Medika Karawang beserta profil, jadwal praktik, poliklinik dan informasi pendaftaran janji temu.";
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDescription)
@section('canonical_url', $canonicalUrl)

@section('schema_jsonld')
<script type="application/ld+json">
{!! json_encode($seoService->generateBreadcrumbSchema([
    'Beranda' => url('/'),
    'Dokter di Karawang' => url('/dokter-di-karawang'),
    "Dokter Spesialis {$cleanSpecialtyName}" => $canonicalUrl
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<script type="application/ld+json">
{!! json_encode($seoService->generateSpecialtySchema($polyclinic, $doctors), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
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
        <span class="text-[#0e7c47] font-bold">Dokter Spesialis {{ $cleanSpecialtyName }}</span>
    </div>
</nav>

<!-- MAIN CONTENT SECTION -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-8">

    <!-- DOCTOR LIST & PRACTICE SCHEDULES -->
    <section id="daftar-dokter-spesialis" class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 border-b border-gray-200 pb-4">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-xs font-black tracking-wider uppercase text-[#0e7c47] mb-1">
                    <i class="fa-solid fa-{{ $polyclinic->icon ?: 'stethoscope' }}"></i>
                    <span>POLIKLINIK SPESIALIS KARAWANG</span>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                    Daftar Dokter Spesialis {{ $cleanSpecialtyName }} & Jadwal Praktik di Karawang
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Berikut daftar nama dokter spesialis {{ strtolower($cleanSpecialtyName) }}, kualifikasi, profil, dan jadwal praktik di RSU Fikri Medika Karawang.
                </p>
            </div>
            <span class="text-xs font-extrabold text-[#0e7c47] bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-full self-start sm:self-auto shrink-0">
                {{ $doctors->count() }} Dokter Praktik
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($doctors as $doc)
                @php
                    $docPhoto = $doc->photo;
                    $docUrl = $doc->route_url;
                    $specName = $doc->specialty_name;
                @endphp
                <div class="bg-white rounded-3xl border-2 border-emerald-100/90 p-5 sm:p-6 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all flex flex-col justify-between space-y-5">
                    <!-- DOCTOR HEADER -->
                    <div class="flex items-start gap-4">
                        <a href="{{ $docUrl }}" class="shrink-0 group">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl overflow-hidden border-2 border-emerald-500 p-0.5 bg-emerald-50 shadow-sm relative">
                                @if(!empty($docPhoto))
                                    <img src="{{ $docPhoto }}" 
                                         alt="{{ $doc->name }} {{ $doc->title_degree }} dokter spesialis {{ $cleanSpecialtyName }} RSU Fikri Medika Karawang" 
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

                        <div class="space-y-1.5 flex-1 min-w-0">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-[#0e7c47] text-[11px] font-extrabold border border-emerald-200">
                                <i class="fa-solid fa-stethoscope text-[10px]"></i>
                                <span>Spesialis {{ $cleanSpecialtyName }}</span>
                            </span>

                            <h3 class="text-base sm:text-lg font-black text-slate-900 leading-snug">
                                <a href="{{ $docUrl }}" class="hover:text-[#0e7c47] transition-colors">
                                    {{ $doc->name }}
                                </a>
                            </h3>

                            <p class="text-xs text-slate-500 font-semibold line-clamp-1">
                                Bidang: <span class="text-slate-800 font-bold">{{ $specName }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- PRACTICE SCHEDULES -->
                    <div class="space-y-2 bg-slate-50/80 rounded-2xl p-3.5 border border-slate-200/70">
                        <div class="text-[11px] font-extrabold text-slate-700 uppercase tracking-wider flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-calendar-days text-[#0e7c47]"></i>
                                <span>Jadwal Praktik Harian</span>
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
                                <i class="fa-regular fa-clock mr-1"></i> Jadwal praktik dokter ini dapat dikonfirmasi via CS WhatsApp.
                            </div>
                        @endif
                    </div>

                    <!-- CTA BUTTONS -->
                    <div class="flex items-center gap-2 pt-1">
                        <a href="{{ $docUrl }}" class="flex-1 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-extrabold text-center transition-colors">
                            Lihat Profil
                        </a>
                        <a href="{{ url('/jadwal-dokter?spesialis=' . $polyclinic->slug) }}" class="px-3.5 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-[#0e7c47] border border-emerald-200 text-xs font-extrabold text-center transition-colors">
                            Jadwal
                        </a>
                        <a href="{{ url('/buat-janji?dokter_id=' . $doc->id) }}" class="flex-1 py-2 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white text-xs font-black text-center shadow-xs transition-colors">
                            Buat Janji
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-12 bg-white rounded-3xl border border-gray-100 p-8 space-y-3">
                    <i class="fa-solid fa-user-doctor text-4xl text-gray-300"></i>
                    <h4 class="font-bold text-gray-700 text-base">Informasi Dokter Sedang Diperbarui</h4>
                    <p class="text-xs text-gray-500">Silakan hubungi Call Center RSU Fikri Medika untuk informasi jadwal dokter spesialis {{ $cleanSpecialtyName }}.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- FAQ SECTION FOR TOPICAL AUTHORITY -->
    <section class="bg-white rounded-3xl p-6 sm:p-8 border border-emerald-100 shadow-sm space-y-6">
        <div>
            <h2 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight">
                Pertanyaan Umum Seputar Dokter Spesialis {{ $cleanSpecialtyName }} di Karawang
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Informasi penting yang sering ditanyakan pasien mengenai konsultasi dan jadwal dokter.
            </p>
        </div>

        <div class="space-y-4">
            <div class="bg-slate-50 rounded-2xl p-4 sm:p-5 border border-slate-200/80 space-y-2">
                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-circle-question text-[#0e7c47]"></i>
                    <span>Kapan saya harus berkonsultasi ke dokter spesialis {{ strtolower($cleanSpecialtyName) }}?</span>
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed pl-6">
                    Anda disarankan berkonsultasi jika mengalami gejala atau keluhan spesifik yang berkaitan dengan bidang {{ strtolower($cleanSpecialtyName) }}, membutuhkan pemeriksaan lanjutan, rujukan dari dokter umum, atau untuk penanganan kondisi medis kronis.
                </p>
            </div>

            <div class="bg-slate-50 rounded-2xl p-4 sm:p-5 border border-slate-200/80 space-y-2">
                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-circle-question text-[#0e7c47]"></i>
                    <span>Bagaimana cara mendaftar atau membuat janji temu dokter di RSU Fikri Medika?</span>
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed pl-6">
                    Pendaftaran janji temu dapat dilakukan secara online melalui tombol <strong>Buat Janji Online</strong> pada website ini atau melalui nomor WhatsApp Customer Service RSU Fikri Medika Karawang.
                </p>
            </div>

            <div class="bg-slate-50 rounded-2xl p-4 sm:p-5 border border-slate-200/80 space-y-2">
                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-circle-question text-[#0e7c47]"></i>
                    <span>Apakah RSU Fikri Medika melayani pasien BPJS dan Asuransi?</span>
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed pl-6">
                    Ya, RSU Fikri Medika melayani pasien umum, BPJS Kesehatan (sesuai ketentuan rujukan yang berlaku), serta berbagai rekanan asuransi kesehatan swasta dan perusahaan di wilayah Karawang.
                </p>
            </div>
        </div>
    </section>

    <!-- OTHER SPECIALTIES NAVIGATION (INTERNAL LINKING) -->
    @if(!empty($allPolyclinics) && $allPolyclinics->count() > 0)
    <section class="space-y-4">
        <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">
            Lihat Dokter Spesialis Lainnya di Karawang
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
            @foreach($allPolyclinics as $otherPoli)
                @php
                    $otherName = is_array($otherPoli->name) ? ($otherPoli->name['id'] ?? $otherPoli->name['en'] ?? '') : $otherPoli->name;
                    $cleanOtherName = preg_replace('/^Poli\s+/i', '', $otherName);
                @endphp
                <a href="{{ url('/dokter/' . $otherPoli->slug . '-karawang') }}" 
                   class="p-3 rounded-2xl bg-white hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 transition-all text-center space-y-1 group">
                    <i class="fa-solid fa-{{ $otherPoli->icon ?: 'stethoscope' }} text-[#0e7c47] text-sm group-hover:scale-110 transition-transform"></i>
                    <div class="text-xs font-bold text-slate-800 group-hover:text-[#0e7c47] line-clamp-1">
                        {{ $cleanOtherName }}
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

</div>

@endsection
