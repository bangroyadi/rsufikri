@extends('layouts.app')

@section('content')

@php
    $galleryImages = isset($service) ? $service->gallery_images : [];
@endphp

<!-- MAIN CONTENT CONTAINER -->
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto" x-data="serviceGalleryApp({{ json_encode($galleryImages) }})">
    <div class="w-full space-y-8">
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
            
            <!-- HEADER -->
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-gray-100">
                <div class="w-12 h-12 rounded-xl bg-[#0e7c47]/10 text-[#0e7c47] flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid {{ isset($service) && $service->icon ? 'fa-'.$service->icon : ($category === 'Layanan' ? 'fa-user-nurse' : 'fa-circle-info') }}"></i>
                </div>
                <div>
                    <span class="text-xs uppercase tracking-wider text-[#0e7c47] font-bold">{{ $category }} RSU Fikri Medika</span>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $title }}</h2>
                </div>
            </div>

            <!-- COVER IMAGE -->
            @if(isset($service) && !empty($service->image))
            @php
                $detailImg = \Illuminate\Support\Str::startsWith($service->image, ['http://', 'https://']) ? $service->image : asset($service->image);
            @endphp
            <div class="mb-6 rounded-2xl overflow-hidden shadow-sm max-h-96 border border-gray-100">
                <img src="{{ $detailImg }}" alt="{{ $title }}" class="w-full h-full object-cover">
            </div>
            @endif

            <!-- DESCRIPTION PROSE -->
            <div class="prose max-w-none text-gray-600 leading-relaxed space-y-4 text-sm sm:text-base">
                @if(isset($service) && !empty($service->tr('short_description')))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100 font-medium text-emerald-900 text-sm sm:text-base leading-relaxed">
                    {{ $service->tr('short_description') }}
                </div>
                @endif

                @if(isset($service) && !empty($service->tr('description')))
                <div>
                    {!! nl2br(e($service->tr('description'))) !!}
                </div>
                @else
                <p>
                    Selamat datang di halaman resmi <strong>{{ $title }}</strong> RSU Fikri Medika Karawang. 
                    Kami berkomitmen untuk memberikan pelayanan terbaik, tercepat, dan berstandar medis tinggi dengan mengedepankan empati dan prinsip-prinsip Islami.
                </p>
                <p>
                    Fasilitas dan layanan kami terus ditunjang oleh dokter spesialis berpengalaman, perawat profesional, serta peralatan medis canggih 24 jam untuk menjamin kenyamanan dan keselamatan pasien.
                </p>
                @endif
            </div>

            <!-- BENEFIT & KEUNTUNGAN LAYANAN (FOTO BENEFIT PROPORSIONAL, MAX 5 PER BARIS, CENTER) -->
            @if(!empty($galleryImages) && count($galleryImages) > 0)
            <div class="mt-8 pt-6 border-t border-slate-100 space-y-4">
                <div class="text-center space-y-1">
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-emerald-50 text-[#0e7c47] border border-emerald-100 text-[11px] font-extrabold uppercase tracking-wider shadow-2xs">
                        <i class="fa-solid fa-gift text-xs"></i>
                        <span>Benefit & Fasilitas Layanan</span>
                    </span>
                    <h3 class="text-base sm:text-lg font-black text-slate-900">Keuntungan Eksklusif Pasien</h3>
                    <p class="text-xs text-slate-500 font-medium">Klik pada gambar untuk melihat detail voucher & paket benefit</p>
                </div>

                <!-- DAFTAR KARTU BENEFIT: MAKSIMAL 5 FOTO PER BARIS, WRAP KE BAWAH, POSISI CENTER -->
                <div class="flex flex-wrap justify-center items-center gap-3 sm:gap-4 max-w-4xl mx-auto pt-2">
                    <template x-for="(img, idx) in images" :key="idx">
                        <div @click="openLightbox(idx)" 
                             class="group relative w-28 sm:w-32 md:w-36 h-36 sm:h-42 md:h-46 rounded-2xl overflow-hidden bg-white border border-slate-200 shadow-xs hover:shadow-md cursor-pointer transition-all duration-300 hover:-translate-y-1.5 hover:border-[#0e7c47] flex items-center justify-center p-2 shrink-0">
                            
                            <!-- BENEFIT IMAGE FULLY PROPORTIONAL -->
                            <img :src="img" 
                                 alt="{{ $title }}" 
                                 class="max-w-full max-h-full w-auto h-auto object-contain transition-transform duration-300 group-hover:scale-105">
                            
                            <!-- HOVER OVERLAY WITH EXPAND ICON -->
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

            <!-- INFO KONTAK MARKETING & KONSULTASI LAYANAN -->
            <div class="mt-8 pt-6 border-t border-slate-100 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div class="space-y-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-red-50 text-red-700 border border-red-100 text-[11px] font-extrabold uppercase tracking-wider">
                            <i class="fa-solid fa-bullhorn text-xs"></i>
                            <span>Informasi & Konsultasi Marketing</span>
                        </span>
                        <h3 class="text-base sm:text-lg font-black text-slate-900">Kontak Tim Marketing & Kemitraan</h3>
                        <p class="text-xs text-slate-500 font-medium">Konsultasi paket benefit, estimasi biaya, penjaminan asuransi & kerjasama perusahaan</p>
                    </div>
                </div>

                <!-- GRID KONTAK TIM MARKETING -->
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-3 pt-1">
                    <!-- IBU ULFAH -->
                    <a href="https://wa.me/6281316720656?text=Halo%20Ibu%20Ulfah%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20layanan%20{{ urlencode($title) }}" target="_blank" class="p-3 sm:p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/80 border border-slate-200 hover:border-emerald-300 transition-all duration-200 flex items-center gap-3 group shadow-2xs hover:shadow-xs">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-sm font-bold shrink-0">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="font-extrabold text-slate-900 text-xs truncate group-hover:text-[#0e7c47] transition-colors">Ibu Ulfah</div>
                            <div class="text-[11px] text-slate-500 font-mono mt-0.5">0813-1672-0656</div>
                        </div>
                    </a>

                    <!-- IBU AI -->
                    <a href="https://wa.me/6281384656298?text=Halo%20Ibu%20Ai%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20layanan%20{{ urlencode($title) }}" target="_blank" class="p-3 sm:p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/80 border border-slate-200 hover:border-emerald-300 transition-all duration-200 flex items-center gap-3 group shadow-2xs hover:shadow-xs">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-sm font-bold shrink-0">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="font-extrabold text-slate-900 text-xs truncate group-hover:text-[#0e7c47] transition-colors">Ibu Ai</div>
                            <div class="text-[11px] text-slate-500 font-mono mt-0.5">0813-8465-6298</div>
                        </div>
                    </a>

                    <!-- IBU RINA -->
                    <a href="https://wa.me/628988965646?text=Halo%20Ibu%20Rina%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20layanan%20{{ urlencode($title) }}" target="_blank" class="p-3 sm:p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/80 border border-slate-200 hover:border-emerald-300 transition-all duration-200 flex items-center gap-3 group shadow-2xs hover:shadow-xs">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-sm font-bold shrink-0">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="font-extrabold text-slate-900 text-xs truncate group-hover:text-[#0e7c47] transition-colors">Ibu Rina</div>
                            <div class="text-[11px] text-slate-500 font-mono mt-0.5">0898-8965-646</div>
                        </div>
                    </a>

                    <!-- IBU ITJE -->
                    <a href="https://wa.me/6281382895002?text=Halo%20Ibu%20Itje%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20layanan%20{{ urlencode($title) }}" target="_blank" class="p-3 sm:p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/80 border border-slate-200 hover:border-emerald-300 transition-all duration-200 flex items-center gap-3 group shadow-2xs hover:shadow-xs">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-sm font-bold shrink-0">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="font-extrabold text-slate-900 text-xs truncate group-hover:text-[#0e7c47] transition-colors">Ibu Itje</div>
                            <div class="text-[11px] text-slate-500 font-mono mt-0.5">0813-8289-5002</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- CARDS GRID DETAILS FOR OPERATIONAL & PHONE -->
            <div class="mt-8 pt-6 border-t border-gray-100 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 rounded-xl bg-emerald-50/50 border border-emerald-100 flex items-start gap-3">
                    <i class="fa-solid fa-clock text-[#0e7c47] text-lg mt-0.5"></i>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">{{ __('Operasional') }}</h4>
                        <p class="text-xs text-gray-600 mt-0.5">Siaga 24 Jam / 7 Hari Seminggu</p>
                    </div>
                </div>
                <div class="p-4 rounded-xl bg-emerald-50/50 border border-emerald-100 flex items-start gap-3">
                    <i class="fa-solid fa-headset text-[#0e7c47] text-lg mt-0.5"></i>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">{{ __('Pendaftaran & Info') }}</h4>
                        <p class="text-xs text-gray-600 mt-0.5">0822 8074 9999 / WA: 0896 7821 1575</p>
                    </div>
                </div>
        </div>
    </div>

    <!-- FULLSCREEN LIGHTBOX MODAL -->
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
            
            <!-- MODAL HEADER -->
            <div class="p-3 sm:p-4 flex items-center justify-between border-b border-slate-800 bg-slate-950/80 text-white">
                <span class="text-xs font-bold truncate">{{ $title }}</span>
                <button type="button" @click="lightboxOpen = false" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 text-white flex items-center justify-center transition-colors cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- MODAL IMAGE -->
            <div class="relative flex-1 bg-slate-950 flex items-center justify-center min-h-[280px] max-h-[65vh] p-2">
                <template x-for="(img, idx) in images" :key="'lb-'+idx">
                    <img x-show="activeIndex === idx" 
                         :src="img" 
                         alt="{{ $title }}" 
                         class="max-w-full max-h-[60vh] object-contain rounded-lg">
                </template>

                <!-- PREV / NEXT -->
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

            <!-- MODAL FOOTER -->
            <div class="p-3 border-t border-slate-800 bg-slate-950/90 flex items-center justify-between text-xs text-slate-400">
                <span>Foto <strong class="text-white" x-text="activeIndex + 1"></strong> dari <strong class="text-white" x-text="images.length"></strong></span>
                <button type="button" @click="lightboxOpen = false" class="px-3 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold">Tutup</button>
            </div>

        </div>
    </div>

</section>

<!-- ALPINE SCRIPT -->
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
