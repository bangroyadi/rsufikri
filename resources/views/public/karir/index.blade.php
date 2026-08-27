@extends('layouts.app')

@section('title', 'Karir & Rekrutmen - RSU Fikri Medika')

@section('content')
<div x-data="{
    selectedDept: '{{ addslashes($department ?? 'all') }}',
    selectedType: '{{ addslashes($type ?? 'all') }}',
    search: '{{ addslashes($query ?? '') }}',
    visibleLimit: 4,
    allJobs: [
        @foreach($careers as $job)
        {
            id: {{ $job->id }},
            title: {{ json_encode($job->tr('title')) }},
            slug: '{{ $job->slug }}',
            url: '{{ route('karir.show', $job->slug) }}',
            applyUrl: '{{ route('karir.show', $job->slug) }}#form-apply',
            department: {{ json_encode($job->department) }},
            deptBadgeBg: '{{ $job->department_badge['bg'] }}',
            deptBadgeText: '{{ $job->department_badge['text'] }}',
            deptBadgeBorder: '{{ $job->department_badge['border'] }}',
            deptBadgeIcon: '{{ $job->department_badge['icon'] }}',
            employment_type: {{ json_encode($job->employment_type) }},
            education_level: {{ json_encode($job->education_level) }},
            experience_years: {{ json_encode($job->experience_years) }},
            location: {{ json_encode($job->location) }},
            deadline_formatted: {{ json_encode($job->deadline_formatted) }},
            is_open: {{ $job->is_open ? 'true' : 'false' }},
            is_featured: {{ $job->is_featured ? 'true' : 'false' }},
            short_description: {{ json_encode($job->tr('short_description') ?? '') }},
            requirements: {{ json_encode(array_slice((array)($job->requirements ?? []), 0, 2)) }},
        },
        @endforeach
    ],
    get filteredJobs() {
        return this.allJobs.filter(job => {
            const matchesDept = (this.selectedDept === 'all' || this.selectedDept === job.department);
            const matchesType = (this.selectedType === 'all' || this.selectedType === job.employment_type);
            const searchTarget = (job.title + ' ' + job.department + ' ' + job.education_level + ' ' + job.short_description).toLowerCase();
            const matchesSearch = (!this.search || searchTarget.includes(this.search.toLowerCase().trim()));
            return matchesDept && matchesType && matchesSearch;
        });
    },
    get displayedJobs() {
        return this.filteredJobs.slice(0, this.visibleLimit);
    },
    get hasMore() {
        return this.visibleLimit < this.filteredJobs.length;
    },
    loadMore() {
        if (this.visibleLimit === 4) {
            this.visibleLimit = 10;
        } else if (this.visibleLimit === 10) {
            this.visibleLimit = 20;
        } else {
            this.visibleLimit += 10;
        }
    }
}" class="bg-slate-50 min-h-screen">

    <!-- MAIN CONTAINER -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-8">

        {{-- ═══════════════════════════════════════════
             1. FILTER & SEARCH BAR
        ═══════════════════════════════════════════ --}}
        <div class="bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl shadow-xs border border-gray-100 space-y-4">
            <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">

                {{-- DEPARTMENT FILTER PILLS --}}
                <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
                    <button type="button"
                            @click="selectedDept = 'all'; visibleLimit = 4"
                            :class="selectedDept === 'all' ? 'bg-[#0e7c47] text-white shadow-xs' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-gray-200'"
                            class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all cursor-pointer whitespace-nowrap flex items-center gap-1.5">
                        <i class="fa-solid fa-layer-group text-xs"></i>
                        <span>Semua Bidang ({{ $careers->count() }})</span>
                    </button>

                    @foreach($departments as $dept)
                    <button type="button"
                            @click="selectedDept = '{{ addslashes($dept) }}'; visibleLimit = 4"
                            :class="selectedDept === '{{ addslashes($dept) }}' ? 'bg-[#0e7c47] text-white shadow-xs' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-gray-200'"
                            class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all cursor-pointer whitespace-nowrap">
                        {{ $dept }}
                    </button>
                    @endforeach
                </div>

                {{-- SEARCH INPUT --}}
                <div class="relative w-full md:w-72 shrink-0">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text"
                           x-model="search"
                           @input="visibleLimit = 4"
                           placeholder="Cari nama posisi, keahlian..."
                           class="w-full pl-9 pr-4 py-2 text-xs rounded-xl bg-slate-50 border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:bg-white transition-all">
                </div>

            </div>
        </div>

        {{-- ═══════════════════════════════════════════
             2. VACANCIES LIST / GRID
        ═══════════════════════════════════════════ --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-black text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-bullhorn text-[#0e7c47]"></i>
                    <span>Daftar Lowongan Pekerjaan Terbaru</span>
                </h2>
                <span class="text-xs text-slate-500 font-semibold">
                    Menampilkan <strong x-text="displayedJobs.length" class="text-slate-800"></strong> dari <span x-text="filteredJobs.length"></span> lowongan
                </span>
            </div>

            {{-- JOB CARDS GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <template x-for="job in displayedJobs" :key="job.id">
                    <div class="bg-white rounded-3xl p-6 shadow-xs hover:shadow-md border border-gray-100 hover:border-emerald-200 transition-all duration-300 flex flex-col justify-between group">
                        
                        <div class="space-y-4">
                            {{-- BADGE & STATUS ROW --}}
                            <div class="flex items-center justify-between gap-2 flex-wrap">
                                <span :class="job.deptBadgeBg + ' ' + job.deptBadgeText + ' ' + job.deptBadgeBorder" 
                                      class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-black border uppercase tracking-wider">
                                    <i :class="'fa-solid ' + job.deptBadgeIcon"></i>
                                    <span x-text="job.department"></span>
                                </span>

                                <template x-if="job.is_open">
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-[#0e7c47] font-bold text-[11px] border border-emerald-200 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#0e7c47] animate-pulse"></span>
                                        <span>Terbuka</span>
                                    </span>
                                </template>
                                <template x-if="!job.is_open">
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500 font-bold text-[11px] border border-slate-200">
                                        Ditutup
                                    </span>
                                </template>
                            </div>

                            {{-- JOB TITLE --}}
                            <div>
                                <h3 class="font-black text-slate-900 text-lg leading-snug group-hover:text-[#0e7c47] transition-colors">
                                    <a :href="job.url" x-text="job.title"></a>
                                </h3>
                                <div class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-slate-400"></i>
                                    <span x-text="job.location"></span>
                                </div>
                            </div>

                            {{-- QUICK SPECS PILLS --}}
                            <div class="flex flex-wrap items-center gap-2 text-xs">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-50 text-slate-700 font-semibold border border-gray-200 flex items-center gap-1.5">
                                    <i class="fa-solid fa-graduation-cap text-[#0e7c47]"></i>
                                    <span x-text="job.education_level"></span>
                                </span>
                                <span class="px-2.5 py-1 rounded-lg bg-slate-50 text-slate-700 font-semibold border border-gray-200 flex items-center gap-1.5">
                                    <i class="fa-solid fa-clock text-blue-600"></i>
                                    <span x-text="job.employment_type"></span>
                                </span>
                                <span class="px-2.5 py-1 rounded-lg bg-slate-50 text-slate-700 font-semibold border border-gray-200 flex items-center gap-1.5">
                                    <i class="fa-solid fa-business-time text-amber-600"></i>
                                    <span x-text="job.experience_years"></span>
                                </span>
                            </div>

                            {{-- SHORT DESCRIPTION --}}
                            <template x-if="job.short_description">
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed font-normal" x-text="job.short_description"></p>
                            </template>

                            {{-- TOP REQUIREMENTS PREVIEW --}}
                            <template x-if="job.requirements && job.requirements.length > 0">
                                <div class="pt-2 border-t border-gray-100 space-y-1">
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Persyaratan Utama:</div>
                                    <template x-for="(req, rIdx) in job.requirements" :key="rIdx">
                                        <div class="flex items-start gap-1.5 text-xs text-slate-700">
                                            <i class="fa-solid fa-circle-check text-emerald-500 text-xs mt-0.5 shrink-0"></i>
                                            <span class="line-clamp-1" x-text="req"></span>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>

                        {{-- FOOTER / ACTION ROW --}}
                        <div class="pt-4 mt-4 border-t border-gray-100 flex items-center justify-between gap-3">
                            <div class="text-[11px] text-slate-500">
                                <div class="font-medium text-slate-400">Batas Lamaran:</div>
                                <div class="font-bold text-slate-700" x-text="job.deadline_formatted"></div>
                            </div>

                            <div class="flex items-center gap-2">
                                <a :href="job.url"
                                   class="px-4 py-2 rounded-xl border border-gray-200 hover:border-[#0e7c47] text-slate-700 hover:text-[#0e7c47] text-xs font-bold transition-all">
                                    Detail
                                </a>
                                <template x-if="job.is_open">
                                    <a :href="job.applyUrl"
                                       class="px-4 py-2 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white text-xs font-bold shadow-xs transition-all flex items-center gap-1.5">
                                        <i class="fa-solid fa-paper-plane text-xs"></i>
                                        <span>Lamar Posisi</span>
                                    </a>
                                </template>
                            </div>
                        </div>

                    </div>
                </template>

                {{-- EMPTY STATE --}}
                <template x-if="filteredJobs.length === 0">
                    <div class="col-span-full bg-white p-12 rounded-3xl border border-gray-100 text-center space-y-3 shadow-xs">
                        <i class="fa-solid fa-briefcase text-4xl text-slate-200"></i>
                        <h3 class="font-black text-slate-800 text-base">Tidak Ada Lowongan yang Cocok</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto">Coba ubah kata kunci pencarian atau pilih kategori bidang lainnya.</p>
                    </div>
                </template>
            </div>

            {{-- ═══════════════════════════════════════════
                 TOMBOL LIHAT LEBIH BANYAK (LOAD MORE)
            ═══════════════════════════════════════════ --}}
            <template x-if="hasMore">
                <div class="text-center pt-6">
                    <button type="button"
                            @click="loadMore()"
                            class="inline-flex items-center gap-2 px-8 py-3.5 rounded-2xl bg-white hover:bg-slate-50 border-2 border-emerald-600/30 hover:border-[#0e7c47] text-[#0e7c47] font-black text-xs shadow-xs hover:shadow-md transition-all cursor-pointer active:scale-98">
                        <i class="fa-solid fa-arrow-down text-xs animate-bounce"></i>
                        <span>Lihat Lebih Banyak Lowongan</span>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-[#0e7c47] text-[10px] font-bold border border-emerald-200">
                            +<span x-text="visibleLimit === 4 ? 6 : 10"></span> Loker
                        </span>
                    </button>
                    <p class="text-[11px] text-slate-400 mt-2">
                        Menampilkan <span x-text="displayedJobs.length"></span> dari <span x-text="filteredJobs.length"></span> lowongan tersedia
                    </p>
                </div>
            </template>

            <template x-if="!hasMore && filteredJobs.length > 4">
                <div class="text-center pt-4">
                    <span class="inline-flex items-center gap-1.5 text-xs text-slate-400 font-semibold bg-white px-4 py-1.5 rounded-full border border-gray-200 shadow-2xs">
                        <i class="fa-solid fa-check text-emerald-600 text-xs"></i>
                        <span>Seluruh lowongan telah ditampilkan (<span x-text="filteredJobs.length"></span> lowongan)</span>
                    </span>
                </div>
            </template>
        </div>

        {{-- ═══════════════════════════════════════════
             3. NILAI-NILAI & BENEFIT KERJA
        ═══════════════════════════════════════════ --}}
        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xs border border-gray-100 space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-extrabold text-[#0e7c47] uppercase tracking-wider">Budaya Kerja Kami</span>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900">Mengapa Berkarier di RSU Fikri Medika?</h2>
                <p class="text-xs sm:text-sm text-slate-500">Kami percaya bahwa pelayanan medis unggul berawal dari tenaga kesehatan dan staf yang sejahtera, terlatih, dan saling menghargai.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="p-5 rounded-2xl bg-slate-50 border border-gray-100 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0e7c47] flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Pelayanan Bernilai Ibadah</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Menjunjung tinggi nilai kemanusiaan, empati, dan etika Islami dalam setiap interaksi dengan pasien dan sesama rekan kerja.</p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-50 border border-gray-100 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Jenjang Karir Terbuka</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Pengembangan karir fungsional dan struktural yang transparan berbasis kompetensi, kinerja, dan integritas kerja.</p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-50 border border-gray-100 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Pelatihan Berkelanjutan</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Dukungan seminar berkala, sertifikasi keahlian medis (SKP), dan workshop untuk meningkatkan standar kompetensi staf.</p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-50 border border-gray-100 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Proteksi & Fasilitas Lengkap</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Jaminan perlindungan BPJS Kesehatan, BPJS Ketenagakerjaan, serta fasilitas kerja medis modern dan aman.</p>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════
             4. ALUR SELEKSI REKRUTMEN
        ═══════════════════════════════════════════ --}}
        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xs border border-gray-100 space-y-6">
            <div class="text-center max-w-xl mx-auto space-y-1">
                <span class="text-xs font-extrabold text-[#0e7c47] uppercase tracking-wider">Transparansi Proses</span>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900">4 Tahapan Alur Rekrutmen</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="relative p-5 rounded-2xl bg-emerald-50/50 border border-emerald-100 space-y-2">
                    <div class="w-7 h-7 rounded-full bg-[#0e7c47] text-white text-xs font-black flex items-center justify-center">1</div>
                    <h4 class="font-bold text-slate-900 text-sm">Pendaftaran & Submit CV</h4>
                    <p class="text-xs text-slate-600">Pilih lowongan yang sesuai kualifikasi dan isi formulir online beserta upload berkas CV.</p>
                </div>

                <div class="relative p-5 rounded-2xl bg-slate-50 border border-gray-100 space-y-2">
                    <div class="w-7 h-7 rounded-full bg-slate-700 text-white text-xs font-black flex items-center justify-center">2</div>
                    <h4 class="font-bold text-slate-900 text-sm">Seleksi Berkas Administrasi</h4>
                    <p class="text-xs text-slate-600">Tim HRD melakukan verifikasi berkas, legalitas STR, dan kesesuaian pengalaman kerja.</p>
                </div>

                <div class="relative p-5 rounded-2xl bg-slate-50 border border-gray-100 space-y-2">
                    <div class="w-7 h-7 rounded-full bg-slate-700 text-white text-xs font-black flex items-center justify-center">3</div>
                    <h4 class="font-bold text-slate-900 text-sm">Tes & Wawancara</h4>
                    <p class="text-xs text-slate-600">Pelamar lolos berkas diundang untuk wawancara HRD, tes kompetensi medis, dan user interview.</p>
                </div>

                <div class="relative p-5 rounded-2xl bg-slate-50 border border-gray-100 space-y-2">
                    <div class="w-7 h-7 rounded-full bg-slate-700 text-white text-xs font-black flex items-center justify-center">4</div>
                    <h4 class="font-bold text-slate-900 text-sm">Medical Check Up & Onboarding</h4>
                    <p class="text-xs text-slate-600">Pemeriksaan kesehatan kerja (MCU), penandatanganan kontrak kerja, dan orientasi staf baru.</p>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
