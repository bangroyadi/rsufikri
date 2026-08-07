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
<body class="antialiased flex flex-col min-h-screen bg-[#f7faf8]">

    <!-- TOP EMERGENCY & INFO BAR -->
    <div class="bg-[#0e7c47] text-white text-xs sm:text-sm py-2 px-4 border-b border-[#096237]/50">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4 flex-wrap justify-center sm:justify-start">
                <span class="inline-flex items-center gap-1.5 font-semibold text-yellow-300">
                    <i class="fa-solid fa-phone-volume text-red-300 animate-pulse"></i>
                    <span>{{ __('IGD 24 Jam') }}: <strong>(0267) 8454999</strong></span>
                </span>
                <span class="hidden md:inline-block text-[#159b5a]">|</span>
                <span class="hidden md:inline-flex items-center gap-1.5 text-gray-100">
                    <i class="fa-brands fa-whatsapp text-emerald-300"></i>
                    <span>WA: 0812-3456-7890</span>
                </span>
                <span class="hidden lg:inline-block text-[#159b5a]">|</span>
                <span class="hidden lg:inline-flex items-center gap-1.5 text-gray-100">
                    <i class="fa-regular fa-clock text-yellow-300"></i>
                    <span>{{ __('Buka 24 Jam / 7 Hari') }}</span>
                </span>
            </div>

            <!-- LANGUAGE SWITCHER -->
            <div class="flex items-center gap-3">
                <span class="text-gray-200 text-xs hidden sm:inline">{{ __('Bahasa') }}:</span>
                <div class="inline-flex items-center bg-[#096237] rounded-full p-1 border border-[#159b5a]/40">
                    <a href="{{ route('lang.switch', 'id') }}" 
                       class="px-2.5 py-0.5 rounded-full text-xs font-bold transition-all flex items-center gap-1 {{ app()->getLocale() == 'id' ? 'bg-yellow-400 text-gray-900 shadow-sm' : 'text-gray-200 hover:text-white' }}">
                        <span>🇮🇩</span> <span>ID</span>
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}" 
                       class="px-2.5 py-0.5 rounded-full text-xs font-bold transition-all flex items-center gap-1 {{ app()->getLocale() == 'en' ? 'bg-yellow-400 text-gray-900 shadow-sm' : 'text-gray-200 hover:text-white' }}">
                        <span>🇬🇧</span> <span>EN</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN NAVBAR -->
    <header x-data="{ mobileMenuOpen: false, scrolled: false }" 
            @scroll.window="scrolled = (window.pageYOffset > 20)" 
            class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-sm transition-all duration-300 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- OFFICIAL HORIZONTAL LOGO -->
                <a href="{{ route('home') }}" class="flex items-center py-2 group">
                    <img src="{{ asset('logodasboard.png') }}" 
                         alt="RSU Fikri Medika Logo" 
                         class="h-12 sm:h-14 w-auto object-contain group-hover:scale-105 transition-transform">
                </a>

                <!-- DESKTOP NAV -->
                <nav class="hidden lg:flex items-center gap-7 text-sm font-semibold text-gray-700">
                    <a href="{{ route('home') }}" class="hover:text-[#0e7c47] transition-colors text-[#0e7c47] font-bold relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-[#0e7c47]">
                        {{ __('Beranda') }}
                    </a>
                    <a href="#profil" class="hover:text-[#0e7c47] transition-colors">{{ __('Profil') }}</a>
                    
                    <!-- LAYANAN DROPDOWN -->
                    <div class="relative py-6" x-data="{ dropdownOpen: false, subOpen: false }" @mouseenter="dropdownOpen = true" @mouseleave="dropdownOpen = false; subOpen = false">
                        <button class="hover:text-[#0e7c47] transition-colors flex items-center gap-1.5 focus:outline-none">
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
                             class="absolute left-0 mt-0 w-64 bg-[#0e7c47] rounded-xl shadow-2xl py-2 z-50 text-white text-xs font-semibold border border-[#096237]"
                             style="display: none;">
                            
                            <!-- PERAWATAN WITH SUBMENU -->
                            <div class="relative" @mouseenter="subOpen = true" @mouseleave="subOpen = false">
                                <a href="#layanan" class="flex items-center justify-between px-4 py-2.5 text-yellow-300 font-extrabold hover:bg-[#096237] transition-colors">
                                    <span>{{ __('Perawatan') }}</span>
                                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>

                                <!-- SUBMENU PERAWATAN -->
                                <div x-show="subOpen" 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 translate-x-1"
                                     x-transition:enter-end="opacity-100 translate-x-0"
                                     class="absolute left-full top-0 w-48 bg-[#0e7c47] rounded-xl shadow-2xl py-2 text-white text-xs font-semibold border border-[#096237]"
                                     style="display: none;">
                                    <a href="#layanan" class="block px-4 py-2.5 hover:bg-[#096237] hover:text-yellow-300 transition-colors">{{ __('Rawat Jalan') }}</a>
                                    <a href="#layanan" class="block px-4 py-2.5 hover:bg-[#096237] hover:text-yellow-300 transition-colors">{{ __('Rawat Inap') }}</a>
                                </div>
                            </div>

                            <!-- OTHER SERVICES -->
                            <a href="#layanan" class="block px-4 py-2.5 hover:bg-[#096237] hover:text-yellow-300 transition-colors">{{ __('Instalasi Gawat Darurat') }}</a>
                            <a href="#layanan" class="block px-4 py-2.5 hover:bg-[#096237] hover:text-yellow-300 transition-colors">{{ __('Kamar Operasi') }}</a>
                            <a href="#layanan" class="block px-4 py-2.5 hover:bg-[#096237] hover:text-yellow-300 transition-colors">{{ __('ICU, NICU') }}</a>
                            <a href="#layanan" class="block px-4 py-2.5 hover:bg-[#096237] hover:text-yellow-300 transition-colors">{{ __('Hemodialisa') }}</a>
                            <a href="#layanan" class="block px-4 py-2.5 hover:bg-[#096237] hover:text-yellow-300 transition-colors">{{ __('X-Ray (FotoRontgent)') }}</a>
                            <a href="#layanan" class="block px-4 py-2.5 hover:bg-[#096237] hover:text-yellow-300 transition-colors">{{ __('IR (Fisioteraphy)') }}</a>
                            <a href="#layanan" class="block px-4 py-2.5 hover:bg-[#096237] hover:text-yellow-300 transition-colors">{{ __('Laboratorium') }}</a>
                            <a href="#layanan" class="block px-4 py-2.5 hover:bg-[#096237] hover:text-yellow-300 transition-colors">{{ __('Rehab Medik') }}</a>
                            <a href="#layanan" class="block px-4 py-2.5 hover:bg-[#096237] hover:text-yellow-300 transition-colors">{{ __('Medical Check Up') }}</a>
                            <a href="#layanan" class="block px-4 py-2.5 hover:bg-[#096237] hover:text-yellow-300 transition-colors">{{ __('Instalasi Farmasi') }}</a>
                            <a href="#layanan" class="block px-4 py-2.5 hover:bg-[#096237] hover:text-yellow-300 transition-colors">{{ __('USG 3D & USG 4D') }}</a>
                            <a href="#layanan" class="block px-4 py-2.5 hover:bg-[#096237] hover:text-yellow-300 transition-colors">{{ __('Ambulance') }}</a>
                        </div>
                    </div>

                    <a href="#jadwal-dokter" class="hover:text-[#0e7c47] transition-colors">{{ __('Jadwal Dokter') }}</a>
                    <a href="#berita" class="hover:text-[#0e7c47] transition-colors">{{ __('Berita') }}</a>
                    <a href="#kontak" class="hover:text-[#0e7c47] transition-colors">{{ __('Kontak') }}</a>
                    <a href="#karir" class="hover:text-[#0e7c47] transition-colors">{{ __('Karir') }}</a>
                </nav>

                <!-- HEADER CTA BUTTONS -->
                <div class="hidden lg:flex items-center gap-3">
                    <a href="#kontak" class="px-5 py-2.5 rounded-lg text-xs font-semibold bg-[#e31e24] text-white hover:bg-red-700 shadow-md shadow-red-200 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-heart-pulse"></i>
                        <span>{{ __('Daftar / Buat Janji') }}</span>
                    </a>
                </div>

                <!-- MOBILE MENU TOGGLE -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100 focus:outline-none">
                    <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark text-2xl' : 'fa-bars text-2xl'"></i>
                </button>
            </div>
        </div>

        <!-- MOBILE MENU DRAWER -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="lg:hidden bg-white border-b border-gray-200 px-4 pt-2 pb-6 space-y-3 shadow-xl max-h-[85vh] overflow-y-auto">
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="block py-2 font-bold text-[#0e7c47] border-b border-gray-100">{{ __('Beranda') }}</a>
            <a href="#profil" @click="mobileMenuOpen = false" class="block py-2 text-gray-700 hover:text-[#0e7c47] border-b border-gray-100">{{ __('Profil') }}</a>
            
            <!-- MOBILE LAYANAN ACCORDION -->
            <div x-data="{ mobileLayananOpen: false }">
                <button @click="mobileLayananOpen = !mobileLayananOpen" class="w-full flex items-center justify-between py-2 text-gray-700 font-semibold border-b border-gray-100">
                    <span>{{ __('Layanan') }}</span>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform" :class="mobileLayananOpen ? 'rotate-180 text-[#0e7c47]' : ''"></i>
                </button>
                <div x-show="mobileLayananOpen" class="pl-4 py-2 space-y-2 bg-[#0e7c47] text-white rounded-xl my-2 text-xs font-semibold">
                    <div class="font-extrabold text-yellow-300 pb-1 border-b border-[#096237]">{{ __('Perawatan') }}:</div>
                    <a href="#layanan" @click="mobileMenuOpen = false" class="block pl-2 py-1 hover:text-yellow-300">• {{ __('Rawat Jalan') }}</a>
                    <a href="#layanan" @click="mobileMenuOpen = false" class="block pl-2 py-1 hover:text-yellow-300">• {{ __('Rawat Inap') }}</a>
                    <div class="border-t border-[#096237] pt-2 space-y-1.5">
                        <a href="#layanan" @click="mobileMenuOpen = false" class="block py-1 hover:text-yellow-300">{{ __('Instalasi Gawat Darurat') }}</a>
                        <a href="#layanan" @click="mobileMenuOpen = false" class="block py-1 hover:text-yellow-300">{{ __('Kamar Operasi') }}</a>
                        <a href="#layanan" @click="mobileMenuOpen = false" class="block py-1 hover:text-yellow-300">{{ __('ICU, NICU') }}</a>
                        <a href="#layanan" @click="mobileMenuOpen = false" class="block py-1 hover:text-yellow-300">{{ __('Hemodialisa') }}</a>
                        <a href="#layanan" @click="mobileMenuOpen = false" class="block py-1 hover:text-yellow-300">{{ __('X-Ray (FotoRontgent)') }}</a>
                        <a href="#layanan" @click="mobileMenuOpen = false" class="block py-1 hover:text-yellow-300">{{ __('IR (Fisioteraphy)') }}</a>
                        <a href="#layanan" @click="mobileMenuOpen = false" class="block py-1 hover:text-yellow-300">{{ __('Laboratorium') }}</a>
                        <a href="#layanan" @click="mobileMenuOpen = false" class="block py-1 hover:text-yellow-300">{{ __('Rehab Medik') }}</a>
                        <a href="#layanan" @click="mobileMenuOpen = false" class="block py-1 hover:text-yellow-300">{{ __('Medical Check Up') }}</a>
                        <a href="#layanan" @click="mobileMenuOpen = false" class="block py-1 hover:text-yellow-300">{{ __('Instalasi Farmasi') }}</a>
                        <a href="#layanan" @click="mobileMenuOpen = false" class="block py-1 hover:text-yellow-300">{{ __('USG 3D & USG 4D') }}</a>
                        <a href="#layanan" @click="mobileMenuOpen = false" class="block py-1 hover:text-yellow-300">{{ __('Ambulance') }}</a>
                    </div>
                </div>
            </div>

            <a href="#jadwal-dokter" @click="mobileMenuOpen = false" class="block py-2 text-gray-700 hover:text-[#0e7c47] border-b border-gray-100">{{ __('Jadwal Dokter') }}</a>
            <a href="#berita" @click="mobileMenuOpen = false" class="block py-2 text-gray-700 hover:text-[#0e7c47] border-b border-gray-100">{{ __('Berita & Artikel') }}</a>
            <a href="#kontak" @click="mobileMenuOpen = false" class="block py-2 text-gray-700 hover:text-[#0e7c47] border-b border-gray-100">{{ __('Kontak') }}</a>
            <a href="#karir" @click="mobileMenuOpen = false" class="block py-2 text-gray-700 hover:text-[#0e7c47] border-b border-gray-100">{{ __('Karir') }}</a>
            <div class="pt-2 flex flex-col gap-2">
                <a href="#kontak" @click="mobileMenuOpen = false" class="w-full text-center py-2.5 rounded-lg text-sm font-semibold bg-[#e31e24] text-white">
                    {{ __('Daftar / Buat Janji') }}
                </a>
            </div>
        </div>
    </header>

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
                        <a href="https://facebook.com" target="_blank" class="w-9 h-9 rounded-full bg-[#096237] hover:bg-yellow-400 hover:text-gray-900 flex items-center justify-center transition-colors">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                        <a href="https://instagram.com" target="_blank" class="w-9 h-9 rounded-full bg-[#096237] hover:bg-yellow-400 hover:text-gray-900 flex items-center justify-center transition-colors">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                        <a href="https://youtube.com" target="_blank" class="w-9 h-9 rounded-full bg-[#096237] hover:bg-yellow-400 hover:text-gray-900 flex items-center justify-center transition-colors">
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
    </footer>

</body>
</html>
