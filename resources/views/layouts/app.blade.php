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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased flex flex-col min-h-screen bg-[#f7faf8] pb-14 lg:pb-0" x-data="{ mobileMenuOpen: false, searchOpen: false, scrolled: false }">

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
                             class="absolute top-full left-0 w-60 bg-[#0e7c47] rounded-xl shadow-2xl py-2 z-50 text-white text-xs font-semibold border border-[#096237]"
                             style="display: none;">
                            <a href="{{ url('/layanan/igd') }}" class="block px-4 py-2 hover:bg-[#096237] hover:text-yellow-300 transition-colors {{ request()->is('layanan/igd') ? 'text-yellow-300 font-bold bg-[#096237]' : '' }}">{{ __('IGD') }}</a>
                            <a href="{{ url('/layanan/rawat-jalan') }}" class="block px-4 py-2 hover:bg-[#096237] hover:text-yellow-300 transition-colors {{ request()->is('layanan/rawat-jalan') ? 'text-yellow-300 font-bold bg-[#096237]' : '' }}">{{ __('Instalasi Rawat Jalan') }}</a>
                            <a href="{{ url('/layanan/rawat-inap') }}" class="block px-4 py-2 hover:bg-[#096237] hover:text-yellow-300 transition-colors {{ request()->is('layanan/rawat-inap') ? 'text-yellow-300 font-bold bg-[#096237]' : '' }}">{{ __('Instalasi Rawat Inap') }}</a>
                            <a href="{{ url('/layanan/penunjang-medik') }}" class="block px-4 py-2 hover:bg-[#096237] hover:text-yellow-300 transition-colors {{ request()->is('layanan/penunjang-medik') ? 'text-yellow-300 font-bold bg-[#096237]' : '' }}">{{ __('Penunjang Medik') }}</a>
                            <a href="{{ url('/layanan/unggulan') }}" class="block px-4 py-2 hover:bg-[#096237] hover:text-yellow-300 transition-colors {{ request()->is('layanan/unggulan') ? 'text-yellow-300 font-bold bg-[#096237]' : '' }}">{{ __('Layanan Unggulan') }}</a>
                        </div>
                    </div>

                    <a href="{{ url('/jadwal-dokter') }}" class="flex items-center h-full transition-colors {{ request()->is('jadwal-dokter') ? 'text-[#0e7c47] font-bold relative after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#0e7c47]' : 'hover:text-[#0e7c47]' }}">{{ __('Jadwal Dokter') }}</a>
                    
                    <!-- INFORMASI DROPDOWN -->
                    <div class="relative flex items-center h-full" x-data="{ dropdownOpen: false }" @mouseenter="dropdownOpen = true" @mouseleave="dropdownOpen = false">
                        <button class="transition-colors flex items-center gap-1.5 focus:outline-none h-full {{ request()->is('informasi*') ? 'text-[#0e7c47] font-bold relative after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#0e7c47]' : 'hover:text-[#0e7c47]' }}">
                            <span>{{ __('Informasi') }}</span>
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
                             class="absolute top-full left-0 w-60 bg-[#0e7c47] rounded-xl shadow-2xl py-2 z-50 text-white text-xs font-semibold border border-[#096237]"
                             style="display: none;">
                            <a href="{{ url('/informasi/artikel-kesehatan') }}" class="block px-4 py-2 hover:bg-[#096237] hover:text-yellow-300 transition-colors {{ request()->is('informasi/artikel-kesehatan') ? 'text-yellow-300 font-bold bg-[#096237]' : '' }}">{{ __('Artikel Kesehatan') }}</a>
                            <a href="{{ url('/informasi/event') }}" class="block px-4 py-2 hover:bg-[#096237] hover:text-yellow-300 transition-colors {{ request()->is('informasi/event') ? 'text-yellow-300 font-bold bg-[#096237]' : '' }}">{{ __('Event') }}</a>
                            <a href="{{ url('/informasi/penawaran-khusus') }}" class="block px-4 py-2 hover:bg-[#096237] hover:text-yellow-300 transition-colors {{ request()->is('informasi/penawaran-khusus') ? 'text-yellow-300 font-bold bg-[#096237]' : '' }}">{{ __('Penawaran Khusus') }}</a>
                            <a href="{{ url('/informasi/aduan-layanan') }}" class="block px-4 py-2 hover:bg-[#096237] hover:text-yellow-300 transition-colors {{ request()->is('informasi/aduan-layanan') ? 'text-yellow-300 font-bold bg-[#096237]' : '' }}">{{ __('Aduan Layanan') }}</a>
                            <a href="{{ url('/informasi/ikm') }}" class="block px-4 py-2 hover:bg-[#096237] hover:text-yellow-300 transition-colors {{ request()->is('informasi/ikm') ? 'text-yellow-300 font-bold bg-[#096237]' : '' }}">{{ __('Indeks Kepuasan Masyarakat') }}</a>
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
                <div x-show="mobileLayananOpen" class="pl-4 py-1.5 space-y-1 bg-[#0e7c47] text-white rounded-xl my-1.5 text-xs font-semibold">
                    <a href="{{ url('/layanan/igd') }}" @click="mobileMenuOpen = false" class="block py-1.5 px-2 hover:text-yellow-300">{{ __('IGD') }}</a>
                    <a href="{{ url('/layanan/rawat-jalan') }}" @click="mobileMenuOpen = false" class="block py-1.5 px-2 hover:text-yellow-300">{{ __('Instalasi Rawat Jalan') }}</a>
                    <a href="{{ url('/layanan/rawat-inap') }}" @click="mobileMenuOpen = false" class="block py-1.5 px-2 hover:text-yellow-300">{{ __('Instalasi Rawat Inap') }}</a>
                    <a href="{{ url('/layanan/penunjang-medik') }}" @click="mobileMenuOpen = false" class="block py-1.5 px-2 hover:text-yellow-300">{{ __('Penunjang Medik') }}</a>
                    <a href="{{ url('/layanan/unggulan') }}" @click="mobileMenuOpen = false" class="block py-1.5 px-2 hover:text-yellow-300">{{ __('Layanan Unggulan') }}</a>
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
                <div x-show="mobileInformasiOpen" class="pl-4 py-1.5 space-y-1 bg-[#0e7c47] text-white rounded-xl my-1.5 text-xs font-semibold">
                    <a href="{{ url('/informasi/artikel-kesehatan') }}" @click="mobileMenuOpen = false" class="block py-1.5 px-2 hover:text-yellow-300">{{ __('Artikel Kesehatan') }}</a>
                    <a href="{{ url('/informasi/event') }}" @click="mobileMenuOpen = false" class="block py-1.5 px-2 hover:text-yellow-300">{{ __('Event') }}</a>
                    <a href="{{ url('/informasi/penawaran-khusus') }}" @click="mobileMenuOpen = false" class="block py-1.5 px-2 hover:text-yellow-300">{{ __('Penawaran Khusus') }}</a>
                    <a href="{{ url('/informasi/aduan-layanan') }}" @click="mobileMenuOpen = false" class="block py-1.5 px-2 hover:text-yellow-300">{{ __('Aduan Layanan') }}</a>
                    <a href="{{ url('/informasi/ikm') }}" @click="mobileMenuOpen = false" class="block py-1.5 px-2 hover:text-yellow-300">{{ __('Indeks Kepuasan Masyarakat') }}</a>
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
    <footer class="bg-[#0e7c47] text-white pt-16 pb-8 border-t-4 border-yellow-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-[#096237]">
                
                <!-- COL 1: BRAND PROFILE WITH LOGO -->
                <div class="space-y-4">
                    <div class="bg-white p-3 rounded-2xl inline-block shadow-md">
                        <img src="{{ asset('logodasboard.png') }}" 
                             alt="RSU Fikri Medika Logo" 
                             class="h-12 w-auto object-contain">
                    </div>
                    <p class="text-sm text-gray-200 leading-relaxed">
                        {{ app()->getLocale() == 'en' ? 'RSU Fikri Medika provides comprehensive, rapid, and professional healthcare services with Islamic warmth and hospitality.' : 'Rumah Sakit Umum Fikri Medika hadir memberikan pelayanan kesehatan komprehensif, cepat, dan profesional dengan mengedepankan keramahan dan nilai-nilai Islami.' }}
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="https://www.instagram.com/rsu.fikrimedika/" target="_blank" class="w-9 h-9 rounded-full bg-[#096237] hover:bg-yellow-400 hover:text-gray-900 flex items-center justify-center transition-colors">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                        <a href="https://www.tiktok.com/@rsu.fikrimedika" target="_blank" class="w-9 h-9 rounded-full bg-[#096237] hover:bg-slate-900 hover:text-cyan-300 flex items-center justify-center transition-colors">
                            <i class="fa-brands fa-tiktok text-sm"></i>
                        </a>
                        <a href="https://www.youtube.com/@rsufikrimedika" target="_blank" class="w-9 h-9 rounded-full bg-[#096237] hover:bg-red-600 hover:text-white flex items-center justify-center transition-colors">
                            <i class="fa-brands fa-youtube text-sm"></i>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank" class="w-9 h-9 rounded-full bg-[#096237] hover:bg-emerald-500 flex items-center justify-center transition-colors">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- COL 2: NAV LINKS -->
                <div>
                    <h3 class="text-base font-bold text-yellow-300 uppercase tracking-wider mb-4 border-b border-[#096237] pb-2 inline-block">
                        {{ __('Menu Utama') }}
                    </h3>
                    <ul class="space-y-2.5 text-sm text-gray-200">
                        <li><a href="{{ route('home') }}" class="hover:text-yellow-300 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-yellow-400"></i> {{ __('Beranda') }}</a></li>
                        <li><a href="#profil" class="hover:text-yellow-300 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-yellow-400"></i> {{ __('Profil') }}</a></li>
                        <li><a href="#layanan" class="hover:text-yellow-300 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-yellow-400"></i> {{ __('Layanan Unggulan') }}</a></li>
                        <li><a href="#jadwal-dokter" class="hover:text-yellow-300 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-yellow-400"></i> {{ __('Jadwal Dokter') }}</a></li>
                        <li><a href="#berita" class="hover:text-yellow-300 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-yellow-400"></i> {{ __('Berita & Artikel') }}</a></li>
                        <li><a href="{{ route('admin.login') }}" class="hover:text-yellow-300 transition-colors flex items-center gap-2"><i class="fa-solid fa-lock text-[10px] text-yellow-400"></i> {{ __('Portal Admin') }}</a></li>
                    </ul>
                </div>

                <!-- COL 3: SERVICES SHORTCUT -->
                <div>
                    <h3 class="text-base font-bold text-yellow-300 uppercase tracking-wider mb-4 border-b border-[#096237] pb-2 inline-block">
                        {{ __('Informasi Pasien') }}
                    </h3>
                    <ul class="space-y-2.5 text-sm text-gray-200">
                        <li><a href="#kontak" class="hover:text-yellow-300 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-yellow-400"></i> {{ __('Pendaftaran') }}</a></li>
                        <li><a href="#layanan" class="hover:text-yellow-300 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-yellow-400"></i> {{ __('Persyaratan Rawat Inap') }}</a></li>
                        <li><a href="#layanan" class="hover:text-yellow-300 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-yellow-400"></i> {{ __('Informasi BPJS') }}</a></li>
                        <li><a href="#layanan" class="hover:text-yellow-300 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-yellow-400"></i> {{ __('Tarif & Layanan') }}</a></li>
                        <li><a href="#kontak" class="hover:text-yellow-300 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-yellow-400"></i> {{ __('Panggilan Darurat') }}</a></li>
                    </ul>
                </div>

                <!-- COL 4: CONTACT & EMERGENCY -->
                <div class="space-y-4">
                    <h3 class="text-base font-bold text-yellow-300 uppercase tracking-wider mb-4 border-b border-[#096237] pb-2 inline-block">
                        {{ __('Kontak & Lokasi') }}
                    </h3>
                    <div class="space-y-3 text-sm text-gray-200">
                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot text-yellow-400 mt-1"></i>
                            <span>Jl. Raya Kosambi - Telagasari No. 9, Klari, Kabupaten Karawang, Jawa Barat 41371</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-yellow-400"></i>
                            <span>(0267) 8454123</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-brands fa-whatsapp text-emerald-300"></i>
                            <span>0812-3456-7890</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-yellow-400"></i>
                            <span>info@rsufikrimedika.com</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- COPYRIGHT -->
            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-gray-300 gap-4">
                <div>
                    &copy; {{ date('Y') }} <strong>RSU Fikri Medika</strong>. {{ __('Hak Cipta Dilindungi') }}
                </div>
                <div class="flex items-center gap-4">
                    <span>{{ __('Terpercaya • Islami • Modern') }}</span>
                </div>
            </div>
        </div>
    <!-- KAKA FIKRI AI CHAT WIDGET -->
    <div x-data="fikriChatWidget()" class="relative z-50">
        
        <!-- FLOATING TRIGGER BUTTON -->
        <button @click="toggleChat()" 
                class="fixed bottom-20 lg:bottom-6 right-4 sm:right-6 z-50 bg-[#065c36] hover:bg-[#097a47] text-white p-1.5 sm:p-2 pr-4 sm:pr-5 rounded-full shadow-2xl border-2 border-white/40 flex items-center gap-2.5 sm:gap-3 transition-all transform hover:scale-105 active:scale-95 cursor-pointer group">
            <div class="relative shrink-0">
                <img src="{{ asset('avatar-fikri.png') }}" 
                     alt="Kaka Fikri" 
                     class="w-10 h-10 sm:w-11 sm:h-11 rounded-full object-cover border-2 border-yellow-300 shadow-md group-hover:rotate-6 transition-transform bg-white">
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-400 border-2 border-white rounded-full animate-ping"></span>
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-400 border-2 border-white rounded-full"></span>
            </div>
            <div class="text-left leading-tight">
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
                        <p class="text-[11px] text-emerald-100 font-medium" style="color: #d1fae5 !important;">Asisten Medis RSU Fikri Medika</p>
                    </div>
                </div>
                <button @click="open = false" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- MESSAGES CONTAINER -->
            <div class="flex-grow p-4 overflow-y-auto space-y-4 bg-[#f8faf9]" id="fikriChatMessages">
                
                <template x-for="(msg, index) in messages" :key="index">
                    <div>
                        <!-- AI MESSAGE -->
                        <template x-if="msg.sender === 'ai'">
                            <div class="flex items-start gap-2.5 max-w-[92%]">
                                <img src="{{ asset('avatar-fikri.png') }}" class="w-8 h-8 rounded-full border border-emerald-200 shrink-0 mt-0.5 object-cover bg-white">
                                <div class="bg-[#e8f4f8] p-3.5 rounded-2xl rounded-tl-xs text-xs sm:text-sm leading-relaxed border border-sky-200 shadow-xs space-y-2 font-semibold text-slate-900" style="color: #0f172a !important;" x-html="msg.text">
                                </div>
                            </div>
                        </template>

                        <!-- USER MESSAGE -->
                        <template x-if="msg.sender === 'user'">
                            <div class="flex justify-end">
                                <div class="bg-[#0e7c47] p-3.5 rounded-2xl rounded-tr-xs text-xs sm:text-sm leading-relaxed shadow-sm max-w-[85%] font-semibold text-white" style="color: #ffffff !important;" x-text="msg.text">
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- TYPING INDICATOR -->
                <div x-show="isTyping" class="flex items-start gap-2.5">
                    <img src="{{ asset('avatar-fikri.png') }}" class="w-8 h-8 rounded-full border border-emerald-200 shrink-0 object-cover bg-white">
                    <div class="bg-[#e8f4f8] p-3 rounded-2xl rounded-tl-xs flex items-center gap-1.5 border border-sky-100">
                        <span class="w-2 h-2 bg-sky-600 rounded-full animate-bounce"></span>
                        <span class="w-2 h-2 bg-sky-600 rounded-full animate-bounce [animation-delay:0.2s]"></span>
                        <span class="w-2 h-2 bg-sky-600 rounded-full animate-bounce [animation-delay:0.4s]"></span>
                    </div>
                </div>

            </div>

            <!-- QUICK SUGGESTION PILLS -->
            <div class="px-3 py-2 bg-white border-t border-gray-100 flex items-center gap-1.5 overflow-x-auto text-[11px] font-semibold text-slate-700 no-scrollbar">
                <button @click="sendQuickQuery('kalau sakit perut gimana ?')" class="px-2.5 py-1 rounded-full bg-emerald-50 text-[#0e7c47] hover:bg-emerald-100 transition-colors whitespace-nowrap border border-emerald-200 shrink-0">
                    🤢 Sakit perut gimana?
                </button>
                <button @click="sendQuickQuery('Cek jadwal dokter hari ini')" class="px-2.5 py-1 rounded-full bg-emerald-50 text-[#0e7c47] hover:bg-emerald-100 transition-colors whitespace-nowrap border border-emerald-200 shrink-0">
                    📅 Jadwal Dokter
                </button>
                <button @click="sendQuickQuery('Nomor IGD 24 Jam')" class="px-2.5 py-1 rounded-full bg-red-50 text-red-600 hover:bg-red-100 transition-colors whitespace-nowrap border border-red-200 shrink-0">
                    🚨 Emergency IGD
                </button>
            </div>

            <!-- INPUT BOX & DISCLAIMER -->
            <div class="p-3 bg-white border-t border-gray-100 space-y-2">
                <form @submit.prevent="sendMessage()" class="flex items-center gap-2">
                    <input type="text" x-model="userInput" placeholder="Ketik pertanyaan Anda..." 
                           class="flex-grow px-3.5 py-2.5 rounded-xl border border-gray-300 text-slate-900 placeholder-slate-400 text-xs sm:text-sm focus:outline-none focus:border-[#0e7c47] focus:ring-1 focus:ring-[#0e7c47] bg-white font-medium" style="color: #0f172a !important;">
                    <button type="submit" class="w-10 h-10 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white flex items-center justify-center shrink-0 transition-colors shadow-md disabled:opacity-50" :disabled="!userInput.trim()">
                        <i class="fa-solid fa-paper-plane text-xs text-white"></i>
                    </button>
                </form>
                <div class="text-[9px] text-gray-500 text-center leading-tight font-medium" style="color: #64748b !important;">
                    Disclaimer : Informasi yang diberikan bersifat umum dan tidak menggantikan saran medis. Jawaban AI tidak dapat dijadikan acuan.
                </div>
            </div>

        </div>
    </div>

    <!-- SCRIPT FOR KAKA FIKRI AI CHAT LOGIC -->
    <script>
    function fikriChatWidget() {
        return {
            open: false,
            userInput: '',
            isTyping: false,
            messages: [
                {
                    sender: 'ai',
                    text: 'Halo, ada yang bisa Kaka Fikri bantu? Jika Anda memiliki pertanyaan terkait kesehatan atau medis, jangan ragu untuk bertanya. Kaka Fikri akan dengan senang hati membantu Anda.'
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
            sendMessage() {
                const query = this.userInput.trim();
                if (!query) return;

                // Push User Message
                this.messages.push({ sender: 'user', text: query });
                this.userInput = '';
                this.isTyping = true;
                this.scrollToBottom();

                // Simulate AI Processing & Response Generation
                setTimeout(() => {
                    const responseText = this.generateAiResponse(query);
                    this.messages.push({ sender: 'ai', text: responseText });
                    this.isTyping = false;
                    this.scrollToBottom();
                }, 1000);
            },
            scrollToBottom() {
                this.$nextTick(() => {
                    const el = document.getElementById('fikriChatMessages');
                    if (el) {
                        el.scrollTop = el.scrollHeight;
                    }
                });
            },
            generateAiResponse(text) {
                const lower = text.toLowerCase();

                if (lower.includes('sakit perut') || lower.includes('perut')) {
                    return `Halo, sakit perut bisa disebabkan oleh berbagai hal, mulai dari yang ringan hingga kondisi yang memerlukan perhatian medis. Agar mendapatkan diagnosis dan penanganan yang tepat, sangat disarankan untuk berkonsultasi dengan dokter.<br><br>Apakah Anda ingin saya carikan jadwal dokter spesialis penyakit dalam atau spesialis lainnya di RSU Fikri Medika Karawang? Atau mungkin Anda ingin mencari informasi tentang layanan kesehatan terkait pencernaan?`;
                }

                if (lower.includes('jadwal') || lower.includes('dokter') || lower.includes('spesialis')) {
                    return `Untuk melihat jadwal praktek harian dokter spesialis di RSU Fikri Medika Karawang, Anda dapat langsung mengunjungi halaman <a href="/jadwal-dokter" class="text-[#0e7c47] font-bold underline">Jadwal Dokter</a>.<br><br>Kami memiliki dokter spesialis Penyakit Dalam, Kebidanan & Kandungan, Anak, Bedah, serta Spesialis Mata dan Gigi.`;
                }

                if (lower.includes('igd') || lower.includes('darurat') || lower.includes('emergency') || lower.includes('ambulans')) {
                    return `🚨 <strong>Instalasi Gawat Darurat (IGD 24 Jam) RSU Fikri Medika</strong><br><br>Tim medis dan perawat siaga penuh 24 jam nonstop.<br>Panggilan Darurat: <strong>(0267) 8454999</strong><br>WhatsApp IGD: <strong>0812-3456-7890</strong>`;
                }

                if (lower.includes('bpjs') || lower.includes('persyaratan')) {
                    return `RSU Fikri Medika melayani pasien <strong>BPJS Kesehatan</strong>.<br><br>Persyaratan berkas:<br>1. Kartu BPJS Kesehatan Aktif<br>2. Surat Rujukan Faskes 1<br>3. KTP / Kartu Keluarga`;
                }

                return `Halo! Kaka Fikri siap membantu Anda mengenai informasi medis, konsultasi kesehatan umum, jadwal dokter spesialis, serta pendaftaran online di RSU Fikri Medika Karawang. Ada yang ingin Anda tanyakan lagi? 😊`;
            }
        };
    }
    </script>
</body>
</html>
