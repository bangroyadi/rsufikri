@extends('layouts.app')

@section('content')

<!-- HERO SECTION -->
<section class="relative bg-gradient-to-r from-[#0e7c47] via-[#096237] to-[#0e7c47] text-white overflow-hidden py-16 lg:py-24">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#f8ec1d_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-emerald-500/20 blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- LEFT HERO TEXT -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-yellow-400/20 border border-yellow-400/40 text-yellow-300 text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-star text-yellow-300"></i>
                    <span>{{ __('Pelayanan Kesehatan Islami & Modern') }}</span>
                </div>
                
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight text-white">
                    {{ $banners->first()?->tr('title') }}
                </h1>
                
                <p class="text-base sm:text-lg text-emerald-100/90 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                    {{ $banners->first()?->tr('subtitle') }}
                </p>
                
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="#jadwal-dokter" class="w-full sm:w-auto px-6 py-3.5 rounded-xl font-bold bg-yellow-400 text-gray-900 hover:bg-yellow-300 shadow-lg shadow-yellow-400/20 transition-all flex items-center justify-center gap-2 text-sm">
                        <i class="fa-regular fa-calendar-check text-base"></i>
                        <span>{{ __('Lihat Jadwal Dokter') }}</span>
                    </a>
                    <a href="#kontak" class="w-full sm:w-auto px-6 py-3.5 rounded-xl font-bold bg-[#e31e24] hover:bg-red-700 text-white shadow-lg shadow-red-900/30 transition-all flex items-center justify-center gap-2 text-sm">
                        <i class="fa-solid fa-hospital-user text-base"></i>
                        <span>{{ __('Daftar / Buat Janji') }}</span>
                    </a>
                </div>

                <!-- KEY HIGHLIGHT BADGES -->
                <div class="pt-6 grid grid-cols-3 gap-4 border-t border-emerald-600/50 max-w-xl mx-auto lg:mx-0">
                    <div class="text-center lg:text-left">
                        <div class="text-xl sm:text-2xl font-extrabold text-yellow-300">24/7</div>
                        <div class="text-xs text-gray-200 font-medium">{{ __('IGD & Ambulans') }}</div>
                    </div>
                    <div class="text-center lg:text-left">
                        <div class="text-xl sm:text-2xl font-extrabold text-yellow-300">15+</div>
                        <div class="text-xs text-gray-200 font-medium">{{ __('Dokter Spesialis') }}</div>
                    </div>
                    <div class="text-center lg:text-left">
                        <div class="text-xl sm:text-2xl font-extrabold text-yellow-300">100%</div>
                        <div class="text-xs text-gray-200 font-medium">{{ __('Pelayanan Islami') }}</div>
                    </div>
                </div>
            </div>

            <!-- RIGHT HERO VISUAL -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <div class="rounded-3xl overflow-hidden shadow-2xl border-4 border-white/20 transform lg:rotate-1 hover:rotate-0 transition-transform duration-500 bg-white p-2">
                        <img src="{{ $banners->first()?->image ?? 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1200&q=80' }}" 
                             alt="RSU Fikri Medika" 
                             class="w-full h-80 lg:h-[390px] object-cover rounded-2xl"
                             loading="lazy">
                    </div>
                    <!-- Floating emergency highlight card -->
                    <div class="absolute -bottom-6 -left-6 bg-white text-gray-900 p-4 rounded-2xl shadow-xl border border-emerald-100 hidden sm:flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-truck-medical animate-bounce"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider">{{ __('IGD Siaga') }}</div>
                            <div class="text-sm font-extrabold text-[#0e7c47]">(0267) 8454999</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- QUICK INFO ACTION BAR -->
<section class="relative -mt-8 z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
        
        <a href="#jadwal-dokter" class="group p-4 rounded-xl hover:bg-emerald-50/80 transition-colors flex flex-col items-center gap-2">
            <div class="w-12 h-12 rounded-full bg-emerald-100 text-[#0e7c47] flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                <i class="fa-regular fa-calendar-days"></i>
            </div>
            <span class="text-xs sm:text-sm font-bold text-gray-800 group-hover:text-[#0e7c47]">{{ __('Jadwal Dokter') }}</span>
        </a>

        <a href="#layanan" class="group p-4 rounded-xl hover:bg-emerald-50/80 transition-colors flex flex-col items-center gap-2">
            <div class="w-12 h-12 rounded-full bg-emerald-100 text-[#0e7c47] flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-notes-medical"></i>
            </div>
            <span class="text-xs sm:text-sm font-bold text-gray-800 group-hover:text-[#0e7c47]">{{ __('Layanan RS') }}</span>
        </a>

        <a href="#kontak" class="group p-4 rounded-xl hover:bg-emerald-50/80 transition-colors flex flex-col items-center gap-2">
            <div class="w-12 h-12 rounded-full bg-emerald-100 text-[#0e7c47] flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-clipboard-user"></i>
            </div>
            <span class="text-xs sm:text-sm font-bold text-gray-800 group-hover:text-[#0e7c47]">{{ __('Pendaftaran') }}</span>
        </a>

        <a href="#kontak" class="group p-4 rounded-xl hover:bg-red-50 transition-colors flex flex-col items-center gap-2">
            <div class="w-12 h-12 rounded-full bg-red-100 text-[#e31e24] flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-kit-medical"></i>
            </div>
            <span class="text-xs sm:text-sm font-bold text-red-600">{{ __('IGD 24 Jam') }}</span>
        </a>

        <a href="#kontak" class="group p-4 rounded-xl hover:bg-emerald-50/80 transition-colors flex flex-col items-center gap-2 col-span-2 md:col-span-1">
            <div class="w-12 h-12 rounded-full bg-emerald-100 text-[#0e7c47] flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-headset"></i>
            </div>
            <span class="text-xs sm:text-sm font-bold text-gray-800 group-hover:text-[#0e7c47]">{{ __('Kontak RS') }}</span>
        </a>

    </div>
</section>

<!-- SECTION: TENTANG RSU FIKRI MEDIKA -->
<section id="profil" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- LEFT IMAGE -->
            <div class="lg:col-span-5 relative">
                <div class="relative rounded-2xl overflow-hidden shadow-lg border border-gray-100">
                    <img src="https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=800&q=80" 
                         alt="Gedung RSU Fikri Medika" 
                         class="w-full h-[420px] object-cover"
                         loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0e7c47]/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-white">
                        <div class="font-bold text-lg">RSU Fikri Medika</div>
                        <div class="text-xs text-yellow-300">Jl. Raya Kosambi - Telagasari No. 9, Klari, Karawang</div>
                    </div>
                </div>
            </div>

            <!-- RIGHT CONTENT -->
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-[#0e7c47] text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-hospital-user"></i>
                    <span>{{ __('Tentang Kami') }}</span>
                </div>

                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0e7c47] tracking-tight">
                    {{ __('Rumah Sakit Umum Terpercaya Berorientasi Islami & Modern') }}
                </h2>

                <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                    {{ $profile?->tr('about') }}
                </p>

                <!-- VISION & MISSION TABS -->
                <div x-data="{ activeTab: 'vision' }" class="bg-[#f7faf8] rounded-xl p-5 border border-emerald-100 space-y-4">
                    <div class="flex gap-2 border-b border-gray-200 pb-3">
                        <button @click="activeTab = 'vision'" 
                                :class="activeTab === 'vision' ? 'bg-[#0e7c47] text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-gray-100'"
                                class="px-4 py-2 rounded-lg text-xs font-bold transition-all">
                            <i class="fa-solid fa-eye mr-1.5"></i> {{ __('Visi') }}
                        </button>
                        <button @click="activeTab = 'mission'" 
                                :class="activeTab === 'mission' ? 'bg-[#0e7c47] text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-gray-100'"
                                class="px-4 py-2 rounded-lg text-xs font-bold transition-all">
                            <i class="fa-solid fa-bullseye mr-1.5"></i> {{ __('Misi') }}
                        </button>
                        <button @click="activeTab = 'values'" 
                                :class="activeTab === 'values' ? 'bg-[#0e7c47] text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-gray-100'"
                                class="px-4 py-2 rounded-lg text-xs font-bold transition-all">
                            <i class="fa-solid fa-gem mr-1.5"></i> {{ __('Nilai Kami') }}
                        </button>
                    </div>

                    <div x-show="activeTab === 'vision'" class="text-sm text-gray-700 font-medium leading-relaxed">
                        {{ $profile?->tr('vision') }}
                    </div>

                    <div x-show="activeTab === 'mission'" class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                        {{ $profile?->tr('mission') }}
                    </div>

                    <div x-show="activeTab === 'values'" class="text-sm text-gray-700 font-semibold text-[#0e7c47]">
                        {{ $profile?->tr('values') }}
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- SECTION: LAYANAN UNGGULAN -->
<section id="layanan" class="py-20 bg-[#f7faf8] border-t border-b border-gray-100">
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
</section>

<!-- SECTION: JADWAL DOKTER WITH PAGINATED TABLE DESIGN -->
<section id="jadwal-dokter" class="py-20 bg-white" x-data="{
    searchName: '',
    selectedPoli: '',
    selectedDay: '',
    currentPage: 1,
    perPage: 10,
    doctorsData: [
        @foreach($doctors as $doc)
        {
            id: {{ $doc->id }},
            name: '{{ addslashes($doc->name) }}',
            poliId: {{ $doc->polyclinic_id }},
            days: [ @foreach($doc->schedules as $s)'{{ $s->day }}', @endforeach ]
        },
        @endforeach
    ],
    get filteredDoctors() {
        return this.doctorsData.filter(d => {
            let matchN = !this.searchName || d.name.toLowerCase().includes(this.searchName.toLowerCase());
            let matchP = !this.selectedPoli || d.poliId == this.selectedPoli;
            let matchD = !this.selectedDay || d.days.includes(this.selectedDay);
            return matchN && matchP && matchD;
        });
    },
    get totalPages() {
        return Math.ceil(this.filteredDoctors.length / this.perPage) || 1;
    },
    isDoctorVisible(docId) {
        let index = this.filteredDoctors.findIndex(d => d.id === docId);
        if (index === -1) return false;
        let page = Math.floor(index / this.perPage) + 1;
        return page === this.currentPage;
    },
    goToPage(p) {
        if (p >= 1 && p <= this.totalPages) {
            this.currentPage = p;
        }
    }
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-[#0e7c47] text-xs font-bold uppercase tracking-wider mb-3">
                <i class="fa-regular fa-calendar-check"></i>
                <span>{{ __('Tim Medis Kami') }}</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0e7c47] tracking-tight">
                {{ __('Jadwal Dokter') }} {{ __('& Praktik Poliklinik') }}
            </h2>
            <p class="text-gray-600 text-sm sm:text-base mt-2">
                {{ __('Temukan dokter spesialis pilihan Anda dan periksa jadwal praktik harian di RSU Fikri Medika.') }}
            </p>
        </div>

        <!-- SEARCH & FILTER BAR -->
        <div class="bg-[#f7faf8] p-6 rounded-2xl border border-emerald-100 shadow-sm mb-10 grid grid-cols-1 sm:grid-cols-3 gap-4">
            
            <!-- SEARCH BY NAME -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">{{ __('Cari Nama Dokter') }}</label>
                <div class="relative">
                    <input type="text" 
                           x-model="searchName" 
                           @input="currentPage = 1"
                           placeholder="{{ __('Ketik nama dokter...') }}" 
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] focus:border-[#0e7c47] outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-gray-400 text-xs"></i>
                </div>
            </div>

            <!-- FILTER BY POLICLINIC -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">{{ __('Pilih Poliklinik') }}</label>
                <select x-model="selectedPoli" @change="currentPage = 1" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] focus:border-[#0e7c47] outline-none bg-white">
                    <option value="">-- {{ __('Semua Poli') }} --</option>
                    @foreach($polyclinics as $poli)
                        <option value="{{ $poli->id }}">{{ $poli->tr('name') }}</option>
                    @endforeach
                </select>
            </div>

            <!-- FILTER BY DAY -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">{{ __('Pilih Hari Praktik') }}</label>
                <select x-model="selectedDay" @change="currentPage = 1" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] focus:border-[#0e7c47] outline-none bg-white">
                    <option value="">-- {{ __('Semua Hari') }} --</option>
                    <option value="Senin">{{ __('Senin') }}</option>
                    <option value="Selasa">{{ __('Selasa') }}</option>
                    <option value="Rabu">{{ __('Rabu') }}</option>
                    <option value="Kamis">{{ __('Kamis') }}</option>
                    <option value="Jumat">{{ __('Jumat') }}</option>
                    <option value="Sabtu">{{ __('Sabtu') }}</option>
                    <option value="Minggu">{{ __('Minggu') }}</option>
                </select>
            </div>

        </div>

        <!-- DOCTORS SCHEDULE LIST (REVISED DESIGN MATCHING ATTACHED IMAGE) -->
        <div class="space-y-10 min-h-[500px]">
            @foreach($doctors as $doc)
            @php
                $dayMap = [
                    'Senin' => [],
                    'Selasa' => [],
                    'Rabu' => [],
                    'Kamis' => [],
                    'Jumat' => [],
                    'Sabtu' => [],
                    'Minggu' => []
                ];
                foreach($doc->schedules as $sched) {
                    if (isset($dayMap[$sched->day])) {
                        $dayMap[$sched->day][] = \Carbon\Carbon::parse($sched->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($sched->end_time)->format('H:i');
                    }
                }
            @endphp
            <div x-show="isDoctorVisible({{ $doc->id }})" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="space-y-4 pb-8 mb-4 border-b-2 border-yellow-400 last:border-b-0">
                
                <!-- POLYCLINIC / SPECIALTY TITLE (GREEN SUBHEADING) -->
                <div class="flex items-center gap-2 border-b-2 border-gray-100 pb-2">
                    <h4 class="text-base sm:text-lg font-extrabold text-[#0e7c47] tracking-tight">
                        {{ $doc->polyclinic?->tr('name') }}
                    </h4>
                </div>

                <!-- DOCTOR ROW ITEM -->
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6 pt-2">
                    
                    <!-- CIRCULAR DOCTOR PHOTO -->
                    <div class="flex-shrink-0 mx-auto md:mx-0">
                        <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full overflow-hidden border-4 border-emerald-600 p-1 bg-white shadow-md">
                            <img src="{{ $doc->photo ?? 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=400&q=80' }}" 
                                 alt="{{ $doc->name }}" 
                                 class="w-full h-full rounded-full object-cover"
                                 loading="lazy">
                        </div>
                    </div>

                    <!-- DOCTOR INFO & WEEKLY SCHEDULE TABLE -->
                    <div class="flex-grow w-full space-y-3">
                        
                        <!-- DOCTOR NAME & SUBTITLE & APPOINTMENT BUTTON -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <h3 class="text-base sm:text-lg font-extrabold text-gray-900 leading-snug">
                                    {{ $doc->name }}, {{ $doc->title_degree }}
                                </h3>
                                <div class="text-xs text-gray-500 font-semibold mt-0.5">
                                    RSU Fikri Medika Karawang <span class="text-gray-300">|</span> <span class="text-[#0e7c47]">{{ $doc->tr('specialty') }}</span>
                                </div>
                            </div>

                            <a href="#kontak" class="inline-flex items-center justify-center gap-2 px-5 py-2 rounded-lg bg-[#0e7c47] hover:bg-[#096237] text-white text-xs font-extrabold uppercase tracking-wider shadow-sm transition-all self-start sm:self-auto">
                                <i class="fa-solid fa-calendar-check"></i>
                                <span>APPOINTMENT</span>
                            </a>
                        </div>

                        <!-- SIMPLE & CLEAN JADWAL BADGES (ONLY ACTIVE DAYS) -->
                        <div class="pt-1">
                            <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <i class="fa-regular fa-clock text-[#0e7c47]"></i>
                                <span>{{ __('Jadwal Praktik Harian') }}:</span>
                            </div>
                            <div class="flex flex-wrap items-center gap-2.5">
                                @php $hasAnySched = false; @endphp
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $dayKey)
                                    @if(!empty($dayMap[$dayKey]))
                                        @php $hasAnySched = true; @endphp
                                        @foreach($dayMap[$dayKey] as $timeSlot)
                                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-emerald-50/80 border border-emerald-200/80 text-xs shadow-2xs">
                                                <span class="font-extrabold uppercase tracking-wide text-[#0e7c47]">{{ __($dayKey) }}</span>
                                                <span class="text-emerald-300 font-bold">•</span>
                                                <span class="font-semibold text-gray-700">{{ $timeSlot }}</span>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                                @if(!$hasAnySched)
                                    <span class="text-xs text-gray-400 font-medium italic">{{ __('Tidak ada jadwal harian') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            @endforeach

            <!-- NO RESULTS NOTIFICATION -->
            <div x-show="filteredDoctors.length === 0" class="text-center py-16 text-gray-500 font-medium">
                <i class="fa-solid fa-user-doctor text-4xl text-gray-300 mb-3 block"></i>
                <div>{{ __('Jadwal belum tersedia') }}</div>
            </div>
        </div>

        <!-- PAGINATION CONTROLS (10 DOCTORS PER PAGE, MATCHING IMAGE CIRCULAR NUMBERS) -->
        <div x-show="totalPages > 1" class="mt-12 flex items-center justify-center gap-2">
            
            <!-- PREVIOUS BUTTON -->
            <button @click="goToPage(currentPage - 1)" 
                    :disabled="currentPage === 1" 
                    :class="currentPage === 1 ? 'opacity-40 cursor-not-allowed text-gray-400 bg-gray-100' : 'text-gray-700 bg-white hover:bg-[#0e7c47] hover:text-white border border-gray-200 shadow-sm'"
                    class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all">
                <i class="fa-solid fa-chevron-left text-xs"></i>
            </button>

            <!-- PAGE NUMBER BUTTONS -->
            <template x-for="p in totalPages" :key="p">
                <button @click="goToPage(p)" 
                        :class="currentPage === p ? 'bg-[#0e7c47] text-white font-extrabold shadow-md scale-105' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200 shadow-xs'"
                        class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all"
                        x-text="p">
                </button>
            </template>

            <!-- NEXT BUTTON -->
            <button @click="goToPage(currentPage + 1)" 
                    :disabled="currentPage === totalPages" 
                    :class="currentPage === totalPages ? 'opacity-40 cursor-not-allowed text-gray-400 bg-gray-100' : 'text-gray-700 bg-white hover:bg-[#0e7c47] hover:text-white border border-gray-200 shadow-sm'"
                    class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all">
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </button>

        </div>

    </div>
</section>

<!-- SECTION: BERITA & ARTIKEL KESEHATAN -->
<section id="berita" class="py-20 bg-[#f7faf8] border-t border-gray-100">
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
