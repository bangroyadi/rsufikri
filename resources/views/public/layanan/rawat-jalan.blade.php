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

        <!-- FULL WIDE SECTION 1: DAFTAR POLIKLINIK SPESIALIS (CIRCULAR CARDS WITH 3 DEFAULT SHOW & ALPINE SHOW ALL TOGGLE) -->
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

            <!-- CIRCULAR LOGO GRID (DEFAULT 3 ITEMS, SHOW ALL TOGGLE VIA ALPINE) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 py-2" :class="showAllPoli ? 'lg:grid-cols-6' : 'lg:grid-cols-3'">
                @if(isset($polyclinics) && count($polyclinics) > 0)
                    @foreach($polyclinics as $index => $poli)
                        @php
                            $poliName = is_array($poli->name) ? ($poli->name[app()->getLocale()] ?? $poli->name['id'] ?? '') : $poli->name;
                            $poliDesc = is_array($poli->description) ? ($poli->description[app()->getLocale()] ?? $poli->description['id'] ?? '') : $poli->description;
                            
                            $nameLower = strtolower($poliName);
                            $iconClass = 'fa-solid fa-stethoscope';

                            if (str_contains($nameLower, 'saraf') || str_contains($nameLower, 'neurologi')) {
                                $iconClass = 'fa-solid fa-brain';
                            } elseif (str_contains($nameLower, 'plastik')) {
                                $iconClass = 'fa-solid fa-wand-magic-sparkles';
                            } elseif (str_contains($nameLower, 'jantung') || str_contains($nameLower, 'kardiologi')) {
                                $iconClass = 'fa-solid fa-heart-pulse';
                            } elseif (str_contains($nameLower, 'anak') || str_contains($nameLower, 'pediatri')) {
                                $iconClass = 'fa-solid fa-baby';
                            } elseif (str_contains($nameLower, 'mata')) {
                                $iconClass = 'fa-solid fa-eye';
                            } elseif (str_contains($nameLower, 'toraks')) {
                                $iconClass = 'fa-solid fa-ribbon';
                            } elseif (str_contains($nameLower, 'paru') || str_contains($nameLower, 'pulmonologi')) {
                                $iconClass = 'fa-solid fa-lungs';
                            } elseif (str_contains($nameLower, 'kebidanan') || str_contains($nameLower, 'kandungan') || str_contains($nameLower, 'obgyn')) {
                                $iconClass = 'fa-solid fa-person-pregnant';
                            } elseif (str_contains($nameLower, 'jiwa') || str_contains($nameLower, 'psikiatri')) {
                                $iconClass = 'fa-solid fa-head-side-virus';
                            } elseif (str_contains($nameLower, 'gigi')) {
                                $iconClass = 'fa-solid fa-tooth';
                            } elseif (str_contains($nameLower, 'tht')) {
                                $iconClass = 'fa-solid fa-ear-listen';
                            } elseif (str_contains($nameLower, 'bedah')) {
                                $iconClass = 'fa-solid fa-kit-medical';
                            } elseif (!empty($poli->icon)) {
                                $iconClass = str_starts_with($poli->icon, 'fa-') ? $poli->icon : 'fa-solid fa-' . $poli->icon;
                            }
                        @endphp

                        <div x-show="showAllPoli || {{ $index }} < 3" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="flex flex-col items-center text-center group cursor-pointer"
                             @click="openPoliMenu('{{ addslashes($poliName) }}', '{{ addslashes($poliDesc) }}', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-3xl sm:text-4xl font-bold group-hover:bg-[#0e7c47] group-hover:text-white group-hover:scale-110 transition-all duration-300 shadow-md group-hover:shadow-xl ring-4 ring-emerald-500/10 group-hover:ring-[#0e7c47]/30">
                                <i class="{{ $iconClass }}"></i>
                            </div>
                            <h4 class="font-extrabold text-gray-900 text-xs sm:text-sm mt-3 leading-tight group-hover:text-[#0e7c47] transition-colors">
                                {{ $poliName }}
                            </h4>
                        </div>
                    @endforeach
                @else
                    <!-- FALLBACK STATIC ITEMS WITH 3 DEFAULT SHOW -->
                    <div x-show="true" class="flex flex-col items-center text-center group cursor-pointer" @click="openPoliMenu('Jantung dan Pembuluh Darah', 'Poli Spesialis Jantung & Pembuluh Darah (Kardiologi)', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-3xl sm:text-4xl font-bold group-hover:bg-[#0e7c47] group-hover:text-white group-hover:scale-110 transition-all duration-300 shadow-md group-hover:shadow-xl ring-4 ring-emerald-500/10 group-hover:ring-[#0e7c47]/30">
                            <i class="fa-solid fa-heart-pulse"></i>
                        </div>
                        <h4 class="font-extrabold text-gray-900 text-xs sm:text-sm mt-3 leading-tight group-hover:text-[#0e7c47] transition-colors">Jantung dan Pembuluh Darah</h4>
                    </div>

                    <div x-show="true" class="flex flex-col items-center text-center group cursor-pointer" @click="openPoliMenu('Anak', 'Poli Spesialis Kesehatan Anak & Tumbuh Kembang', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('trauma-center.png') }}'])">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-3xl sm:text-4xl font-bold group-hover:bg-[#0e7c47] group-hover:text-white group-hover:scale-110 transition-all duration-300 shadow-md group-hover:shadow-xl ring-4 ring-emerald-500/10 group-hover:ring-[#0e7c47]/30">
                            <i class="fa-solid fa-baby"></i>
                        </div>
                        <h4 class="font-extrabold text-gray-900 text-xs sm:text-sm mt-3 leading-tight group-hover:text-[#0e7c47] transition-colors">Anak</h4>
                    </div>

                    <div x-show="true" class="flex flex-col items-center text-center group cursor-pointer" @click="openPoliMenu('Mata', 'Poli Spesialis Mata & Refraksi Katarak', ['{{ asset('spesialis-mata.png') }}', '{{ asset('gedung1_web.jpg') }}'])">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-3xl sm:text-4xl font-bold group-hover:bg-[#0e7c47] group-hover:text-white group-hover:scale-110 transition-all duration-300 shadow-md group-hover:shadow-xl ring-4 ring-emerald-500/10 group-hover:ring-[#0e7c47]/30">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <h4 class="font-extrabold text-gray-900 text-xs sm:text-sm mt-3 leading-tight group-hover:text-[#0e7c47] transition-colors">Mata</h4>
                    </div>

                    <div x-show="showAllPoli" x-transition class="flex flex-col items-center text-center group cursor-pointer" @click="openPoliMenu('Bedah Toraks Kardiovaskuler', 'Poli Spesialis Bedah Dada & Kardiovaskuler', ['{{ asset('trauma-center.png') }}', '{{ asset('gedung2_web.jpg') }}'])">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-3xl sm:text-4xl font-bold group-hover:bg-[#0e7c47] group-hover:text-white group-hover:scale-110 transition-all duration-300 shadow-md group-hover:shadow-xl ring-4 ring-emerald-500/10 group-hover:ring-[#0e7c47]/30">
                            <i class="fa-solid fa-ribbon"></i>
                        </div>
                        <h4 class="font-extrabold text-gray-900 text-xs sm:text-sm mt-3 leading-tight group-hover:text-[#0e7c47] transition-colors">Bedah Toraks Kardiovaskuler</h4>
                    </div>

                    <div x-show="showAllPoli" x-transition class="flex flex-col items-center text-center group cursor-pointer" @click="openPoliMenu('Paru', 'Poli Spesialis Paru & Pulmonologi', ['{{ asset('gedung1_web.jpg') }}', '{{ asset('banner-igd.png') }}'])">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-3xl sm:text-4xl font-bold group-hover:bg-[#0e7c47] group-hover:text-white group-hover:scale-110 transition-all duration-300 shadow-md group-hover:shadow-xl ring-4 ring-emerald-500/10 group-hover:ring-[#0e7c47]/30">
                            <i class="fa-solid fa-lungs"></i>
                        </div>
                        <h4 class="font-extrabold text-gray-900 text-xs sm:text-sm mt-3 leading-tight group-hover:text-[#0e7c47] transition-colors">Paru</h4>
                    </div>

                    <div x-show="showAllPoli" x-transition class="flex flex-col items-center text-center group cursor-pointer" @click="openPoliMenu('Bedah Umum', 'Poli Spesialis Bedah Umum & Perawatan Luka Operasi', ['{{ asset('trauma-center.png') }}', '{{ asset('gedung2_web.jpg') }}'])">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-3xl sm:text-4xl font-bold group-hover:bg-[#0e7c47] group-hover:text-white group-hover:scale-110 transition-all duration-300 shadow-md group-hover:shadow-xl ring-4 ring-emerald-500/10 group-hover:ring-[#0e7c47]/30">
                            <i class="fa-solid fa-kit-medical"></i>
                        </div>
                        <h4 class="font-extrabold text-gray-900 text-xs sm:text-sm mt-3 leading-tight group-hover:text-[#0e7c47] transition-colors">Bedah Umum</h4>
                    </div>
                @endif
            </div>

            <!-- BUTTON LIHAT SEMUA POLIKLINIK / SEMBUNYIKAN -->
            <div class="pt-4 text-center border-t border-gray-100">
                <button @click="showAllPoli = !showAllPoli" 
                        class="inline-flex items-center gap-2.5 px-6 py-3 rounded-2xl bg-emerald-50 hover:bg-[#0e7c47] text-[#0e7c47] hover:text-white font-extrabold text-xs sm:text-sm transition-all shadow-xs active:scale-98">
                    <span x-text="showAllPoli ? 'Sembunyikan Poliklinik' : 'Lihat Semua Poliklinik Spesialis'"></span>
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
