@extends('layouts.app')

@section('title', $career->tr('title') . ' - Karir RSU Fikri Medika')

@section('content')
@php
    $title      = $career->tr('title');
    $shortDesc  = $career->tr('short_description');
    $desc       = $career->tr('description');
    $reqs       = is_array($career->requirements) ? $career->requirements : [];
    $resps      = is_array($career->responsibilities) ? $career->responsibilities : [];
    $bens       = is_array($career->benefits) ? $career->benefits : [];
    $badgeTheme = $career->department_badge;
@endphp

<div class="bg-slate-50 min-h-screen py-8 sm:py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- BREADCRUMB --}}
        <nav class="flex items-center gap-2 text-xs text-slate-400 font-medium">
            <a href="{{ route('home') }}" class="hover:text-[#0e7c47] transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <a href="{{ route('karir') }}" class="hover:text-[#0e7c47] transition-colors">Karir & Rekrutmen</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <span class="text-slate-600 font-semibold line-clamp-1">{{ $title }}</span>
        </nav>

        {{-- SUCCESS NOTIFICATION --}}
        @if(session('apply_success'))
        <div class="p-5 rounded-3xl bg-emerald-50 border border-emerald-200 text-[#0e7c47] flex items-start gap-3 shadow-xs">
            <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">
                <i class="fa-solid fa-check"></i>
            </div>
            <div class="space-y-1">
                <h4 class="font-black text-sm text-[#0e7c47]">Lamaran Berhasil Terkirim!</h4>
                <p class="text-xs text-emerald-800 leading-relaxed">{{ session('apply_success') }}</p>
                <div class="pt-2">
                    <a href="{{ route('karir') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0e7c47] hover:underline">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        <span>Lihat Lowongan Lainnya</span>
                    </a>
                </div>
            </div>
        </div>
        @endif

        {{-- ERROR NOTIFICATION --}}
        @if($errors->any())
        <div class="p-5 rounded-3xl bg-red-50 border border-red-200 text-red-700 flex items-start gap-3 shadow-xs">
            <div class="w-8 h-8 rounded-xl bg-red-600 text-white flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div class="space-y-1 text-xs">
                <h4 class="font-black text-sm text-red-800">Terdapat Kesalahan Pengisian Form:</h4>
                <ul class="list-disc pl-4 space-y-0.5 text-red-700">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- MAIN VACANCY CARD --}}
        <article class="bg-white rounded-3xl p-6 sm:p-10 shadow-xs border border-gray-100 space-y-8">

            {{-- HEADER ROW --}}
            <div class="border-b border-gray-100 pb-6 space-y-4">
                <div class="flex items-center justify-between gap-3 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-black {{ $badgeTheme['bg'] }} {{ $badgeTheme['text'] }} border {{ $badgeTheme['border'] }} uppercase tracking-wider">
                        <i class="fa-solid {{ $badgeTheme['icon'] }}"></i>
                        <span>{{ $career->department }}</span>
                    </span>

                    @if($career->is_open)
                    <span class="px-3 py-1 rounded-full bg-emerald-50 text-[#0e7c47] font-black text-xs border border-emerald-200 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-[#0e7c47] animate-pulse"></span>
                        <span>Lowongan Sedang Dibuka</span>
                    </span>
                    @else
                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-500 font-black text-xs border border-slate-200">
                        Lowongan Telah Ditutup
                    </span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 leading-tight">
                    {{ $title }}
                </h1>

                {{-- KEY SPECS GRID --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-gray-100">
                        <div class="text-[10px] uppercase font-bold text-slate-400">Pendidikan Min.</div>
                        <div class="font-black text-slate-800 text-xs sm:text-sm mt-0.5 truncate">{{ $career->education_level }}</div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-gray-100">
                        <div class="text-[10px] uppercase font-bold text-slate-400">Pengalaman</div>
                        <div class="font-black text-slate-800 text-xs sm:text-sm mt-0.5 truncate">{{ $career->experience_years }}</div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-gray-100">
                        <div class="text-[10px] uppercase font-bold text-slate-400">Tipe Pekerjaan</div>
                        <div class="font-black text-slate-800 text-xs sm:text-sm mt-0.5 truncate">{{ $career->employment_type }}</div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-gray-100">
                        <div class="text-[10px] uppercase font-bold text-slate-400">Batas Lamaran</div>
                        <div class="font-black text-[#0e7c47] text-xs sm:text-sm mt-0.5 truncate">{{ $career->deadline_formatted }}</div>
                    </div>
                </div>
            </div>

            {{-- DESKRIPSI SINGKAT & LENGKAP --}}
            @if($shortDesc || $desc)
            <div class="space-y-3">
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-[#0e7c47]"></i>
                    <span>Tentang Posisi Ini</span>
                </h3>
                @if($shortDesc)
                <p class="text-sm text-slate-700 leading-relaxed font-medium">
                    {{ $shortDesc }}
                </p>
                @endif
                @if($desc)
                <div class="prose prose-sm max-w-none text-slate-600 leading-relaxed">
                    {!! nl2br(e($desc)) !!}
                </div>
                @endif
            </div>
            @endif

            {{-- TANGGUNG JAWAB PEKERJAAN --}}
            @if(!empty($resps))
            <div class="space-y-3 pt-2">
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-[#0e7c47]"></i>
                    <span>Tanggung Jawab Pekerjaan (Job Responsibilities)</span>
                </h3>
                <ul class="space-y-2">
                    @foreach($resps as $resp)
                    <li class="flex items-start gap-2.5 text-xs sm:text-sm text-slate-700">
                        <i class="fa-solid fa-check text-[#0e7c47] mt-1 shrink-0 text-xs"></i>
                        <span>{{ $resp }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- PERSYARATAN & KUALIFIKASI --}}
            @if(!empty($reqs))
            <div class="space-y-3 pt-2">
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-user-check text-[#0e7c47]"></i>
                    <span>Kualifikasi & Persyaratan (Requirements)</span>
                </h3>
                <ul class="space-y-2">
                    @foreach($reqs as $req)
                    <li class="flex items-start gap-2.5 text-xs sm:text-sm text-slate-700">
                        <i class="fa-solid fa-circle-check text-emerald-600 mt-1 shrink-0 text-xs"></i>
                        <span>{{ $req }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- BENEFIT & FASILITAS --}}
            @if(!empty($bens))
            <div class="space-y-3 pt-2">
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-gift text-[#0e7c47]"></i>
                    <span>Benefit & Fasilitas Kerja</span>
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    @foreach($bens as $ben)
                    <div class="p-3 rounded-xl bg-emerald-50/60 border border-emerald-100 flex items-center gap-2.5 text-xs sm:text-sm font-bold text-emerald-900">
                        <i class="fa-solid fa-circle-check text-[#0e7c47] shrink-0"></i>
                        <span>{{ $ben }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </article>

        {{-- ═══════════════════════════════════════════
             FORM APPLY CV ONLINE
        ═══════════════════════════════════════════ --}}
        <section id="form-apply" class="bg-white rounded-3xl p-6 sm:p-10 shadow-xs border border-gray-100 space-y-6">
            <div class="border-b border-gray-100 pb-5 space-y-1">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-[#0e7c47] font-black text-xs uppercase tracking-wider">
                    <i class="fa-solid fa-file-arrow-up"></i>
                    <span>Formulir Lamaran Online</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900">Lamar Posisi {{ $title }}</h2>
                <p class="text-xs sm:text-sm text-slate-500">Lengkapi data diri Anda dan lampirkan berkas Curriculum Vitae (CV) terbaru.</p>
            </div>

            @if($career->is_open)
            <form action="{{ route('karir.apply', $career->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    {{-- NAMA LENGKAP --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Nama Lengkap (Sesuai KTP / Ijazah) <span class="text-red-500">*</span></label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" required placeholder="Contoh: Siti Nurhaliza, S.Kep., Ners" class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:bg-white transition-all">
                    </div>

                    {{-- EMAIL --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Alamat Email Aktif <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="email.anda@gmail.com" class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:bg-white transition-all">
                    </div>

                    {{-- NO WHATSAPP --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Nomor WhatsApp / HP Aktif <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:bg-white transition-all">
                    </div>

                    {{-- PENDIDIKAN TERAKHIR --}}
                    <div x-data="{ 
                            open: false, 
                            selectedVal: '{{ old('last_education', '') }}',
                            selectedLabel: '{{ old('last_education') ? old('last_education') : 'Pilih Pendidikan Terakhir' }}',
                            searchQuery: '',
                            options: [
                                'D3 Keperawatan',
                                'D3 Kebidanan',
                                'D3 Farmasi',
                                'D3 Radiologi / Radiodiagnostik',
                                'D3 Analis Kesehatan / Laboratorium',
                                'D3 Fisioterapi / Gizi',
                                'D3 Non Medis (Administrasi / IT / Umum)',
                                'S1 Keperawatan & Profesi Ners',
                                'S1 Farmasi & Profesi Apoteker',
                                'S1 Kesehatan Masyarakat',
                                'S1 Teknik Informatika / Sistem Informasi',
                                'S1 Manajemen / Akuntansi / Psikologi',
                                'Profesi Dokter Umum',
                                'Dokter Spesialis',
                                'S2 / Pascasarjana'
                            ]
                         }" 
                         @click.outside="open = false"
                         class="relative space-y-1.5 w-full">
                        <label class="block text-xs font-bold text-slate-700">Pendidikan Terakhir <span class="text-red-500">*</span></label>
                        <input type="hidden" name="last_education" :value="selectedVal" required>
                        
                        <!-- Trigger Button -->
                        <button type="button" 
                                @click="open = !open" 
                                class="w-full pl-9 pr-8 py-2.5 rounded-xl border border-gray-200 focus:border-[#0e7c47] focus:ring-1 focus:ring-[#0e7c47] text-xs text-left bg-white outline-none transition-all flex items-center justify-between cursor-pointer relative"
                                :class="selectedVal ? 'text-gray-900 font-semibold border-emerald-300' : 'text-gray-500'">
                            <i class="fa-solid fa-graduation-cap absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                            <span class="truncate pr-2" x-text="selectedLabel">Pilih Pendidikan Terakhir</span>
                            <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] transition-transform duration-200" :class="open ? 'rotate-180 text-[#0e7c47]' : ''"></i>
                        </button>

                        <!-- Dropdown Menu List -->
                        <div x-show="open" 
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
                                       x-model="searchQuery" 
                                       placeholder="Cari tingkat pendidikan..." 
                                       @click.stop
                                       class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-gray-50 border border-gray-200 outline-none focus:border-[#0e7c47] focus:bg-white text-gray-800 placeholder-gray-400">
                            </div>

                            <template x-for="opt in options.filter(o => !searchQuery || o.toLowerCase().includes(searchQuery.toLowerCase()))" :key="opt">
                                <div @click="selectedVal = opt; selectedLabel = opt; open = false" 
                                     class="px-3 py-2 rounded-xl text-xs font-semibold cursor-pointer transition-colors flex items-center justify-between"
                                     :class="selectedVal === opt ? 'bg-emerald-50 text-[#0e7c47]' : 'text-gray-700 hover:bg-gray-50'">
                                    <span class="truncate" x-text="opt"></span>
                                    <i x-show="selectedVal === opt" class="fa-solid fa-check text-xs text-[#0e7c47]"></i>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- PENGALAMAN KERJA --}}
                    <div x-data="{ 
                            open: false, 
                            selectedVal: '{{ old('experience_years', 'Fresh Graduate') }}',
                            selectedLabel: '{{ old('experience_years') ? old('experience_years') : 'Fresh Graduate (Baru Lulus)' }}',
                            options: [
                                { val: 'Fresh Graduate', label: 'Fresh Graduate (Baru Lulus)' },
                                { val: 'Kurang dari 1 Tahun', label: 'Kurang dari 1 Tahun' },
                                { val: '1 - 2 Tahun', label: '1 - 2 Tahun' },
                                { val: '3 - 5 Tahun', label: '3 - 5 Tahun' },
                                { val: 'Lebih dari 5 Tahun', label: 'Lebih dari 5 Tahun' }
                            ]
                         }" 
                         @click.outside="open = false"
                         class="relative space-y-1.5 w-full">
                        <label class="block text-xs font-bold text-slate-700">Pengalaman Kerja di Posisi Serupa</label>
                        <input type="hidden" name="experience_years" :value="selectedVal">
                        
                        <!-- Trigger Button -->
                        <button type="button" 
                                @click="open = !open" 
                                class="w-full pl-9 pr-8 py-2.5 rounded-xl border border-gray-200 focus:border-[#0e7c47] focus:ring-1 focus:ring-[#0e7c47] text-xs text-left bg-white outline-none transition-all flex items-center justify-between cursor-pointer relative"
                                :class="selectedVal ? 'text-gray-900 font-semibold border-emerald-300' : 'text-gray-500'">
                            <i class="fa-solid fa-briefcase absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                            <span class="truncate pr-2" x-text="selectedLabel">Pilih Pengalaman</span>
                            <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] transition-transform duration-200" :class="open ? 'rotate-180 text-[#0e7c47]' : ''"></i>
                        </button>

                        <!-- Dropdown Menu List -->
                        <div x-show="open" 
                             x-cloak
                             x-transition:enter="transition ease-out duration-150 transform"
                             x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-100 transform"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                             class="absolute left-0 right-0 top-full mt-1.5 z-50 bg-white rounded-2xl shadow-2xl border border-emerald-100 p-2 max-h-60 overflow-y-auto w-full">
                            
                            <template x-for="opt in options" :key="opt.val">
                                <div @click="selectedVal = opt.val; selectedLabel = opt.label; open = false" 
                                     class="px-3 py-2 rounded-xl text-xs font-semibold cursor-pointer transition-colors flex items-center justify-between"
                                     :class="selectedVal === opt.val ? 'bg-emerald-50 text-[#0e7c47]' : 'text-gray-700 hover:bg-gray-50'">
                                    <span class="truncate" x-text="opt.label"></span>
                                    <i x-show="selectedVal === opt.val" class="fa-solid fa-check text-xs text-[#0e7c47]"></i>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- NOMOR STR (OPSIONAL UNTUK NAKES) --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Nomor STR Aktif <span class="text-slate-400 font-normal">(Khusus Tenaga Medis / Nakes)</span></label>
                        <input type="text" name="str_number" value="{{ old('str_number') }}" placeholder="Contoh: 320152123456789" class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:bg-white transition-all">
                    </div>
                </div>

                {{-- UPLOAD BERKAS CV --}}
                <div class="space-y-2 p-4 sm:p-5 rounded-2xl bg-emerald-50/50 border border-emerald-200">
                    <label class="block text-xs font-bold text-slate-900 flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-file-pdf text-[#0e7c47] text-sm"></i>
                            <span>Upload Berkas CV / Resume Terbaru <span class="text-red-500">*</span></span>
                        </span>
                        <span class="text-[10px] text-emerald-700 font-semibold">Format PDF/DOCX, Maks. 15MB</span>
                    </label>
                    <input type="file" name="cv_file" required accept=".pdf,.doc,.docx" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0e7c47] file:text-white hover:file:bg-[#096237] cursor-pointer bg-white border border-gray-200 rounded-xl p-1">
                    <p class="text-[11px] text-slate-500">Lampirkan CV lengkap beserta riwayat pendidikan, pelatihan bersertifikat, dan kontak referensi.</p>
                </div>

                {{-- LINKEDIN / PORTOFOLIO URL --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Link LinkedIn / Portofolio / Berkas Pendukung <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <input type="url" name="portfolio_url" value="{{ old('portfolio_url') }}" placeholder="https://linkedin.com/in/username atau link Google Drive sertifikat" class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:bg-white transition-all">
                </div>

                {{-- SURAT LAMARAN / CATATAN --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Surat Lamaran Singkat / Catatan untuk HRD <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <textarea name="cover_letter" rows="3" placeholder="Tuliskan motivasi Anda bergabung di RSU Fikri Medika dan keunggulan kompetensi yang Anda miliki..." class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:bg-white transition-all">{{ old('cover_letter') }}</textarea>
                </div>

                {{-- SUBMIT BUTTON --}}
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-[11px] text-slate-400">
                        <i class="fa-solid fa-lock text-[10px]"></i>
                        Data pribadi dan berkas Anda terenkripsi aman dan hanya digunakan untuk keperluan rekrutmen RSU Fikri Medika.
                    </p>
                    <button type="submit"
                            style="background-color: #0e7c47; color: #ffffff;"
                            class="w-full sm:w-auto px-8 py-3.5 rounded-2xl font-black text-xs shadow-md hover:bg-[#096237] transition-all flex items-center justify-center gap-2 cursor-pointer shrink-0">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span>Kirim Lamaran Sekarang</span>
                    </button>
                </div>
            </form>
            @else
            <div class="p-8 rounded-2xl bg-slate-50 border border-gray-200 text-center space-y-2">
                <i class="fa-solid fa-lock text-3xl text-slate-300"></i>
                <h4 class="font-black text-slate-800 text-sm">Pendaftaran Posisi Ini Telah Ditutup</h4>
                <p class="text-xs text-slate-500">Silakan melihat posisi lowongan lainnya yang sedang dibuka oleh RSU Fikri Medika.</p>
                <div class="pt-2">
                    <a href="{{ route('karir') }}" class="px-4 py-2 rounded-xl bg-[#0e7c47] text-white text-xs font-bold inline-flex items-center gap-1.5 shadow-xs">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                        <span>Kembali ke Daftar Lowongan</span>
                    </a>
                </div>
            </div>
            @endif
        </section>

        {{-- ═══════════════════════════════════════════
             LOWONGAN LAINNYA
        ═══════════════════════════════════════════ --}}
        @if($otherCareers->count())
        <section class="space-y-4">
            <h2 class="text-base font-black text-slate-800 uppercase tracking-wide flex items-center gap-2">
                <i class="fa-solid fa-briefcase text-[#0e7c47]"></i>
                <span>Lowongan Terbuka Lainnya</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($otherCareers as $oth)
                @php
                    $othBadge = $oth->department_badge;
                @endphp
                <a href="{{ route('karir.show', $oth->slug) }}"
                   class="bg-white rounded-2xl p-5 border border-gray-100 hover:border-emerald-200 hover:shadow-md transition-all flex flex-col justify-between group">
                    <div class="space-y-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[10px] font-black {{ $othBadge['bg'] }} {{ $othBadge['text'] }} border {{ $othBadge['border'] }} uppercase">
                            {{ $oth->department }}
                        </span>
                        <h3 class="font-black text-slate-900 text-xs leading-snug group-hover:text-[#0e7c47] transition-colors line-clamp-2">
                            {{ $oth->tr('title') }}
                        </h3>
                        <div class="text-[11px] text-slate-500 flex items-center gap-1">
                            <i class="fa-solid fa-graduation-cap text-[#0e7c47]"></i>
                            <span>{{ $oth->education_level }}</span>
                        </div>
                    </div>
                    <div class="pt-3 mt-3 border-t border-gray-100 text-[10px] font-bold text-[#0e7c47] flex items-center justify-between">
                        <span>Lamar Sekarang</span>
                        <i class="fa-solid fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

    </div>
</div>
@endsection
