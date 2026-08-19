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

<!-- SECTION: FLOATING CARI DOKTER CARD (MATCHING REFERENCE DESIGN) -->
<section class="relative z-30 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-4 sm:-mt-8 lg:-mt-10 mb-8 sm:mb-12">
    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl border border-gray-100/90 overflow-hidden">
        
        <!-- CARD TOP TAB -->
        <div class="border-b border-gray-100 px-6 sm:px-8 pt-2">
            <div class="inline-flex items-center gap-2 px-6 py-3 rounded-t-xl bg-[#e6f4f1] text-[#0e7c47] font-extrabold text-xs sm:text-sm border-b-2 border-[#0e7c47]">
                <i class="fa-solid fa-user-doctor text-amber-500 text-xs"></i>
                <span>Cari Dokter</span>
            </div>
        </div>

        <!-- CARD FORM CONTENT -->
        <div class="p-6 sm:p-8">
            <form action="{{ route('jadwal.dokter') }}" method="GET" class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    
                    <!-- 1. Nama Dokter -->
                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-2">Nama Dokter</label>
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                            <input type="text" 
                                   name="q" 
                                   placeholder="Nama Dokter" 
                                   class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#0e7c47] focus:ring-1 focus:ring-[#0e7c47] text-xs sm:text-sm text-gray-800 placeholder-gray-400 outline-none transition-all">
                        </div>
                    </div>

                    <!-- 2. Rumah Sakit -->
                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-2">Rumah Sakit</label>
                        <div class="relative">
                            <select name="rs" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#0e7c47] focus:ring-1 focus:ring-[#0e7c47] text-xs sm:text-sm text-gray-700 bg-white outline-none appearance-none cursor-pointer">
                                <option value="rsufikri" selected>RSU Fikri Medika Karawang</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- 3. Spesialisasi -->
                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-2">Spesialisasi</label>
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                            <select name="poli" class="w-full pl-9 pr-8 py-2.5 rounded-xl border border-gray-200 focus:border-[#0e7c47] focus:ring-1 focus:ring-[#0e7c47] text-xs sm:text-sm text-gray-700 bg-white outline-none appearance-none cursor-pointer">
                                <option value="">Pilih Spesialisasi</option>
                                @if(isset($polyclinics))
                                    @foreach($polyclinics as $poli)
                                        <option value="{{ $poli->id }}">{{ is_array($poli->name) ? ($poli->name[app()->getLocale()] ?? $poli->name['id'] ?? $poli->name['en']) : $poli->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- 4. Pilihan Hari -->
                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-2">Pilihan Hari</label>
                        <div class="relative">
                            <i class="fa-regular fa-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                            <select name="hari" class="w-full pl-9 pr-8 py-2.5 rounded-xl border border-gray-200 focus:border-[#0e7c47] focus:ring-1 focus:ring-[#0e7c47] text-xs sm:text-sm text-gray-700 bg-white outline-none appearance-none cursor-pointer">
                                <option value="">Pilih Hari / Tanggal</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                                <option value="Minggu">Minggu</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
                        </div>
                    </div>

                </div>

                <!-- BOTTOM ACTION BUTTONS -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="reset" class="px-7 py-2.5 rounded-xl border border-[#0e7c47] text-[#0e7c47] hover:bg-emerald-50 text-xs sm:text-sm font-bold transition-all duration-200 cursor-pointer">
                        Reset
                    </button>
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-7 py-2.5 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white text-xs sm:text-sm font-bold shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer">
                        Cari Dokter
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>

<!-- SECTION: LAYANAN SPESIALIS KAMI (MATCHING REFERENCE DESIGN WITH GREEN & YELLOW THEME) -->
<section id="layanan-spesialis" class="py-16 lg:py-20 bg-white border-t border-gray-100 relative overflow-hidden" x-data="{ showAllSpesialis: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- HEADER -->
        <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-10">
            <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-[#0e7c47] tracking-tight">
                Poliklinik & Spesialisasi
            </h2>
        </div>

        <!-- SPECIALIST SERVICES GRID: ROW 1 (DEFAULT 6 ITEMS) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-y-10 sm:gap-y-12 gap-x-4 sm:gap-x-6 lg:gap-x-8">
            
            <!-- 1. Penyakit Dalam -->
            <a href="{{ route('jadwal.dokter') }}?spesialis=Penyakit+Dalam" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                    <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="grad-hm-stomach" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#fed7aa" />
                                <stop offset="50%" stop-color="#fb923c" />
                                <stop offset="100%" stop-color="#ea580c" />
                            </linearGradient>
                        </defs>
                        <circle cx="32" cy="11" r="5" fill="#e2e8f0" stroke="#0e7c47" stroke-width="2"/>
                        <path d="M21 18h22l4 8-3 29H20L17 26l4-8z" fill="#f8fafc" stroke="#0e7c47" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M32 23v6c0 3 4 3 6 5 3 3 2 8-2 10-5 2-9-1-9-6 0-4 3-6 6-6" fill="url(#grad-hm-stomach)" stroke="#c2410c" stroke-width="2"/>
                        <path d="M31 43v6" stroke="#0e7c47" stroke-width="2.5" stroke-linecap="round"/>
                        <rect x="23" y="24" width="6" height="6" rx="1" fill="#10b981"/>
                        <path d="M26 25v4M24 27h4" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                </div>
                <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                    Penyakit Dalam
                </span>
            </a>

            <!-- 2. Anak -->
            <a href="{{ route('jadwal.dokter') }}?spesialis=Anak" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                    <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="grad-hm-steth" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#10b981" />
                                <stop offset="100%" stop-color="#047857" />
                            </linearGradient>
                        </defs>
                        <circle cx="32" cy="24" r="14" fill="#ffedd5" stroke="#f97316" stroke-width="2"/>
                        <path d="M30 10c1-3 3-3 4 0" stroke="#ea580c" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="27" cy="22" r="2" fill="#451a03"/>
                        <circle cx="37" cy="22" r="2" fill="#451a03"/>
                        <circle cx="28" cy="21" r="0.6" fill="#ffffff"/>
                        <circle cx="38" cy="21" r="0.6" fill="#ffffff"/>
                        <circle cx="24" cy="26" r="2.5" fill="#fca5a5" opacity="0.8"/>
                        <circle cx="40" cy="26" r="2.5" fill="#fca5a5" opacity="0.8"/>
                        <path d="M29 27c1.5 2 4.5 2 6 0" stroke="#ea580c" stroke-width="2" stroke-linecap="round"/>
                        <path d="M19 37c3.5 3 8 4.5 13 4.5s9.5-1.5 13-4.5" stroke="url(#grad-hm-steth)" stroke-width="3" stroke-linecap="round"/>
                        <path d="M20 37v9c0 6 5 10 12 10s12-4 12-10v-9" stroke="url(#grad-hm-steth)" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="32" cy="48" r="4.5" fill="#f59e0b" stroke="#b45309" stroke-width="1.8"/>
                        <circle cx="32" cy="48" r="2" fill="#ffffff"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                </div>
                <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                    Anak
                </span>
            </a>

            <!-- 3. Obgyn (Kandungan) -->
            <a href="{{ route('jadwal.dokter') }}?spesialis=Kandungan" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                    <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                        <circle cx="28" cy="14" r="6" fill="#fecdd3" stroke="#e11d48" stroke-width="2"/>
                        <path d="M25 20c-6 4-9 11-9 19 0 10 8 18 17 18" stroke="#0e7c47" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M31 20c5 4 16 9 16 21 0 10-8 18-18 18" stroke="#0e7c47" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="36" cy="35" r="4" fill="#f59e0b" stroke="#b45309" stroke-width="1.5"/>
                        <path d="M38 39c2 2 3 5 1 7-2 2-5 1-6-1" stroke="#f59e0b" stroke-width="2" stroke-linecap="round"/>
                        <path d="M24 35c2 2 6 3 10 2" stroke="#fda4af" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                </div>
                <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                    Obgyn (Kandungan)
                </span>
            </a>

            <!-- 4. Bedah -->
            <a href="{{ route('jadwal.dokter') }}?spesialis=Bedah" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                    <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="grad-hm-scalpel-b" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#f8fafc" />
                                <stop offset="100%" stop-color="#94a3b8" />
                            </linearGradient>
                            <linearGradient id="grad-hm-scalpel-h" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#34d399" />
                                <stop offset="100%" stop-color="#059669" />
                            </linearGradient>
                        </defs>
                        <path d="M49 13l2 2c2 2 1 5-1 7L30 42l-14 4 4-14L40 12c2-2 5-3 7-1z" fill="url(#grad-hm-scalpel-h)" stroke="#047857" stroke-width="2"/>
                        <path d="M40 12l9 1c2 2 1 5-1 7l-8-8z" fill="url(#grad-hm-scalpel-b)" stroke="#64748b" stroke-width="1.5"/>
                        <line x1="34" y1="22" x2="42" y2="30" stroke="#ecfdf5" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M48 38l2 5 5 2-5 2-2 5-2-5-5-2 5-2 2-5z" fill="#f59e0b" stroke="#b45309" stroke-width="1"/>
                        <path d="M10 54h44" stroke="#0e7c47" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                </div>
                <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                    Bedah
                </span>
            </a>

            <!-- 5. Mata -->
            <a href="{{ route('jadwal.dokter') }}?spesialis=Mata" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                    <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="grad-hm-iris" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#38bdf8" />
                                <stop offset="50%" stop-color="#0284c7" />
                                <stop offset="100%" stop-color="#0369a1" />
                            </linearGradient>
                            <linearGradient id="grad-hm-eyeball" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#ffffff" />
                                <stop offset="100%" stop-color="#e0f2fe" />
                            </linearGradient>
                        </defs>
                        <path d="M6 32S16 14 32 14s26 18 26 18-10 18-26 18S6 32 6 32z" fill="url(#grad-hm-eyeball)" stroke="#0284c7" stroke-width="2.2" stroke-linejoin="round"/>
                        <circle cx="32" cy="32" r="10" fill="url(#grad-hm-iris)" stroke="#0369a1" stroke-width="1.5"/>
                        <circle cx="32" cy="32" r="5" fill="#0f172a"/>
                        <circle cx="35" cy="29" r="2" fill="#ffffff"/>
                        <circle cx="30" cy="35" r="1" fill="#bae6fd"/>
                        <path d="M32 7v4M32 53v4M5 32h4M55 32h4" stroke="#f59e0b" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                </div>
                <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                    Mata
                </span>
            </a>

            <!-- 6. Jantung -->
            <a href="{{ route('jadwal.dokter') }}?spesialis=Jantung" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                    <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="grad-hm-heart" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#f87171" />
                                <stop offset="100%" stop-color="#dc2626" />
                            </linearGradient>
                            <linearGradient id="grad-hm-aorta" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#38bdf8" />
                                <stop offset="100%" stop-color="#0284c7" />
                            </linearGradient>
                        </defs>
                        <path d="M26 12V6c0-1.1.9-2 2-2h4c1.1 0 2 .9 2 2v6" fill="url(#grad-hm-aorta)" stroke="#0284c7" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M37 14V8c0-1.1.9-2 2-2h3c1.1 0 2 .9 2 2v8" fill="url(#grad-hm-aorta)" stroke="#0284c7" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M32 54C18 43 8 32 8 20a12 12 0 0 1 21.2-7.8L32 15l2.8-2.8A12 12 0 0 1 56 20c0 12-10 23-24 34z" fill="url(#grad-hm-heart)" stroke="#b91c1c" stroke-width="2"/>
                        <path d="M14 20c0-6 4-10 10-10" stroke="#fecaca" stroke-width="2" stroke-linecap="round"/>
                        <path d="M16 28h8l3-6 5 13 4-9 3 2h9" stroke="#fef08a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                </div>
                <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                    Jantung
                </span>
            </a>

        </div>

        <!-- SPECIALIST SERVICES GRID: ROW 2 & 3 (REMAINING 13 ITEMS WITH ANIMATED EXPAND/COLLAPSE) -->
        <div x-show="showAllSpesialis" 
             x-cloak
             x-transition:enter="transition ease-out duration-500 transform"
             x-transition:enter-start="opacity-0 -translate-y-6 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-300 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-y-6 scale-95"
             class="pt-10 sm:pt-12">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-y-10 sm:gap-y-12 gap-x-4 sm:gap-x-6 lg:gap-x-8">

                <!-- 7. Paru -->
                <a href="{{ route('jadwal.dokter') }}?spesialis=Paru" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <defs>
                                <linearGradient id="grad-hm-lung-l" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#6ee7b7" />
                                    <stop offset="100%" stop-color="#059669" />
                                </linearGradient>
                                <linearGradient id="grad-hm-lung-r" x1="100%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" stop-color="#6ee7b7" />
                                    <stop offset="100%" stop-color="#059669" />
                                </linearGradient>
                            </defs>
                            <path d="M29 6h6v14h-6z" fill="#e2e8f0" stroke="#0e7c47" stroke-width="2" stroke-linecap="round"/>
                            <line x1="29" y1="10" x2="35" y2="10" stroke="#0e7c47" stroke-width="1.8"/>
                            <line x1="29" y1="14" x2="35" y2="14" stroke="#0e7c47" stroke-width="1.8"/>
                            <line x1="29" y1="18" x2="35" y2="18" stroke="#0e7c47" stroke-width="1.8"/>
                            <path d="M29 20c-3 1-8 4-11 1-5-5-9 6-10 16-1 9 5 18 13 18 6 0 8-7 8-15v-20z" fill="url(#grad-hm-lung-l)" stroke="#047857" stroke-width="2"/>
                            <path d="M35 20c3 1 8 4 11 1 5-5 9 6 10 16 1 9-5 18-13 18-6 0-8-7-8-15v-20z" fill="url(#grad-hm-lung-r)" stroke="#047857" stroke-width="2"/>
                            <path d="M26 27l-6 6M23 30l-3-2M38 27l6 6M41 30l3-2" stroke="#ecfdf5" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Paru
                    </span>
                </a>

                <!-- 8. Orthopedi -->
                <a href="{{ route('jadwal.dokter') }}?spesialis=Orthopedi" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <defs>
                                <linearGradient id="grad-hm-bone" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#ffffff" />
                                    <stop offset="50%" stop-color="#f1f5f9" />
                                    <stop offset="100%" stop-color="#cbd5e1" />
                                </linearGradient>
                            </defs>
                            <path d="M22 10c-3-3-8-2-10 1s-1 8 2 10l8 8-10 2c-4 1-5 6-3 9s7 4 10 1l12-12 12 12c3 3 8 2 10-1s1-8-2-10l-8-8 10-2c4-1 5-6 3-9s-7-4-10-1L36 22 24 10z" fill="url(#grad-hm-bone)" stroke="#475569" stroke-width="2" stroke-linejoin="round"/>
                            <circle cx="32" cy="32" r="5" fill="#38bdf8" stroke="#0284c7" stroke-width="1.8"/>
                            <path d="M30 32h4M32 30v4" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M12 48l6-6M46 16l6-6" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Orthopedi
                    </span>
                </a>

                <!-- 9. Urologi -->
                <a href="{{ route('jadwal.dokter') }}?spesialis=Urologi" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <defs>
                                <linearGradient id="grad-hm-kidney-l" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#f43f5e" />
                                    <stop offset="100%" stop-color="#9f1239" />
                                </linearGradient>
                                <linearGradient id="grad-hm-kidney-r" x1="100%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" stop-color="#f43f5e" />
                                    <stop offset="100%" stop-color="#9f1239" />
                                </linearGradient>
                            </defs>
                            <path d="M16 16c-6 4-8 14-4 20 4 6 12 4 14-2 1-4-1-8-3-10-3-3-4-6-7-8z" fill="url(#grad-hm-kidney-l)" stroke="#881337" stroke-width="2"/>
                            <path d="M48 16c6 4 8 14 4 20-4 6-12 4-14-2-1-4 1-8 3-10 3-3 4-6 7-8z" fill="url(#grad-hm-kidney-r)" stroke="#881337" stroke-width="2"/>
                            <path d="M23 28c3 10 7 18 9 24M41 28c-3 10-7 18-9 24" stroke="#38bdf8" stroke-width="2" stroke-linecap="round"/>
                            <circle cx="32" cy="54" r="5" fill="#38bdf8" stroke="#0284c7" stroke-width="1.8"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Urologi
                    </span>
                </a>

                <!-- 10. THT – KL -->
                <a href="{{ route('jadwal.dokter') }}?spesialis=THT" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <defs>
                                <linearGradient id="grad-hm-ear" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#fed7aa" />
                                    <stop offset="100%" stop-color="#fb923c" />
                                </linearGradient>
                            </defs>
                            <path d="M18 18c-6 0-10 5-10 11 0 9 6 13 10 18 2 2 3 5 2 8" fill="url(#grad-hm-ear)" stroke="#ea580c" stroke-width="2" stroke-linecap="round"/>
                            <path d="M16 23c-3 1-4 3-4 6 0 5 4 7 6 8" stroke="#c2410c" stroke-width="2" stroke-linecap="round"/>
                            <path d="M38 12c5 7 12 11 12 18 0 4-4 5-7 4-1 2-1 4-1 6 0 7 3 12 6 17H36c-5-9-6-16-6-23 0-9 4-17 8-22z" fill="#ecfdf5" stroke="#0e7c47" stroke-width="2.2"/>
                            <path d="M52 26c3 2 4 4 4 7s-1 5-4 7" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M57 21c4 3 6 8 6 12s-2 9-6 12" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        THT – KL
                    </span>
                </a>

                <!-- 11. Neurologi (Saraf) -->
                <a href="{{ route('jadwal.dokter') }}?spesialis=Saraf" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <defs>
                                <linearGradient id="grad-hm-neuro" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#a855f7" />
                                    <stop offset="100%" stop-color="#6b21a8" />
                                </linearGradient>
                            </defs>
                            <path d="M32 12c-5-5-17-4-21 4-4 7-2 16 2 20-2 4-2 9 1 12 4 4 10 3 13 1 2 4 8 6 13 2" fill="url(#grad-hm-neuro)" stroke="#581c87" stroke-width="2"/>
                            <path d="M32 12c5-5 17-4 21 4 4 7 2 16-2 20 2 4 2 9-1 12-4 4-10 3-13 1-2 4-8 6-13 2" fill="url(#grad-hm-neuro)" stroke="#581c87" stroke-width="2"/>
                            <line x1="32" y1="12" x2="32" y2="52" stroke="#3b0764" stroke-width="2"/>
                            <circle cx="21" cy="24" r="2.5" fill="#38bdf8"/>
                            <circle cx="43" cy="24" r="2.5" fill="#38bdf8"/>
                            <circle cx="20" cy="38" r="2.5" fill="#fde047"/>
                            <circle cx="44" cy="38" r="2.5" fill="#fde047"/>
                            <path d="M21 24l5 6-4 8M43 24l-5 6 4 8" stroke="#ffffff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Neurologi (Saraf)
                    </span>
                </a>

                <!-- 12. Bedah Saraf -->
                <a href="{{ route('jadwal.dokter') }}?spesialis=Bedah+Saraf" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <defs>
                                <linearGradient id="grad-hm-neurosurg" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#c084fc" />
                                    <stop offset="100%" stop-color="#7c3aed" />
                                </linearGradient>
                            </defs>
                            <path d="M32 14c-4-4-14-3-18 3-3 6-2 13 2 17-2 3-2 7 1 10 3 3 8 2 11 1 2 3 6 5 10 2" fill="url(#grad-hm-neurosurg)" stroke="#6d28d9" stroke-width="1.8"/>
                            <path d="M32 14c4-4 14-3 18 3 3 6 2 13-2 17 2 3 2 7-1 10-3 3-8 2-11 1-2 3-6 5-10 2" fill="url(#grad-hm-neurosurg)" stroke="#6d28d9" stroke-width="1.8"/>
                            <path d="M48 10l6 6-18 18-4-4L48 10z" fill="#f8fafc" stroke="#0e7c47" stroke-width="1.8"/>
                            <circle cx="32" cy="30" r="3" fill="#f59e0b" stroke="#b45309" stroke-width="1"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Bedah Saraf
                    </span>
                </a>

                <!-- 13. Jiwa -->
                <a href="{{ route('jadwal.dokter') }}?spesialis=Jiwa" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <defs>
                                <linearGradient id="grad-hm-mind" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#fef08a" />
                                    <stop offset="100%" stop-color="#f59e0b" />
                                </linearGradient>
                            </defs>
                            <path d="M18 55v-6c0-6 2-9 6-12-3-4-3-10-2-15 3-11 13-15 23-12 8 3 12 11 11 19-1 4-2 6-2 9l4 5-3 5h-8l-1 7" fill="#f0fdf4" stroke="#0e7c47" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="36" cy="27" r="7" fill="url(#grad-hm-mind)" stroke="#d97706" stroke-width="1.8"/>
                            <path d="M36 17v-3M46 27h3M36 37v3M26 27h-3M43 20l2-2M29 34l-2 2M43 34l2 2M29 20l-2-2" stroke="#f59e0b" stroke-width="2.2" stroke-linecap="round"/>
                            <path d="M33 28c1.5 2 4.5 2 6 0" stroke="#78350f" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Jiwa
                    </span>
                </a>

                <!-- 14. Kulit dan Kelamin -->
                <a href="{{ route('jadwal.dokter') }}?spesialis=Kulit" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <defs>
                                <linearGradient id="grad-hm-skin" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#fbcfe8" />
                                    <stop offset="100%" stop-color="#f43f5e" />
                                </linearGradient>
                            </defs>
                            <path d="M32 10c12 0 20 8 20 18 0 14-12 24-20 28-8-4-20-14-20-28 0-10 8-18 20-18z" fill="url(#grad-hm-skin)" stroke="#be123c" stroke-width="2"/>
                            <path d="M22 26c4-3 16-3 20 0M20 34c6-2 18-2 24 0M26 42c3-1 9-1 12 0" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                            <circle cx="32" cy="22" r="3" fill="#fde047" stroke="#ca8a04" stroke-width="1"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Kulit dan Kelamin
                    </span>
                </a>

                <!-- 15. Rehab Medik -->
                <a href="{{ route('jadwal.dokter') }}?spesialis=Rehab+Medik" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <circle cx="32" cy="14" r="5" fill="#38bdf8" stroke="#0284c7" stroke-width="2"/>
                            <path d="M22 28l10-4 10 4M32 24v18l-8 12M32 42l8 12" stroke="#0e7c47" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14 36c4-10 14-16 26-14M14 44c6 8 16 12 26 8" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-dasharray="2 3"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Rehab Medik
                    </span>
                </a>

                <!-- 16. Spesialis Gigi (Periodonti) -->
                <a href="{{ route('jadwal.dokter') }}?spesialis=Gigi" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <defs>
                                <linearGradient id="grad-hm-perio" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#ffffff" />
                                    <stop offset="100%" stop-color="#e0f2fe" />
                                </linearGradient>
                            </defs>
                            <path d="M18 20c0-8 6-12 14-12s14 4 14 12c0 9-3 15-4 24-1 6-4 11-6 11s-2-8-2-13-2 13-4 13-5-5-6-11c-1-9-4-15-4-24z" fill="url(#grad-hm-perio)" stroke="#0284c7" stroke-width="2.2" stroke-linejoin="round"/>
                            <path d="M12 36c4-3 12-4 20-4s16 1 20 4v8H12v-8z" fill="#fda4af" stroke="#e11d48" stroke-width="1.8"/>
                            <path d="M46 12l2 4 4 2-4 2-2 4-2-4-4-2 4-2 2-4z" fill="#fbbf24" stroke="#d97706" stroke-width="1"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Spesialis Gigi<br>(Periodonti)
                    </span>
                </a>

                <!-- 17. Bedah Mulut -->
                <a href="{{ route('jadwal.dokter') }}?spesialis=Bedah+Mulut" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <path d="M12 28c0-10 9-16 20-16s20 6 20 16c0 8-6 16-12 22-5 5-11 5-16 0-6-6-12-14-12-22z" fill="#f8fafc" stroke="#0e7c47" stroke-width="2"/>
                            <rect x="22" y="24" width="8" height="10" rx="2" fill="#38bdf8" stroke="#0284c7" stroke-width="1.5"/>
                            <rect x="34" y="24" width="8" height="10" rx="2" fill="#38bdf8" stroke="#0284c7" stroke-width="1.5"/>
                            <path d="M44 14l8 8-14 14-4-4 10-18z" fill="#f59e0b" stroke="#b45309" stroke-width="1.5"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Bedah Mulut
                    </span>
                </a>

                <!-- 18. Gigi -->
                <a href="{{ route('jadwal.dokter') }}?spesialis=Gigi" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <defs>
                                <linearGradient id="grad-hm-teeth" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#ffffff" />
                                    <stop offset="100%" stop-color="#dbeafe" />
                                </linearGradient>
                            </defs>
                            <path d="M18 20c0-8 6-12 14-12s14 4 14 12c0 9-3 15-4 24-1 6-4 11-6 11s-2-8-2-13-2 13-4 13-5-5-6-11c-1-9-4-15-4-24z" fill="url(#grad-hm-teeth)" stroke="#0284c7" stroke-width="2.2" stroke-linejoin="round"/>
                            <path d="M25 15c3-2 8-2 12 0" stroke="#38bdf8" stroke-width="2" stroke-linecap="round"/>
                            <circle cx="32" cy="24" r="3" fill="#fef08a" stroke="#ca8a04" stroke-width="1"/>
                            <path d="M46 12l2 4 4 2-4 2-2 4-2-4-4-2 4-2 2-4z" fill="#fbbf24" stroke="#d97706" stroke-width="1"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Gigi
                    </span>
                </a>

                <!-- 19. Radiologi -->
                <a href="{{ route('jadwal.dokter') }}?spesialis=Radiologi" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <rect x="12" y="10" width="40" height="44" rx="4" fill="#0f172a" stroke="#38bdf8" stroke-width="2"/>
                            <line x1="32" y1="16" x2="32" y2="48" stroke="#38bdf8" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M32 20c-6-2-12 0-14 4M32 20c6-2 12 0 14 4M32 28c-7-2-14 1-16 6M32 28c7-2 14 1 16 6M32 36c-6-1-12 2-14 7M32 36c6-1 12 2 14 7" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                            <line x1="12" y1="18" x2="52" y2="18" stroke="#f59e0b" stroke-width="1" stroke-dasharray="2 2"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Radiologi
                    </span>
                </a>

            </div>
        </div>

        <!-- SEE ALL BUTTON (TOGGLE) -->
        <div class="mt-12 text-center">
            <button @click="showAllSpesialis = !showAllSpesialis" 
                    type="button"
                    style="background-color: #0e7c47; color: #ffffff;"
                    class="inline-flex items-center justify-center px-10 sm:px-12 py-2.5 rounded-full bg-[#0e7c47] hover:bg-[#096237] text-white font-bold text-sm tracking-tight shadow-sm hover:shadow-md active:scale-95 transition-all duration-200 cursor-pointer gap-2">
                <span x-text="showAllSpesialis ? 'Tutup Daftar Spesialisasi' : 'Lihat Seluruh Poliklinik (19 Poli)'">Lihat Seluruh Poliklinik (19 Poli)</span>
                <i class="fa-solid text-xs transition-transform duration-300" :class="showAllSpesialis ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </button>
        </div>

    </div>
</section>

<!-- SECTION: CENTER OF EXCELLENCE / LAYANAN UNGGULAN (MATCHING REFERENCE DESIGN) -->
<section id="layanan" class="py-16 lg:py-24 bg-white border-t border-gray-100 relative overflow-hidden" x-data="{
    canScrollLeft: false,
    canScrollRight: true,
    currentSlideIndex: 0,
    totalCount: {{ count($featuredServices) }},
    get totalDots() {
        return Math.max(1, this.totalCount - 2);
    },
    scrollSlider(dir) {
        const el = this.$refs.slider;
        if (!el) return;
        const card = el.querySelector('.service-card');
        const cardWidth = card ? card.offsetWidth + 24 : 380;
        el.scrollBy({ left: dir * cardWidth, behavior: 'smooth' });
    },
    goToSlide(idx) {
        const el = this.$refs.slider;
        if (!el) return;
        const card = el.querySelector('.service-card');
        const cardWidth = card ? card.offsetWidth + 24 : 380;
        el.scrollTo({ left: idx * cardWidth, behavior: 'smooth' });
    },
    checkScroll() {
        const el = this.$refs.slider;
        if (!el) return;
        this.canScrollLeft = el.scrollLeft > 15;
        this.canScrollRight = el.scrollLeft < (el.scrollWidth - el.clientWidth - 15);
        const card = el.querySelector('.service-card');
        const cardWidth = card ? card.offsetWidth + 24 : 380;
        this.currentSlideIndex = Math.min(this.totalDots - 1, Math.max(0, Math.round(el.scrollLeft / cardWidth)));
    }
}" x-init="setTimeout(() => checkScroll(), 300)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        
        <!-- CENTERED TITLE -->
        <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-14">
            <h2 class="text-2.5xl sm:text-3xl lg:text-4xl font-extrabold text-[#005f59] tracking-tight">
                Layanan Unggulan
            </h2>
        </div>

        <!-- SLIDER CONTAINER WITH FLOATING ARROWS -->
        <div class="relative group/slider">
            
            <!-- LEFT FLOATING ARROW BUTTON -->
            <button @click="scrollSlider(-1)" 
                    x-show="canScrollLeft" 
                    x-cloak
                    type="button" 
                    aria-label="Previous Slide" 
                    class="absolute left-2 sm:-left-5 top-1/2 -translate-y-1/2 z-30 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-[#005f59]/90 hover:bg-[#005f59] text-white flex items-center justify-center shadow-xl hover:scale-110 active:scale-95 transition-all duration-200 cursor-pointer">
                <i class="fa-solid fa-chevron-left text-sm sm:text-base"></i>
            </button>

            <!-- RIGHT FLOATING ARROW BUTTON (MATCHING REFERENCE DESIGN) -->
            <button @click="scrollSlider(1)" 
                    type="button" 
                    aria-label="Next Slide" 
                    class="absolute right-2 sm:-right-5 top-1/2 -translate-y-1/2 z-30 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-[#005f59] hover:bg-[#004743] text-white flex items-center justify-center shadow-xl hover:scale-110 active:scale-95 transition-all duration-200 cursor-pointer">
                <i class="fa-solid fa-chevron-right text-sm sm:text-base"></i>
            </button>

            <!-- HORIZONTAL SWIPEABLE / SCROLLABLE SLIDER -->
            <div x-ref="slider"
                 @scroll.passive="checkScroll()"
                 style="scrollbar-width: none; -ms-overflow-style: none; -webkit-overflow-scrolling: touch;"
                 class="flex gap-6 overflow-x-auto scroll-smooth snap-x snap-mandatory py-2 cursor-grab active:cursor-grabbing select-none [::-webkit-scrollbar]:hidden">
                
                @foreach($featuredServices as $service)
                @php
                    $featImg = !empty($service->image) ? (\Illuminate\Support\Str::startsWith($service->image, ['http://', 'https://']) ? $service->image : asset($service->image)) : 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=800&q=80';
                @endphp
                <a href="{{ url('/layanan/' . ($service->slug ?: \Illuminate\Support\Str::slug($service->tr('name')))) }}" 
                   class="service-card w-[88%] sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] shrink-0 snap-start rounded-2xl sm:rounded-3xl overflow-hidden relative h-80 sm:h-96 lg:h-[420px] shadow-lg hover:shadow-2xl transition-all duration-300 group block">
                    
                    <!-- FULL COVER BACKGROUND IMAGE -->
                    <img src="{{ $featImg }}" 
                         alt="{{ $service->tr('name') }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 pointer-events-none"
                         loading="lazy"
                         decoding="async">
                    
                    <!-- BOTTOM GRADIENT OVERLAY -->
                    <div class="absolute inset-0 bg-gradient-to-t from-[#005f59] via-[#005f59]/65 via-35% to-transparent flex flex-col justify-end p-6 sm:p-8 text-center transition-all duration-300">
                        <h3 class="text-lg sm:text-xl lg:text-2xl font-extrabold text-white tracking-wide leading-snug drop-shadow-sm group-hover:text-amber-300 transition-colors">
                            {{ $service->tr('name') }}
                        </h3>
                    </div>

                </a>
                @endforeach

            </div>
        </div>

        <!-- PAGINATION PILLS INDICATOR (ORANGE ACTIVE PILL) -->
        <div class="flex items-center justify-center gap-2 mt-8 sm:mt-10">
            <template x-for="i in totalDots" :key="i">
                <button @click="goToSlide(i - 1)"
                        type="button"
                        :class="currentSlideIndex === (i - 1) ? 'w-8 bg-orange-500' : 'w-6 bg-[#005f59]/25 hover:bg-[#005f59]/50'"
                        class="h-1.5 rounded-full transition-all duration-300 cursor-pointer outline-none">
                </button>
            </template>
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
