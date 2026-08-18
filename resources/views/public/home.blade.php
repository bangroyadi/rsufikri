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
        @php
            $firstImg = Str::startsWith($banners->first()->image, ['http://', 'https://']) ? $banners->first()->image : asset($banners->first()->image);
        @endphp
        <img src="{{ $firstImg }}"
             alt=""
             aria-hidden="true"
             draggable="false"
             loading="eager"
             style="width: 100%; height: auto; display: block; visibility: hidden; pointer-events: none;">
        @endif

        {{-- All slides absolutely positioned so they never affect container height --}}
        @foreach($banners as $index => $banner)
        @php
            $bannerImg = Str::startsWith($banner->image, ['http://', 'https://']) ? $banner->image : asset($banner->image);
        @endphp
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
                <img src="{{ $bannerImg }}"
                     alt="Banner RSU Fikri Medika"
                     draggable="false"
                     loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                     style="width: 100%; height: 100%; display: block; object-fit: cover; pointer-events: none;">
            </a>
            @else
            <img src="{{ $bannerImg }}"
                 alt="Banner RSU Fikri Medika"
                 draggable="false"
                 loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                 style="width: 100%; height: 100%; display: block; object-fit: cover; pointer-events: none;">
            @endif
        </div>
        @endforeach
    </div>


    @if($banners->count() > 1)

    <style>
        .banner-nav-arrow {
            display: none !important;
        }
        @media (min-width: 640px) {
            .banner-nav-arrow {
                display: flex !important;
            }
        }
    </style>

    <!-- PREV ARROW (HIDDEN ON MOBILE, SHOWN ON TABLET, LAPTOP & PC) -->
    <button @click="prevSlide(); stopAutoSlide(); startAutoSlide();"
            type="button"
            aria-label="Banner Sebelumnya"
            class="banner-nav-arrow"
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

    <!-- NEXT ARROW (HIDDEN ON MOBILE, SHOWN ON TABLET, LAPTOP & PC) -->
    <button @click="nextSlide(); stopAutoSlide(); startAutoSlide();"
            type="button"
            aria-label="Banner Berikutnya"
            class="banner-nav-arrow"
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
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-shadow duration-300 flex flex-col group">
                <div class="relative h-48 overflow-hidden bg-gray-100">
                    @php
                        $featImg = !empty($service->image) ? (\Illuminate\Support\Str::startsWith($service->image, ['http://', 'https://']) ? $service->image : asset($service->image)) : 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=600&q=80';
                    @endphp
                    <img src="{{ $featImg }}" 
                         alt="{{ $service->tr('name') }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         loading="lazy"
                         decoding="async">
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full bg-[#0e7c47] text-yellow-300 text-xs font-bold shadow-md">
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
                        <a href="{{ url('/layanan/' . ($service->slug ?: \Illuminate\Support\Str::slug($service->tr('name')))) }}" class="text-xs font-bold text-[#0e7c47] hover:text-amber-600 flex items-center gap-1">
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
            <div class="youtube-card bg-white p-2.5 rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                <div class="relative aspect-video w-full rounded-xl overflow-hidden bg-slate-900">
                    <iframe class="w-full h-full border-0 outline-none rounded-xl block" 
                            style="border:0; outline:none;"
                            srcdoc="<style>*{padding:0;margin:0;overflow:hidden}html,body{height:100%}img,span{position:absolute;width:100%;top:0;bottom:0;margin:auto}img{object-fit:cover;height:100%}span{height:1.5em;text-align:center;font:48px/1.5 sans-serif;color:white;text-shadow:0 0 0.5em rgba(0,0,0,0.6)}</style><a href=https://www.youtube.com/embed/{{ $video['youtubeId'] }}?autoplay=1><img src=https://img.youtube.com/vi/{{ $video['youtubeId'] }}/hqdefault.jpg alt='{{ e($video['title']) }}'><span>&#x25BA;</span></a>"
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



<!-- SECTION: HEALTH HUB (ARTICLE CAROUSEL MATCHING REFERENCE) -->
<section id="health-hub" 
         class="py-16 sm:py-20 bg-white relative overflow-hidden select-none"
         x-data="{
             activeCategory: 'All',
             progressWidth: 25,
             thumbLeftPercent: 0,
             isThumbDragging: false,
             thumbStartX: 0,
             thumbStartScroll: 0,
             isCardDragging: false,
             cardStartX: 0,
             cardStartScroll: 0,
             lastX: 0,
             lastTime: 0,
             velocity: 0,
             hasMoved: false,
             animFrame: null,
             
             init() {
                 this.$nextTick(() => { 
                     this.updateProgress(); 
                 });
                 window.addEventListener('resize', () => { this.updateProgress(); });
                 
                 // Global mouse move & up listeners for thumb dragging
                 window.addEventListener('mousemove', (e) => {
                     if (this.isThumbDragging) {
                         const el = this.$refs.carousel;
                         const track = this.$refs.track;
                         if (!el || !track) return;
                         const deltaX = e.clientX - this.thumbStartX;
                         const trackWidth = track.clientWidth;
                         const thumbWidthPx = trackWidth * (this.progressWidth / 100);
                         const availableTrack = trackWidth - thumbWidthPx;
                         const maxScroll = el.scrollWidth - el.clientWidth;
                         if (availableTrack > 0 && maxScroll > 0) {
                             el.scrollLeft = this.thumbStartScroll + (deltaX / availableTrack) * maxScroll;
                             this.updateProgress();
                         }
                     } else if (this.isCardDragging) {
                         this.onCardMove(e.clientX);
                     }
                 });
                 
                 window.addEventListener('mouseup', () => {
                     if (this.isThumbDragging) {
                         this.isThumbDragging = false;
                         this.updateProgress();
                     }
                     if (this.isCardDragging) {
                         this.stopCardDrag();
                     }
                 });

                 // Global touch move & end
                 window.addEventListener('touchmove', (e) => {
                     if (this.isThumbDragging && e.touches[0]) {
                         const el = this.$refs.carousel;
                         const track = this.$refs.track;
                         if (!el || !track) return;
                         const deltaX = e.touches[0].clientX - this.thumbStartX;
                         const trackWidth = track.clientWidth;
                         const thumbWidthPx = trackWidth * (this.progressWidth / 100);
                         const availableTrack = trackWidth - thumbWidthPx;
                         const maxScroll = el.scrollWidth - el.clientWidth;
                         if (availableTrack > 0 && maxScroll > 0) {
                             el.scrollLeft = this.thumbStartScroll + (deltaX / availableTrack) * maxScroll;
                             this.updateProgress();
                         }
                     }
                 }, { passive: true });

                 window.addEventListener('touchend', () => {
                     if (this.isThumbDragging) this.isThumbDragging = false;
                 });
             },

             setCategory(cat) {
                 this.activeCategory = cat;
                 cancelAnimationFrame(this.animFrame);
                 this.$nextTick(() => {
                     const el = this.$refs.carousel;
                     if (el) {
                         el.scrollTo({ left: 0, behavior: 'smooth' });
                         this.updateProgress();
                     }
                 });
             },

             matches(cat) {
                 if (this.activeCategory === 'All' || this.activeCategory === 'Semua') return true;
                 return this.activeCategory.trim().toLowerCase() === cat.trim().toLowerCase();
             },

             updateProgress() {
                 const el = this.$refs.carousel;
                 if (!el) return;
                 const maxScroll = el.scrollWidth - el.clientWidth;
                 const ratio = el.clientWidth / (el.scrollWidth || 1);
                 this.progressWidth = Math.max(16, Math.min(80, ratio * 100));
                 if (maxScroll <= 0) {
                     this.thumbLeftPercent = 0;
                     return;
                 }
                 const scrollRatio = Math.max(0, Math.min(1, el.scrollLeft / maxScroll));
                 this.thumbLeftPercent = scrollRatio * (100 - this.progressWidth);
             },

             handleTrackClick(e) {
                 if (this.isThumbDragging) return;
                 const track = this.$refs.track;
                 const el = this.$refs.carousel;
                 if (!track || !el) return;
                 cancelAnimationFrame(this.animFrame);
                 const rect = track.getBoundingClientRect();
                 const clickX = e.clientX - rect.left;
                 const clickRatio = Math.max(0, Math.min(1, clickX / rect.width));
                 const maxScroll = el.scrollWidth - el.clientWidth;
                 el.scrollTo({ left: clickRatio * maxScroll, behavior: 'smooth' });
             },

             startThumbDrag(e) {
                 cancelAnimationFrame(this.animFrame);
                 this.isThumbDragging = true;
                 this.thumbStartX = e.clientX;
                 this.thumbStartScroll = this.$refs.carousel ? this.$refs.carousel.scrollLeft : 0;
                 e.preventDefault();
             },

             startThumbTouch(e) {
                 if (!e.touches[0]) return;
                 cancelAnimationFrame(this.animFrame);
                 this.isThumbDragging = true;
                 this.thumbStartX = e.touches[0].clientX;
                 this.thumbStartScroll = this.$refs.carousel ? this.$refs.carousel.scrollLeft : 0;
             },

             // Buttery-smooth Card Dragging with Momentum Physics
             startCardDrag(e) {
                 if (e.button !== 0) return;
                 cancelAnimationFrame(this.animFrame);
                 this.isCardDragging = true;
                 this.hasMoved = false;
                 this.cardStartX = e.clientX;
                 this.cardStartScroll = this.$refs.carousel ? this.$refs.carousel.scrollLeft : 0;
                 this.lastX = e.clientX;
                 this.lastTime = performance.now();
                 this.velocity = 0;
             },

             onCardMove(clientX) {
                 if (!this.isCardDragging) return;
                 const delta = clientX - this.cardStartX;
                 if (Math.abs(delta) > 4) {
                     this.hasMoved = true;
                 }
                 const now = performance.now();
                 const dt = Math.max(1, now - this.lastTime);
                 this.velocity = (clientX - this.lastX) / dt;
                 this.lastX = clientX;
                 this.lastTime = now;
                 
                 const el = this.$refs.carousel;
                 if (el) {
                     el.scrollLeft = this.cardStartScroll - delta;
                     this.updateProgress();
                 }
             },

             stopCardDrag() {
                 if (!this.isCardDragging) return;
                 this.isCardDragging = false;
                 
                 const el = this.$refs.carousel;
                 if (!el) return;

                 // Inertia momentum glide
                 if (Math.abs(this.velocity) > 0.15) {
                     let speed = this.velocity * 16; // initial kinetic boost
                     const decay = 0.94; // friction
                     const step = () => {
                         if (Math.abs(speed) > 0.4) {
                             el.scrollLeft -= speed;
                             speed *= decay;
                             this.updateProgress();
                             this.animFrame = requestAnimationFrame(step);
                         } else {
                             this.updateProgress();
                         }
                     };
                     this.animFrame = requestAnimationFrame(step);
                 }
             },

             handleCardClick(e) {
                 if (this.hasMoved) {
                     e.preventDefault();
                     e.stopPropagation();
                 }
             }
         }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- TITLE: HEALTH HUB -->
        <div class="mb-3 sm:mb-4">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#0e7c47] tracking-tight">
                Health Hub
            </h2>
        </div>

        <!-- FILTER PILLS -->
        @php
            $pills = ['All', 'Kids Health', "Men's Health", "Women's Health", 'More Articles'];
        @endphp
        <div class="flex items-center gap-2 sm:gap-3 overflow-x-auto pb-1 mb-2.5 sm:mb-3 no-scrollbar">
            @foreach($pills as $pill)
            <button type="button" 
                    @click="setCategory('{{ $pill }}')" 
                    :class="activeCategory === '{{ $pill }}' 
                        ? 'bg-[#0e7c47] text-white border-[#0e7c47] shadow-xs font-bold' 
                        : 'bg-transparent text-[#0e7c47] border-[#0e7c47] hover:bg-[#0e7c47]/10 font-semibold'"
                    class="px-5 sm:px-6 py-1 sm:py-1.5 rounded-full text-xs sm:text-sm border-2 transition-all whitespace-nowrap cursor-pointer shrink-0 {{ $pill === 'All' ? 'bg-[#0e7c47] text-white border-[#0e7c47] font-bold' : 'text-[#0e7c47] border-[#0e7c47] font-semibold' }}">
                {{ $pill }}
            </button>
            @endforeach
        </div>

        <!-- HORIZONTAL CAROUSEL OF CARDS -->
        <div class="relative -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
            <div x-ref="carousel"
                 @scroll.passive="updateProgress()"
                 @mousedown="startCardDrag($event)"
                 :class="isCardDragging ? 'cursor-grabbing select-none scroll-auto' : 'cursor-grab scroll-smooth'"
                 class="flex gap-5 sm:gap-6 overflow-x-auto no-scrollbar pt-1 pb-1 select-none"
                 style="scrollbar-width: none; -ms-overflow-style: none; -webkit-overflow-scrolling: touch;">
                
                @forelse($latestArticles as $article)
                @php
                    $catName = $article->tr('category') ?: 'More Articles';
                    $artTitle = $article->tr('title');
                    $artExcerpt = $article->tr('excerpt');
                    $artImg = $article->thumbnail ?: 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=600&q=80';
                @endphp
                <a href="{{ url('/informasi/artikel-kesehatan') }}" 
                   @click="handleCardClick($event)"
                   x-show="matches('{{ addslashes($catName) }}')"
                   x-transition:enter="transition ease-out duration-200"
                   x-transition:enter-start="opacity-0 scale-95"
                   x-transition:enter-end="opacity-100 scale-100"
                   class="shrink-0 w-[80vw] sm:w-[310px] md:w-[330px] lg:w-[345px] bg-white rounded-2xl border border-slate-100 shadow-[0_6px_25px_rgba(0,0,0,0.06)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                    
                    <!-- 1. FEATURED IMAGE (MATCHING REFERENCE RATIO) -->
                    <div class="relative aspect-[16/10] w-full overflow-hidden bg-slate-100 rounded-t-2xl pointer-events-none">
                        <img src="{{ $artImg }}" 
                             alt="{{ $artTitle }}" 
                             draggable="false"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 pointer-events-none" 
                             loading="lazy">
                    </div>

                    <!-- 2. CARD CONTENT (TITLE, EXCERPT, GREEN/YELLOW ARROW BUTTON) -->
                    <div class="p-5 sm:p-6 flex flex-col flex-grow justify-between pointer-events-none">
                        <div>
                            <!-- TITLE -->
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 leading-snug line-clamp-2 mb-2 group-hover:text-[#0e7c47] transition-colors">
                                {{ $artTitle }}
                            </h3>

                            <!-- EXCERPT -->
                            <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 mb-4 font-normal">
                                {{ $artExcerpt }}
                            </p>
                        </div>

                        <!-- 3. BOTTOM RIGHT CIRCULAR GREEN BUTTON WITH YELLOW ARROW -->
                        <div class="flex items-center justify-end pt-1">
                            <div class="w-8 h-8 rounded-full bg-[#0e7c47] group-hover:bg-[#096237] text-yellow-400 group-hover:text-yellow-300 flex items-center justify-center shadow-sm transition-transform group-hover:scale-110">
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="w-full text-center py-12 text-slate-400 text-sm">
                    Belum ada artikel tersedia.
                </div>
                @endforelse

            </div>
        </div>

        <!-- BOTTOM INTERACTIVE DRAGGABLE SCROLLBAR / PROGRESS TRACK -->
        <div class="mt-3 sm:mt-4 pt-0 pb-1">
            <div x-ref="track" 
                 @click="handleTrackClick($event)"
                 class="w-full bg-emerald-100/70 h-2.5 sm:h-3 rounded-full relative cursor-pointer select-none group/track shadow-inner hover:bg-emerald-100 transition-colors">
                
                <!-- DRAGGABLE THUMB BAR -->
                <div x-ref="thumb"
                     @mousedown.stop="startThumbDrag($event)"
                     @touchstart.stop="startThumbTouch($event)"
                     :class="isThumbDragging ? 'cursor-grabbing shadow-lg scale-y-110 brightness-105 ring-2 ring-emerald-400/50' : 'cursor-grab hover:brightness-105'"
                     class="absolute top-0 bottom-0 bg-gradient-to-r from-[#0e7c47] to-amber-400 rounded-full shadow-md flex items-center justify-center touch-none select-none"
                     :style="'width: ' + progressWidth + '%; left: ' + thumbLeftPercent + '%;'">
                    <!-- Subtle grip line indicator on thumb -->
                    <div class="w-4 h-1 bg-white/70 rounded-full"></div>
                </div>
            </div>
            <div class="flex items-center justify-between text-[11px] text-slate-400 font-medium mt-1.5 px-1">
                <span><i class="fa-solid fa-arrows-left-right text-xs mr-1 text-[#0e7c47]"></i> Geser atau tarik bar untuk melihat artikel lainnya</span>
            </div>
        </div>

    </div>
</section>

<!-- SECTION: EMERGENCY IGD 24 JAM & GOOGLE MAPS LOCATION -->
<section id="kontak" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

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
