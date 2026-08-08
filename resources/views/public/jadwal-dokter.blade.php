@extends('layouts.app')

@section('content')


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
             class="bg-white rounded-2xl border-2 border-emerald-100/90 p-5 sm:p-6 shadow-sm hover:shadow-md transition-all space-y-4">
            
            <!-- POLYCLINIC / SPECIALTY TITLE BAR -->
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#0e7c47]"></span>
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

                <!-- DOCTOR INFO & SCHEDULE -->
                <div class="flex-grow w-full space-y-4">
                    
                    <!-- DOCTOR NAME & APPOINTMENT BUTTON -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <h3 class="text-lg sm:text-xl font-black text-slate-900 leading-snug">
                                {{ $doc->name }}
                            </h3>
                            <div class="text-xs text-gray-500 font-bold mt-1">
                                Spesialisasi: <span class="text-[#0e7c47] font-extrabold">{{ is_array($doc->specialization) ? ($doc->specialization[app()->getLocale()] ?? $doc->specialization['id']) : ($doc->specialization ?? 'Dokter Spesialis') }}</span>
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
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $dayKey)
                                @if(!empty($dayMap[$dayKey]))
                                    @php $hasAnySched = true; @endphp
                                    @foreach($dayMap[$dayKey] as $timeSlot)
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
                                <div class="text-xs text-gray-400 font-semibold italic py-1">{{ __('Tidak ada jadwal harian') }}</div>
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

        <button @click="goToPage(currentPage + 1)" 
                :disabled="currentPage === totalPages"
                class="px-4 py-2 rounded-xl border border-gray-300 text-xs font-bold hover:bg-emerald-50 disabled:opacity-40 disabled:hover:bg-white transition-colors">
            {{ __('Selanjutnya') }} <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

</section>
@endsection
