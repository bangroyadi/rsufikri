@extends('layouts.app')

@section('content')
<!-- BREADCRUMB & HERO BANNER -->
 <!-- BREADCRUMB & HERO BANNER -->
<section class="relative bg-gradient-to-r from-[#0e7c47] via-[#096237] to-[#084b2a] text-white py-12 px-4 sm:px-6 lg:px-8 overflow-hidden shadow-inner">
    <!-- BACKGROUND DECORATIVE GLOW -->
    <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-yellow-400/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute left-10 top-0 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none"></div>

    <div class="max-w-6xl mx-auto relative z-10">
        <!-- BREADCRUMB -->
        <div class="flex items-center gap-2 text-xs sm:text-sm text-yellow-300 mb-3 font-semibold">
            <a href="{{ route('home') }}" class="hover:underline flex items-center gap-1">
                <i class="fa-solid fa-house text-xs"></i> {{ __('Beranda') }}
            </a>
            <i class="fa-solid fa-chevron-right text-[10px] text-emerald-200"></i>
            <span class="text-emerald-100">{{ __('Jadwal Dokter') }}</span>
            <i class="fa-solid fa-chevron-right text-[10px] text-emerald-200"></i>
            <span class="text-white font-bold">{{ __('Jadwal Praktik Poliklinik') }}</span>
        </div>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-yellow-300 text-xs font-bold border border-yellow-300/30 backdrop-blur-sm mb-2.5">
                    <i class="fa-solid fa-calendar-check text-xs"></i> Update Real-Time Database Dokter
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight">
                    Jadwal Praktik Dokter Spesialis
                </h1>
                <p class="mt-2 text-sm sm:text-base text-emerald-100 leading-relaxed max-w-2xl">
                    Periksa jadwal praktik harian dokter spesialis RSU Fikri Medika Karawang secara resmi dan terintegrasi langsung dengan database.
                </p>
            </div>
            
            <a href="{{ url('/buat-janji') }}" class="px-5 py-3 rounded-xl bg-yellow-400 text-gray-900 font-extrabold text-xs sm:text-sm hover:bg-yellow-300 transition-all shadow-lg hover:scale-105 flex items-center justify-center gap-2 shrink-0 border-2 border-yellow-300">
                <i class="fa-solid fa-heart-pulse text-red-600 text-base"></i>
                <span>Daftar / Buat Janji Temu</span>
            </a>
        </div>
    </div>
</section>

<!-- MAIN CONTENT & INTERACTIVE PAGINATED TABLE (MATCHING DATABASE STRUCTURE) -->
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto" x-data="{
    searchName: '{{ request()->get('q') }}',
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

    <!-- SEARCH & FILTER BAR -->
    <div class="bg-white p-6 rounded-3xl border border-emerald-100 shadow-lg -mt-10 relative z-30 mb-10 grid grid-cols-1 sm:grid-cols-3 gap-4">
        
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
                    <option value="{{ $poli->id }}">{{ is_array($poli->name) ? ($poli->name[app()->getLocale()] ?? $poli->name['id']) : $poli->name }}</option>
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

    <!-- DOCTORS SCHEDULE LIST (REVISED TABLE DESIGN FETCHING FROM DATABASE) -->
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
                if (isset($dayMap[$sched->day])) {
                    $dayMap[$sched->day][] = \Carbon\Carbon::parse($sched->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($sched->end_time)->format('H:i');
                }
            }
            $poliName = is_array($doc->polyclinic->name) ? ($doc->polyclinic->name[app()->getLocale()] ?? $doc->polyclinic->name['id']) : ($doc->polyclinic->name ?? 'Poliklinik');
        @endphp
        
        <div x-show="isDoctorVisible({{ $doc->id }})" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-4 border-b-2 border-emerald-600">
            
            <!-- POLYCLINIC / SPECIALTY TITLE -->
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#0e7c47]"></span>
                    <h4 class="text-base sm:text-lg font-extrabold text-[#0e7c47] tracking-tight">
                        {{ $poliName }}
                    </h4>
                </div>
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-emerald-50 text-[#0e7c47] border border-emerald-200/50">
                    RSU Fikri Medika Karawang
                </span>
            </div>

            <!-- DOCTOR ROW ITEM -->
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6 pt-1">
                
                <!-- CIRCULAR DOCTOR PHOTO -->
                <div class="flex-shrink-0 mx-auto md:mx-0">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-4 border-emerald-600 p-1 bg-white shadow-md">
                        @if($doc->photo)
                            <img src="{{ \Illuminate\Support\Str::startsWith($doc->photo, 'http') ? $doc->photo : asset('storage/' . $doc->photo) }}" 
                                 alt="{{ $doc->name }}" 
                                 class="w-full h-full rounded-full object-cover">
                        @else
                            <div class="w-full h-full rounded-full bg-gradient-to-tr from-[#0e7c47] to-emerald-500 text-white flex items-center justify-center text-3xl font-bold">
                                <i class="fa-solid fa-user-doctor"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- DOCTOR INFO & WEEKLY SCHEDULE TABLE -->
                <div class="flex-grow w-full space-y-4">
                    
                    <!-- DOCTOR NAME & APPOINTMENT BUTTON -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <h3 class="text-base sm:text-xl font-extrabold text-gray-900 leading-snug">
                                {{ $doc->name }}
                            </h3>
                            <div class="text-xs text-gray-500 font-semibold mt-0.5">
                                {{ is_array($doc->specialization) ? ($doc->specialization[app()->getLocale()] ?? $doc->specialization['id']) : ($doc->specialization ?? 'Dokter Spesialis') }}
                            </div>
                        </div>

                        <div class="flex items-center gap-2 self-start sm:self-auto">
                            <a href="{{ url('/buat-janji?dokter_id=' . $doc->id) }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white text-xs font-extrabold shadow-sm transition-all">
                                <i class="fa-solid fa-calendar-check"></i>
                                <span>BUAT JANJI</span>
                            </a>
                            <a href="https://wa.me/6281234567890?text=Halo%20RSU%20Fikri%20Medika,%20saya%20ingin%20tanya%20jadwal%20{{ urlencode($doc->name) }}" target="_blank" class="p-2.5 rounded-xl bg-emerald-50 text-[#0e7c47] hover:bg-emerald-100 transition-colors border border-emerald-200 text-xs font-bold" title="Tanya CS WhatsApp">
                                <i class="fa-brands fa-whatsapp text-base"></i>
                            </a>
                        </div>
                    </div>

                    <!-- SIMPLE & CLEAN JADWAL BADGES (ONLY ACTIVE DAYS) -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-2 pt-1">
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                            <div class="p-2.5 rounded-xl text-center border transition-all {{ count($dayMap[$day]) > 0 ? 'bg-emerald-50/80 border-emerald-200 text-[#0e7c47]' : 'bg-gray-50/50 border-gray-100 text-gray-300' }}">
                                <div class="text-[11px] font-bold uppercase tracking-wider {{ count($dayMap[$day]) > 0 ? 'text-[#0e7c47]' : 'text-gray-400' }}">{{ __($day) }}</div>
                                <div class="text-[11px] font-bold mt-1">
                                    @if(count($dayMap[$day]) > 0)
                                        @foreach($dayMap[$day] as $timeStr)
                                            <span class="block text-gray-800 font-mono font-semibold">{{ $timeStr }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-300 font-normal">-</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
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

        <button @click="goToPage(currentPage + 1)" 
                :disabled="currentPage === totalPages"
                class="px-4 py-2 rounded-xl border border-gray-300 text-xs font-bold hover:bg-emerald-50 disabled:opacity-40 disabled:hover:bg-white transition-colors">
            {{ __('Selanjutnya') }} <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

</section>
@endsection
