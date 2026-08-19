<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RSU Fikri Medika - {{ __('Rumah Sakit Umum Terpercaya Berorientasi Islami & Modern') }}</title>
    <meta name="description" content="RSU Fikri Medika adalah rumah sakit umum terpercaya di Karawang yang mengedepankan pelayanan kesehatan profesional, modern, dan berkarakter Islami.">

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Alpine.js for lightweight interactive components -->
    <style>[x-cloak] { display: none !important; }</style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased flex flex-col min-h-screen bg-[#f7faf8] pb-14 lg:pb-0" x-data="{ mobileMenuOpen: false, searchOpen: false, scrolled: false }">

    <!-- MEDICAL ECG HEARTBEAT PRELOADER -->
    <div id="medicare-preloader">
        <div class="flex flex-col items-center justify-center p-6 text-center select-none">
            <!-- ECG WAVEFORM SVG -->
            <div class="relative flex items-center justify-center my-2">
                <svg class="ecg-svg" viewBox="0 0 300 100" xmlns="http://www.w3.org/2000/svg">
                    <!-- BACKGROUND FAINT GUIDE LINE -->
                    <path class="ecg-bg-line" d="M 0 50 L 60 50 L 70 40 L 80 50 L 115 50 L 125 70 L 140 10 L 155 90 L 170 50 L 185 50 L 195 38 L 210 50 L 300 50" />
                    <!-- ANIMATED PULSE LINE -->
                    <path class="ecg-pulse-line" d="M 0 50 L 60 50 L 70 40 L 80 50 L 115 50 L 125 70 L 140 10 L 155 90 L 170 50 L 185 50 L 195 38 L 210 50 L 300 50" />
                    <!-- GLOWING MEDICAL RED BEAT PIN -->
                    <circle class="ecg-dot" cx="140" cy="10" r="4.5" />
                </svg>
            </div>

            <!-- TEXT & MEDICAL BADGE -->
            <div class="mt-2 space-y-1">
                <div class="text-xs sm:text-sm font-extrabold text-[#0e7c47] uppercase tracking-widest flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-heart-pulse text-red-500 animate-pulse text-xs"></i>
                    <span>RSU FIKRI MEDIKA</span>
                </div>
                <p class="text-[11px] sm:text-xs text-slate-400 font-medium tracking-wide">
                    {{ app()->getLocale() == 'en' ? 'Loading healthcare services...' : 'Memuat layanan kesehatan...' }}
                </p>
            </div>
        </div>
    </div>

    <!-- PRELOADER DISMISS SCRIPT -->
    <script>
        (function() {
            function hidePreloader() {
                var preloader = document.getElementById('medicare-preloader');
                if (preloader && !preloader.classList.contains('loaded')) {
                    preloader.classList.add('loaded');
                    setTimeout(function() {
                        if (preloader && preloader.parentNode) {
                            preloader.parentNode.removeChild(preloader);
                        }
                    }, 600);
                }
            }

            if (document.readyState === 'complete') {
                setTimeout(hidePreloader, 400);
            } else {
                window.addEventListener('load', function() {
                    setTimeout(hidePreloader, 400);
                });
                // Fallback max 3.5s in case of slow network/trackers
                setTimeout(hidePreloader, 3500);
            }
        })();
    </script>

    <!-- TOP EMERGENCY & INFO BAR -->
    <div class="bg-[#0e7c47] text-white text-xs py-1 px-3 sm:px-6 lg:px-8 border-b border-[#096237]/60">
        <div class="max-w-6xl mx-auto flex flex-row justify-between items-center gap-2">
            
            <!-- LEFT INFO ITEMS -->
            <div class="flex items-center gap-2 sm:gap-4 truncate">
                <a href="https://maps.google.com" target="_blank" class="inline-flex items-center gap-1 text-gray-100 hover:text-yellow-300 transition-colors text-[11px] sm:text-xs">
                    <i class="fa-solid fa-location-dot text-yellow-300 text-xs"></i>
                    <span class="inline">{{ __('Lokasi') }}</span>
                </a>

                <span class="text-[#159b5a]/60">|</span>

                <!-- CLICKABLE IGD NUMBER -->
                <a href="tel:02678454999" class="inline-flex items-center gap-1.5 font-bold text-yellow-300 hover:text-yellow-200 transition-colors shrink-0 text-[11px] sm:text-xs">
                    <i class="fa-solid fa-phone-volume text-red-300 animate-pulse text-xs"></i>
                    <span>{{ __('IGD 24 Jam') }}: <span class="underline decoration-yellow-300/50">(0267) 8454999</span></span>
                </a>

                <span class="hidden sm:inline-block text-[#159b5a]/60">|</span>

                <!-- CLICKABLE EMAIL -->
                <a href="mailto:fikri.medika@gmail.com" class="hidden sm:inline-flex items-center gap-1.5 text-gray-100 hover:text-white transition-colors text-[11px] sm:text-xs">
                    <i class="fa-regular fa-envelope text-yellow-300 text-xs"></i>
                    <span>fikri.medika@gmail.com</span>
                </a>

                <span class="hidden md:inline-block text-[#159b5a]/60">|</span>

                <!-- LIVE TIME CLOCK -->
                <div x-data="{ liveTime: '' }" 
                     x-init="const updateClock = () => { const now = new Date(); liveTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WIB'; }; updateClock(); setInterval(updateClock, 1000);" 
                     class="hidden lg:inline-flex items-center gap-1.5 text-gray-100 font-medium text-xs">
                    <i class="fa-regular fa-clock text-yellow-300 text-xs"></i>
                    <span x-text="liveTime" class="font-mono text-yellow-200"></span>
                </div>
            </div>

            <!-- RIGHT LANGUAGE SWITCHER -->
            <div class="flex items-center gap-1.5 shrink-0">
                <div class="inline-flex items-center bg-[#096237] rounded-full p-0.5 border border-[#159b5a]/40">
                    <a href="{{ route('lang.switch', 'id') }}" 
                       class="px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-bold transition-all flex items-center gap-1 {{ app()->getLocale() == 'id' ? 'bg-yellow-400 text-gray-900 shadow-sm' : 'text-gray-200 hover:text-white' }}">
                        <span>ID</span>
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}" 
                       class="px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-bold transition-all flex items-center gap-1 {{ app()->getLocale() == 'en' ? 'bg-yellow-400 text-gray-900 shadow-sm' : 'text-gray-200 hover:text-white' }}">
                        <span>EN</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN NAVBAR HEADER -->
    <header @scroll.window="scrolled = (window.pageYOffset > 20)" 
            class="sticky top-0 z-40 bg-white/95 backdrop-blur-md shadow-sm transition-all duration-300 border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-14 sm:h-16">
                <!-- OFFICIAL HORIZONTAL LOGO -->
                <a href="{{ route('home') }}" class="flex items-center py-1 group shrink-0">
                    <img src="{{ asset('logodasboard.png') }}" 
                         alt="RSU Fikri Medika Logo" 
                         class="h-8 sm:h-10 w-auto object-contain group-hover:scale-105 transition-transform">
                </a>

                <!-- DESKTOP NAV -->
                <nav class="hidden lg:flex items-center gap-5 xl:gap-7 text-xs sm:text-sm font-semibold text-gray-700 h-full">
                    <a href="{{ route('home') }}" class="flex items-center h-full transition-colors {{ request()->is('/') ? 'text-[#0e7c47] font-bold relative after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#0e7c47]' : 'hover:text-[#0e7c47]' }}">
                        {{ __('Beranda') }}
                    </a>
                    <a href="{{ url('/profil') }}" class="flex items-center h-full transition-colors {{ request()->is('profil') ? 'text-[#0e7c47] font-bold relative after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#0e7c47]' : 'hover:text-[#0e7c47]' }}">{{ __('Profil') }}</a>
                    
                    <!-- LAYANAN DROPDOWN -->
                    <div class="relative flex items-center h-full" x-data="{ dropdownOpen: false }" @mouseenter="dropdownOpen = true" @mouseleave="dropdownOpen = false">
                        <button class="transition-colors flex items-center gap-1.5 focus:outline-none h-full {{ request()->is('layanan*') ? 'text-[#0e7c47] font-bold relative after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#0e7c47]' : 'hover:text-[#0e7c47]' }}">
                            <span>{{ __('Layanan') }}</span>
                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" :class="dropdownOpen ? 'rotate-180 text-[#0e7c47]' : ''"></i>
                        </button>

                        <!-- DROPDOWN MENU CONTAINER -->
                        <div x-show="dropdownOpen" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                             class="absolute top-full left-0 w-64 bg-white rounded-xl shadow-2xl py-1 z-50 text-gray-700 text-xs font-semibold border border-gray-100 divide-y divide-gray-100"
                             style="display: none;">
                            
                             <style>
                                .unggulan-menu-item, .penunjang-menu-item {
                                    position: relative;
                                }
                                .unggulan-sub-menu, .penunjang-sub-menu {
                                    display: none !important;
                                    position: absolute;
                                    top: 0;
                                    left: 100%;
                                    width: 260px;
                                    background: #ffffff;
                                    border-radius: 12px;
                                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                                    padding: 4px 0;
                                    z-index: 9999;
                                    border: 1px solid #f3f4f6;
                                }
                                .unggulan-menu-item:hover .unggulan-sub-menu,
                                .penunjang-menu-item:hover .penunjang-sub-menu {
                                    display: block !important;
                                }
                            </style>

                            <!-- LAYANAN UNGGULAN SUB-DROPDOWN -->
                            @php
                                $navFeaturedServices = \App\Models\Service::where('is_active', true)->where('is_featured', true)->orderBy('order', 'asc')->get();
                                if ($navFeaturedServices->isEmpty()) {
                                    $navFeaturedServices = \App\Models\Service::where('is_active', true)->orderBy('order', 'asc')->get();
                                }
                            @endphp
                            <div class="unggulan-menu-item">
                                <a href="{{ url('/layanan/unggulan') }}" class="flex items-center justify-between px-4 py-3 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors text-gray-700 font-semibold border-b border-gray-100 {{ request()->is('layanan/unggulan*') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">
                                    <span>Layanan Unggulan</span>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-[#0e7c47]"></i>
                                </a>

                                <!-- SUB-MENU POPUP (RIGHT SIDE) -->
                                <div class="unggulan-sub-menu">
                                    @foreach($navFeaturedServices as $navFeat)
                                    @php
                                        $featSlug = $navFeat->slug ?: \Illuminate\Support\Str::slug($navFeat->tr('name'));
                                    @endphp
                                    <a href="{{ url('/layanan/' . $featSlug) }}" class="block px-4 py-2.5 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors border-b border-gray-100 last:border-0 {{ request()->is('layanan/' . $featSlug . '*') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">
                                        {{ $navFeat->tr('name') }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>

                            <a href="{{ url('/layanan/rawat-inap') }}" class="block px-4 py-3 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors border-b border-gray-100 {{ request()->is('layanan/rawat-inap*') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">
                                Rawat Inap
                            </a>

                            <a href="{{ url('/layanan/rawat-jalan') }}" class="block px-4 py-3 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors border-b border-gray-100 {{ request()->is('layanan/rawat-jalan*') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">
                                Klinik Rawat Jalan
                            </a>

                            <a href="{{ url('/layanan/igd') }}" class="block px-4 py-3 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors border-b border-gray-100 {{ request()->is('layanan/igd*') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">
                                IGD 24 Jam
                            </a>

                            <a href="{{ url('/layanan/rehabilitasi-medik') }}" class="block px-4 py-3 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors border-b border-gray-100 {{ request()->is('layanan/rehabilitasi-medik*') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">
                                Instalasi Rehabilitasi Medik
                            </a>

                            <a href="{{ url('/layanan/farmasi-24-jam') }}" class="block px-4 py-3 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors border-b border-gray-100 {{ request()->is('layanan/farmasi-24-jam*') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">
                                Farmasi 24 Jam
                            </a>

                            <!-- PENUNJANG MEDIS SUB-DROPDOWN -->
                            <div class="penunjang-menu-item">
                                <a href="{{ url('/layanan/penunjang-medis') }}" class="flex items-center justify-between px-4 py-3 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors text-gray-700 font-semibold {{ request()->is('layanan/penunjang*') || request()->is('layanan/radiologi*') || request()->is('layanan/laboratorium*') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">
                                    <span>Penunjang Medis</span>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-[#0e7c47]"></i>
                                </a>

                                <!-- SUB-MENU POPUP (RIGHT SIDE) -->
                                <div class="penunjang-sub-menu">
                                    <a href="{{ url('/layanan/radiologi-24-jam') }}" class="block px-4 py-3 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors border-b border-gray-100 {{ request()->is('layanan/radiologi*') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">
                                        Radiologi 24 Jam
                                    </a>
                                    <a href="{{ url('/layanan/laboratorium-klinik') }}" class="block px-4 py-3 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors border-b border-gray-100 {{ request()->is('layanan/laboratorium-klinik*') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">
                                        Laboratorium Klinik 24 Jam
                                    </a>
                                    <a href="{{ url('/layanan/laboratorium-patologi') }}" class="block px-4 py-3 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors {{ request()->is('layanan/laboratorium-patologi*') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">
                                        Laboratorium Patologi Anatomi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ url('/jadwal-dokter') }}" class="flex items-center h-full transition-colors {{ request()->is('jadwal-dokter') ? 'text-[#0e7c47] font-bold relative after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#0e7c47]' : 'hover:text-[#0e7c47]' }}">{{ __('Jadwal Dokter') }}</a>
                    
                    <!-- INFORMASI DROPDOWN -->
                    <div class="relative flex items-center h-full" x-data="{ dropdownOpen: false }" @mouseenter="dropdownOpen = true" @mouseleave="dropdownOpen = false">
                        <button class="transition-colors flex items-center gap-1.5 focus:outline-none h-full {{ request()->is('informasi*') ? 'text-[#0e7c47] font-bold relative after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#0e7c47]' : 'hover:text-[#0e7c47]' }}">
                            <span>{{ __('Informasi') }}</span>
                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" :class="dropdownOpen ? 'rotate-180 text-[#0e7c47]' : ''"></i>
                        </button>

                        <!-- DROPDOWN MENU CONTAINER (MATCHING LAYANAN WHITE THEME WITH GREEN HOVER) -->
                        <div x-show="dropdownOpen" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                             class="absolute top-full left-0 w-64 bg-white rounded-xl shadow-2xl py-1 z-50 text-gray-700 text-xs font-semibold border border-gray-100 divide-y divide-gray-100"
                             style="display: none;">
                            <a href="{{ url('/informasi/artikel-kesehatan') }}" class="block px-4 py-3 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors border-b border-gray-100 {{ request()->is('informasi/artikel-kesehatan') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">{{ __('Artikel Kesehatan') }}</a>
                            <a href="{{ url('/informasi/event') }}" class="block px-4 py-3 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors border-b border-gray-100 {{ request()->is('informasi/event') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">{{ __('Event') }}</a>
                            <a href="{{ url('/informasi/penawaran-khusus') }}" class="block px-4 py-3 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors border-b border-gray-100 {{ request()->is('informasi/penawaran-khusus') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">{{ __('Penawaran Khusus') }}</a>
                            <a href="{{ url('/informasi/aduan-layanan') }}" class="block px-4 py-3 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors border-b border-gray-100 {{ request()->is('informasi/aduan-layanan') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">{{ __('Aduan Layanan') }}</a>
                            <a href="{{ url('/informasi/ikm') }}" class="block px-4 py-3 hover:bg-emerald-50 hover:text-[#0e7c47] transition-colors {{ request()->is('informasi/ikm') ? 'text-[#0e7c47] font-bold bg-emerald-50' : '' }}">{{ __('Indeks Kepuasan Masyarakat') }}</a>
                        </div>
                    </div>

                    <a href="{{ url('/karir') }}" class="flex items-center h-full transition-colors {{ request()->is('karir') ? 'text-[#0e7c47] font-bold relative after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#0e7c47]' : 'hover:text-[#0e7c47]' }}">{{ __('Karir') }}</a>
                </nav>

                <!-- RIGHT CONTROLS: SEARCH ICON AND DESKTOP CTA -->
                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <!-- SEARCH BUTTON -->
                    <button @click="searchOpen = !searchOpen" class="p-1.5 rounded-lg text-[#0e7c47] hover:bg-emerald-50 transition-colors focus:outline-none" title="Cari">
                        <i class="fa-solid fa-magnifying-glass text-base sm:text-lg"></i>
                    </button>

                    <!-- DESKTOP CTA BUTTON -->
                    <a href="{{ url('/buat-janji') }}" class="hidden lg:flex px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-[#e31e24] text-white hover:bg-red-700 shadow-md shadow-red-200 transition-all items-center gap-2">
                        <i class="fa-solid fa-heart-pulse"></i>
                        <span>{{ __('Daftar / Buat Janji') }}</span>
                    </a>
                </div>
            </div>

            <!-- SEARCH OVERLAY INPUT -->
            <div x-show="searchOpen" 
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="pb-3 pt-1 border-t border-gray-100"
                 style="display: none;">
                <form action="{{ url('/jadwal-dokter') }}" method="GET" class="relative max-w-xl mx-auto flex items-center px-1">
                    <input type="text" name="q" placeholder="Cari dokter, poliklinik, atau layanan..." 
                           class="w-full pl-9 pr-14 py-2 rounded-xl border border-gray-300 focus:outline-none focus:border-[#0e7c47] focus:ring-1 focus:ring-[#0e7c47] text-xs sm:text-sm text-gray-800 shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 text-gray-400 text-xs sm:text-sm"></i>
                    <button type="submit" class="absolute right-3 px-3 py-1 bg-[#0e7c47] text-white rounded-lg text-xs font-bold hover:bg-[#096237] transition-colors">
                        Cari
                    </button>
                </form>
            </div>
        </div>

    </header>

    <!-- MOBILE SLIDE-UP BOTTOM SHEET MENU DRAWER -->
    <div x-show="mobileMenuOpen" 
         class="fixed inset-0 z-50 lg:hidden flex flex-col justify-end" 
         style="display: none;">
        
        <!-- BACKDROP OVERLAY -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false" 
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

        <!-- SLIDE-UP BOTTOM PANEL -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full"
             class="relative bg-white rounded-t-3xl shadow-2xl p-4 pb-20 space-y-1.5 z-10 border-t border-emerald-900/10">
            
            <!-- GRAB HANDLE BAR & CLOSE ICON -->
            <div class="relative flex items-center justify-center pt-1 pb-1 mb-1">
                <div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
                <button @click="mobileMenuOpen = false" class="absolute right-0 -top-1 w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>

            <!-- MENU LINKS (FIT PERFECTLY WITHOUT SCROLL) -->
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="flex items-center justify-between py-2 px-1 font-bold text-[#0e7c47] border-b border-gray-100 text-sm">
                <span>{{ __('Beranda') }}</span>
                <i class="fa-solid fa-chevron-right text-xs text-emerald-600"></i>
            </a>

            <a href="{{ url('/profil') }}" @click="mobileMenuOpen = false" class="flex items-center justify-between py-2 px-1 font-semibold text-gray-700 hover:text-[#0e7c47] border-b border-gray-100 text-sm">
                <span>{{ __('Profil') }}</span>
                <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
            </a>
            
            <!-- MOBILE LAYANAN ACCORDION -->
            <div x-data="{ mobileLayananOpen: false }" class="border-b border-gray-100">
                <button @click="mobileLayananOpen = !mobileLayananOpen" class="w-full flex items-center justify-between py-2 px-1 text-gray-700 font-semibold focus:outline-none text-sm">
                    <span>{{ __('Layanan') }}</span>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform" :class="mobileLayananOpen ? 'rotate-180 text-[#0e7c47]' : 'text-gray-400'"></i>
                </button>
                <div x-show="mobileLayananOpen" class="pl-4 py-2 space-y-1 bg-white text-gray-700 rounded-xl my-1.5 text-xs font-medium border border-gray-100 shadow-sm max-h-80 overflow-y-auto divide-y divide-gray-100">
                    
                    <div x-data="{ mobileUnggulanOpen: false }" class="py-1 border-b border-gray-100">
                        <button @click="mobileUnggulanOpen = !mobileUnggulanOpen" class="w-full flex items-center justify-between py-2 px-2 text-gray-700 font-semibold hover:text-[#0e7c47]">
                            <span>Layanan Unggulan</span>
                            <i class="fa-solid fa-chevron-down text-[10px] text-[#0e7c47] transition-transform" :class="mobileUnggulanOpen ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="mobileUnggulanOpen" class="pl-4 py-1 space-y-1 bg-gray-50 rounded-lg my-1 text-xs">
                            @foreach($navFeaturedServices as $navFeat)
                            @php
                                $featSlug = $navFeat->slug ?: \Illuminate\Support\Str::slug($navFeat->tr('name'));
                            @endphp
                            <a href="{{ url('/layanan/' . $featSlug) }}" @click="mobileMenuOpen = false" class="block py-2 px-2 hover:text-[#0e7c47] {{ request()->is('layanan/' . $featSlug . '*') ? 'text-[#0e7c47] font-bold' : '' }}">
                                {{ $navFeat->tr('name') }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ url('/layanan/rawat-inap') }}" @click="mobileMenuOpen = false" class="block py-2.5 px-2 hover:text-[#0e7c47]">Rawat Inap</a>
                    <a href="{{ url('/layanan/rawat-jalan') }}" @click="mobileMenuOpen = false" class="block py-2.5 px-2 hover:text-[#0e7c47]">Klinik Rawat Jalan</a>
                    <a href="{{ url('/layanan/igd') }}" @click="mobileMenuOpen = false" class="block py-2.5 px-2 hover:text-[#0e7c47]">IGD 24 Jam</a>
                    <a href="{{ url('/layanan/rehabilitasi-medik') }}" @click="mobileMenuOpen = false" class="block py-2.5 px-2 hover:text-[#0e7c47]">Instalasi Rehabilitasi Medik</a>
                    <a href="{{ url('/layanan/farmasi-24-jam') }}" @click="mobileMenuOpen = false" class="block py-2.5 px-2 hover:text-[#0e7c47]">Farmasi 24 Jam</a>
                    
                    <div x-data="{ mobilePenunjangOpen: false }" class="py-1">
                        <button @click="mobilePenunjangOpen = !mobilePenunjangOpen" class="w-full flex items-center justify-between py-2 px-2 text-gray-700 font-semibold hover:text-[#0e7c47]">
                            <span>Penunjang Medis</span>
                            <i class="fa-solid fa-chevron-down text-[10px] text-[#0e7c47] transition-transform" :class="mobilePenunjangOpen ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="mobilePenunjangOpen" class="pl-4 py-1 space-y-1 bg-gray-50 rounded-lg my-1 text-xs">
                            <a href="{{ url('/layanan/radiologi-24-jam') }}" @click="mobileMenuOpen = false" class="block py-2 px-2 hover:text-[#0e7c47]">Radiologi 24 Jam</a>
                            <a href="{{ url('/layanan/laboratorium-klinik') }}" @click="mobileMenuOpen = false" class="block py-2 px-2 hover:text-[#0e7c47]">Laboratorium Klinik 24 Jam</a>
                            <a href="{{ url('/layanan/laboratorium-patologi') }}" @click="mobileMenuOpen = false" class="block py-2 px-2 hover:text-[#0e7c47]">Laboratorium Patologi Anatomi</a>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ url('/jadwal-dokter') }}" @click="mobileMenuOpen = false" class="flex items-center justify-between py-2 px-1 font-semibold text-gray-700 hover:text-[#0e7c47] border-b border-gray-100 text-sm">
                <span>{{ __('Jadwal Dokter') }}</span>
                <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
            </a>
            
            <!-- MOBILE INFORMASI ACCORDION -->
            <div x-data="{ mobileInformasiOpen: false }" class="border-b border-gray-100">
                <button @click="mobileInformasiOpen = !mobileInformasiOpen" class="w-full flex items-center justify-between py-2 px-1 text-gray-700 font-semibold focus:outline-none text-sm">
                    <span>{{ __('Informasi') }}</span>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform" :class="mobileInformasiOpen ? 'rotate-180 text-[#0e7c47]' : 'text-gray-400'"></i>
                </button>
                <div x-show="mobileInformasiOpen" class="pl-4 py-2 space-y-1 bg-white text-gray-700 rounded-xl my-1.5 text-xs font-medium border border-gray-100 shadow-sm divide-y divide-gray-100">
                    <a href="{{ url('/informasi/artikel-kesehatan') }}" @click="mobileMenuOpen = false" class="block py-2.5 px-2 hover:text-[#0e7c47]">{{ __('Artikel Kesehatan') }}</a>
                    <a href="{{ url('/informasi/event') }}" @click="mobileMenuOpen = false" class="block py-2.5 px-2 hover:text-[#0e7c47]">{{ __('Event') }}</a>
                    <a href="{{ url('/informasi/penawaran-khusus') }}" @click="mobileMenuOpen = false" class="block py-2.5 px-2 hover:text-[#0e7c47]">{{ __('Penawaran Khusus') }}</a>
                    <a href="{{ url('/informasi/aduan-layanan') }}" @click="mobileMenuOpen = false" class="block py-2.5 px-2 hover:text-[#0e7c47]">{{ __('Aduan Layanan') }}</a>
                    <a href="{{ url('/informasi/ikm') }}" @click="mobileMenuOpen = false" class="block py-2.5 px-2 hover:text-[#0e7c47]">{{ __('Indeks Kepuasan Masyarakat') }}</a>
                </div>
            </div>

            <a href="{{ url('/karir') }}" @click="mobileMenuOpen = false" class="flex items-center justify-between py-2 px-1 font-semibold text-gray-700 hover:text-[#0e7c47] text-sm">
                <span>{{ __('Karir') }}</span>
                <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
            </a>

        </div>
    </div>

    <!-- ULTRA-PREMIUM MOBILE BOTTOM NAVIGATION BAR -->
    <div class="fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-t border-emerald-900/10 lg:hidden shadow-[0_-4px_25px_rgba(14,124,71,0.12)]">
        <div class="grid grid-cols-5 h-16 max-w-md mx-auto items-center px-1">
            
            <!-- TAB 1: MENU -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="flex flex-col items-center justify-center gap-1 transition-all focus:outline-none py-1 group">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-all group-active:scale-95 text-slate-500 group-hover:text-[#0e7c47] group-hover:bg-emerald-50">
                    <i class="fa-solid fa-bars-staggered text-base"></i>
                </div>
                <span class="text-[10px] font-semibold text-slate-500 group-hover:text-[#0e7c47]">Menu</span>
            </button>

            <!-- TAB 2: BERANDA -->
            <a href="{{ route('home') }}" 
               class="flex flex-col items-center justify-center gap-1 transition-all py-1 group">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-all {{ request()->is('/') ? 'bg-emerald-50 text-[#0e7c47] shadow-sm' : 'text-slate-500 group-hover:text-[#0e7c47]' }}">
                    <i class="fa-solid fa-house text-base"></i>
                </div>
                <span class="text-[10px] {{ request()->is('/') ? 'font-bold text-[#0e7c47]' : 'font-medium text-slate-500' }}">Beranda</span>
            </a>

            <!-- TAB 3: CENTER FLOATING ACTION (BUAT JANJI) -->
            <a href="{{ url('/buat-janji') }}" 
               class="flex flex-col items-center justify-center -mt-5 transition-all group">
                <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-red-600 via-red-600 to-red-500 text-white flex items-center justify-center shadow-lg shadow-red-600/35 border-4 border-white group-active:scale-95 group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-heart-pulse text-base animate-pulse"></i>
                </div>
                <span class="text-[10px] font-bold text-red-600 mt-0.5">Buat Janji</span>
            </a>

            <!-- TAB 4: JADWAL DOKTER -->
            <a href="{{ url('/jadwal-dokter') }}" 
               class="flex flex-col items-center justify-center gap-1 transition-all py-1 group">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-all {{ request()->is('jadwal-dokter') ? 'bg-emerald-50 text-[#0e7c47] shadow-sm' : 'text-slate-500 group-hover:text-[#0e7c47]' }}">
                    <i class="fa-solid fa-user-doctor text-base"></i>
                </div>
                <span class="text-[10px] {{ request()->is('jadwal-dokter') ? 'font-bold text-[#0e7c47]' : 'font-medium text-slate-500' }}">Jadwal</span>
            </a>

            <!-- TAB 5: PROFIL -->
            <a href="{{ url('/profil') }}" 
               class="flex flex-col items-center justify-center gap-1 transition-all py-1 group">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-all {{ request()->is('profil') ? 'bg-emerald-50 text-[#0e7c47] shadow-sm' : 'text-slate-500 group-hover:text-[#0e7c47]' }}">
                    <i class="fa-solid fa-hospital text-base"></i>
                </div>
                <span class="text-[10px] {{ request()->is('profil') ? 'font-bold text-[#0e7c47]' : 'font-medium text-slate-500' }}">Profil</span>
            </a>

        </div>
    </div>

    <!-- CONTENT -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-200 mt-auto text-slate-700">
        
        <!-- GREEN TOP CONTACT & INFO BAR -->
        <div class="bg-[#0e7c47] text-white py-7 px-4 sm:px-6 lg:px-8 border-b border-[#096237]">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6 md:gap-4">
                
                <!-- CONTACT 1: PHONE -->
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="w-13 h-13 rounded-full border-2 border-white/80 flex items-center justify-center shrink-0 bg-white/10 text-white shadow-sm">
                        <i class="fa-solid fa-phone-volume text-xl"></i>
                    </div>
                    <div>
                        <a href="tel:02678454123" class="text-base sm:text-lg font-bold tracking-wide hover:text-yellow-300 transition-colors block text-white leading-tight">
                            (0267) 8454123
                        </a>
                        <span class="text-xs text-emerald-100 font-normal">
                            {{ app()->getLocale() == 'en' ? 'Have a question? call us now' : 'Ada pertanyaan? Hubungi kami sekarang' }}
                        </span>
                    </div>
                </div>

                <!-- CONTACT 2: EMAIL -->
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="w-13 h-13 rounded-full border-2 border-white/80 flex items-center justify-center shrink-0 bg-white/10 text-white shadow-sm">
                        <i class="fa-regular fa-envelope text-xl"></i>
                    </div>
                    <div>
                        <a href="mailto:info@rsufikrimedika.com" class="text-base sm:text-lg font-bold tracking-wide hover:text-yellow-300 transition-colors block text-white leading-tight">
                            info@rsufikrimedika.com
                        </a>
                        <span class="text-xs text-emerald-100 font-normal">
                            {{ app()->getLocale() == 'en' ? 'Need support? Drop us an email' : 'Butuh bantuan? Kirimkan pesan email' }}
                        </span>
                    </div>
                </div>

                <!-- CONTACT 3: OPERATING HOURS -->
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="w-13 h-13 rounded-full border-2 border-white/80 flex items-center justify-center shrink-0 bg-white/10 text-white shadow-sm">
                        <i class="fa-regular fa-clock text-xl"></i>
                    </div>
                    <div>
                        <div class="text-base sm:text-lg font-bold tracking-wide text-white leading-tight">
                            {{ app()->getLocale() == 'en' ? 'Mon – Sun 24 Hours' : 'Senin – Minggu 24 Jam' }}
                        </div>
                        <span class="text-xs text-emerald-100 font-normal">
                            {{ app()->getLocale() == 'en' ? 'We are open 24/7 nonstop' : 'Pelayanan IGD siaga setiap saat' }}
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <!-- MAIN WHITE FOOTER CONTENT -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12">
                
                <!-- LEFT HOSPITAL PROFILE (4 COLS) -->
                <div class="lg:col-span-4 space-y-4">
                    <a href="{{ route('home') }}" class="inline-block">
                        <img src="{{ asset('logodasboard.png') }}" 
                             alt="RSU Fikri Medika Logo" 
                             class="h-12 sm:h-14 w-auto object-contain">
                    </a>
                    
                    <div class="border-b-2 border-[#0e7c47] pb-1.5 w-fit pr-4">
                        <h3 class="text-sm font-extrabold text-[#0e7c47] uppercase tracking-wider">
                            RUMAH SAKIT UMUM FIKRI MEDIKA
                        </h3>
                    </div>

                    <p class="text-xs sm:text-sm text-slate-500 uppercase tracking-wide leading-relaxed font-medium">
                        Jl. Raya Kosambi - Telagasari No. 9, Klari, Kabupaten Karawang, Jawa Barat 41371
                    </p>

                    <div class="space-y-1 text-xs sm:text-sm text-slate-600 font-normal pt-1">
                        <p>
                            General information: <a href="tel:02678454123" class="font-bold text-[#0e7c47] hover:underline">(0267) 8454123</a>
                        </p>
                        <p>
                            New Patients & BPJS: <a href="https://wa.me/6281234567890" target="_blank" class="font-bold text-[#0e7c47] hover:underline">0812-3456-7890</a>
                        </p>
                    </div>

                    <!-- SOCIAL ICONS -->
                    <div class="flex items-center gap-2 pt-2">
                        <a href="https://www.instagram.com/rsu.fikrimedika/" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-[#0e7c47] text-slate-600 hover:text-white flex items-center justify-center transition-colors" title="Instagram">
                            <i class="fa-brands fa-instagram text-xs"></i>
                        </a>
                        <a href="https://www.tiktok.com/@rsu.fikrimedika" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-900 text-slate-600 hover:text-white flex items-center justify-center transition-colors" title="TikTok">
                            <i class="fa-brands fa-tiktok text-xs"></i>
                        </a>
                        <a href="https://www.youtube.com/@rsufikrimedika" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-red-600 text-slate-600 hover:text-white flex items-center justify-center transition-colors" title="YouTube">
                            <i class="fa-brands fa-youtube text-xs"></i>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-emerald-600 text-slate-600 hover:text-white flex items-center justify-center transition-colors" title="WhatsApp">
                            <i class="fa-brands fa-whatsapp text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- RIGHT NAVIGATION COLUMNS (8 COLS) -->
                <div class="lg:col-span-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                    
                    <!-- COLUMN 1: CENTERS / LAYANAN -->
                    <div>
                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4 border-b border-slate-200 pb-2">
                            {{ __('Layanan') }}
                        </h4>
                        <ul class="space-y-2.5 text-xs sm:text-[13px] text-slate-500">
                            <li><a href="{{ url('/layanan/trauma-center') }}" class="hover:text-[#0e7c47] transition-colors block">Trauma Center</a></li>
                            <li><a href="{{ url('/layanan/spesialis-mata') }}" class="hover:text-[#0e7c47] transition-colors block">Spesialis Mata</a></li>
                            <li><a href="{{ url('/layanan/kemilau-cinta-layanan-ibu-anak') }}" class="hover:text-[#0e7c47] transition-colors block">Kemilau Cinta (Ibu & Anak)</a></li>
                            <li><a href="{{ url('/layanan/layanan-antar-jemput') }}" class="hover:text-[#0e7c47] transition-colors block">Antar Jemput</a></li>
                            <li><a href="{{ url('/layanan/rawat-inap') }}" class="hover:text-[#0e7c47] transition-colors block">Rawat Inap</a></li>
                            <li><a href="{{ url('/layanan/rawat-jalan') }}" class="hover:text-[#0e7c47] transition-colors block">Rawat Jalan</a></li>
                            <li><a href="{{ url('/layanan/igd') }}" class="hover:text-[#0e7c47] transition-colors block">IGD 24 Jam</a></li>
                            <li><a href="{{ url('/layanan/farmasi-24-jam') }}" class="hover:text-[#0e7c47] transition-colors block">Farmasi 24 Jam</a></li>
                        </ul>
                    </div>

                    <!-- COLUMN 2: CLINICAL DEPARTMENTS SUBCOL 1 -->
                    <div>
                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4 border-b border-slate-200 pb-2">
                            {{ __('Penunjang') }}
                        </h4>
                        <ul class="space-y-2.5 text-xs sm:text-[13px] text-slate-500">
                            <li><a href="{{ url('/layanan/radiologi-24-jam') }}" class="hover:text-[#0e7c47] transition-colors block">Radiologi 24 Jam</a></li>
                            <li><a href="{{ url('/layanan/laboratorium-klinik') }}" class="hover:text-[#0e7c47] transition-colors block">Laboratorium Klinik</a></li>
                            <li><a href="{{ url('/layanan/laboratorium-patologi') }}" class="hover:text-[#0e7c47] transition-colors block">Patologi Anatomi</a></li>
                            <li><a href="{{ url('/layanan/rehabilitasi-medik') }}" class="hover:text-[#0e7c47] transition-colors block">Rehabilitasi Medik</a></li>
                            <li><a href="{{ url('/layanan/penunjang-medis') }}" class="hover:text-[#0e7c47] transition-colors block">Penunjang Medis</a></li>
                        </ul>
                    </div>

                    <!-- COLUMN 3: CLINICAL DEPARTMENTS SUBCOL 2 / SPESIALIS -->
                    <div>
                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4 border-b border-slate-200 pb-2">
                            {{ __('Poliklinik') }}
                        </h4>
                        <ul class="space-y-2.5 text-xs sm:text-[13px] text-slate-500">
                            <li><a href="{{ url('/jadwal-dokter') }}" class="hover:text-[#0e7c47] transition-colors block">Penyakit Dalam</a></li>
                            <li><a href="{{ url('/jadwal-dokter') }}" class="hover:text-[#0e7c47] transition-colors block">Kebidanan & Kandungan</a></li>
                            <li><a href="{{ url('/jadwal-dokter') }}" class="hover:text-[#0e7c47] transition-colors block">Kesehatan Anak</a></li>
                            <li><a href="{{ url('/jadwal-dokter') }}" class="hover:text-[#0e7c47] transition-colors block">Bedah Umum</a></li>
                            <li><a href="{{ url('/jadwal-dokter') }}" class="hover:text-[#0e7c47] transition-colors block">Poli Gigi & Mulut</a></li>
                        </ul>
                    </div>

                    <!-- COLUMN 4: DEPARTMENTS / INFORMASI -->
                    <div>
                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4 border-b border-slate-200 pb-2">
                            {{ __('Informasi') }}
                        </h4>
                        <ul class="space-y-2.5 text-xs sm:text-[13px] text-slate-500">
                            <li><a href="{{ url('/jadwal-dokter') }}" class="hover:text-[#0e7c47] transition-colors block">{{ __('Jadwal Dokter') }}</a></li>
                            <li><a href="{{ url('/buat-janji') }}" class="hover:text-[#0e7c47] transition-colors block">{{ __('Buat Janji') }}</a></li>
                            <li><a href="{{ url('/informasi/artikel-kesehatan') }}" class="hover:text-[#0e7c47] transition-colors block">{{ __('Artikel') }}</a></li>
                            <li><a href="{{ url('/informasi/event') }}" class="hover:text-[#0e7c47] transition-colors block">{{ __('Event') }}</a></li>
                            <li><a href="{{ url('/informasi/penawaran-khusus') }}" class="hover:text-[#0e7c47] transition-colors block">{{ __('Penawaran') }}</a></li>
                            <li><a href="{{ url('/informasi/aduan-layanan') }}" class="hover:text-[#0e7c47] transition-colors block">{{ __('Aduan') }}</a></li>
                            <li><a href="{{ url('/informasi/ikm') }}" class="hover:text-[#0e7c47] transition-colors block">{{ __('IKM') }}</a></li>
                            <li><a href="{{ url('/karir') }}" class="hover:text-[#0e7c47] transition-colors block">{{ __('Karir') }}</a></li>
                            <li><a href="{{ route('admin.login') }}" class="hover:text-[#0e7c47] transition-colors block text-slate-400">{{ __('Admin') }}</a></li>
                        </ul>
                    </div>

                </div>

            </div>
        </div>

        <!-- COPYRIGHT & SCROLL TO TOP -->
        <div class="border-t border-slate-100 bg-white py-5 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto flex justify-between items-center text-xs text-slate-500">
                <div>
                    &copy; {{ date('Y') }} <strong>RSU Fikri Medika</strong>. {{ __('Hak Cipta Dilindungi.') }}
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" 
                            onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                            class="w-8 h-8 rounded bg-[#0e7c47] hover:bg-[#096237] text-white flex items-center justify-center transition-colors shadow-xs cursor-pointer" 
                            title="Kembali ke atas">
                        <i class="fa-solid fa-chevron-up text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
    </footer>
    <!-- KAKA FIKRI AI CHAT WIDGET -->
    <div x-data="fikriChatWidget()" class="relative z-50">
        
        <!-- FLOATING TRIGGER BUTTON -->
        <button @click="toggleChat()" 
                aria-label="Tanya Kaka Fikri"
                class="fixed bottom-20 lg:bottom-6 right-4 sm:right-6 z-50 bg-[#065c36] hover:bg-[#097a47] text-white p-1 sm:p-2 sm:pr-5 rounded-full shadow-2xl border-2 border-white/40 flex items-center justify-center sm:justify-start sm:gap-3 transition-all transform hover:scale-105 active:scale-95 cursor-pointer group">
            <div class="relative shrink-0">
                <img src="{{ asset('avatar-fikri.png') }}" 
                     alt="Kaka Fikri" 
                     class="w-11 h-11 sm:w-11 sm:h-11 rounded-full object-cover border-2 border-yellow-300 shadow-md group-hover:rotate-6 transition-transform bg-white">
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-400 border-2 border-white rounded-full animate-ping"></span>
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-400 border-2 border-white rounded-full"></span>
            </div>
            <div class="hidden sm:block text-left leading-tight">
                <div class="text-xs sm:text-sm font-black text-white flex items-center gap-1.5" style="color: #ffffff !important;">
                    <span>Tanya Kaka Fikri Yuk</span>
                    <i class="fa-solid fa-sparkles text-yellow-300 text-xs animate-bounce"></i>
                </div>
            </div>
        </button>

        <!-- CHAT MODAL DRAWER -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 scale-95"
             class="fixed bottom-24 lg:bottom-20 right-3 sm:right-6 w-[94vw] sm:w-[390px] h-[530px] max-h-[82vh] bg-white rounded-3xl shadow-2xl border border-emerald-100 flex flex-col z-50 overflow-hidden"
             style="display: none;">
            
            <!-- HEADER -->
            <div class="bg-gradient-to-r from-[#0e7c47] to-[#096237] text-white p-3.5 px-4 flex items-center justify-between shadow-md">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <img src="{{ asset('avatar-fikri.png') }}" alt="Kaka Fikri" class="w-10 h-10 rounded-full border-2 border-yellow-300 shadow-sm object-cover bg-white">
                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-400 border border-white rounded-full"></span>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-sm text-white flex items-center gap-1.5" style="color: #ffffff !important;">
                            <span>Kaka Fikri</span>
                            <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-yellow-400 text-slate-950 uppercase" style="color: #020617 !important;">Online AI</span>
                        </h3>
                        <p class="text-[11px] text-emerald-100 font-medium" style="color: #d1fae5 !important;">Asisten Virtual RSU Fikri Medika</p>
                    </div>
                </div>
                <div class="flex items-center gap-1.5">
                    <button type="button" @click="resetChat()" title="Reset Percakapan" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer text-xs">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>
                    <button type="button" @click="open = false" title="Tutup Chat" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer text-sm">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <!-- MESSAGES CONTAINER -->
            <div class="flex-grow p-4 overflow-y-auto space-y-4 bg-[#f8faf9]" id="fikriChatMessages">
                
                <template x-for="(msg, index) in messages" :key="index">
                    <div>
                        <!-- AI MESSAGE -->
                        <template x-if="msg.sender === 'ai'">
                            <div class="flex items-start gap-2.5 max-w-[96%]">
                                <img src="{{ asset('avatar-fikri.png') }}" class="w-8 h-8 rounded-full border border-emerald-200 shrink-0 mt-0.5 object-cover bg-white">
                                <div class="w-full">
                                    <div class="bg-[#e8f4f8] p-3 rounded-2xl rounded-tl-xs text-[12px] sm:text-[12.5px] leading-relaxed border border-sky-200 shadow-xs font-semibold text-slate-900" style="color: #0f172a !important;" x-html="msg.text">
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- USER MESSAGE -->
                        <template x-if="msg.sender === 'user'">
                            <div class="flex justify-end">
                                <div class="bg-[#0e7c47] p-3 rounded-2xl rounded-tr-xs text-[12px] sm:text-[12.5px] leading-relaxed shadow-sm max-w-[85%] font-semibold text-white" style="color: #ffffff !important;" x-text="msg.text">
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- TYPING INDICATOR -->
                <div x-show="isTyping" class="flex items-start gap-2.5">
                    <img src="{{ asset('avatar-fikri.png') }}" class="w-8 h-8 rounded-full border border-emerald-200 shrink-0 object-cover bg-white">
                    <div class="bg-[#e8f4f8] p-3 rounded-2xl rounded-tl-xs flex items-center gap-1.5 border border-sky-100">
                        <span class="w-2 h-2 bg-emerald-600 rounded-full animate-bounce"></span>
                        <span class="w-2 h-2 bg-emerald-600 rounded-full animate-bounce [animation-delay:0.2s]"></span>
                        <span class="w-2 h-2 bg-emerald-600 rounded-full animate-bounce [animation-delay:0.4s]"></span>
                    </div>
                </div>

            </div>



            <!-- INPUT BOX & DISCLAIMER -->
            <div class="p-3 bg-white border-t border-gray-100 space-y-2">
                <form @submit.prevent="sendMessage()" class="flex items-center gap-2">
                    <input type="text" x-model="userInput" placeholder="Ketik pertanyaan Anda..." 
                           class="flex-grow px-3.5 py-2.5 rounded-xl border border-gray-300 text-slate-900 placeholder-slate-400 text-xs sm:text-sm focus:outline-none focus:border-[#0e7c47] focus:ring-1 focus:ring-[#0e7c47] bg-white font-medium" style="color: #0f172a !important;">
                    <button type="submit" class="w-10 h-10 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white flex items-center justify-center shrink-0 transition-colors shadow-md disabled:opacity-50 cursor-pointer" :disabled="!userInput.trim() || isTyping">
                        <i class="fa-solid fa-paper-plane text-xs text-white"></i>
                    </button>
                </form>
                <div class="text-[9px] text-gray-500 text-center leading-tight font-medium" style="color: #64748b !important;">
                    Disclaimer: Asisten virtual cerdas RSU Fikri Medika memberikan informasi operasional umum dan bukan pengganti diagnosis medis.
                </div>
            </div>

        </div>
    </div>

    <!-- SCRIPT FOR FIKRI CHAT AI ENGINE (INTELLIGENT RULE-BASED & LIVE DATABASE) -->
    <script>
    function fikriChatWidget() {
        return {
            open: false,
            userInput: '',
            isTyping: false,
            messages: [
                {
                    sender: 'ai',
                    text: 'Halo 👋 Saya <strong>Kakak Fikri</strong>, asisten virtual resmi RSU Fikri Medika Karawang.<br><br>Ada yang bisa saya bantu terkait jadwal dokter, pendaftaran rawat jalan, kamar rawat inap, BPJS, atau fasilitas rumah sakit hari ini? 😊'
                }
            ],

            toggleChat() {
                this.open = !this.open;
                if (this.open) {
                    this.scrollToBottom();
                }
            },
            sendQuickQuery(queryText) {
                this.userInput = queryText;
                this.sendMessage();
            },
            async sendMessage() {
                const query = this.userInput.trim();
                if (!query || this.isTyping) return;

                // Push User Message
                this.messages.push({ sender: 'user', text: query });
                this.userInput = '';
                this.isTyping = true;
                this.scrollToBottom();

                try {
                    const response = await fetch('{{ route("ai.chat") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            message: query
                        })
                    });

                    const data = await response.json();

                    if (data.success && data.reply) {
                        this.messages.push({
                            sender: 'ai',
                            text: data.reply
                        });
                    } else {
                        this.messages.push({
                            sender: 'ai',
                            text: data.message || 'Maaf, Kakak Fikri sedang mengalami kendala jaringan. Silakan coba sesaat lagi. 🙏'
                        });
                    }
                } catch (err) {
                    console.error('Tanya Fikri Chat Error:', err);
                    this.messages.push({
                        sender: 'ai',
                        text: 'Maaf, sambungan terputus. Silakan periksa koneksi internet Anda atau hubungi Customer Service kami. 🙏'
                    });
                } finally {
                    this.isTyping = false;
                    this.scrollToBottom();
                }
            },
            async resetChat() {
                try {
                    await fetch('{{ route("ai.reset") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    });
                } catch (e) {
                    // Ignore
                }

                this.messages = [
                    {
                        sender: 'ai',
                        text: 'Sesi percakapan telah direset 👋 Ada topik atau informasi lain yang ingin Anda cari bersama <strong>Kakak Fikri</strong>?'
                    }
                ];
                this.scrollToBottom();
            },
            scrollToBottom() {
                this.$nextTick(() => {
                    const el = document.getElementById('fikriChatMessages');
                    if (el) {
                        el.scrollTop = el.scrollHeight;
                    }
                });
            }
        };
    }
    </script>
</body>
</html>
