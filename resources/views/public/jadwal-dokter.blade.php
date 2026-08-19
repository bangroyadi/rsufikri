@extends('layouts.app')

@section('content')

@php
    $initPoliId = request()->get('poli') ?? '';
    $initPoliName = '-- ' . __('Semua Poli') . ' --';
    if ($initPoliId && isset($polyclinics)) {
        $matched = $polyclinics->firstWhere('id', $initPoliId);
        if ($matched) {
            $initPoliName = is_array($matched->name) ? ($matched->name[app()->getLocale()] ?? $matched->name['id'] ?? '') : $matched->name;
        }
    } elseif (request()->get('spesialis') && isset($polyclinics)) {
        $spesParam = strtolower(request()->get('spesialis'));
        $matched = $polyclinics->first(function($p) use ($spesParam) {
            $nameStr = is_array($p->name) ? ($p->name['id'] ?? '') : $p->name;
            return str_contains(strtolower($nameStr), $spesParam) || str_contains(strtolower($p->slug), $spesParam);
        });
        if ($matched) {
            $initPoliId = $matched->id;
            $initPoliName = is_array($matched->name) ? ($matched->name[app()->getLocale()] ?? $matched->name['id'] ?? '') : $matched->name;
        }
    }
    $initDay = request()->get('hari') ?? '';
    $initDayName = $initDay ? $initDay : '-- ' . __('Semua Hari') . ' --';
@endphp

<!-- MAIN CONTENT & INTERACTIVE PAGINATED TABLE (MATCHING DATABASE STRUCTURE) -->
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto" x-data="{
    searchName: '{{ request()->get('q') }}',
    selectedPoli: '{{ $initPoliId }}',
    selectedPoliName: '{{ addslashes($initPoliName) }}',
    selectedDay: '{{ $initDay }}',
    selectedDayName: '{{ addslashes($initDayName) }}',
    poliDropdownOpen: false,
    poliSearchQuery: '',
    dayDropdownOpen: false,
    currentPage: 1,
    perPage: 10,
    doctorsData: [
        @foreach($doctors as $doc)
        {
            id: {{ $doc->id }},
            name: '{{ addslashes($doc->name) }}',
            poliId: {{ $doc->polyclinic_id ?? 0 }},
            days: [ @foreach($doc->schedules as $s)'{{ addslashes($s->day) }}', @endforeach ]
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

    <!-- SEARCH & FILTER BAR -->
    <div class="bg-white p-6 rounded-3xl border border-emerald-100 shadow-lg relative z-30 mb-10 grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        <!-- SEARCH BY NAME -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">{{ __('Cari Nama Dokter') }}</label>
            <div style="position: relative; width: 100%;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px; pointer-events: none; z-index: 10;"></i>
                <input type="text" 
                       x-model="searchName" 
                       @input="currentPage = 1"
                       placeholder="{{ __('Ketik nama dokter...') }}" 
                       style="padding-left: 38px; padding-right: 16px; padding-top: 10px; padding-bottom: 10px; border-radius: 12px; border: 1px solid #cbd5e1; font-size: 14px; width: 100%; outline: none;"
                       class="focus:ring-2 focus:ring-[#0e7c47] bg-white text-gray-800">
            </div>
        </div>

        <!-- FILTER BY POLICLINIC (Responsive Alpine.js Dropdown) -->
        <div class="relative" @click.outside="poliDropdownOpen = false">
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">{{ __('Pilih Poliklinik') }}</label>
            
            <!-- Trigger Button -->
            <button type="button" 
                    @click="poliDropdownOpen = !poliDropdownOpen; dayDropdownOpen = false" 
                    class="w-full pl-9 pr-8 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#0e7c47] focus:border-[#0e7c47] text-sm text-left bg-white outline-none transition-all flex items-center justify-between cursor-pointer relative"
                    :class="selectedPoli ? 'text-gray-900 font-semibold border-emerald-400' : 'text-gray-600'">
                <i class="fa-solid fa-stethoscope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                <span class="truncate pr-2" x-text="selectedPoliName">-- {{ __('Semua Poli') }} --</span>
                <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] transition-transform duration-200" :class="poliDropdownOpen ? 'rotate-180 text-[#0e7c47]' : ''"></i>
            </button>

            <!-- Dropdown Menu List -->
            <div x-show="poliDropdownOpen" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-150 transform"
                 x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-100 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                 class="absolute left-0 right-0 top-full mt-1.5 z-50 bg-white rounded-2xl shadow-2xl border border-emerald-100 p-2 max-h-60 overflow-y-auto w-full">
                
                <!-- Search filter for quick selection -->
                <div class="px-1 pb-1.5 mb-1 border-b border-gray-100">
                    <input type="text" 
                           x-model="poliSearchQuery" 
                           placeholder="{{ __('Cari spesialisasi...') }}" 
                           @click.stop
                           class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-gray-50 border border-gray-200 outline-none focus:border-[#0e7c47] focus:bg-white text-gray-800 placeholder-gray-400">
                </div>

                <!-- All Option -->
                <div @click="selectedPoli = ''; selectedPoliName = '-- {{ __('Semua Poli') }} --'; currentPage = 1; poliDropdownOpen = false" 
                     x-show="!poliSearchQuery || 'semua poli'.includes(poliSearchQuery.toLowerCase())"
                     class="px-3 py-2 rounded-xl text-xs font-semibold cursor-pointer transition-colors flex items-center justify-between"
                     :class="selectedPoli === '' ? 'bg-emerald-50 text-[#0e7c47]' : 'text-gray-700 hover:bg-gray-50'">
                    <span>-- {{ __('Semua Poli') }} --</span>
                    <i x-show="selectedPoli === ''" class="fa-solid fa-check text-xs text-[#0e7c47]"></i>
                </div>

                @if(isset($polyclinics))
                    @foreach($polyclinics as $poli)
                        @php
                            $poliTitle = is_array($poli->name) ? ($poli->name[app()->getLocale()] ?? $poli->name['id'] ?? $poli->name['en']) : $poli->name;
                        @endphp
                        <div @click="selectedPoli = '{{ $poli->id }}'; selectedPoliName = '{{ addslashes($poliTitle) }}'; currentPage = 1; poliDropdownOpen = false" 
                             x-show="!poliSearchQuery || '{{ strtolower(addslashes($poliTitle)) }}'.includes(poliSearchQuery.toLowerCase())"
                             class="px-3 py-2 rounded-xl text-xs font-semibold cursor-pointer transition-colors flex items-center justify-between"
                             :class="selectedPoli == '{{ $poli->id }}' ? 'bg-emerald-50 text-[#0e7c47]' : 'text-gray-700 hover:bg-gray-50'">
                            <span class="truncate">{{ $poliTitle }}</span>
                            <i x-show="selectedPoli == '{{ $poli->id }}'" class="fa-solid fa-check text-xs text-[#0e7c47]"></i>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- FILTER BY DAY (Responsive Alpine.js Dropdown) -->
        <div class="relative" @click.outside="dayDropdownOpen = false">
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">{{ __('Pilih Hari Praktik') }}</label>
            
            <!-- Trigger Button -->
            <button type="button" 
                    @click="dayDropdownOpen = !dayDropdownOpen; poliDropdownOpen = false" 
                    class="w-full pl-9 pr-8 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#0e7c47] focus:border-[#0e7c47] text-sm text-left bg-white outline-none transition-all flex items-center justify-between cursor-pointer relative"
                    :class="selectedDay ? 'text-gray-900 font-semibold border-emerald-400' : 'text-gray-600'">
                <i class="fa-regular fa-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                <span class="truncate pr-2" x-text="selectedDayName">-- {{ __('Semua Hari') }} --</span>
                <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] transition-transform duration-200" :class="dayDropdownOpen ? 'rotate-180 text-[#0e7c47]' : ''"></i>
            </button>

            <!-- Dropdown Menu List -->
            <div x-show="dayDropdownOpen" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-150 transform"
                 x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-100 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                 class="absolute left-0 right-0 top-full mt-1.5 z-50 bg-white rounded-2xl shadow-2xl border border-emerald-100 p-2 max-h-60 overflow-y-auto w-full">
                
                <div @click="selectedDay = ''; selectedDayName = '-- {{ __('Semua Hari') }} --'; currentPage = 1; dayDropdownOpen = false" 
                     class="px-3 py-2 rounded-xl text-xs font-semibold cursor-pointer transition-colors flex items-center justify-between"
                     :class="selectedDay === '' ? 'bg-emerald-50 text-[#0e7c47]' : 'text-gray-700 hover:bg-gray-50'">
                    <span>-- {{ __('Semua Hari') }} --</span>
                    <i x-show="selectedDay === ''" class="fa-solid fa-check text-xs text-[#0e7c47]"></i>
                </div>

                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                    <div @click="selectedDay = '{{ $day }}'; selectedDayName = '{{ $day }}'; currentPage = 1; dayDropdownOpen = false" 
                         class="px-3 py-2 rounded-xl text-xs font-semibold cursor-pointer transition-colors flex items-center justify-between"
                         :class="selectedDay == '{{ $day }}' ? 'bg-emerald-50 text-[#0e7c47]' : 'text-gray-700 hover:bg-gray-50'">
                        <span>{{ $day }}</span>
                        <i x-show="selectedDay == '{{ $day }}'" class="fa-solid fa-check text-xs text-[#0e7c47]"></i>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- DOCTORS SCHEDULE LIST (FETCHED DYNAMICALLY FROM DATABASE) -->
    <div class="space-y-8 min-h-[450px]">
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
                $dName = ucfirst(trim($sched->day));
                if (isset($dayMap[$dName])) {
                    $dayMap[$dName][] = \Carbon\Carbon::parse($sched->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($sched->end_time)->format('H:i');
                } else {
                    $dayMap[$dName][] = \Carbon\Carbon::parse($sched->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($sched->end_time)->format('H:i');
                }
            }
            $poliName = is_array($doc->polyclinic?->name) ? ($doc->polyclinic?->name[app()->getLocale()] ?? $doc->polyclinic?->name['id'] ?? '') : ($doc->polyclinic?->name ?? 'Poliklinik');
            
            $specText = is_array($doc->specialty) ? ($doc->specialty[app()->getLocale()] ?? $doc->specialty['id'] ?? '') : ($doc->specialty ?? $doc->title_degree ?? 'Dokter Spesialis');

            $docPhoto = $doc->photo;
            if ($docPhoto) {
                if (\Illuminate\Support\Str::contains($docPhoto, '/storage/')) {
                    $docPhoto = asset('storage/' . \Illuminate\Support\Str::after($docPhoto, '/storage/'));
                } elseif (!\Illuminate\Support\Str::startsWith($docPhoto, 'http')) {
                    $docPhoto = asset(ltrim($docPhoto, '/'));
                }
            }
        @endphp
        
        <div x-show="isDoctorVisible({{ $doc->id }})" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-white rounded-2xl border-2 border-emerald-100/90 p-5 sm:p-6 shadow-sm hover:shadow-md transition-all space-y-4">
            
            <!-- POLYCLINIC / SPECIALTY TITLE BAR -->
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-[#0e7c47] to-emerald-600 text-white flex items-center justify-center text-xs sm:text-sm font-black shadow-xs shrink-0">
                        <i class="fa-solid fa-{{ $doc->polyclinic?->icon ?? 'stethoscope' }}"></i>
                    </div>
                    <h4 class="text-base sm:text-lg font-black text-[#0e7c47] tracking-tight">
                        {{ $poliName }}
                    </h4>
                </div>
                <span class="text-xs font-bold px-3 py-1 rounded-full bg-emerald-50 text-[#0e7c47] border border-emerald-200">
                    RSU Fikri Medika Karawang
                </span>
            </div>

            <!-- DOCTOR ROW ITEM -->
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6 pt-1">
                
                <!-- CIRCULAR DOCTOR PHOTO -->
                <div class="flex-shrink-0 mx-auto md:mx-0">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-4 border-emerald-600 p-1 bg-white shadow-md flex items-center justify-center">
                        @if(!empty($docPhoto))
                            <img src="{{ $docPhoto }}" 
                                 alt="{{ $doc->name }}" 
                                 class="w-full h-full rounded-full object-cover"
                                 style="object-fit: cover; object-position: center 8%; transform: translateY(4px) scale(1.04);"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-full h-full rounded-full bg-gradient-to-tr from-[#0e7c47] to-emerald-500 text-white hidden items-center justify-center text-3xl sm:text-4xl font-bold shadow-inner">
                                <i class="fa-solid fa-user-doctor"></i>
                            </div>
                        @else
                            <div class="w-full h-full rounded-full bg-gradient-to-tr from-[#0e7c47] to-emerald-500 text-white flex items-center justify-center text-3xl sm:text-4xl font-bold shadow-inner">
                                <i class="fa-solid fa-user-doctor"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- DOCTOR INFO & SCHEDULE -->
                <div class="flex-grow w-full space-y-4">
                    
                    <!-- DOCTOR NAME & APPOINTMENT BUTTON -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <h3 class="text-lg sm:text-xl font-black text-slate-900 leading-snug">
                                {{ $doc->name }}
                            </h3>
                            <div class="text-xs text-gray-500 font-bold mt-1">
                                Spesialisasi: <span class="text-[#0e7c47] font-extrabold">{{ $specText }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 self-start sm:self-auto">
                            <a href="{{ url('/buat-janji?dokter_id=' . $doc->id) }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white text-xs font-black uppercase tracking-wider shadow-sm transition-all">
                                <i class="fa-solid fa-calendar-check text-sm"></i>
                                <span>BUAT JANJI</span>
                            </a>
                            <a href="https://wa.me/6281234567890?text=Halo%20RSU%20Fikri%20Medika,%20saya%20ingin%20tanya%20jadwal%20{{ urlencode($doc->name) }}" target="_blank" class="p-2.5 rounded-xl bg-emerald-50 text-[#0e7c47] hover:bg-emerald-100 transition-colors border border-emerald-200 text-xs font-bold" title="Tanya CS WhatsApp">
                                <i class="fa-brands fa-whatsapp text-base"></i>
                            </a>
                        </div>
                    </div>

                    <!-- HIGH CONTRAST CLEAR PRACTICE SCHEDULE BADGES -->
                    <div class="space-y-2 pt-1">
                        <div class="text-xs font-extrabold text-slate-600 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar-days text-[#0e7c47]"></i>
                            <span>{{ __('Jadwal Praktik Dokter') }}:</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2.5">
                            @php $hasAnySched = false; @endphp
                            @foreach($dayMap as $dayKey => $timeSlots)
                                @if(!empty($timeSlots))
                                    @php $hasAnySched = true; @endphp
                                    @foreach($timeSlots as $timeSlot)
                                        <div class="flex items-center justify-between p-2.5 px-3.5 rounded-xl bg-gradient-to-r from-emerald-50 to-teal-50/60 border-2 border-emerald-200/90 shadow-2xs">
                                            <span class="px-2.5 py-1 rounded-lg bg-[#0e7c47] text-white text-xs font-black uppercase tracking-wider shrink-0 shadow-2xs">
                                                {{ __($dayKey) }}
                                            </span>
                                            <div class="flex items-center gap-1.5 text-slate-900 font-black text-sm sm:text-base font-mono">
                                                <i class="fa-regular fa-clock text-emerald-600 text-xs"></i>
                                                <span>{{ $timeSlot }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                            @if(!$hasAnySched)
                                <div class="text-xs text-amber-600 font-bold bg-amber-50 border border-amber-200 px-3 py-1.5 rounded-xl inline-block">
                                    <i class="fa-regular fa-clock mr-1"></i> {{ __('Jadwal Praktik Belum Diatur') }}
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

            </div>

        </div>
        @endforeach

        <!-- EMPTY STATE IF NO DOCTORS FOUND -->
        <div x-show="filteredDoctors.length === 0" class="text-center py-16 bg-white rounded-3xl border border-gray-100 p-8 space-y-3">
            <i class="fa-solid fa-user-doctor text-4xl text-gray-300"></i>
            <h4 class="font-bold text-gray-700 text-base">{{ __('Dokter Tidak Ditemukan') }}</h4>
            <p class="text-xs text-gray-500">{{ __('Silakan ubah kata kunci pencarian atau pilih poliklinik lain.') }}</p>
        </div>
    </div>

    <!-- PAGINATION CONTROLS -->
    <div x-show="totalPages > 1" class="flex items-center justify-center gap-2 pt-8">
        <button @click="goToPage(currentPage - 1)" 
                :disabled="currentPage === 1"
                class="px-4 py-2 rounded-xl border border-gray-300 text-xs font-bold hover:bg-emerald-50 disabled:opacity-40 disabled:hover:bg-white transition-colors">
            <i class="fa-solid fa-chevron-left"></i> {{ __('Sebelumnya') }}
        </button>

        <template x-for="p in totalPages" :key="p">
            <button @click="goToPage(p)" 
                    class="w-9 h-9 rounded-xl border text-xs font-bold transition-all"
                    :class="currentPage === p ? 'bg-[#0e7c47] text-white border-[#0e7c47] shadow-sm' : 'bg-white text-gray-700 border-gray-300 hover:bg-emerald-50'"
                    x-text="p">
            </button>
        </template>

        <button @click="goToPage(p)" 
                :disabled="currentPage === totalPages"
                class="px-4 py-2 rounded-xl border border-gray-300 text-xs font-bold hover:bg-emerald-50 disabled:opacity-40 disabled:hover:bg-white transition-colors">
            {{ __('Selanjutnya') }} <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

</section>
@endsection
