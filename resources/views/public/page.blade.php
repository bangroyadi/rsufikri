@extends('layouts.app')

@section('content')

@php
    $galleryImages = isset($service) ? $service->gallery_images : [];
    $serviceImg = isset($service) && !empty($service->image)
        ? (\Illuminate\Support\Str::startsWith($service->image, ['http://', 'https://']) ? $service->image : asset($service->image))
        : null;
    $iconClass = isset($service) && $service->icon ? 'fa-'.$service->icon : ($category === 'Layanan' ? 'fa-user-nurse' : 'fa-circle-info');
    $waTitle = urlencode("Halo RSU Fikri Medika, saya ingin mengetahui lebih lanjut mengenai layanan: " . $title);
@endphp

<div class="bg-slate-50 min-h-screen" x-data="serviceGalleryApp({{ json_encode($galleryImages) }})">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-8">

        {{-- ═══════════════════════════════════════════
             1. HEADER SECTION (gaya event)
        ═══════════════════════════════════════════ --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-gray-100 space-y-3">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-[#0e7c47] text-xs font-black uppercase tracking-wider">
                <i class="fa-solid {{ $iconClass }} text-[#0e7c47]"></i>
                <span>{{ $category }} RSU Fikri Medika</span>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                {{ $title }}
            </h1>
            @if(isset($service) && !empty($service->tr('short_description')))
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal max-w-3xl">
                {{ $service->tr('short_description') }}
            </p>
            @else
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal max-w-3xl">
                Komitmen RSU Fikri Medika dalam memberikan pelayanan terbaik, cepat, dan berstandar medis tinggi dengan mengedepankan empati dan prinsip-prinsip profesional untuk kesehatan Anda dan keluarga.
            </p>
            @endif
        </div>

        {{-- ═══════════════════════════════════════════
             2. SPOTLIGHT CARD (gambar kiri, konten kanan - gaya featured event)
        ═══════════════════════════════════════════ --}}
        <div class="relative bg-white rounded-3xl shadow-xs hover:shadow-md border border-gray-100 overflow-hidden transition-all duration-300">
            <div class="grid grid-cols-1 lg:grid-cols-12 items-stretch">

                {{-- IMAGE PANEL (5 COLS) --}}
                <div class="lg:col-span-5 relative bg-slate-900 min-h-[260px] sm:min-h-[340px] overflow-hidden">
                    @if($serviceImg)
                    <img src="{{ $serviceImg }}" alt="{{ $title }}" class="w-full h-full object-cover">
                    @else
                    <img src="{{ asset('gedung_profile.jpg') }}" alt="{{ $title }}" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>

                    {{-- SPOTLIGHT BADGE --}}
                    <div class="absolute top-4 left-4 px-3 py-1 rounded-full bg-amber-400 text-slate-950 font-black text-xs shadow-xs uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-star text-amber-900"></i>
                        <span>Layanan Unggulan</span>
                    </div>

                    {{-- BOTTOM DATE-STYLE BADGE --}}
                    <div class="absolute bottom-4 left-4 right-4 p-3 rounded-2xl bg-slate-900/90 backdrop-blur-md border border-white/10 text-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-black flex flex-col items-center justify-center text-xs leading-none shadow-xs">
                                <i class="fa-solid fa-clock text-base"></i>
                            </div>
                            <div>
                                <div class="text-xs font-bold">Tersedia 24 Jam / 7 Hari</div>
                                <div class="text-[11px] text-emerald-300 flex items-center gap-1">
                                    <i class="fa-regular fa-clock text-[10px]"></i>
                                    <span>RSU Fikri Medika, Karawang</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CONTENT PANEL (7 COLS) --}}
                <div class="lg:col-span-7 p-6 sm:p-8 flex flex-col justify-between space-y-6">
                    <div class="space-y-4">

                        {{-- BADGES ROW --}}
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-3 py-1 rounded-lg bg-emerald-50 text-[#0e7c47] font-black text-xs uppercase tracking-wider border border-emerald-100">
                                {{ $category }}
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

                        {{-- TITLE --}}
                        <h2 class="text-xl sm:text-2xl font-black text-slate-900 leading-snug">
                            {{ $title }}
                        </h2>

                        {{-- DESCRIPTION --}}
                        @if(isset($service) && !empty($service->tr('description')))
                        <div class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal prose max-w-none">
                            {!! nl2br(e($service->tr('description'))) !!}
                        </div>
                        @else
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Selamat datang di halaman resmi <strong>{{ $title }}</strong> RSU Fikri Medika Karawang.
                            Kami berkomitmen untuk memberikan pelayanan terbaik, tercepat, dan berstandar medis tinggi
                            dengan mengedepankan empati dan prinsip-prinsip Islami.
                        </p>
                        @endif

                        {{-- KEUNGGULAN GRID (gaya speaker cards) --}}
                        <div class="pt-2 border-t border-gray-100 space-y-2">
                            <div class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                                <i class="fa-solid fa-medal text-[#0e7c47]"></i>
                                <span>Keunggulan Layanan:</span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach(['Tenaga Medis Berpengalaman', 'Peralatan Canggih & Modern', 'Pelayanan Cepat & Responsif', 'Terakreditasi Nasional'] as $kgl)
                                <div class="p-2.5 rounded-xl bg-slate-50 border border-gray-100 flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-[#0e7c47] flex items-center justify-center font-bold text-xs shrink-0">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </div>
                                    <div class="font-bold text-xs text-slate-900">{{ $kgl }}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- LOCATION --}}
                        <div class="text-xs font-semibold text-slate-700 flex items-start gap-2 pt-1">
                            <i class="fa-solid fa-location-dot text-red-500 text-sm mt-0.5 shrink-0"></i>
                            <span>RSU Fikri Medika, Jl. Arteri Interchange Karawang Barat, Karawang</span>
                        </div>
                    </div>

                    {{-- CTA ROW (gaya benefit + daftar button) --}}
                    <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex flex-wrap items-center gap-1.5">
                            @foreach(['Buka 24 Jam', 'BPJS Diterima', 'Akreditasi RS'] as $tag)
                            <span class="px-2.5 py-1 rounded-md bg-emerald-50 text-[#0e7c47] text-[11px] font-bold border border-emerald-100 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check text-xs"></i>
                                <span>{{ $tag }}</span>
                            </span>
                            @endforeach
                        </div>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile?->whatsapp ?: '089678211575') }}?text={{ $waTitle }}"
                           target="_blank"
                           style="background-color: #0e7c47; color: #ffffff;"
                           class="w-full sm:w-auto px-6 py-3 rounded-2xl font-black text-xs shadow-xs hover:bg-[#096237] transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-95 shrink-0">
                            <i class="fa-brands fa-whatsapp text-base"></i>
                            <span>Daftar / Reservasi</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        {{-- ═══════════════════════════════════════════
             3. GALLERY / BENEFIT SECTION
        ═══════════════════════════════════════════ --}}
        @if(!empty($galleryImages) && count($galleryImages) > 0)
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-gray-100 space-y-6">
            <div class="border-b border-gray-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-[#0e7c47] text-xs font-black uppercase tracking-wider">
                        <i class="fa-solid fa-gift text-xs"></i>
                        <span>Benefit & Fasilitas Layanan</span>
                    </span>
                    <h2 class="text-xl font-black text-slate-900 mt-2">Keuntungan Eksklusif Pasien</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Klik pada gambar untuk melihat detail voucher & paket benefit</p>
                </div>
            </div>
            <div class="flex flex-wrap justify-center items-center gap-3 sm:gap-4 max-w-4xl mx-auto">
                <template x-for="(img, idx) in images" :key="idx">
                    <div @click="openLightbox(idx)"
                         class="group relative w-28 sm:w-32 md:w-36 h-36 sm:h-42 md:h-46 rounded-2xl overflow-hidden bg-white border border-slate-200 shadow-xs hover:shadow-md cursor-pointer transition-all duration-300 hover:-translate-y-1.5 hover:border-[#0e7c47] flex items-center justify-center p-2 shrink-0">
                        <img :src="img" alt="{{ $title }}"
                             class="max-w-full max-h-full w-auto h-auto object-contain transition-transform duration-300 group-hover:scale-105">
                        <div class="absolute inset-0 bg-slate-950/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-2xl">
                            <div class="w-7 h-7 rounded-full bg-white/95 text-slate-800 flex items-center justify-center shadow-md text-xs font-bold">
                                <i class="fa-solid fa-magnifying-glass-plus"></i>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        @endif

        {{-- ═══════════════════════════════════════════
             4. KONTAK MARKETING (gaya marketing team cards event)
        ═══════════════════════════════════════════ --}}
        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xs border border-gray-100 space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-6">
                <div>
                    <span class="text-xs font-extrabold text-[#0e7c47] uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-handshake-angle"></i>
                        <span>Informasi & Konsultasi Marketing</span>
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Kontak Tim Marketing & Kemitraan</h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-0.5">Konsultasi paket benefit, estimasi biaya, penjaminan asuransi & kerjasama perusahaan bersama tim Marketing RSU Fikri Medika.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <a href="https://wa.me/6281316720656?text=Halo%20Ibu%20Ulfah%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20layanan%20{{ urlencode($title) }}"
                   target="_blank"
                   class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3.5 group shadow-2xs">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-lg font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-slate-900 text-xs sm:text-sm group-hover:text-[#0e7c47] transition-colors">Ibu Ulfah</div>
                        <div class="text-xs text-slate-500 font-mono mt-0.5">0813-1672-0656</div>
                    </div>
                </a>

                <a href="https://wa.me/6281384656298?text=Halo%20Ibu%20Ai%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20layanan%20{{ urlencode($title) }}"
                   target="_blank"
                   class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3.5 group shadow-2xs">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-lg font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-slate-900 text-xs sm:text-sm group-hover:text-[#0e7c47] transition-colors">Ibu Ai</div>
                        <div class="text-xs text-slate-500 font-mono mt-0.5">0813-8465-6298</div>
                    </div>
                </a>

                <a href="https://wa.me/628988965646?text=Halo%20Ibu%20Rina%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20layanan%20{{ urlencode($title) }}"
                   target="_blank"
                   class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3.5 group shadow-2xs">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-lg font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-slate-900 text-xs sm:text-sm group-hover:text-[#0e7c47] transition-colors">Ibu Rina</div>
                        <div class="text-xs text-slate-500 font-mono mt-0.5">0898-8965-646</div>
                    </div>
                </a>

                <a href="https://wa.me/6281382895002?text=Halo%20Ibu%20Itje%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20layanan%20{{ urlencode($title) }}"
                   target="_blank"
                   class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3.5 group shadow-2xs">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-lg font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-slate-900 text-xs sm:text-sm group-hover:text-[#0e7c47] transition-colors">Ibu Itje</div>
                        <div class="text-xs text-slate-500 font-mono mt-0.5">0813-8289-5002</div>
                    </div>
                </a>
            </div>

            {{-- OPERASIONAL & INFO CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-gray-100 mt-2">
                <div class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-sm shrink-0">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 text-xs">Operasional</div>
                        <div class="text-xs text-slate-600 mt-0.5">Siaga 24 Jam / 7 Hari Seminggu</div>
                    </div>
                </div>
                <div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center text-sm shrink-0">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 text-xs">Pendaftaran & Info</div>
                        <div class="text-xs text-slate-600 mt-0.5">{{ $profile?->whatsapp ?: '0896-7821-1575' }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════
         FULLSCREEN LIGHTBOX MODAL
    ═══════════════════════════════════════════ --}}
    <div x-show="lightboxOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/85 backdrop-blur-xs"
         style="display: none;">

        <div @click.away="lightboxOpen = false"
             class="bg-slate-900 w-full max-w-3xl rounded-2xl shadow-2xl overflow-hidden relative flex flex-col max-h-[90vh] border border-slate-700">

            <div class="p-3 sm:p-4 flex items-center justify-between border-b border-slate-800 bg-slate-950/80 text-white">
                <span class="text-xs font-bold truncate">{{ $title }}</span>
                <button type="button" @click="lightboxOpen = false" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 text-white flex items-center justify-center transition-colors cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <div class="relative flex-1 bg-slate-950 flex items-center justify-center min-h-[280px] max-h-[65vh] p-2">
                <template x-for="(img, idx) in images" :key="'lb-'+idx">
                    <img x-show="activeIndex === idx" :src="img" alt="{{ $title }}"
                         class="max-w-full max-h-[60vh] object-contain rounded-lg">
                </template>
                <template x-if="images.length > 1">
                    <div class="absolute inset-0 flex items-center justify-between p-3 pointer-events-none">
                        <button type="button" @click="prevImage()" class="w-10 h-10 rounded-full bg-slate-950/70 hover:bg-slate-950 text-white flex items-center justify-center pointer-events-auto transition-all shadow-md active:scale-95 cursor-pointer">
                            <i class="fa-solid fa-chevron-left text-sm"></i>
                        </button>
                        <button type="button" @click="nextImage()" class="w-10 h-10 rounded-full bg-slate-950/70 hover:bg-slate-950 text-white flex items-center justify-center pointer-events-auto transition-all shadow-md active:scale-95 cursor-pointer">
                            <i class="fa-solid fa-chevron-right text-sm"></i>
                        </button>
                    </div>
                </template>
            </div>

            <div class="p-3 border-t border-slate-800 bg-slate-950/90 flex items-center justify-between text-xs text-slate-400">
                <span>Foto <strong class="text-white" x-text="activeIndex + 1"></strong> dari <strong class="text-white" x-text="images.length"></strong></span>
                <button type="button" @click="lightboxOpen = false" class="px-3 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold">Tutup</button>
            </div>
        </div>
    </div>

</div>

<script>
function serviceGalleryApp(initialImages) {
    return {
        images: Array.isArray(initialImages) ? initialImages : [],
        activeIndex: 0,
        lightboxOpen: false,
        openLightbox(index) {
            this.activeIndex = index;
            this.lightboxOpen = true;
        },
        nextImage() {
            if (this.images.length === 0) return;
            this.activeIndex = (this.activeIndex === this.images.length - 1) ? 0 : this.activeIndex + 1;
        },
        prevImage() {
            if (this.images.length === 0) return;
            this.activeIndex = (this.activeIndex === 0) ? this.images.length - 1 : this.activeIndex - 1;
        }
    };
}
</script>

@endsection
