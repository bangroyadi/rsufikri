@extends('layouts.app')

@php
    $seoService = app(\App\Services\SeoService::class);
    $galleryImages = isset($service) ? $service->gallery_images : [];
    $serviceImg = isset($service) && !empty($service->image)
        ? (\Illuminate\Support\Str::startsWith($service->image, ['http://', 'https://']) ? $service->image : asset($service->image))
        : null;
    $iconClass = isset($service) && $service->icon ? (str_starts_with($service->icon, 'fa-') ? $service->icon : 'fa-'.$service->icon) : 'fa-star';
    $waTitle = urlencode("Halo RSU Fikri Medika, saya ingin mengetahui lebih lanjut mengenai layanan: " . $title);
    $serviceDesc = $seoService->sanitizeText(isset($service) ? ($service->tr('short_description') ?: $service->tr('description')) : null, 160);
    $currentUrl = url()->current();
@endphp

@section('title', $title . ' | RSU Fikri Medika Karawang')
@section('meta_description', $serviceDesc)
@section('canonical_url', $currentUrl)
@section('og_image', $serviceImg ?: asset('gedung1_web.jpg'))

@section('schema_jsonld')
<script type="application/ld+json">
{!! json_encode($seoService->generateBreadcrumbSchema([
    'Beranda' => url('/'),
    'Layanan Unggulan' => url('/layanan/unggulan'),
    $title => $currentUrl
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

@section('content')

<div class="bg-slate-50 min-h-screen" x-data="serviceGalleryApp({{ json_encode($galleryImages) }})">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-8">

        {{-- ═══════════════════════════════════════════
             SPOTLIGHT CARD (GAMBAR KIRI, KONTEN KANAN)
        ═══════════════════════════════════════════ --}}
        <div class="relative bg-white rounded-3xl shadow-xs hover:shadow-md border border-gray-100 overflow-hidden transition-all duration-300">
            <div class="grid grid-cols-1 lg:grid-cols-12 items-stretch">

                {{-- IMAGE PANEL (5 COLS) --}}
                <div class="lg:col-span-5 relative bg-slate-900 min-h-[260px] sm:min-h-[340px] overflow-hidden">
                    @if($serviceImg)
                    <img src="{{ $serviceImg }}" alt="{{ $title }}" class="w-full h-full object-cover">
                    @else
                    <img src="{{ asset('gedung1_web.jpg') }}" alt="{{ $title }}" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>

                    {{-- SPOTLIGHT BADGE --}}
                    <div class="absolute top-4 left-4 px-3 py-1 rounded-full bg-amber-400 text-slate-950 font-black text-xs shadow-xs uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-star text-amber-900"></i>
                        <span>Layanan Unggulan</span>
                    </div>

                    {{-- BOTTOM 24H BADGE --}}
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
                                Layanan Unggulan
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
                        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 leading-snug">
                            {{ $title }}
                        </h1>

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

                        {{-- KEUNGGULAN GRID --}}
                        <div class="pt-2 border-t border-gray-100 space-y-2">
                            <div class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                                <i class="fa-solid fa-medal text-[#0e7c47]"></i>
                                <span>Keunggulan Layanan:</span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach(['Tenaga Medis Berpengalaman', 'Peralatan Canggih & Modern', 'Pelayanan Cepat & Responsif', 'Terakreditasi Paripurna'] as $kgl)
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
                            <span>RSU Fikri Medika, Jl. Raya Kosambi - Telagasari, Klari, Karawang</span>
                        </div>
                    </div>

                    {{-- CTA ROW --}}
                    <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex flex-wrap items-center gap-1.5">
                            @foreach(['Buka 24 Jam', 'BPJS Diterima', 'Ambulans Siaga'] as $tag)
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
             3. BENEFIT & FASILITAS GALLERY SECTION
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
             4. KONTAK MARKETING & KEMITRAAN
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

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                <a href="https://wa.me/6281316720656?text=Halo%20Ulfah%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20layanan%20{{ urlencode($title) }}"
                   target="_blank"
                   class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3 group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="font-extrabold text-slate-900 text-xs group-hover:text-[#0e7c47] transition-colors truncate">Ulfah</div>
                        <div class="text-[11px] text-slate-500 font-mono mt-0.5 truncate">0813-1672-0656</div>
                    </div>
                </a>

                <a href="https://wa.me/6285714285901?text=Halo%20Ken%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20layanan%20{{ urlencode($title) }}"
                   target="_blank"
                   class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3 group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="font-extrabold text-slate-900 text-xs group-hover:text-[#0e7c47] transition-colors truncate">Ken</div>
                        <div class="text-[11px] text-slate-500 font-mono mt-0.5 truncate">0857-1428-5901</div>
                    </div>
                </a>

                <a href="https://wa.me/6285879121294?text=Halo%20Adel%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20layanan%20{{ urlencode($title) }}"
                   target="_blank"
                   class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3 group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="font-extrabold text-slate-900 text-xs group-hover:text-[#0e7c47] transition-colors truncate">Adel</div>
                        <div class="text-[11px] text-slate-500 font-mono mt-0.5 truncate">0858-7912-1294</div>
                    </div>
                </a>

                <a href="https://wa.me/6282123872110?text=Halo%20Itje%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20layanan%20{{ urlencode($title) }}"
                   target="_blank"
                   class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3 group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="font-extrabold text-slate-900 text-xs group-hover:text-[#0e7c47] transition-colors truncate">Itje</div>
                        <div class="text-[11px] text-slate-500 font-mono mt-0.5 truncate">0821-2387-2110</div>
                    </div>
                </a>

                <a href="https://wa.me/628988965646?text=Halo%20Rina%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20layanan%20{{ urlencode($title) }}"
                   target="_blank"
                   class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3 group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="font-extrabold text-slate-900 text-xs group-hover:text-[#0e7c47] transition-colors truncate">Rina</div>
                        <div class="text-[11px] text-slate-500 font-mono mt-0.5 truncate">0898-8965-646</div>
                    </div>
                </a>

                <a href="https://wa.me/6281384656298?text=Halo%20Ai%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20layanan%20{{ urlencode($title) }}"
                   target="_blank"
                   class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3 group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="font-extrabold text-slate-900 text-xs group-hover:text-[#0e7c47] transition-colors truncate">Ai</div>
                        <div class="text-[11px] text-slate-500 font-mono mt-0.5 truncate">0813-8465-6298</div>
                    </div>
                </a>
            </div>
        </div>

    </div>

    {{-- LIGHTBOX MODAL --}}
    <div x-show="lightboxOpen"
         x-cloak
         @keydown.escape.window="closeLightbox()"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4 backdrop-blur-sm"
         style="display: none;">
        <button @click="closeLightbox()"
                class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-50 p-2 cursor-pointer">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <button @click="prevImage()"
                class="absolute left-4 top-1/2 -translate-y-1/2 text-white text-3xl hover:text-gray-300 z-50 p-3 bg-white/10 hover:bg-white/20 rounded-full cursor-pointer transition">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button @click="nextImage()"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-white text-3xl hover:text-gray-300 z-50 p-3 bg-white/10 hover:bg-white/20 rounded-full cursor-pointer transition">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
        <div class="relative max-w-5xl max-h-[85vh] flex flex-col items-center justify-center">
            <img :src="images[activeImageIndex]"
                 alt="{{ $title }}"
                 class="max-w-full max-h-[80vh] object-contain rounded-xl shadow-2xl">
            <div class="text-white text-center text-xs mt-3 bg-slate-900/80 px-4 py-1.5 rounded-full border border-white/10">
                <span x-text="activeImageIndex + 1"></span> / <span x-text="images.length"></span>
            </div>
        </div>
    </div>

</div>

<script>
function serviceGalleryApp(initialImages) {
    return {
        images: initialImages || [],
        lightboxOpen: false,
        activeImageIndex: 0,
        openLightbox(index) {
            this.activeImageIndex = index;
            this.lightboxOpen = true;
            document.body.style.overflow = 'hidden';
        },
        closeLightbox() {
            this.lightboxOpen = false;
            document.body.style.overflow = 'auto';
        },
        nextImage() {
            if (this.images.length > 0) {
                this.activeImageIndex = (this.activeImageIndex + 1) % this.images.length;
            }
        },
        prevImage() {
            if (this.images.length > 0) {
                this.activeImageIndex = (this.activeImageIndex - 1 + this.images.length) % this.images.length;
            }
        }
    }
}
</script>
@endsection
