@extends('layouts.app')

@section('content')

<!-- MAIN CONTENT SECTION (WIDE CONTAINER STANDAR APLIKASI WEB MODERN) -->
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-10">

    <!-- HERO SHOWCASE BANNER (BACKGROUND GAMBAR & MAPS BUTTON) -->
    <div class="relative rounded-3xl p-6 sm:p-8 lg:p-10 text-white shadow-2xl overflow-hidden bg-cover bg-center" 
         style="background-image: url('{{ asset('gedung2_web.jpg') }}');">
        <!-- PREMIUM DARK GRADIENT OVERLAY FOR MAXIMUM TEXT READABILITY -->
        <div class="absolute inset-0 bg-slate-950/70"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#042d19] via-[#084829]/90 to-[#021f11]/85"></div>

        <div class="space-y-5 max-w-3xl relative z-10">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 text-yellow-300 text-xs font-black uppercase tracking-wider backdrop-blur-md shadow-xs">
                <i class="fa-solid fa-truck-medical text-sm text-yellow-400 animate-pulse"></i>
                <span>{{ __('Pelayanan Medis Darurat 24 Jam Nonstop') }}</span>
            </div>
            
            <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight leading-snug drop-shadow-md">
                {{ __('Instalasi Gawat Darurat (IGD 24 Jam)') }}
            </h1>
            
            <p class="text-emerald-100 text-xs sm:text-sm leading-relaxed font-medium">
                {{ __('Penanganan medis gawat darurat yang cepat, tepat, dan profesional oleh Dokter & Tim Medis siaga 24 jam nonstop di RSU Fikri Medika Karawang.') }}
            </p>

            <!-- MAPS BUTTON IN HERO BANNER -->
            <div class="pt-1">
                <a href="https://maps.google.com/?q=RSU+Fikri+Medika+Karawang" target="_blank" 
                   class="inline-flex items-center gap-3 px-6 py-3.5 rounded-2xl bg-yellow-400 hover:bg-yellow-300 text-slate-950 font-black text-xs sm:text-sm shadow-xl transition-all border border-yellow-300 active:scale-98">
                    <i class="fa-solid fa-location-dot text-base text-slate-950"></i>
                    <span>{{ __('📍 Petunjuk Lokasi & Rute Google Maps') }}</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs text-slate-800"></i>
                </a>
            </div>

            <!-- 3 HIGHLIGHT BADGES -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                <div class="flex items-center gap-2.5 p-3 rounded-2xl bg-white/10 backdrop-blur-md">
                    <div class="w-8 h-8 rounded-xl bg-yellow-400 text-slate-950 flex items-center justify-center text-sm font-black shrink-0 shadow-xs">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-white text-xs">Siaga 24 Jam</h4>
                        <p class="text-[10px] text-emerald-100 font-medium">7 Hari Seminggu</p>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 p-3 rounded-2xl bg-white/10 backdrop-blur-md">
                    <div class="w-8 h-8 rounded-xl bg-yellow-400 text-slate-950 flex items-center justify-center text-sm font-black shrink-0 shadow-xs">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-white text-xs">Dokter Siaga</h4>
                        <p class="text-[10px] text-emerald-100 font-medium">Respon Medis Cepat</p>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 p-3 rounded-2xl bg-white/10 backdrop-blur-md">
                    <div class="w-8 h-8 rounded-xl bg-yellow-400 text-slate-950 flex items-center justify-center text-sm font-black shrink-0 shadow-xs">
                        <i class="fa-solid fa-ambulance"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-white text-xs">Ambulans IGD</h4>
                        <p class="text-[10px] text-emerald-100 font-medium">Evakuasi Pasien 24h</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TOP SECTION (7 COLS TENTANG IGD + 5 COLS CALL CENTER) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
        
        <!-- LEFT MAIN DETAILS (7 COLS) -->
        <div class="lg:col-span-7">
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm space-y-6 h-full flex flex-col justify-between">
                <div class="space-y-6">
                    <div class="flex items-center gap-3.5 pb-5 border-b border-gray-100">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-extrabold">
                            <i class="fa-solid fa-hospital-user"></i>
                        </div>
                        <div>
                            <span class="inline-block px-3 py-1 rounded-full bg-emerald-100 text-[#0e7c47] text-xs font-bold mb-1">
                                {{ __('Pelayanan Utama Emergency') }}
                            </span>
                            <h2 class="text-lg sm:text-xl font-bold text-gray-900">{{ __('Tentang Instalasi Gawat Darurat') }}</h2>
                        </div>
                    </div>

                    <div class="prose max-w-none text-gray-600 leading-relaxed text-xs sm:text-sm space-y-4 font-medium">
                        <p>
                            <strong>Instalasi Gawat Darurat (IGD 24 Jam) RSU Fikri Medika Karawang</strong> merupakan garda terdepan penanganan medis gawat darurat yang siap melayani pasien dengan respon cepat, tepat, dan mengedepankan prinsip keselamatan medis serta nilai-nilai kehangatan Islami.
                        </p>
                        <p>
                            Ditunjang oleh tim dokter siaga 24 jam, perawat medis bersertifikasi khusus gawat darurat (BTCLS/ATCLS), serta ruang penanganan medis terintegrasi yang terhubung langsung ke unit penunjang 24 jam.
                        </p>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center gap-2 text-xs font-bold text-[#0e7c47]">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Menerima Pasien BPJS Kesehatan & Asuransi Kasus Emergency 24h</span>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDEBAR (5 COLS) -->
        <div class="lg:col-span-5">
            <div class="bg-gradient-to-br from-[#084829] via-[#0e7c47] to-[#042d19] p-6 sm:p-8 rounded-3xl text-white shadow-xl space-y-5 relative overflow-hidden h-full flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex items-center gap-3 pb-3 border-b border-emerald-500/30">
                        <div class="w-10 h-10 rounded-xl bg-yellow-400 text-slate-950 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <div>
                            <span class="text-[10px] text-yellow-300 font-bold uppercase tracking-wider">{{ __('Call Center IGD 24 Jam') }}</span>
                            <h3 class="font-extrabold text-sm sm:text-base leading-tight text-white">{{ __('RSU Fikri Medika') }}</h3>
                        </div>
                    </div>

                    <p class="text-xs text-emerald-100 leading-relaxed font-medium">
                        {{ __('Segera hubungi tim penanganan darurat kami untuk bantuan pertolongan pertama dan penjemputan ambulans 24 jam.') }}
                    </p>

                    <div class="p-3.5 rounded-2xl bg-white/10 text-xs font-bold text-yellow-300 flex items-center justify-between backdrop-blur-md">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-red-400 animate-pulse"></i>
                            <span>(0267) 861-5555</span>
                        </div>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-600 text-white font-bold">IGD 24 Jam</span>
                    </div>
                </div>

                <!-- COMBINED EMERGENCY BUTTONS IN SIDEBAR -->
                <div class="space-y-2.5 pt-2">
                    <a href="tel:02678615555" 
                       class="w-full py-3.5 px-4 rounded-xl bg-[#e31e24] hover:bg-red-700 text-white font-black text-xs transition-colors shadow flex items-center justify-center gap-2">
                        <i class="fa-solid fa-phone-volume text-sm animate-bounce"></i>
                        <span>{{ __('Telepon IGD Direct (0267) 861-5555') }}</span>
                    </a>

                    <a href="https://wa.me/6281234567890" target="_blank" 
                       class="w-full py-3 px-4 rounded-xl bg-yellow-400 hover:bg-yellow-300 text-slate-950 font-black text-xs transition-colors shadow flex items-center justify-center gap-2">
                        <i class="fa-brands fa-whatsapp text-base"></i>
                        <span>{{ __('WhatsApp Ambulans 24 Jam') }}</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- FULL-WIDTH SECTIONS BELOW (FULL CONTAINER SPAN FOR MAX SPACE & READABILITY) -->
    <div class="space-y-10 pt-2">

        <!-- FULL WIDE SECTION 1: FASILITAS & PENUNJANG IGD CARDS (4-COLS GRID) -->
        <div class="space-y-5">
            <div class="flex items-center gap-2">
                <span class="inline-block px-3 py-1 rounded-full bg-emerald-100 text-[#0e7c47] text-xs font-bold">Fasilitas Utama</span>
                <h3 class="text-xl font-extrabold text-gray-900">Fasilitas & Peralatan Medis IGD</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <div class="bg-white p-6 rounded-3xl shadow-sm space-y-3.5 hover:shadow-md transition-all border border-gray-100/50">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-base">Ruang Resusitasi & Triage</h4>
                    <p class="text-xs text-gray-600 leading-relaxed font-medium">
                        Bedside Monitor, Defibrillator, Syringe Pump, dan peralatan resusitasi jantung paru modern.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm space-y-3.5 hover:shadow-md transition-all border border-gray-100/50">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-truck-medical"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-base">Ambulans Emergency 24 Jam</h4>
                    <p class="text-xs text-gray-600 leading-relaxed font-medium">
                        Armada ambulans gawat darurat dilengkapi tabung oksigen, stretcher medis, & tim penjemputan.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm space-y-3.5 hover:shadow-md transition-all border border-gray-100/50">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-vial"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-base">Laboratorium & Radiologi 24 Jam</h4>
                    <p class="text-xs text-gray-600 leading-relaxed font-medium">
                        Pemeriksaan darah cito 24h, Rontgen Digital, dan CT-Scan untuk respon diagnostik instan.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm space-y-3.5 hover:shadow-md transition-all border border-gray-100/50">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-capsules"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-base">Farmasi 24 Jam & Ruang OK</h4>
                    <p class="text-xs text-gray-600 leading-relaxed font-medium">
                        Pengadaan obat-obatan gawat darurat 24 jam serta akses langsung ke Kamar Operasi (OK) cito.
                    </p>
                </div>

            </div>
        </div>

        <!-- FULL WIDE SECTION 2: GALERI FASILITAS IGD (4-COLS PHOTO GRID) -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm space-y-6">
            <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-images"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Galeri Fasilitas & Sarana IGD</h3>
                    <p class="text-xs text-gray-500 font-medium">Visualisasi ruangan medis & sarana penanganan darurat RSU Fikri Medika</p>
                </div>
            </div>

            <!-- PHOTO GRID 4 COLS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <div class="relative rounded-2xl overflow-hidden shadow-xs group h-52 border border-gray-100">
                    <img src="{{ asset('banner-igd.png') }}" alt="Area Penanganan IGD 24 Jam" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3 text-white">
                        <span class="text-[10px] font-extrabold px-2 py-0.5 rounded bg-[#0e7c47] uppercase tracking-wider mb-1 inline-block">Layanan 24h</span>
                        <h4 class="text-xs font-bold">Area Penanganan IGD</h4>
                    </div>
                </div>

                <div class="relative rounded-2xl overflow-hidden shadow-xs group h-52 border border-gray-100">
                    <img src="{{ asset('trauma-center.png') }}" alt="Unit Trauma Center" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3 text-white">
                        <span class="text-[10px] font-extrabold px-2 py-0.5 rounded bg-[#0e7c47] uppercase tracking-wider mb-1 inline-block">Trauma Center</span>
                        <h4 class="text-xs font-bold">Unit Penanganan Kecelakaan</h4>
                    </div>
                </div>

                <div class="relative rounded-2xl overflow-hidden shadow-xs group h-52 border border-gray-100">
                    <img src="{{ asset('gedung2_web.jpg') }}" alt="Gedung Utama RSU Fikri Medika" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3 text-white">
                        <span class="text-[10px] font-extrabold px-2 py-0.5 rounded bg-[#0e7c47] uppercase tracking-wider mb-1 inline-block">Akses Masuk</span>
                        <h4 class="text-xs font-bold">Gedung Utama IGD</h4>
                    </div>
                </div>

                <div class="relative rounded-2xl overflow-hidden shadow-xs group h-52 border border-gray-100">
                    <img src="{{ asset('antar-jemput.png') }}" alt="Ambulans Gawat Darurat" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3 text-white">
                        <span class="text-[10px] font-extrabold px-2 py-0.5 rounded bg-yellow-400 text-slate-950 uppercase tracking-wider mb-1 inline-block">Evakuasi</span>
                        <h4 class="text-xs font-bold">Armada Ambulans 24h</h4>
                    </div>
                </div>

            </div>
        </div>

        <!-- FULL WIDE SECTION 3: TRIAGE SYSTEM EDUCATIONAL CARD -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm space-y-6">
            <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Alur Sistem Triage Medis IGD</h3>
                    <p class="text-xs text-gray-500 font-medium">Prioritas penanganan medis berdasarkan tingkat kegawatan pasien</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <!-- KATEGORI MERAH -->
                <div class="p-5 rounded-2xl bg-red-50 space-y-2 border border-red-100">
                    <div class="flex items-center gap-2">
                        <span class="w-3.5 h-3.5 rounded-full bg-red-600 animate-pulse"></span>
                        <h4 class="font-extrabold text-red-900 text-sm">Prioritas 1 (Merah)</h4>
                    </div>
                    <p class="text-xs text-red-800 leading-relaxed font-medium">
                        <strong>Kondisi Kritis / Resusitasi:</strong> Penanganan instan tanpa penundaan (Gagal napas, henti jantung, pendarahan berat).
                    </p>
                </div>

                <!-- KATEGORI KUNING -->
                <div class="p-5 rounded-2xl bg-amber-50 space-y-2 border border-amber-100">
                    <div class="flex items-center gap-2">
                        <span class="w-3.5 h-3.5 rounded-full bg-amber-500"></span>
                        <h4 class="font-extrabold text-amber-900 text-sm">Prioritas 2 (Kuning)</h4>
                    </div>
                    <p class="text-xs text-amber-800 leading-relaxed font-medium">
                        <strong>Kondisi Gawat Tidak Darurat:</strong> Penanganan cepat (Nyeri hebat, patah tulang, sesak derajat sedang).
                    </p>
                </div>

                <!-- KATEGORI HIJAU -->
                <div class="p-5 rounded-2xl bg-emerald-50 space-y-2 border border-emerald-100">
                    <div class="flex items-center gap-2">
                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-600"></span>
                        <h4 class="font-extrabold text-emerald-900 text-sm">Prioritas 3 (Hijau)</h4>
                    </div>
                    <p class="text-xs text-emerald-800 leading-relaxed font-medium">
                        <strong>Kondisi Non-Urgent:</strong> Penanganan medis umum (Luka ringan, demam sedang, diare tanpa dehidrasi).
                    </p>
                </div>
            </div>
        </div>

        <!-- FULL WIDE SECTION 4: KAPAN HARUS SEGERA KE IGD? (INTERACTIVE ACCORDION CARDS NO BORDER) -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm space-y-6" x-data="{ activeEmergencyCard: null }">
            <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Kapan Harus Segera ke IGD?</h3>
                    <p class="text-xs text-gray-500 font-medium">Klik kartu kondisi darurat medis di bawah untuk melihat tanda bahaya & pertolongan pertama</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- 1. KECELAKAAN & CEDERA -->
                <div class="bg-slate-50/80 hover:bg-slate-100/90 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all cursor-pointer overflow-hidden space-y-2"
                     @click="activeEmergencyCard = (activeEmergencyCard === 1 ? null : 1)">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-base font-bold shrink-0">
                                <i class="fa-solid fa-car-burst"></i>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-gray-900 text-xs leading-tight">Kecelakaan & Cedera</h4>
                                <span class="text-[10px] font-bold text-rose-600 px-2 py-0.5 bg-rose-50 rounded-full inline-block mt-0.5">Darurat</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-slate-400"
                           :class="activeEmergencyCard === 1 ? 'rotate-180 text-rose-600' : ''"></i>
                    </div>

                    <div x-show="activeEmergencyCard === 1" x-transition class="pt-2 border-t border-slate-200/60 text-[11px] text-gray-600 leading-relaxed font-medium">
                        Benturan kepala keras, patah tulang terbuka/deformitas, muntah menyembur, atau trauma berat akibat kecelakaan lalu lintas.
                    </div>
                </div>

                <!-- 2. STROKE MEDIS -->
                <div class="bg-slate-50/80 hover:bg-slate-100/90 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all cursor-pointer overflow-hidden space-y-2"
                     @click="activeEmergencyCard = (activeEmergencyCard === 2 ? null : 2)">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-base font-bold shrink-0">
                                <i class="fa-solid fa-brain"></i>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-gray-900 text-xs leading-tight">Stroke Medis</h4>
                                <span class="text-[10px] font-bold text-red-600 px-2 py-0.5 bg-red-50 rounded-full inline-block mt-0.5">Kritis</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-slate-400"
                           :class="activeEmergencyCard === 2 ? 'rotate-180 text-red-600' : ''"></i>
                    </div>

                    <div x-show="activeEmergencyCard === 2" x-transition class="pt-2 border-t border-slate-200/60 text-[11px] text-gray-600 leading-relaxed font-medium">
                        Senyum miring mendadak (wajah pelo), kelemahan anggota gerak satu sisi tubuh, atau kehilangan kemampuan berbicara mendadak.
                    </div>
                </div>

                <!-- 3. SERANGAN JANTUNG -->
                <div class="bg-slate-50/80 hover:bg-slate-100/90 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all cursor-pointer overflow-hidden space-y-2"
                     @click="activeEmergencyCard = (activeEmergencyCard === 3 ? null : 3)">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-base font-bold shrink-0">
                                <i class="fa-solid fa-heart-pulse"></i>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-gray-900 text-xs leading-tight">Serangan Jantung</h4>
                                <span class="text-[10px] font-bold text-red-600 px-2 py-0.5 bg-red-50 rounded-full inline-block mt-0.5">Kritis</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-slate-400"
                           :class="activeEmergencyCard === 3 ? 'rotate-180 text-red-600' : ''"></i>
                    </div>

                    <div x-show="activeEmergencyCard === 3" x-transition class="pt-2 border-t border-slate-200/60 text-[11px] text-gray-600 leading-relaxed font-medium">
                        Nyeri dada tertindih beban berat >15 menit menjalar ke lengan/leher/rahang, disertai keringat dingin hebat & mual.
                    </div>
                </div>

                <!-- 4. SESAK NAPAS BERAT -->
                <div class="bg-slate-50/80 hover:bg-slate-100/90 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all cursor-pointer overflow-hidden space-y-2"
                     @click="activeEmergencyCard = (activeEmergencyCard === 4 ? null : 4)">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-base font-bold shrink-0">
                                <i class="fa-solid fa-lungs"></i>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-gray-900 text-xs leading-tight">Sesak Napas Berat</h4>
                                <span class="text-[10px] font-bold text-amber-600 px-2 py-0.5 bg-amber-50 rounded-full inline-block mt-0.5">Darurat</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-slate-400"
                           :class="activeEmergencyCard === 4 ? 'rotate-180 text-amber-600' : ''"></i>
                    </div>

                    <div x-show="activeEmergencyCard === 4" x-transition class="pt-2 border-t border-slate-200/60 text-[11px] text-gray-600 leading-relaxed font-medium">
                        Kesulitan bernapas parah, laju napas sangat cepat, bibir/kuku mulai kebiruan, atau tidak bisa mengucapkan satu kalimat utuh.
                    </div>
                </div>

                <!-- 5. PERDARAHAN HEBAT -->
                <div class="bg-slate-50/80 hover:bg-slate-100/90 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all cursor-pointer overflow-hidden space-y-2"
                     @click="activeEmergencyCard = (activeEmergencyCard === 5 ? null : 5)">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-base font-bold shrink-0">
                                <i class="fa-solid fa-droplet"></i>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-gray-900 text-xs leading-tight">Perdarahan Hebat</h4>
                                <span class="text-[10px] font-bold text-rose-600 px-2 py-0.5 bg-rose-50 rounded-full inline-block mt-0.5">Darurat</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-slate-400"
                           :class="activeEmergencyCard === 5 ? 'rotate-180 text-rose-600' : ''"></i>
                    </div>

                    <div x-show="activeEmergencyCard === 5" x-transition class="pt-2 border-t border-slate-200/60 text-[11px] text-gray-600 leading-relaxed font-medium">
                        Darah memancar deras atau tidak kunjung berhenti pasca-penekanan 10 menit, muntah darah, atau perdarahan aktif pemicu pusing berat.
                    </div>
                </div>

                <!-- 6. KEJANG & PINGSAN -->
                <div class="bg-slate-50/80 hover:bg-slate-100/90 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all cursor-pointer overflow-hidden space-y-2"
                     @click="activeEmergencyCard = (activeEmergencyCard === 6 ? null : 6)">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-base font-bold shrink-0">
                                <i class="fa-solid fa-user-slash"></i>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-gray-900 text-xs leading-tight">Kejang & Pingsan</h4>
                                <span class="text-[10px] font-bold text-red-600 px-2 py-0.5 bg-red-50 rounded-full inline-block mt-0.5">Kritis</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-slate-400"
                           :class="activeEmergencyCard === 6 ? 'rotate-180 text-red-600' : ''"></i>
                    </div>

                    <div x-show="activeEmergencyCard === 6" x-transition class="pt-2 border-t border-slate-200/60 text-[11px] text-gray-600 leading-relaxed font-medium">
                        Pingsan lama tanpa respons panggilan, kejang berulang >5 menit, tidak sadarkan diri, atau kebingungan berat pasca-trauma.
                    </div>
                </div>

                <!-- 7. KERACUNAN MEDIS -->
                <div class="bg-slate-50/80 hover:bg-slate-100/90 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all cursor-pointer overflow-hidden space-y-2"
                     @click="activeEmergencyCard = (activeEmergencyCard === 7 ? null : 7)">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-base font-bold shrink-0">
                                <i class="fa-solid fa-vial-virus"></i>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-gray-900 text-xs leading-tight">Keracunan Medis</h4>
                                <span class="text-[10px] font-bold text-amber-600 px-2 py-0.5 bg-amber-50 rounded-full inline-block mt-0.5">Darurat</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-slate-400"
                           :class="activeEmergencyCard === 7 ? 'rotate-180 text-amber-600' : ''"></i>
                    </div>

                    <div x-show="activeEmergencyCard === 7" x-transition class="pt-2 border-t border-slate-200/60 text-[11px] text-gray-600 leading-relaxed font-medium">
                        Tertelan bahan kimia berbahaya, racun serangga/obat berlebih, muntah berulang hebat, atau penurunan kesadaran akibat racun.
                    </div>
                </div>

                <!-- 8. LUKA BAKAR LUAS -->
                <div class="bg-slate-50/80 hover:bg-slate-100/90 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all cursor-pointer overflow-hidden space-y-2"
                     @click="activeEmergencyCard = (activeEmergencyCard === 8 ? null : 8)">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-base font-bold shrink-0">
                                <i class="fa-solid fa-fire-flame-curved"></i>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-gray-900 text-xs leading-tight">Luka Bakar Luas</h4>
                                <span class="text-[10px] font-bold text-rose-600 px-2 py-0.5 bg-rose-50 rounded-full inline-block mt-0.5">Darurat</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-slate-400"
                           :class="activeEmergencyCard === 8 ? 'rotate-180 text-rose-600' : ''"></i>
                    </div>

                    <div x-show="activeEmergencyCard === 8" x-transition class="pt-2 border-t border-slate-200/60 text-[11px] text-gray-600 leading-relaxed font-medium">
                        Luka bakar akibat api/bahan kimia luas, mengenai area wajah/jalan napas, atau sengatan listrik tegangan tinggi.
                    </div>
                </div>

            </div>
        </div>

        <!-- FULL WIDE SECTION 5: FAQ ACCORDION -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm space-y-6" x-data="{ activeFaq: null }">
            <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-circle-question"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Pertanyaan Umum (FAQ) IGD</h3>
                    <p class="text-xs text-gray-500 font-medium">Informasi seputar pelayanan emergency, BPJS Kesehatan, & ambulans</p>
                </div>
            </div>

            <div class="space-y-3">
                <!-- FAQ 1 -->
                <div class="rounded-2xl bg-gray-50/70 overflow-hidden">
                    <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full p-4.5 text-left font-bold text-gray-900 text-xs sm:text-sm flex items-center justify-between gap-4 hover:text-[#0e7c47] transition-colors">
                        <span>Apakah IGD RSU Fikri Medika melayani pasien BPJS Kesehatan?</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform text-gray-400" :class="activeFaq === 1 ? 'rotate-180 text-[#0e7c47]' : ''"></i>
                    </button>
                    <div x-show="activeFaq === 1" x-transition class="p-4.5 pt-0 text-xs text-gray-600 leading-relaxed font-medium">
                        Ya, untuk kondisi gawat darurat (emergency), pasien BPJS Kesehatan dapat langsung berobat ke IGD RSU Fikri Medika Karawang tanpa memerlukan Surat Rujukan dari Faskes 1 (Puskesmas/Klinik).
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="rounded-2xl bg-gray-50/70 overflow-hidden">
                    <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full p-4.5 text-left font-bold text-gray-900 text-xs sm:text-sm flex items-center justify-between gap-4 hover:text-[#0e7c47] transition-colors">
                        <span>Dokumen apa saja yang perlu dibawa saat ke IGD?</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform text-gray-400" :class="activeFaq === 2 ? 'rotate-180 text-[#0e7c47]' : ''"></i>
                    </button>
                    <div x-show="activeFaq === 2" x-transition class="p-4.5 pt-0 text-xs text-gray-600 leading-relaxed font-medium">
                        Prioritas utama IGD adalah pertolongan medis pasien. Namun jika memungkinkan, siapkan KTP/Kartu Keluarga dan Kartu BPJS/Asuransi kesehatan pasien.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="rounded-2xl bg-gray-50/70 overflow-hidden">
                    <button @click="activeFaq = (activeFaq === 3 ? null : 3)" class="w-full p-4.5 text-left font-bold text-gray-900 text-xs sm:text-sm flex items-center justify-between gap-4 hover:text-[#0e7c47] transition-colors">
                        <span>Bagaimana cara memesan Ambulans IGD RSU Fikri Medika?</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform text-gray-400" :class="activeFaq === 3 ? 'rotate-180 text-[#0e7c47]' : ''"></i>
                    </button>
                    <div x-show="activeFaq === 3" x-transition class="p-4.5 pt-0 text-xs text-gray-600 leading-relaxed font-medium">
                        Anda dapat langsung menghubungi hotline IGD di (0267) 861-5555 atau melalui WhatsApp Ambulans 24 Jam di nomor 0812-3456-7890.
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>

@endsection
