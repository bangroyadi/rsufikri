@extends('layouts.app')

@section('content')

<!-- MAIN CONTENT SECTION (WIDE CONTAINER STANDAR APLIKASI WEB MODERN) -->
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-10" x-data="rawatJalanApp()">

    <!-- TOP SECTION (TENTANG RAWAT JALAN) -->
    <div class="w-full">
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm space-y-6 flex flex-col justify-between border border-gray-100">
            <div class="space-y-6">
                <div class="flex items-center gap-3.5 pb-5 border-b border-gray-100">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-extrabold">
                        <i class="fa-solid fa-hospital"></i>
                    </div>
                    <div>
                        <span class="inline-block px-3 py-1 rounded-full bg-emerald-100 text-[#0e7c47] text-xs font-bold mb-1">
                            {{ __('Pelayanan Poliklinik') }}
                        </span>
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900">{{ __('Tentang Instalasi Rawat Jalan') }}</h2>
                    </div>
                </div>

                <div class="prose max-w-none text-gray-600 leading-relaxed text-xs sm:text-sm space-y-4 font-medium">
                    <p>
                        <strong>Instalasi Rawat Jalan RSU Fikri Medika Karawang</strong> menyediakan berbagai ragam konsultasi dan tindakan medis spesialis untuk menangani berbagai kondisi kesehatan pasien tanpa perlu menjalani rawat inap.
                    </p>
                    <p>
                        Dilengkapi sarana pemeriksaan modern, sistem pendaftaran online terintegrasi, serta jajaran tim dokter spesialis yang siap memberikan solusi kesehatan secara komprehensif dan penuh keramahan Islami.
                    </p>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center gap-2 text-xs font-bold text-[#0e7c47]">
                <i class="fa-solid fa-circle-check"></i>
                <span>Melayani Pasien Umum, BPJS Kesehatan, & Asuransi Swasta / Perusahaan</span>
            </div>
        </div>
    </div>

    <!-- FULL-WIDTH SECTIONS BELOW -->
    <div class="space-y-10 pt-2">

        <!-- FULL WIDE SECTION 1: DAFTAR POLIKLINIK SPESIALIS -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm space-y-6" x-data="{ showAllPoli: false }">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-100">
                <div>
                    <span class="inline-block px-3 py-1 rounded-full bg-emerald-100 text-[#0e7c47] text-xs font-bold mb-1.5">Spesialisasi Medis</span>
                    <h3 class="text-xl font-extrabold text-gray-900">Pilihan Poliklinik Spesialis</h3>
                    <p class="text-xs text-gray-500 font-medium">Klik ikon poliklinik di bawah untuk melihat Galeri Foto atau Jadwal Dokter Spesialis</p>
                </div>
                <a href="{{ url('/jadwal-dokter') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0e7c47] hover:underline shrink-0">
                    <span>Lihat Seluruh Dokter & Jadwal Praktek</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <!-- SPECIALIST SERVICES GRID: ROW 1 (DEFAULT 6 ITEMS) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-y-10 sm:gap-y-12 gap-x-4 sm:gap-x-6 lg:gap-x-8 pt-2">
                
                <!-- 1. Penyakit Dalam -->
                <div @click="openPoliMenu('Poli Penyakit Dalam', 'Pelayanan diagnostik dan penanganan medis komprehensif penyakit organ dalam dewasa (diabetes, hipertensi, lambung, ginjal, hati).', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])" 
                     class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <defs>
                                <linearGradient id="grad-rj-stomach" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#fed7aa" />
                                    <stop offset="50%" stop-color="#fb923c" />
                                    <stop offset="100%" stop-color="#ea580c" />
                                </linearGradient>
                            </defs>
                            <circle cx="32" cy="11" r="5" fill="#e2e8f0" stroke="#0e7c47" stroke-width="2"/>
                            <path d="M21 18h22l4 8-3 29H20L17 26l4-8z" fill="#f8fafc" stroke="#0e7c47" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M32 23v6c0 3 4 3 6 5 3 3 2 8-2 10-5 2-9-1-9-6 0-4 3-6 6-6" fill="url(#grad-rj-stomach)" stroke="#c2410c" stroke-width="2"/>
                            <path d="M31 43v6" stroke="#0e7c47" stroke-width="2.5" stroke-linecap="round"/>
                            <rect x="23" y="24" width="6" height="6" rx="1" fill="#10b981"/>
                            <path d="M26 25v4M24 27h4" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Penyakit Dalam
                    </span>
                </div>

                <!-- 2. Anak -->
                <div @click="openPoliMenu('Poli Anak', 'Pelayanan kesehatan anak komprehensif, imunisasi, pemantauan tumbuh kembang, dan infeksi pediatrik.', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])" 
                     class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <defs>
                                <linearGradient id="grad-rj-steth" x1="0%" y1="0%" x2="100%" y2="100%">
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
                            <path d="M19 37c3.5 3 8 4.5 13 4.5s9.5-1.5 13-4.5" stroke="url(#grad-rj-steth)" stroke-width="3" stroke-linecap="round"/>
                            <path d="M20 37v9c0 6 5 10 12 10s12-4 12-10v-9" stroke="url(#grad-rj-steth)" stroke-width="2" stroke-linecap="round"/>
                            <circle cx="32" cy="48" r="4.5" fill="#f59e0b" stroke="#b45309" stroke-width="1.8"/>
                            <circle cx="32" cy="48" r="2" fill="#ffffff"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Anak
                    </span>
                </div>

                <!-- 3. Obgyn (Kandungan) -->
                <div @click="openPoliMenu('Poli Obgyn (Kandungan)', 'Pemeriksaan kehamilan, USG 4D HD Live, persalinan metode ERACS, dan kesehatan reproduksi wanita.', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])" 
                     class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
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
                </div>

                <!-- 4. Bedah -->
                <div @click="openPoliMenu('Poli Bedah', 'Konsultasi dan tindakan pembedahan umum, appendicitis, hernia, tumor jinak, dan perawatan luka modern.', ['{{ asset('trauma-center.png') }}', '{{ asset('gedung2_web.jpg') }}'])" 
                     class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <defs>
                                <linearGradient id="grad-rj-scalpel-b" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#f8fafc" />
                                    <stop offset="100%" stop-color="#94a3b8" />
                                </linearGradient>
                                <linearGradient id="grad-rj-scalpel-h" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#34d399" />
                                    <stop offset="100%" stop-color="#059669" />
                                </linearGradient>
                            </defs>
                            <path d="M49 13l2 2c2 2 1 5-1 7L30 42l-14 4 4-14L40 12c2-2 5-3 7-1z" fill="url(#grad-rj-scalpel-h)" stroke="#047857" stroke-width="2"/>
                            <path d="M40 12l9 1c2 2 1 5-1 7l-8-8z" fill="url(#grad-rj-scalpel-b)" stroke="#64748b" stroke-width="1.5"/>
                            <line x1="34" y1="22" x2="42" y2="30" stroke="#ecfdf5" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M48 38l2 5 5 2-5 2-2 5-2-5-5-2 5-2 2-5z" fill="#f59e0b" stroke="#b45309" stroke-width="1"/>
                            <path d="M10 54h44" stroke="#0e7c47" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Bedah
                    </span>
                </div>

                <!-- 5. Mata -->
                <div @click="openPoliMenu('Poli Mata', 'Poli Spesialis Mata & Refraksi Katarak (Metode Phacoemulsification modern tanpa jahitan).', ['{{ asset('spesialis-mata.png') }}', '{{ asset('gedung1_web.jpg') }}'])" 
                     class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <defs>
                                <linearGradient id="grad-rj-iris" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#38bdf8" />
                                    <stop offset="50%" stop-color="#0284c7" />
                                    <stop offset="100%" stop-color="#0369a1" />
                                </linearGradient>
                                <linearGradient id="grad-rj-eyeball" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" stop-color="#ffffff" />
                                    <stop offset="100%" stop-color="#e0f2fe" />
                                </linearGradient>
                            </defs>
                            <path d="M6 32S16 14 32 14s26 18 26 18-10 18-26 18S6 32 6 32z" fill="url(#grad-rj-eyeball)" stroke="#0284c7" stroke-width="2.2" stroke-linejoin="round"/>
                            <circle cx="32" cy="32" r="10" fill="url(#grad-rj-iris)" stroke="#0369a1" stroke-width="1.5"/>
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
                </div>

                <!-- 6. Jantung -->
                <div @click="openPoliMenu('Poli Jantung', 'Poli Spesialis Jantung & Pembuluh Darah (Kardiologi) dengan EKG, Treadmill, dan Echocardiography.', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])" 
                     class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                            <defs>
                                <linearGradient id="grad-rj-heart" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#f87171" />
                                    <stop offset="100%" stop-color="#dc2626" />
                                </linearGradient>
                                <linearGradient id="grad-rj-aorta" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" stop-color="#38bdf8" />
                                    <stop offset="100%" stop-color="#0284c7" />
                                </linearGradient>
                            </defs>
                            <path d="M26 12V6c0-1.1.9-2 2-2h4c1.1 0 2 .9 2 2v6" fill="url(#grad-rj-aorta)" stroke="#0284c7" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M37 14V8c0-1.1.9-2 2-2h3c1.1 0 2 .9 2 2v8" fill="url(#grad-rj-aorta)" stroke="#0284c7" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M32 54C18 43 8 32 8 20a12 12 0 0 1 21.2-7.8L32 15l2.8-2.8A12 12 0 0 1 56 20c0 12-10 23-24 34z" fill="url(#grad-rj-heart)" stroke="#b91c1c" stroke-width="2"/>
                            <path d="M14 20c0-6 4-10 10-10" stroke="#fecaca" stroke-width="2" stroke-linecap="round"/>
                            <path d="M16 28h8l3-6 5 13 4-9 3 2h9" stroke="#fef08a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                        Jantung
                    </span>
                </div>

            </div>

            <!-- SPECIALIST SERVICES GRID: ROW 2 & 3 (REMAINING 13 ITEMS WITH ANIMATED EXPAND/COLLAPSE) -->
            <div x-show="showAllPoli" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-500 transform"
                 x-transition:enter-start="opacity-0 -translate-y-6 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-300 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 -translate-y-6 scale-95"
                 class="pt-6 sm:pt-8">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-y-10 sm:gap-y-12 gap-x-4 sm:gap-x-6 lg:gap-x-8">

                    <!-- 7. Paru -->
                    <div @click="openPoliMenu('Poli Paru', 'Poli Spesialis Paru & Pulmonologi untuk asma, PPOK, TBC, bronkitis, dan gangguan pernapasan.', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])" 
                         class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                            <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                                <defs>
                                    <linearGradient id="grad-rj-lung-l" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#6ee7b7" />
                                        <stop offset="100%" stop-color="#059669" />
                                    </linearGradient>
                                    <linearGradient id="grad-rj-lung-r" x1="100%" y1="0%" x2="0%" y2="100%">
                                        <stop offset="0%" stop-color="#6ee7b7" />
                                        <stop offset="100%" stop-color="#059669" />
                                    </linearGradient>
                                </defs>
                                <path d="M29 6h6v14h-6z" fill="#e2e8f0" stroke="#0e7c47" stroke-width="2" stroke-linecap="round"/>
                                <line x1="29" y1="10" x2="35" y2="10" stroke="#0e7c47" stroke-width="1.8"/>
                                <line x1="29" y1="14" x2="35" y2="14" stroke="#0e7c47" stroke-width="1.8"/>
                                <line x1="29" y1="18" x2="35" y2="18" stroke="#0e7c47" stroke-width="1.8"/>
                                <path d="M29 20c-3 1-8 4-11 1-5-5-9 6-10 16-1 9 5 18 13 18 6 0 8-7 8-15v-20z" fill="url(#grad-rj-lung-l)" stroke="#047857" stroke-width="2"/>
                                <path d="M35 20c3 1 8 4 11 1 5-5 9 6 10 16 1 9-5 18-13 18-6 0-8-7-8-15v-20z" fill="url(#grad-rj-lung-r)" stroke="#047857" stroke-width="2"/>
                                <path d="M26 27l-6 6M23 30l-3-2M38 27l6 6M41 30l3-2" stroke="#ecfdf5" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                        </div>
                        <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                            Paru
                        </span>
                    </div>

                    <!-- 8. Orthopedi -->
                    <div @click="openPoliMenu('Poli Orthopedi', 'Penanganan cedera patah tulang, dislokasi sendi, trauma kecelakaan, dan bedah ortopedi.', ['{{ asset('trauma-center.png') }}', '{{ asset('gedung2_web.jpg') }}'])" 
                         class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                            <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                                <defs>
                                    <linearGradient id="grad-rj-bone" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#ffffff" />
                                        <stop offset="50%" stop-color="#f1f5f9" />
                                        <stop offset="100%" stop-color="#cbd5e1" />
                                    </linearGradient>
                                </defs>
                                <path d="M22 10c-3-3-8-2-10 1s-1 8 2 10l8 8-10 2c-4 1-5 6-3 9s7 4 10 1l12-12 12 12c3 3 8 2 10-1s1-8-2-10l-8-8 10-2c4-1 5-6 3-9s-7-4-10-1L36 22 24 10z" fill="url(#grad-rj-bone)" stroke="#475569" stroke-width="2" stroke-linejoin="round"/>
                                <circle cx="32" cy="32" r="5" fill="#38bdf8" stroke="#0284c7" stroke-width="1.8"/>
                                <path d="M30 32h4M32 30v4" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M12 48l6-6M46 16l6-6" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round"/>
                            </svg>
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                        </div>
                        <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                            Orthopedi
                        </span>
                    </div>

                    <!-- 9. Urologi -->
                    <div @click="openPoliMenu('Poli Urologi', 'Penanganan kelainan sistem saluran kemih, batu ginjal, kandung kemih, dan prostat.', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])" 
                         class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                            <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                                <defs>
                                    <linearGradient id="grad-rj-kidney-l" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#f43f5e" />
                                        <stop offset="100%" stop-color="#9f1239" />
                                    </linearGradient>
                                    <linearGradient id="grad-rj-kidney-r" x1="100%" y1="0%" x2="0%" y2="100%">
                                        <stop offset="0%" stop-color="#f43f5e" />
                                        <stop offset="100%" stop-color="#9f1239" />
                                    </linearGradient>
                                </defs>
                                <path d="M16 16c-6 4-8 14-4 20 4 6 12 4 14-2 1-4-1-8-3-10-3-3-4-6-7-8z" fill="url(#grad-rj-kidney-l)" stroke="#881337" stroke-width="2"/>
                                <path d="M48 16c6 4 8 14 4 20-4 6-12 4-14-2-1-4 1-8 3-10 3-3 4-6 7-8z" fill="url(#grad-rj-kidney-r)" stroke="#881337" stroke-width="2"/>
                                <path d="M23 28c3 10 7 18 9 24M41 28c-3 10-7 18-9 24" stroke="#38bdf8" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="32" cy="54" r="5" fill="#38bdf8" stroke="#0284c7" stroke-width="1.8"/>
                            </svg>
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                        </div>
                        <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                            Urologi
                        </span>
                    </div>

                    <!-- 10. THT – KL -->
                    <div @click="openPoliMenu('Poli THT – KL', 'Pemeriksaan telinga, hidung, tenggorokan, serta bedah kepala dan leher (sinusitis, amandel, polip).', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])" 
                         class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                            <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                                <defs>
                                    <linearGradient id="grad-rj-ear" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#fed7aa" />
                                        <stop offset="100%" stop-color="#fb923c" />
                                    </linearGradient>
                                </defs>
                                <path d="M18 18c-6 0-10 5-10 11 0 9 6 13 10 18 2 2 3 5 2 8" fill="url(#grad-rj-ear)" stroke="#ea580c" stroke-width="2" stroke-linecap="round"/>
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
                    </div>

                    <!-- 11. Neurologi (Saraf) -->
                    <div @click="openPoliMenu('Poli Neurologi (Saraf)', 'Penanganan stroke, vertigo, migrain, epilepsi, nyeri saraf, dan saraf terjepit (HNP).', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])" 
                         class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                            <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                                <defs>
                                    <linearGradient id="grad-rj-neuro" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#a855f7" />
                                        <stop offset="100%" stop-color="#6b21a8" />
                                    </linearGradient>
                                </defs>
                                <path d="M32 12c-5-5-17-4-21 4-4 7-2 16 2 20-2 4-2 9 1 12 4 4 10 3 13 1 2 4 8 6 13 2" fill="url(#grad-rj-neuro)" stroke="#581c87" stroke-width="2"/>
                                <path d="M32 12c5-5 17-4 21 4 4 7 2 16-2 20 2 4 2 9-1 12-4 4-10 3-13 1-2 4-8 6-13 2" fill="url(#grad-rj-neuro)" stroke="#581c87" stroke-width="2"/>
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
                    </div>

                    <!-- 12. Bedah Saraf -->
                    <div @click="openPoliMenu('Poli Bedah Saraf', 'Tindakan operasi otak, saraf pusat, tumor saraf, dan trauma kepala.', ['{{ asset('gedung2_web.jpg') }}', '{{ asset('trauma-center.png') }}'])" 
                         class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                            <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                                <defs>
                                    <linearGradient id="grad-rj-neurosurg" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#c084fc" />
                                        <stop offset="100%" stop-color="#7c3aed" />
                                    </linearGradient>
                                </defs>
                                <path d="M32 14c-4-4-14-3-18 3-3 6-2 13 2 17-2 3-2 7 1 10 3 3 8 2 11 1 2 3 6 5 10 2" fill="url(#grad-rj-neurosurg)" stroke="#6d28d9" stroke-width="1.8"/>
                                <path d="M32 14c4-4 14-3 18 3 3 6 2 13-2 17 2 3 2 7-1 10-3 3-8 2-11 1-2 3-6 5-10 2" fill="url(#grad-rj-neurosurg)" stroke="#6d28d9" stroke-width="1.8"/>
                                <path d="M48 10l6 6-18 18-4-4L48 10z" fill="#f8fafc" stroke="#0e7c47" stroke-width="1.8"/>
                                <circle cx="32" cy="30" r="3" fill="#f59e0b" stroke="#b45309" stroke-width="1"/>
                            </svg>
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                        </div>
                        <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                            Bedah Saraf
                        </span>
                    </div>

                    <!-- 13. Jiwa -->
                    <div @click="openPoliMenu('Poli Jiwa', 'Konsultasi dan terapi psikiatri, kesehatan mental, gangguan kecemasan, depresi, dan insomnia.', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])" 
                         class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                            <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                                <defs>
                                    <linearGradient id="grad-rj-mind" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#fef08a" />
                                        <stop offset="100%" stop-color="#f59e0b" />
                                    </linearGradient>
                                </defs>
                                <path d="M18 55v-6c0-6 2-9 6-12-3-4-3-10-2-15 3-11 13-15 23-12 8 3 12 11 11 19-1 4-2 6-2 9l4 5-3 5h-8l-1 7" fill="#f0fdf4" stroke="#0e7c47" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="36" cy="27" r="7" fill="url(#grad-rj-mind)" stroke="#d97706" stroke-width="1.8"/>
                                <path d="M36 17v-3M46 27h3M36 37v3M26 27h-3M43 20l2-2M29 34l-2 2M43 34l2 2M29 20l-2-2" stroke="#f59e0b" stroke-width="2.2" stroke-linecap="round"/>
                                <path d="M33 28c1.5 2 4.5 2 6 0" stroke="#78350f" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                        </div>
                        <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                            Jiwa
                        </span>
                    </div>

                    <!-- 14. Kulit dan Kelamin -->
                    <div @click="openPoliMenu('Poli Kulit dan Kelamin', 'Perawatan masalah kulit (jerawat, alergi, eksim, infeksi) dan kesehatan organ reproduksi.', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])" 
                         class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                            <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                                <defs>
                                    <linearGradient id="grad-rj-skin" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#fbcfe8" />
                                        <stop offset="100%" stop-color="#f43f5e" />
                                    </linearGradient>
                                </defs>
                                <path d="M32 10c12 0 20 8 20 18 0 14-12 24-20 28-8-4-20-14-20-28 0-10 8-18 20-18z" fill="url(#grad-rj-skin)" stroke="#be123c" stroke-width="2"/>
                                <path d="M22 26c4-3 16-3 20 0M20 34c6-2 18-2 24 0M26 42c3-1 9-1 12 0" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="32" cy="22" r="3" fill="#fde047" stroke="#ca8a04" stroke-width="1"/>
                            </svg>
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                        </div>
                        <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                            Kulit dan Kelamin
                        </span>
                    </div>

                    <!-- 15. Rehab Medik -->
                    <div @click="openPoliMenu('Poli Rehab Medik', 'Fisioterapi, okupasi terapi, dan rehabilitasi medis pasca stroke/operasi/cedera.', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])" 
                         class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
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
                    </div>

                    <!-- 16. Spesialis Gigi (Periodonti) -->
                    <div @click="openPoliMenu('Poli Spesialis Gigi (Periodonti)', 'Perawatan khusus jaringan penyangga gigi, gusi berdarah, periodontitis, dan pembersihan karang mendalam.', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])" 
                         class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                            <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                                <defs>
                                    <linearGradient id="grad-rj-perio" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#ffffff" />
                                        <stop offset="100%" stop-color="#e0f2fe" />
                                    </linearGradient>
                                </defs>
                                <path d="M18 20c0-8 6-12 14-12s14 4 14 12c0 9-3 15-4 24-1 6-4 11-6 11s-2-8-2-13-2 13-4 13-5-5-6-11c-1-9-4-15-4-24z" fill="url(#grad-rj-perio)" stroke="#0284c7" stroke-width="2.2" stroke-linejoin="round"/>
                                <path d="M12 36c4-3 12-4 20-4s16 1 20 4v8H12v-8z" fill="#fda4af" stroke="#e11d48" stroke-width="1.8"/>
                                <path d="M46 12l2 4 4 2-4 2-2 4-2-4-4-2 4-2 2-4z" fill="#fbbf24" stroke="#d97706" stroke-width="1"/>
                            </svg>
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                        </div>
                        <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                            Spesialis Gigi<br>(Periodonti)
                        </span>
                    </div>

                    <!-- 17. Bedah Mulut -->
                    <div @click="openPoliMenu('Poli Bedah Mulut', 'Operasi gigi bungsu (odontektomi), kista rongga mulut, fraktur rahang, dan bedah maksilofasial.', ['{{ asset('gedung2_web.jpg') }}', '{{ asset('trauma-center.png') }}'])" 
                         class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
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
                    </div>

                    <!-- 18. Gigi -->
                    <div @click="openPoliMenu('Poli Gigi', 'Kesehatan gigi umum, tambal gigi estetik, pencabutan gigi, pembersihan karang gigi (scaling), dan perawatan saluran akar.', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])" 
                         class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-b from-emerald-50 to-teal-50/70 border-2 border-emerald-100/90 group-hover:border-[#0e7c47] group-hover:from-emerald-100/80 group-hover:to-teal-100/80 group-hover:shadow-md group-hover:shadow-emerald-900/10 flex items-center justify-center mb-3.5 transition-all duration-300 relative group-hover:scale-105">
                            <svg class="w-10 h-10 sm:w-11 sm:h-11 transition-transform duration-300 group-hover:scale-110 drop-shadow-xs" viewBox="0 0 64 64" fill="none">
                                <defs>
                                    <linearGradient id="grad-rj-teeth" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#ffffff" />
                                        <stop offset="100%" stop-color="#dbeafe" />
                                    </linearGradient>
                                </defs>
                                <path d="M18 20c0-8 6-12 14-12s14 4 14 12c0 9-3 15-4 24-1 6-4 11-6 11s-2-8-2-13-2 13-4 13-5-5-6-11c-1-9-4-15-4-24z" fill="url(#grad-rj-teeth)" stroke="#0284c7" stroke-width="2.2" stroke-linejoin="round"/>
                                <path d="M25 15c3-2 8-2 12 0" stroke="#38bdf8" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="32" cy="24" r="3" fill="#fef08a" stroke="#ca8a04" stroke-width="1"/>
                                <path d="M46 12l2 4 4 2-4 2-2 4-2-4-4-2 4-2 2-4z" fill="#fbbf24" stroke="#d97706" stroke-width="1"/>
                            </svg>
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xs"></span>
                        </div>
                        <span class="text-xs sm:text-sm font-bold text-[#0e7c47] group-hover:text-amber-600 transition-colors leading-snug">
                            Gigi
                        </span>
                    </div>

                    <!-- 19. Radiologi -->
                    <div @click="openPoliMenu('Poli Radiologi', 'Pemeriksaan radiologi digital X-Ray (Rontgen), USG Doppler, Panoramic Dental, dan imaging diagnostik.', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])" 
                         class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer">
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
                    </div>

                </div>
            </div>

            <!-- SEE ALL BUTTON (TOGGLE) -->
            <div class="mt-8 text-center pt-2">
                <button @click="showAllPoli = !showAllPoli" 
                        type="button"
                        style="background-color: #0e7c47; color: #ffffff;"
                        class="inline-flex items-center justify-center px-10 sm:px-12 py-2.5 rounded-full bg-[#0e7c47] hover:bg-[#096237] text-white font-bold text-sm tracking-tight shadow-sm hover:shadow-md active:scale-95 transition-all duration-200 cursor-pointer gap-2">
                    <span x-text="showAllPoli ? 'Tutup Daftar Spesialisasi' : 'Lihat Seluruh Poliklinik (19 Poli)'">Lihat Seluruh Poliklinik (19 Poli)</span>
                    <i class="fa-solid text-xs transition-transform duration-300" :class="showAllPoli ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
            </div>
        </div>

        <!-- FULL WIDE SECTION 3: LAYANAN PENUNJANG RAWAT JALAN (CLICKABLE CARDS FOR GALLERY LIGHTBOX) -->
        <div class="space-y-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="inline-block px-3 py-1 rounded-full bg-emerald-100 text-[#0e7c47] text-xs font-bold mb-1">Penunjang Medis</span>
                    <h3 class="text-xl font-extrabold text-gray-900">Fasilitas Penunjang Rawat Jalan</h3>
                </div>
                <span class="text-xs font-bold text-gray-500 hidden sm:inline-block"><i class="fa-solid fa-hand-pointer text-[#0e7c47] mr-1"></i> Klik kartu untuk lihat foto fasilitas</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <!-- FASILITAS 1: LAB -->
                <div @click="openGallery('Laboratorium Cepat 24h', 'Fasilitas laboratorium terakreditasi RSU Fikri Medika.', ['{{ asset('banner-igd.png') }}', '{{ asset('gedung1_web.jpg') }}'])" 
                     class="group bg-white p-6 rounded-3xl shadow-sm space-y-3.5 hover:shadow-md transition-all cursor-pointer flex flex-col justify-between">
                    <div class="space-y-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-bold group-hover:bg-[#0e7c47] group-hover:text-white transition-colors">
                            <i class="fa-solid fa-vial"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 text-base group-hover:text-[#0e7c47] transition-colors">Laboratorium Lengkap</h4>
                        <p class="text-xs text-gray-600 leading-relaxed font-medium">
                            Pemeriksaan darah rutin, kimia darah, hormon, & tes laboratorium terakreditasi.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-[#0e7c47]">
                        <span>Lihat Foto Fasilitas</span>
                        <i class="fa-solid fa-camera group-hover:scale-110 transition-transform"></i>
                    </div>
                </div>

                <!-- FASILITAS 2: FARMASI -->
                <div @click="openGallery('Farmasi Rawat Jalan', 'Layanan apoteker & depo farmasi rawat jalan RSU Fikri Medika.', ['{{ asset('gedung2_web.jpg') }}', '{{ asset('banner-profil.png') }}'])" 
                     class="group bg-white p-6 rounded-3xl shadow-sm space-y-3.5 hover:shadow-md transition-all cursor-pointer flex flex-col justify-between">
                    <div class="space-y-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-bold group-hover:bg-[#0e7c47] group-hover:text-white transition-colors">
                            <i class="fa-solid fa-capsules"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 text-base group-hover:text-[#0e7c47] transition-colors">Farmasi Rawat Jalan</h4>
                        <p class="text-xs text-gray-600 leading-relaxed font-medium">
                            Pengadaan resep obat obgyn, anak, umum, & konsultasi apoteker profesional.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-[#0e7c47]">
                        <span>Lihat Foto Fasilitas</span>
                        <i class="fa-solid fa-camera group-hover:scale-110 transition-transform"></i>
                    </div>
                </div>

                <!-- FASILITAS 3: RADIOLOGI & USG -->
                <div @click="openGallery('Radiologi & USG 4D', 'Pemeriksaan Rontgen Digital & USG Kebidanan RSU Fikri Medika.', ['{{ asset('spesialis-mata.png') }}', '{{ asset('trauma-center.png') }}'])" 
                     class="group bg-white p-6 rounded-3xl shadow-sm space-y-3.5 hover:shadow-md transition-all cursor-pointer flex flex-col justify-between">
                    <div class="space-y-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-bold group-hover:bg-[#0e7c47] group-hover:text-white transition-colors">
                            <i class="fa-solid fa-x-ray"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 text-base group-hover:text-[#0e7c47] transition-colors">Radiologi & USG 4D</h4>
                        <p class="text-xs text-gray-600 leading-relaxed font-medium">
                            Pemeriksaan Rontgen Digital, USG 4D Kebidanan, & diagnosis pencitraan cepat.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-[#0e7c47]">
                        <span>Lihat Foto Fasilitas</span>
                        <i class="fa-solid fa-camera group-hover:scale-110 transition-transform"></i>
                    </div>
                </div>

                <!-- FASILITAS 4: RME -->
                <div @click="openGallery('Rekam Medis Elektronik (RME)', 'Sistem rekam medis digital terintegrasi RSU Fikri Medika.', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])" 
                     class="group bg-white p-6 rounded-3xl shadow-sm space-y-3.5 hover:shadow-md transition-all cursor-pointer flex flex-col justify-between">
                    <div class="space-y-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-bold group-hover:bg-[#0e7c47] group-hover:text-white transition-colors">
                            <i class="fa-solid fa-laptop-medical"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 text-base group-hover:text-[#0e7c47] transition-colors">Rekam Medis Digital</h4>
                        <p class="text-xs text-gray-600 leading-relaxed font-medium">
                            Sistem rekam medis elektronik (RME) aman & terintegrasi untuk riwayat penyakit pasien.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-[#0e7c47]">
                        <span>Lihat Foto Fasilitas</span>
                        <i class="fa-solid fa-camera group-hover:scale-110 transition-transform"></i>
                    </div>
                </div>

            </div>
        </div>

        <!-- FULL WIDE SECTION 4: FAQ ACCORDION -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm space-y-6" x-data="{ activeFaq: null }">
            <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-circle-question"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Pertanyaan Umum (FAQ) Rawat Jalan</h3>
                    <p class="text-xs text-gray-500 font-medium">Informasi pendaftaran, syarat BPJS Kesehatan, & konsultasi poliklinik</p>
                </div>
            </div>

            <div class="space-y-3">
                <!-- FAQ 1 -->
                <div class="rounded-2xl bg-gray-50/70 overflow-hidden">
                    <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full p-4.5 text-left font-bold text-gray-900 text-xs sm:text-sm flex items-center justify-between gap-4 hover:text-[#0e7c47] transition-colors">
                        <span>Bagaimana cara mendaftar berobat rawat jalan secara online?</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform text-gray-400" :class="activeFaq === 1 ? 'rotate-180 text-[#0e7c47]' : ''"></i>
                    </button>
                    <div x-show="activeFaq === 1" x-transition class="p-4.5 pt-0 text-xs text-gray-600 leading-relaxed font-medium border-t border-gray-100">
                        Anda dapat mendaftar langsung melalui menu "Buat Janji Online" pada website RSU Fikri Medika atau mengirimkan pesan ke Call Center WhatsApp resmi di 0822-8074-9999.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="rounded-2xl bg-gray-50/70 overflow-hidden">
                    <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full p-4.5 text-left font-bold text-gray-900 text-xs sm:text-sm flex items-center justify-between gap-4 hover:text-[#0e7c47] transition-colors">
                        <span>Persyaratan apa saja yang dibutuhkan untuk berobat menggunakan BPJS Kesehatan?</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform text-gray-400" :class="activeFaq === 2 ? 'rotate-180 text-[#0e7c47]' : ''"></i>
                    </button>
                    <div x-show="activeFaq === 2" x-transition class="p-4.5 pt-0 text-xs text-gray-600 leading-relaxed font-medium border-t border-gray-100">
                        Pasien rawat jalan BPJS Kesehatan wajib membawa Surat Rujukan aktif dari Faskes 1 (Puskesmas/Klinik), KTP/KK, dan Kartu BPJS Kesehatan aktif.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="rounded-2xl bg-gray-50/70 overflow-hidden">
                    <button @click="activeFaq = (activeFaq === 3 ? null : 3)" class="w-full p-4.5 text-left font-bold text-gray-900 text-xs sm:text-sm flex items-center justify-between gap-4 hover:text-[#0e7c47] transition-colors">
                        <span>Apakah poliklinik melayani konsultasi di hari libur?</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform text-gray-400" :class="activeFaq === 3 ? 'rotate-180 text-[#0e7c47]' : ''"></i>
                    </button>
                    <div x-show="activeFaq === 3" x-transition class="p-4.5 pt-0 text-xs text-gray-600 leading-relaxed font-medium border-t border-gray-100">
                        Sebagian besar Poliklinik Spesialis beroperasi Senin hingga Sabtu. Untuk jadwal praktek dokter spesialis tertentu pada hari Minggu/libur nasional, dapat diperiksa pada menu Jadwal Dokter.
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- CHOICE MODAL WHEN CIRCULAR ICON LOGO IS CLICKED (ALPINE.JS) -->
    <div x-show="activePoliChoiceModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-xs" 
         style="display: none;">
        
        <div @click.away="activePoliChoiceModal = false" 
             class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-6 sm:p-8 space-y-6 relative">
            
            <button @click="activePoliChoiceModal = false" class="absolute right-6 top-6 w-9 h-9 rounded-full bg-gray-100 text-slate-500 hover:bg-gray-200 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>

            <div class="space-y-1">
                <span class="text-xs font-bold text-[#0e7c47] uppercase tracking-wider">Poliklinik Spesialis</span>
                <h3 class="text-xl font-black text-slate-900" x-text="selectedPoliTitle"></h3>
                <p class="text-xs text-slate-500 font-medium" x-text="selectedPoliDesc"></p>
            </div>

            <!-- DUAL CHOICE ACTION BUTTONS -->
            <div class="space-y-3 pt-2">
                <button @click="activePoliChoiceModal = false; openGallery(selectedPoliTitle, selectedPoliDesc, selectedPoliImages)" 
                        class="w-full p-4 rounded-2xl bg-emerald-50 hover:bg-[#0e7c47] text-[#0e7c47] hover:text-white transition-all text-left flex items-center gap-3.5 group shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-white text-[#0e7c47] flex items-center justify-center text-lg font-bold shadow-xs">
                        <i class="fa-solid fa-images"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-sm leading-tight">1. Lihat Galeri Foto Poliklinik</h4>
                        <p class="text-[11px] opacity-80 font-medium">Visualisasi ruangan & fasilitas poliklinik</p>
                    </div>
                </button>

                <a href="{{ url('/jadwal-dokter') }}" 
                   class="w-full p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50 text-slate-800 hover:text-[#0e7c47] transition-all text-left flex items-center gap-3.5 group shadow-xs block">
                    <div class="w-10 h-10 rounded-xl bg-white text-[#0e7c47] flex items-center justify-center text-lg font-bold shadow-xs">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-sm leading-tight">2. Lihat Jadwal Dokter Spesialis</h4>
                        <p class="text-[11px] text-gray-500 font-medium">Cek jam praktek & nama dokter spesialis</p>
                    </div>
                </a>
            </div>

            <div class="pt-2 border-t border-gray-100 flex items-center justify-between">
                <a href="{{ url('/buat-janji') }}" class="px-5 py-2.5 rounded-xl bg-[#0e7c47] hover:bg-emerald-700 text-white font-bold text-xs transition-colors shadow-xs">
                    <i class="fa-solid fa-calendar-plus mr-1.5"></i> Buat Janji Online
                </a>
                <button @click="activePoliChoiceModal = false" class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-slate-700 font-bold text-xs">
                    Batal
                </button>
            </div>

        </div>
    </div>

    <!-- GALLERY LIGHTBOX / MODAL POPUP (ALPINE.JS) -->
    <div x-show="activeModalGallery" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-xs" 
         style="display: none;">
        
        <div @click.away="closeGallery()" 
             class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl p-6 sm:p-8 space-y-5 relative">
            
            <button @click="closeGallery()" class="absolute right-6 top-6 w-9 h-9 rounded-full bg-gray-100 text-slate-500 hover:bg-gray-200 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>

            <div class="space-y-1">
                <span class="text-xs font-bold text-[#0e7c47] uppercase tracking-wider">Galeri Foto RSU Fikri Medika</span>
                <h3 class="text-xl font-black text-slate-900" x-text="galleryTitle"></h3>
                <p class="text-xs text-slate-500 font-medium" x-text="galleryDescription"></p>
            </div>

            <!-- IMAGE DISPLAY -->
            <div class="relative w-full h-72 sm:h-80 rounded-2xl overflow-hidden bg-slate-900">
                <template x-for="(img, idx) in galleryImages" :key="idx">
                    <img x-show="activeImageIndex === idx" 
                         :src="img" 
                         class="w-full h-full object-cover">
                </template>

                <!-- PREV / NEXT NAVIGATION IF MULTIPLE IMAGES -->
                <template x-if="galleryImages.length > 1">
                    <div class="absolute inset-0 flex items-center justify-between p-4 pointer-events-none">
                        <button @click="activeImageIndex = (activeImageIndex === 0 ? galleryImages.length - 1 : activeImageIndex - 1)" 
                                class="w-10 h-10 rounded-full bg-slate-950/60 text-white hover:bg-slate-950 flex items-center justify-center pointer-events-auto transition-colors">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </button>
                        <button @click="activeImageIndex = (activeImageIndex === galleryImages.length - 1 ? 0 : activeImageIndex + 1)" 
                                class="w-10 h-10 rounded-full bg-slate-950/60 text-white hover:bg-slate-950 flex items-center justify-center pointer-events-auto transition-colors">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                </template>
            </div>

            <!-- FOOTER MODAL -->
            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                <a href="{{ url('/buat-janji') }}" class="px-5 py-2.5 rounded-xl bg-[#0e7c47] hover:bg-emerald-700 text-white font-bold text-xs transition-colors shadow-xs">
                    <i class="fa-solid fa-calendar-plus mr-1.5"></i> Buat Janji Berobat
                </a>
                <button @click="closeGallery()" class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-slate-700 font-bold text-xs">
                    Tutup
                </button>
            </div>

        </div>
    </div>

</section>

<!-- ALPINE.JS SCRIPT -->
<script>
function rawatJalanApp() {
    return {
        activePoliChoiceModal: false,
        selectedPoliTitle: '',
        selectedPoliDesc: '',
        selectedPoliImages: [],

        activeModalGallery: false,
        galleryTitle: '',
        galleryDescription: '',
        galleryImages: [],
        activeImageIndex: 0,

        openPoliMenu(title, desc, images) {
            this.selectedPoliTitle = title;
            this.selectedPoliDesc = desc;
            this.selectedPoliImages = images;
            this.activePoliChoiceModal = true;
        },

        openGallery(title, description, images) {
            this.galleryTitle = title;
            this.galleryDescription = description;
            this.galleryImages = images && images.length ? images : ['{{ asset("gedung1_web.jpg") }}'];
            this.activeImageIndex = 0;
            this.activeModalGallery = true;
        },

        closeGallery() {
            this.activeModalGallery = false;
        }
    };
}
</script>

@endsection
