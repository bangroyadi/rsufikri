@extends('layouts.app')

@section('content')

<!-- HERO BANNER SECTION (FULL-WIDTH IMAGE SLIDER) -->
<section class="relative w-full overflow-hidden bg-slate-900"
         x-data="{
             activeSlide: 0,
             totalSlides: {{ $banners->count() > 0 ? $banners->count() : 1 }},
             touchStartX: 0,
             mouseStartX: 0,
             isDragging: false,
             timer: null,
             startAutoSlide() {
                 this.stopAutoSlide();
                 this.timer = setInterval(() => { this.nextSlide(); }, 5000);
             },
             stopAutoSlide() {
                 if (this.timer) { clearInterval(this.timer); this.timer = null; }
             },
             goTo(index) {
                 this.activeSlide = index;
                 this.stopAutoSlide();
                 this.startAutoSlide();
             },
             nextSlide() {
                 this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
             },
             prevSlide() {
                 this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
             },
             handleTouchStart(e) {
                 this.touchStartX = e.changedTouches[0].clientX;
             },
             handleTouchEnd(e) {
                 const diff = this.touchStartX - e.changedTouches[0].clientX;
                 if (diff > 40) { this.nextSlide(); this.stopAutoSlide(); this.startAutoSlide(); }
                 else if (diff < -40) { this.prevSlide(); this.stopAutoSlide(); this.startAutoSlide(); }
             },
             handleMouseDown(e) {
                 e.preventDefault();
                 this.isDragging = true;
                 this.mouseStartX = e.clientX;
             }
         }"
         x-init="
             startAutoSlide();
             window.addEventListener('mouseup', (e) => {
                 if (!isDragging) return;
                 isDragging = false;
                 const diff = mouseStartX - e.clientX;
                 if (diff > 50) { nextSlide(); stopAutoSlide(); startAutoSlide(); }
                 else if (diff < -50) { prevSlide(); stopAutoSlide(); startAutoSlide(); }
             });
         "
         @touchstart.passive="handleTouchStart($event)"
         @touchend.passive="handleTouchEnd($event)"
         @mousedown="handleMouseDown($event)"
         style="user-select: none; -webkit-user-select: none;"
         :style="isDragging ? 'cursor: grabbing;' : 'cursor: grab;'">

    <!-- SLIDE IMAGES — container with stable height -->
    <div style="position: relative; width: 100%; overflow: hidden;"
         x-ref="slideContainer">
        {{-- Spacer slide (first image sets the container height) --}}
        @if($banners->count() > 0)
        <img src="{{ $banners->first()->image }}"
             alt=""
             aria-hidden="true"
             draggable="false"
             loading="eager"
             style="width: 100%; height: auto; display: block; visibility: hidden; pointer-events: none;">
        @endif

        {{-- All slides absolutely positioned so they never affect container height --}}
        @foreach($banners as $index => $banner)
        <div x-show="activeSlide === {{ $index }}"
             style="position: absolute; inset: 0; width: 100%; height: 100%;"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-transition:enter="ease-out duration-[500ms]"
             x-transition:leave="ease-in duration-[300ms]">
            @if(!empty($banner->button_link))
            <a href="{{ $banner->button_link }}" draggable="false" style="display: block; width: 100%; height: 100%;">
                <img src="{{ $banner->image }}"
                     alt="Banner RSU Fikri Medika"
                     draggable="false"
                     loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                     style="width: 100%; height: 100%; display: block; object-fit: cover; pointer-events: none;">
            </a>
            @else
            <img src="{{ $banner->image }}"
                 alt="Banner RSU Fikri Medika"
                 draggable="false"
                 loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                 style="width: 100%; height: 100%; display: block; object-fit: cover; pointer-events: none;">
            @endif
        </div>
        @endforeach
    </div>


    @if($banners->count() > 1)

    <!-- PREV ARROW -->
    <button @click="prevSlide(); stopAutoSlide(); startAutoSlide();"
            type="button"
            aria-label="Banner Sebelumnya"
            style="
                position: absolute;
                left: 16px;
                top: 50%;
                transform: translateY(-50%);
                z-index: 20;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: #f97316;
                color: #fff;
                border: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                box-shadow: 0 4px 14px rgba(0,0,0,0.25);
                transition: background 0.2s, transform 0.2s;
            "
            onmouseover="this.style.background='#ea580c'; this.style.transform='translateY(-50%) scale(1.1)'"
            onmouseout="this.style.background='#f97316'; this.style.transform='translateY(-50%) scale(1)'">
        <i class="fa-solid fa-chevron-left"></i>
    </button>

    <!-- NEXT ARROW -->
    <button @click="nextSlide(); stopAutoSlide(); startAutoSlide();"
            type="button"
            aria-label="Banner Berikutnya"
            style="
                position: absolute;
                right: 16px;
                top: 50%;
                transform: translateY(-50%);
                z-index: 20;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: #f97316;
                color: #fff;
                border: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                box-shadow: 0 4px 14px rgba(0,0,0,0.25);
                transition: background 0.2s, transform 0.2s;
            "
            onmouseover="this.style.background='#ea580c'; this.style.transform='translateY(-50%) scale(1.1)'"
            onmouseout="this.style.background='#f97316'; this.style.transform='translateY(-50%) scale(1)'">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

    <!-- DOT NAVIGATION -->
    <div style="
            position: absolute;
            bottom: 18px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 20;
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(0,0,0,0.35);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            padding: 7px 14px;
            border-radius: 99px;
        ">
        @foreach($banners as $index => $banner)
        <button @click="goTo({{ $index }})"
                type="button"
                title="Slide {{ $index + 1 }}"
                :style="activeSlide === {{ $index }}
                    ? 'width:28px; background:#f97316;'
                    : 'width:8px; background:rgba(255,255,255,0.5);'"
                style="
                    height: 8px;
                    border-radius: 99px;
                    border: none;
                    cursor: pointer;
                    outline: none;
                    padding: 0;
                    display: block;
                    transition: width 0.3s ease, background-color 0.3s ease;
                ">
        </button>
        @endforeach
    </div>

    @endif

</section>

<!-- SECTION: TENTANG KAMI / SEJARAH SINGKAT (MATCHING REFERENCE DESIGN) -->
<section id="profil" class="py-16 lg:py-24 bg-slate-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- LEFT CONTENT -->
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-[#0e7c47] text-xs font-extrabold uppercase tracking-wider">
                    <span>TENTANG KAMI</span>
                </div>
                
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight leading-snug">
                    Sejarah Singkat Berdirinya RSU. Fikri Medika
                </h2>
                
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed font-medium">
                    RSU Fikri Medika bernaung di bawah <strong>PT. Karya Mandiri Medika Utama</strong>, didirikan untuk memberikan kontribusi nyata di bidang pelayanan jasa kesehatan yang komprehensif, cepat, dan profesional bagi seluruh masyarakat Karawang dan sekitarnya dengan mengedepankan keramahan dan nilai-nilai Islami.
                </p>

                <div>
                    <a href="{{ route('profil') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#0e7c47] hover:bg-[#096237] text-white text-xs font-extrabold shadow-md transition-all">
                        <span>Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- RIGHT HOSPITAL BUILDING IMAGE CARD WITH FLOATING BADGE -->
            <div class="lg:col-span-5 relative">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-white p-2">
                    <img src="{{ asset('gedung1_web.jpg') }}" 
                         alt="Gedung RSU Fikri Medika" 
                         class="w-full h-72 sm:h-80 object-cover rounded-2xl"
                         loading="lazy"
                         decoding="async">
                    
                    <!-- FLOATING YEAR BADGE -->
                    <div class="absolute top-6 left-6 bg-white/95 backdrop-blur-md border border-gray-100 p-3 px-4 rounded-2xl shadow-xl text-center space-y-0.5">
                        <div class="text-[10px] text-gray-500 font-extrabold uppercase tracking-wider">Berdiri Sejak</div>
                        <div class="text-base font-black text-[#0e7c47]">2008</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



<!-- SECTION: LAYANAN UNGGULAN -->
<section id="layanan" class="py-20 bg-[#f7faf8] border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-14">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-[#0e7c47] text-xs font-bold uppercase tracking-wider mb-3">
                <i class="fa-solid fa-notes-medical"></i>
                <span>{{ __('Pelayanan Medis') }}</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0e7c47] tracking-tight">
                {{ __('Layanan Unggulan') }} RSU Fikri Medika
            </h2>
            <p class="text-gray-600 text-sm sm:text-base mt-2">
                {{ __('Fasilitas medis terpadu dengan standar keselamatan pasien yang tinggi dan dukungan peralatan kesehatan modern.') }}
            </p>
        </div>

        <!-- SERVICES GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredServices as $service)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 flex flex-col group card-hover">
                <div class="relative h-48 overflow-hidden bg-gray-100">
                    <img src="{{ $service->image ?? 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=600&q=80' }}" 
                         alt="{{ $service->tr('name') }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         loading="lazy">
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full bg-[#0e7c47]/90 backdrop-blur-md text-yellow-300 text-xs font-bold shadow-md">
                            {{ __('Fasilitas Utama') }}
                        </span>
                    </div>
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-[#0e7c47] group-hover:text-[#096237] transition-colors mb-2">
                            {{ $service->tr('name') }}
                        </h3>
                        <p class="text-gray-600 text-xs sm:text-sm leading-relaxed mb-4">
                            {{ $service->tr('short_description') }}
                        </p>
                    </div>
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-emerald-700 flex items-center gap-1">
                            <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ __('Buka 24 Jam') }}
                        </span>
                        <a href="#kontak" class="text-xs font-bold text-[#0e7c47] hover:text-amber-600 flex items-center gap-1">
                            <span>{{ __('Detail') }}</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>


<!-- SECTION: YOUTUBE EMBED VIDEOS (ALIGNED TO TEMPLATE GRID SYSTEM) -->
@php
$youtubeVideos = [
    [
        'title' => 'Identifikasi Pasien - RSU Fikri Medika',
        'youtubeId' => 'RtFTwr3NFI8',
    ],
    [
        'title' => 'Fasilitas Medis & Pelayanan Kesehatan RSU Fikri Medika',
        'youtubeId' => 'FjCMihXaQ6o',
    ],
    [
        'title' => 'Layanan Kesehatan & Edukasi Medis Terpadu',
        'youtubeId' => 'vKTq_3ApUYY',
    ],
];
@endphp

<section id="youtube-videos" class="py-16 sm:py-20 bg-[#ebf6f1]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- SECTION HEADER (WITH YOUTUBE CHANNEL LINK ON THE RIGHT) -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 sm:mb-10 gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0e7c47] tracking-tight">
                    Follow Youtube RSU Fikri Medika Official
                </h2>
                <p class="text-gray-600 text-sm sm:text-base mt-1 font-medium">
                    Video dari youtube
                </p>
            </div>
            <div>
                <a href="https://www.youtube.com/@rsufikrimedika" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-600 hover:bg-red-700 text-white text-xs sm:text-sm font-bold shadow-sm hover:shadow-md transition-all transform hover:-translate-y-0.5">
                    <i class="fa-brands fa-youtube text-lg"></i>
                    <span>YouTube Official</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] opacity-80"></i>
                </a>
            </div>
        </div>

        <!-- VIDEO CARDS GRID (3 COLUMNS GAP-8 MATCHING LAYANAN & BERITA) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            @foreach($youtubeVideos as $index => $video)
            <div class="youtube-card bg-white p-2.5 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                <div class="relative aspect-video w-full rounded-xl overflow-hidden bg-white">
                    <iframe class="w-full h-full border-0 outline-none rounded-xl block" 
                            style="border:0; outline:none;"
                            src="https://www.youtube.com/embed/{{ $video['youtubeId'] }}?rel=0&modestbranding=1" 
                            title="Video YouTube RSU Fikri Medika: {{ $video['title'] }}" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen
                            loading="lazy"></iframe>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>



<section id="berita" class="py-20 bg-[#f7faf8]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-[#0e7c47] text-xs font-bold uppercase tracking-wider mb-2">
                    <i class="fa-regular fa-newspaper"></i>
                    <span>{{ __('Informasi & Edukasi') }}</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0e7c47] tracking-tight">
                    {{ __('Berita & Artikel Kesehatan') }}
                </h2>
            </div>
            <a href="#berita" class="text-xs sm:text-sm font-bold text-[#0e7c47] hover:text-amber-600 flex items-center gap-1.5">
                <span>{{ __('Lihat Semua Berita') }}</span> <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($latestNews as $item)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md border border-gray-100 transition-all flex flex-col card-hover">
                <div class="relative h-48 overflow-hidden bg-gray-100">
                    <img src="{{ $item->thumbnail ?? 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=600&q=80' }}" 
                         alt="{{ $item->tr('title') }}" 
                         class="w-full h-full object-cover"
                         loading="lazy">
                    <div class="absolute top-3 left-3 bg-[#0e7c47] text-yellow-300 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full">
                        {{ $item->tr('category') }}
                    </div>
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between">
                    <div>
                        <div class="text-xs text-gray-400 font-medium mb-2 flex items-center gap-1">
                            <i class="fa-regular fa-clock"></i>
                            <span>{{ $item->published_at?->format('d M Y') }}</span>
                        </div>
                        <h3 class="text-base font-bold text-[#0e7c47] hover:text-[#096237] transition-colors leading-snug mb-3">
                            {{ $item->tr('title') }}
                        </h3>
                        <p class="text-gray-600 text-xs line-clamp-3 leading-relaxed">
                            {{ $item->tr('excerpt') }}
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-gray-100">
                        <a href="#berita" class="text-xs font-bold text-[#0e7c47] hover:text-amber-600 flex items-center gap-1">
                            <span>{{ __('Selengkapnya') }}</span> <i class="fa-solid fa-angle-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

<!-- SECTION: EMERGENCY IGD 24 JAM & GOOGLE MAPS LOCATION -->
<section id="kontak" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-gradient-to-r from-[#0e7c47] to-[#096237] rounded-3xl p-8 sm:p-12 text-white shadow-xl relative overflow-hidden mb-16">
            <div class="absolute -right-10 -bottom-10 w-72 h-72 rounded-full bg-red-500/10 blur-2xl"></div>
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                <div class="lg:col-span-8 space-y-4 text-center lg:text-left">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-600/30 border border-red-400/50 text-red-300 text-xs font-bold uppercase tracking-wider">
                        <i class="fa-solid fa-heart-pulse animate-pulse"></i> {{ __('Layanan Darurat Siaga') }}
                    </span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white">
                        {{ __('Instalasi Gawat Darurat (IGD) 24 Jam') }}
                    </h2>
                    <p class="text-emerald-100 text-sm sm:text-base max-w-2xl">
                        {{ __('Segera hubungi tim medis darurat RSU Fikri Medika untuk penanganan medis darurat dan bantuan penjemputan ambulans siaga 24 jam.') }}
                    </p>
                </div>

                <div class="lg:col-span-4 text-center lg:text-right space-y-3">
                    <a href="tel:02678454999" class="inline-flex items-center justify-center gap-3 px-6 py-4 rounded-2xl bg-[#e31e24] hover:bg-red-700 text-white font-extrabold text-lg shadow-lg shadow-red-900/40 transition-all w-full sm:w-auto">
                        <i class="fa-solid fa-phone-volume text-xl animate-bounce"></i>
                        <span>(0267) 8454999</span>
                    </a>
                    <div class="text-xs text-gray-200">
                        {{ __('Atau WhatsApp') }}: <a href="https://wa.me/6281234567890" target="_blank" class="text-yellow-300 font-bold underline">0812-3456-7890</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- LOCATION MAP & CONTACT DETAILS -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <div class="lg:col-span-5 space-y-6">
                <div>
                    <span class="text-xs font-bold text-emerald-800 uppercase tracking-wider">{{ __('Lokasi Strategis') }}</span>
                    <h3 class="text-2xl font-bold text-[#0e7c47] mt-1">{{ __('Kunjungi RSU Fikri Medika') }}</h3>
                </div>

                <div class="space-y-4 text-sm text-gray-700">
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 text-[#0e7c47] flex items-center justify-center font-bold text-base flex-shrink-0">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <div class="font-bold text-[#0e7c47]">{{ __('Alamat Lengkap') }}:</div>
                            <div class="text-xs text-gray-600 mt-0.5">Jl. Raya Kosambi - Telagasari No. 9, Klari, Kabupaten Karawang, Jawa Barat 41371</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 text-[#0e7c47] flex items-center justify-center font-bold text-base flex-shrink-0">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <div class="font-bold text-[#0e7c47]">{{ __('Jam Operasional') }}:</div>
                            <div class="text-xs text-gray-600 mt-0.5">{{ __('IGD & Rawat Inap Buka 24 Jam | Poliklinik Sesuai Jadwal Dokter') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EMBED GOOGLE MAPS -->
            <div class="lg:col-span-7 rounded-2xl overflow-hidden shadow-md border border-gray-200">
                {!! $profile?->maps_embed ?? '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.5132717070197!2d107.36952737503886!3d-6.327471993662121!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6975a5cb3333cd%3A0x2aa7847b3117498c!2sRSU%20Fikri%20Medika!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" width="100%" height="360" style="border:0;" allowfullscreen="" loading="lazy"></iframe>' !!}
            </div>

        </div>

    </div>
</section>

@endsection
