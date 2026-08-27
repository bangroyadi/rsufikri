@extends('layouts.app')

@section('title', 'Layanan Unggulan - RSU Fikri Medika')

@section('content')
<div class="bg-slate-50 min-h-screen">

    <!-- MAIN CONTAINER -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-8">

        <!-- TITLE & HEADER SECTION -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-gray-100 space-y-3">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-[#0e7c47] text-xs font-black uppercase tracking-wider">
                <i class="fa-solid fa-star text-[#0e7c47]"></i>
                <span>Fasilitas Utama Rumah Sakit</span>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                Layanan Unggulan RSU Fikri Medika
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal max-w-3xl">
                RSU Fikri Medika Karawang menyediakan berbagai fasilitas layanan unggulan yang didukung oleh dokter spesialis berpengalaman, perawat profesional, serta peralatan medis canggih 24 jam untuk memberikan pelayanan kesehatan terbaik, cepat, dan terpercaya bagi Anda dan keluarga.
            </p>
        </div>

        <!-- FEATURED / SPOTLIGHT SERVICE (FIRST SERVICE) -->
        @php $featured = $services->first(); @endphp
        @if($featured)
        @php
            $fName = $featured->tr('name');
            $fDesc = $featured->tr('short_description');
            $fImg = !empty($featured->image)
                ? (str_starts_with($featured->image, ['http://', 'https://']) ? $featured->image : asset($featured->image))
                : asset('gedung1_web.jpg');
            $fSlug = $featured->slug ?: \Illuminate\Support\Str::slug($fName);
            $fWaText = urlencode("Halo RSU Fikri Medika, saya ingin mengetahui lebih lanjut mengenai layanan: " . $fName);
        @endphp
        <div class="relative bg-white rounded-3xl shadow-xs hover:shadow-md border border-gray-100 overflow-hidden transition-all duration-300">
            <div class="grid grid-cols-1 lg:grid-cols-12 items-stretch">

                <!-- IMAGE BANNER (5 COLS) -->
                <div class="lg:col-span-5 relative bg-slate-900 min-h-[260px] sm:min-h-[340px] overflow-hidden">
                    <img src="{{ $fImg }}" alt="{{ $fName }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>

                    <!-- SPOTLIGHT BADGE -->
                    <div class="absolute top-4 left-4 px-3 py-1 rounded-full bg-amber-400 text-slate-950 font-black text-xs shadow-xs uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-star text-amber-900"></i>
                        <span>Layanan Unggulan</span>
                    </div>

                    <!-- BADGE BUKA 24 JAM -->
                    <div class="absolute bottom-4 left-4 right-4 p-3 rounded-2xl bg-slate-900/90 backdrop-blur-md border border-white/10 text-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-black flex flex-col items-center justify-center text-xs leading-none shadow-xs">
                                <i class="fa-solid fa-clock-rotate-left text-base"></i>
                            </div>
                            <div>
                                <div class="text-xs font-bold">Tersedia 24 Jam</div>
                                <div class="text-[11px] text-emerald-300 flex items-center gap-1">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                                    <span>Buka Setiap Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONTENT (7 COLS) -->
                <div class="lg:col-span-7 p-6 sm:p-8 flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-3 py-1 rounded-lg bg-emerald-50 text-[#0e7c47] font-black text-xs uppercase tracking-wider border border-emerald-100">
                                Layanan Utama
                            </span>
                            <span class="px-3 py-1 rounded-lg bg-slate-50 text-slate-700 font-bold text-xs border border-gray-100 flex items-center gap-1">
                                <i class="fa-solid fa-shield-heart text-emerald-600"></i>
                                <span>BPJS & Umum</span>
                            </span>
                            <span class="px-3 py-1 rounded-lg bg-slate-50 text-slate-700 font-bold text-xs border border-gray-100 flex items-center gap-1">
                                <i class="fa-solid fa-users text-blue-600"></i>
                                <span>Dokter Spesialis</span>
                            </span>
                        </div>

                        <h2 class="text-xl sm:text-2xl font-black text-slate-900 leading-snug">
                            {{ $fName }}
                        </h2>

                        @if($fDesc)
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            {{ $fDesc }}
                        </p>
                        @endif

                        <!-- KEUNGGULAN -->
                        <div class="pt-2 border-t border-gray-100 space-y-2">
                            <div class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                                <i class="fa-solid fa-medal text-[#0e7c47]"></i>
                                <span>Keunggulan Layanan:</span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach(['Tenaga Medis Berpengalaman', 'Peralatan Canggih & Modern', 'Pelayanan Cepat & Responsif', 'Terakreditasi Nasional'] as $keunggulan)
                                <div class="p-2.5 rounded-xl bg-slate-50 border border-gray-100 flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-[#0e7c47] flex items-center justify-center font-bold text-xs shrink-0">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </div>
                                    <div class="font-bold text-xs text-slate-900">{{ $keunggulan }}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- LOCATION -->
                        <div class="text-xs font-semibold text-slate-700 flex items-start gap-2 pt-1">
                            <i class="fa-solid fa-location-dot text-red-500 text-sm mt-0.5 shrink-0"></i>
                            <span>RSU Fikri Medika, Jl. Arteri Interchange Karawang Barat, Karawang</span>
                        </div>
                    </div>

                    <!-- CTA ROW -->
                    <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex flex-wrap items-center gap-1.5">
                            @foreach(['Buka 24 Jam', 'BPJS Diterima', 'Dokter Spesialis'] as $tag)
                            <span class="px-2.5 py-1 rounded-md bg-emerald-50 text-[#0e7c47] text-[11px] font-bold border border-emerald-100 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check text-xs"></i>
                                <span>{{ $tag }}</span>
                            </span>
                            @endforeach
                        </div>

                        <a href="{{ url('/layanan/' . $fSlug) }}"
                           style="background-color: #0e7c47; color: #ffffff;"
                           class="w-full sm:w-auto px-6 py-3 rounded-2xl font-black text-xs shadow-xs hover:bg-[#096237] transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-95 shrink-0">
                            <i class="fa-solid fa-arrow-right text-base"></i>
                            <span>Lihat Detail Layanan</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
        @endif

        <!-- SEARCH BAR -->
        <div x-data="{ search: '' }" class="space-y-6">
            <div class="bg-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl shadow-xs border border-gray-100">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">

                    <!-- LEFT LABEL -->
                    <div class="flex items-center gap-2 text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                        <i class="fa-solid fa-layer-group text-[#0e7c47]"></i>
                        <span>Semua Layanan ({{ $services->count() }})</span>
                    </div>

                    <!-- SEARCH INPUT -->
                    <div class="relative w-full md:w-72 shrink-0">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text"
                               x-model="search"
                               placeholder="Cari layanan..."
                               class="w-full pl-9 pr-4 py-2 text-xs rounded-xl bg-slate-50 border border-gray-200/70 focus:outline-none focus:border-[#0e7c47] focus:bg-white transition-all">
                    </div>
                </div>
            </div>

            <!-- SERVICES GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($services->skip(0) as $serv)
                @php
                    $sName = $serv->tr('name');
                    $sDesc = $serv->tr('short_description');
                    $sSlug = $serv->slug ?: \Illuminate\Support\Str::slug($sName);
                    $sImg = !empty($serv->image)
                        ? (str_starts_with($serv->image, ['http://', 'https://']) ? $serv->image : asset($serv->image))
                        : asset('gedung1_web.jpg');
                    $sWaText = urlencode("Halo RSU Fikri Medika, saya ingin mengetahui lebih lanjut mengenai layanan: " . $sName);
                @endphp
                <div x-show="search === '' || '{{ addslashes(strtolower($sName . ' ' . $sDesc)) }}'.includes(search.toLowerCase())"
                     class="bg-white rounded-3xl overflow-hidden shadow-xs hover:shadow-lg border border-gray-100 hover:border-emerald-200 transition-all duration-300 flex flex-col group hover:-translate-y-1">

                    <!-- SERVICE IMAGE -->
                    <div class="relative w-full aspect-video bg-slate-900 overflow-hidden">
                        <img src="{{ $sImg }}" alt="{{ $sName }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent"></div>

                        <!-- BADGE UNGGULAN -->
                        <div class="absolute top-3 left-3 px-3 py-1 rounded-xl bg-slate-900/90 backdrop-blur-sm text-white border border-white/15 shadow-xs flex items-center gap-2 text-xs font-extrabold">
                            <div class="text-emerald-400 font-black"><i class="fa-solid fa-star text-xs"></i></div>
                            <span class="text-white/90 font-medium">Unggulan</span>
                        </div>

                        <!-- BADGE 24 JAM TOP RIGHT -->
                        <div class="absolute top-3 right-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-600 text-white font-black text-[10px] shadow-xs uppercase tracking-wider">
                                🟢 24 Jam
                            </span>
                        </div>

                        <!-- LOCATION -->
                        <div class="absolute bottom-2.5 left-3 right-3 text-[11px] text-white font-semibold flex items-center gap-1.5 truncate">
                            <i class="fa-solid fa-location-dot text-emerald-400 shrink-0"></i>
                            <span class="truncate">RSU Fikri Medika, Karawang</span>
                        </div>
                    </div>

                    <!-- CARD BODY -->
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <!-- CATEGORY & TYPE -->
                            <div class="flex items-center justify-between text-[11px] font-bold">
                                <span class="px-2.5 py-0.5 rounded-lg bg-emerald-50 text-[#0e7c47] border border-emerald-100 uppercase tracking-wider">
                                    Layanan Medis
                                </span>
                                <span class="text-slate-600 font-extrabold">
                                    BPJS & Umum
                                </span>
                            </div>

                            <!-- TITLE -->
                            <h3 class="font-black text-slate-900 text-base leading-snug group-hover:text-[#0e7c47] transition-colors line-clamp-2">
                                {{ $sName }}
                            </h3>

                            <!-- SHORT DESCRIPTION -->
                            @if($sDesc)
                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed font-normal">
                                {{ $sDesc }}
                            </p>
                            @endif

                            <!-- KEUNGGULAN PILLS -->
                            <div class="pt-2 border-t border-gray-100 space-y-1">
                                <div class="flex items-start gap-1.5 text-xs font-semibold text-slate-700">
                                    <i class="fa-solid fa-circle-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                                    <span>Dokter Spesialis Berpengalaman</span>
                                </div>
                                <div class="flex items-start gap-1.5 text-xs font-semibold text-slate-700">
                                    <i class="fa-solid fa-circle-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                                    <span>Peralatan Medis Canggih</span>
                                </div>
                            </div>
                        </div>

                        <!-- ACTION BUTTON -->
                        <div class="pt-4 border-t border-gray-100 space-y-2">
                            <div class="flex items-center justify-between text-[11px] text-slate-500 font-semibold">
                                <span>Tersedia: <strong>Setiap Hari</strong></span>
                                <span class="flex items-center gap-1"><i class="fa-solid fa-shield-heart text-emerald-500"></i> Akreditasi</span>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ url('/layanan/' . $sSlug) }}"
                                   class="flex-1 py-2.5 rounded-xl font-extrabold text-xs border border-[#0e7c47] text-[#0e7c47] hover:bg-emerald-50 transition-all flex items-center justify-center gap-1.5 active:scale-95 cursor-pointer">
                                    <i class="fa-solid fa-eye text-sm"></i>
                                    <span>Detail</span>
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile?->whatsapp ?: '089678211575') }}?text={{ $sWaText }}"
                                   target="_blank"
                                   style="background-color: #0e7c47; color: #ffffff;"
                                   class="flex-1 py-2.5 rounded-xl font-extrabold text-xs shadow-xs hover:bg-[#096237] transition-all flex items-center justify-center gap-1.5 active:scale-95 cursor-pointer">
                                    <i class="fa-brands fa-whatsapp text-sm"></i>
                                    <span>Daftar</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

            <!-- EMPTY STATE -->
            <div x-show="{{ $services->count() }} === 0" class="bg-white p-12 rounded-3xl border border-gray-100 text-center space-y-3 shadow-xs">
                <i class="fa-solid fa-hospital text-4xl text-slate-300"></i>
                <h3 class="font-black text-slate-800 text-lg">Belum Ada Layanan yang Tersedia</h3>
                <p class="text-xs text-slate-500">Silakan hubungi kami untuk informasi layanan lebih lanjut.</p>
            </div>

        </div><!-- end x-data search -->

        <!-- KEMITRAAN / CTA SECTION -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xs border border-gray-100 space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-6">
                <div>
                    <span class="text-xs font-extrabold text-[#0e7c47] uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-handshake-angle"></i>
                        <span>Konsultasi & Pendaftaran</span>
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Butuh Bantuan & Konsultasi Medis?</h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-0.5">Hubungi tim Call Center RSU Fikri Medika untuk pendaftaran poliklinik, informasi layanan, atau pertanyaan medis lainnya.</p>
                </div>
            </div>

            <!-- CONTACT CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile?->whatsapp ?: '089678211575') }}?text=Halo%20RSU%20Fikri%20Medika,%20saya%20ingin%20mendaftar%20layanan%20unggulan"
                   target="_blank"
                   class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3.5 group shadow-2xs">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-lg font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-slate-900 text-xs sm:text-sm group-hover:text-[#0e7c47] transition-colors">WhatsApp Pendaftaran</div>
                        <div class="text-xs text-slate-500 font-mono mt-0.5">{{ $profile?->whatsapp ?: '0896-7821-1575' }}</div>
                    </div>
                </a>

                <a href="tel:{{ preg_replace('/[^0-9]/', '', $profile?->phone ?: '0267412xxx') }}"
                   class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3.5 group shadow-2xs">
                    <div class="w-11 h-11 rounded-2xl bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors flex items-center justify-center text-lg font-bold shrink-0">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-slate-900 text-xs sm:text-sm group-hover:text-blue-600 transition-colors">Telepon CS / Informasi</div>
                        <div class="text-xs text-slate-500 font-mono mt-0.5">{{ $profile?->phone ?: '(0267) 412-xxx' }}</div>
                    </div>
                </a>

                <a href="tel:{{ preg_replace('/[^0-9]/', '', $profile?->emergency_phone ?: '119') }}"
                   class="p-4 rounded-2xl bg-slate-50 hover:bg-red-50/70 border border-gray-100 hover:border-red-200 transition-all duration-200 flex items-center gap-3.5 group shadow-2xs">
                    <div class="w-11 h-11 rounded-2xl bg-red-100 text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors flex items-center justify-center text-lg font-bold shrink-0">
                        <i class="fa-solid fa-truck-medical"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-slate-900 text-xs sm:text-sm group-hover:text-red-600 transition-colors">IGD 24 Jam (Darurat)</div>
                        <div class="text-xs text-slate-500 font-mono mt-0.5">{{ $profile?->emergency_phone ?: '(0267) IGD-24jam' }}</div>
                    </div>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
