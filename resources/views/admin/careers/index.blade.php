@extends('layouts.admin')

@section('title', 'Manajemen Lowongan Karir - Admin RSU Fikri Medika')

@section('content')
<div x-data="{
    search: '',
    deptFilter: 'all',
    statusFilter: 'all',
    modalOpen: false,
    editMode: false,
    editId: null,
    formData: {
        title_id: '',
        title_en: '',
        department: 'Keperawatan',
        employment_type: 'Full Time',
        education_level: 'D3 Keperawatan / Profesi Ners',
        experience_years: 'Fresh Graduate / 1-2 Tahun',
        location: 'RSU Fikri Medika, Karawang',
        quota: '1 Orang',
        deadline: '',
        requirements_text: '',
        responsibilities_text: '',
        benefits_text: '',
        short_description_id: '',
        description_id: '',
        status: 'open',
        is_featured: false,
        is_active: true,
    },
    openAddModal() {
        this.editMode = false;
        this.editId = null;
        this.formData = {
            title_id: '',
            title_en: '',
            department: 'Keperawatan',
            employment_type: 'Full Time',
            education_level: 'D3 / S1',
            experience_years: 'Fresh Graduate / 1 Tahun',
            location: 'RSU Fikri Medika, Karawang',
            quota: '1 Orang',
            deadline: '{{ date('Y-m-d', strtotime('+30 days')) }}',
            requirements_text: 'Pendidikan sesuai kualifikasi yang dipersyaratkan\nMemiliki STR aktif bagi tenaga kesehatan\nMemiliki kemampuan komunikasi yang baik dan ramah\nSehat jasmani dan rohani',
            responsibilities_text: 'Melaksanakan tugas pelayanan medis / operasional sesuai SOP rumah sakit\nMenjaga keselamatan pasien dan kepuasan pelayanan\nMelakukan pencatatan dan dokumentasi berkas kerja secara rapi',
            benefits_text: 'Gaji Pokok & Tunjangan Medis\nBPJS Kesehatan & Ketenagakerjaan\nPelatihan & Pengembangan Karir',
            short_description_id: '',
            description_id: '',
            status: 'open',
            is_featured: false,
            is_active: true,
        };
        this.modalOpen = true;
    },
    openEditModal(item) {
        this.editMode = true;
        this.editId = item.id;
        
        let reqsFormatted = '';
        if (item.requirements && Array.isArray(item.requirements)) {
            reqsFormatted = item.requirements.join('\n');
        }

        let respsFormatted = '';
        if (item.responsibilities && Array.isArray(item.responsibilities)) {
            respsFormatted = item.responsibilities.join('\n');
        }

        let bensFormatted = '';
        if (item.benefits && Array.isArray(item.benefits)) {
            bensFormatted = item.benefits.join('\n');
        }

        this.formData = {
            title_id: item.title_id || '',
            title_en: item.title_en || '',
            department: item.department || 'Keperawatan',
            employment_type: item.employment_type || 'Full Time',
            education_level: item.education_level || '',
            experience_years: item.experience_years || '',
            location: item.location || 'RSU Fikri Medika, Karawang',
            quota: item.quota || '',
            deadline: item.deadline || '',
            requirements_text: reqsFormatted,
            responsibilities_text: respsFormatted,
            benefits_text: bensFormatted,
            short_description_id: item.short_description_id || '',
            description_id: item.description_id || '',
            status: item.status || 'open',
            is_featured: Boolean(item.is_featured),
            is_active: Boolean(item.is_active),
        };
        this.modalOpen = true;
    }
}" class="space-y-6">

    <!-- TOP BAR -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-xs border border-gray-100">
        <div>
            <h1 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-briefcase text-[#0e7c47]"></i>
                <span>Manajemen Lowongan Karir & Rekrutmen</span>
            </h1>
            <p class="text-xs text-gray-500 mt-1">Publikasikan posisi lowongan kerja baru, atur batas waktu pendaftaran, dan pantau pelamar masuk.</p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <a href="{{ route('admin.applications.index') }}" 
               class="px-4 py-2.5 rounded-xl border border-gray-200 hover:border-[#0e7c47] bg-white text-slate-700 hover:text-[#0e7c47] font-bold text-xs shadow-2xs transition-all flex items-center gap-2">
                <i class="fa-solid fa-users text-xs"></i>
                <span>Database Pelamar CV ({{ \App\Models\JobApplication::count() }})</span>
            </a>

            <button @click="openAddModal()" 
                    type="button" 
                    style="background-color: #0e7c47; color: #ffffff;"
                    class="px-5 py-2.5 rounded-xl font-bold text-xs shadow-md hover:bg-[#096237] transition-all flex items-center justify-center gap-2 cursor-pointer shrink-0">
                <i class="fa-solid fa-plus text-sm"></i>
                <span>Buka Lowongan Baru</span>
            </button>
        </div>
    </div>

    <!-- QUICK STATS CARDS -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-2xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-base shrink-0 font-bold">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <div>
                <div class="text-lg font-black text-slate-900">{{ $careers->count() }}</div>
                <div class="text-[11px] text-slate-500 font-medium">Total Lowongan</div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-2xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0e7c47] flex items-center justify-center text-base shrink-0 font-bold">
                <i class="fa-solid fa-door-open"></i>
            </div>
            <div>
                <div class="text-lg font-black text-[#0e7c47]">{{ $careers->where('is_open', true)->count() }}</div>
                <div class="text-[11px] text-slate-500 font-medium">Lowongan Buka</div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-2xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-base shrink-0 font-bold">
                <i class="fa-solid fa-door-closed"></i>
            </div>
            <div>
                <div class="text-lg font-black text-amber-700">{{ $careers->where('is_open', false)->count() }}</div>
                <div class="text-[11px] text-slate-500 font-medium">Lowongan Tutup</div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-2xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-base shrink-0 font-bold">
                <i class="fa-solid fa-file-lines"></i>
            </div>
            <div>
                <div class="text-lg font-black text-blue-700">{{ \App\Models\JobApplication::count() }}</div>
                <div class="text-[11px] text-slate-500 font-medium">Total Pelamar CV</div>
            </div>
        </div>
    </div>

    <!-- FILTER & SEARCH -->
    <div class="bg-white p-4 rounded-2xl shadow-xs border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- SEARCH INPUT -->
        <div class="relative w-full md:w-80">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" 
                   x-model="search" 
                   placeholder="Cari nama posisi, bidang, pendidikan..." 
                   class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:ring-1 focus:ring-[#0e7c47]">
        </div>

        <!-- DEPARTMENT TABS -->
        <div class="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto pb-1 md:pb-0">
            <button type="button" 
                    @click="deptFilter = 'all'" 
                    :class="deptFilter === 'all' ? 'bg-[#0e7c47] text-white font-bold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    class="px-3.5 py-1.5 rounded-lg text-xs transition-all cursor-pointer whitespace-nowrap">
                Semua Bidang ({{ $careers->count() }})
            </button>
            <button type="button" 
                    @click="deptFilter = 'Keperawatan'" 
                    :class="deptFilter === 'Keperawatan' ? 'bg-[#0e7c47] text-white font-bold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    class="px-3.5 py-1.5 rounded-lg text-xs transition-all cursor-pointer whitespace-nowrap">
                Keperawatan
            </button>
            <button type="button" 
                    @click="deptFilter = 'Medis'" 
                    :class="deptFilter === 'Medis' ? 'bg-[#0e7c47] text-white font-bold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    class="px-3.5 py-1.5 rounded-lg text-xs transition-all cursor-pointer whitespace-nowrap">
                Medis
            </button>
            <button type="button" 
                    @click="deptFilter = 'Farmasi'" 
                    :class="deptFilter === 'Farmasi' ? 'bg-[#0e7c47] text-white font-bold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    class="px-3.5 py-1.5 rounded-lg text-xs transition-all cursor-pointer whitespace-nowrap">
                Farmasi
            </button>
            <button type="button" 
                    @click="deptFilter = 'Penunjang Medis'" 
                    :class="deptFilter === 'Penunjang Medis' ? 'bg-[#0e7c47] text-white font-bold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    class="px-3.5 py-1.5 rounded-lg text-xs transition-all cursor-pointer whitespace-nowrap">
                Penunjang
            </button>
            <button type="button" 
                    @click="deptFilter = 'Administrasi & IT'" 
                    :class="deptFilter === 'Administrasi & IT' ? 'bg-[#0e7c47] text-white font-bold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    class="px-3.5 py-1.5 rounded-lg text-xs transition-all cursor-pointer whitespace-nowrap">
                IT & Admin
            </button>
        </div>
    </div>

    <!-- CAREERS TABLE -->
    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50 text-gray-700 font-bold border-b border-gray-100 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Posisi & Bidang</th>
                        <th class="py-3.5 px-4">Tipe & Pendidikan</th>
                        <th class="py-3.5 px-4">Batas Lamaran</th>
                        <th class="py-3.5 px-4 text-center">Status Loker</th>
                        <th class="py-3.5 px-4 text-center">Pelamar CV</th>
                        <th class="py-3.5 px-4 text-center">Tampil Web</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($careers as $index => $career)
                    @php
                        $badgeTheme = $career->department_badge;
                        $jsonItem = [
                            'id' => $career->id,
                            'title_id' => $career->getTranslation('title', 'id') ?? '',
                            'title_en' => $career->getTranslation('title', 'en') ?? '',
                            'department' => $career->department,
                            'employment_type' => $career->employment_type,
                            'education_level' => $career->education_level,
                            'experience_years' => $career->experience_years,
                            'location' => $career->location,
                            'quota' => $career->quota,
                            'deadline' => $career->deadline ? $career->deadline->format('Y-m-d') : '',
                            'requirements' => $career->requirements ?? [],
                            'responsibilities' => $career->responsibilities ?? [],
                            'benefits' => $career->benefits ?? [],
                            'short_description_id' => $career->getTranslation('short_description', 'id') ?? '',
                            'description_id' => $career->getTranslation('description', 'id') ?? '',
                            'status' => $career->status,
                            'is_featured' => (bool)$career->is_featured,
                            'is_active' => (bool)$career->is_active,
                        ];
                    @endphp
                    <tr x-show="(deptFilter === 'all' || deptFilter === '{{ addslashes($career->department) }}') && (search === '' || '{{ addslashes(strtolower($career->tr('title') . ' ' . $career->department . ' ' . $career->education_level)) }}'.includes(search.toLowerCase()))"
                        class="hover:bg-slate-50/80 transition-colors">
                        
                        <td class="py-3.5 px-4 text-center font-bold text-gray-400">{{ $index + 1 }}</td>
                        
                        <!-- TITLE & DEPARTMENT -->
                        <td class="py-3.5 px-4">
                            <div class="space-y-1">
                                <span class="px-2 py-0.5 rounded-md {{ $badgeTheme['bg'] }} {{ $badgeTheme['text'] }} font-bold text-[10px] uppercase border {{ $badgeTheme['border'] }}">
                                    <i class="fa-solid {{ $badgeTheme['icon'] }} mr-0.5"></i>
                                    {{ $career->department }}
                                </span>
                                @if($career->is_featured)
                                <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 font-bold text-[10px] uppercase">
                                    ⭐ Spotlight
                                </span>
                                @endif
                                <div class="font-bold text-gray-900 text-sm leading-snug">{{ $career->tr('title') }}</div>
                                <div class="text-[11px] text-gray-400 flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot text-slate-300"></i>
                                    <span>{{ $career->location }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- TYPE & EDUCATION -->
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-gray-800">{{ $career->education_level }}</div>
                            <div class="text-[11px] text-gray-500 mt-0.5 flex items-center gap-2">
                                <span class="text-blue-600 font-semibold">{{ $career->employment_type }}</span>
                                <span>•</span>
                                <span>{{ $career->experience_years }}</span>
                            </div>
                        </td>

                        <!-- DEADLINE -->
                        <td class="py-3.5 px-4">
                            <div class="font-semibold text-gray-800 flex items-center gap-1.5">
                                <i class="fa-regular fa-calendar-check text-[#0e7c47]"></i>
                                <span>{{ $career->deadline_formatted }}</span>
                            </div>
                        </td>

                        <!-- STATUS (OPEN/CLOSED) -->
                        <td class="py-3.5 px-4 text-center">
                            <button type="button"
                                    @click="
                                        fetch('{{ route('admin.careers.toggleStatus', $career->id) }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            }
                                        }).then(r => r.json()).then(data => {
                                            if(data.success) { location.reload(); }
                                        })
                                    "
                                    class="px-2.5 py-1 rounded-full text-[11px] font-extrabold cursor-pointer transition-all {{ $career->is_open ? 'bg-emerald-50 text-[#0e7c47] border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200 hover:bg-slate-200' }}">
                                @if($career->is_open)
                                    🟢 Dibuka
                                @else
                                    ⚪ Ditutup
                                @endif
                            </button>
                        </td>

                        <!-- PELAMAR CV COUNT -->
                        <td class="py-3.5 px-4 text-center">
                            <a href="{{ route('admin.applications.index', ['career_id' => $career->id]) }}" 
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 font-black text-xs transition-colors"
                               title="Lihat Pelamar Posisi Ini">
                                <i class="fa-solid fa-users text-xs"></i>
                                <span>{{ $career->applications_count }} Pelamar</span>
                            </a>
                        </td>

                        <!-- TOGGLE ACTIVE -->
                        <td class="py-3.5 px-4 text-center">
                            <button type="button" 
                                    @click="
                                        fetch('{{ route('admin.careers.toggleActive', $career->id) }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            }
                                        }).then(r => r.json()).then(data => {
                                            if(data.success) { location.reload(); }
                                        })
                                    "
                                    class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $career->is_active ? 'bg-[#0e7c47]' : 'bg-gray-200' }}">
                                <span class="sr-only">Toggle</span>
                                <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out {{ $career->is_active ? 'translate-x-4' : 'translate-x-0' }}"></span>
                            </button>
                        </td>

                        <!-- ACTIONS -->
                        <td class="py-3.5 px-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('karir.show', $career->slug) }}" 
                                   target="_blank"
                                   class="w-7 h-7 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-600 flex items-center justify-center transition-colors" 
                                   title="Lihat Halaman Publik">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                </a>

                                <button type="button" 
                                        @click='openEditModal({!! json_encode($jsonItem, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!})' 
                                        class="w-7 h-7 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition-colors cursor-pointer" 
                                        title="Edit Lowongan">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </button>

                                <form action="{{ route('admin.careers.destroy', $career->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan pekerjaan ini beserta data pelamarnya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition-colors cursor-pointer" title="Hapus Lowongan">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-10 text-center text-gray-400">
                            <i class="fa-solid fa-briefcase text-3xl mb-2 text-gray-300"></i>
                            <p>Belum ada data lowongan pekerjaan yang dibuat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL FORM TAMBAH / EDIT LOWONGAN -->
    <div x-show="modalOpen" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs" 
         style="display: none;">
        
        <div @click.away="modalOpen = false" 
             class="bg-white w-full max-w-3xl rounded-3xl shadow-2xl overflow-hidden relative flex flex-col max-h-[90vh]">
            
            <!-- HEADER -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-slate-50/80">
                <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-briefcase text-[#0e7c47]"></i>
                    <span x-text="editMode ? 'Edit Posisi Lowongan Kerja' : 'Buka Posisi Lowongan Kerja Baru'"></span>
                </h3>
                <button type="button" @click="modalOpen = false" class="text-gray-400 hover:text-gray-600 cursor-pointer p-1.5 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <!-- FORM BODY -->
            <form :action="editMode ? '{{ url('admin/careers') }}/' + editId : '{{ route('admin.careers.store') }}'" 
                  method="POST" 
                  class="overflow-y-auto flex-1 p-6 space-y-4 text-xs">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <!-- JUDUL POSISI -->
                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Nama Posisi / Jabatan Pekerjaan <span class="text-red-500">*</span></label>
                    <input type="text" name="title_id" x-model="formData.title_id" required placeholder="Contoh: Perawat Pelaksana Rawat Inap & IGD" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                </div>

                <!-- BIDANG / DEPARTEMEN & TIPE PEKERJAAN -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Bidang / Departemen <span class="text-red-500">*</span></label>
                        <select name="department" x-model="formData.department" required class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] bg-white">
                            <option value="Keperawatan">Keperawatan</option>
                            <option value="Medis">Medis (Dokter Umum / Spesialis)</option>
                            <option value="Farmasi">Farmasi</option>
                            <option value="Penunjang Medis">Penunjang Medis (Radiologi, Lab, Gizi, Fisioterapi)</option>
                            <option value="Administrasi & IT">Administrasi, Rekam Medis & IT</option>
                            <option value="Umum & Keuangan">Umum, Keuangan & Logistik</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Tipe Pekerjaan <span class="text-red-500">*</span></label>
                        <select name="employment_type" x-model="formData.employment_type" required class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] bg-white">
                            <option value="Full Time">Full Time (Penuh Waktu)</option>
                            <option value="Kontrak">Kontrak (PKWT)</option>
                            <option value="Part Time">Part Time / Paruh Waktu</option>
                            <option value="Mitra Dokter">Mitra Dokter / Dokter Tamu</option>
                            <option value="Magang / Internship">Magang / Internship</option>
                        </select>
                    </div>
                </div>

                <!-- PENDIDIKAN & PENGALAMAN -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Pendidikan Minimal <span class="text-red-500">*</span></label>
                        <input type="text" name="education_level" x-model="formData.education_level" required placeholder="Contoh: D3 Keperawatan / Profesi Ners" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Pengalaman Kerja</label>
                        <input type="text" name="experience_years" x-model="formData.experience_years" placeholder="Contoh: Fresh Graduate / Minimal 1 Tahun" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                </div>

                <!-- LOKASI, KUOTA, DEADLINE -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Lokasi Penempatan <span class="text-red-500">*</span></label>
                        <input type="text" name="location" x-model="formData.location" required placeholder="RSU Fikri Medika, Karawang" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Kebutuhan / Kuota</label>
                        <input type="text" name="quota" x-model="formData.quota" placeholder="Contoh: 3 Orang" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Batas Akhir Lamaran</label>
                        <input type="date" name="deadline" x-model="formData.deadline" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                </div>

                <!-- KUALIFIKASI / PERSYARATAN (1 PER BARIS) -->
                <div class="space-y-1">
                    <label class="font-bold text-gray-700 flex items-center justify-between">
                        <span>Kualifikasi & Persyaratan (1 Baris 1 Poin)</span>
                        <span class="text-[10px] text-slate-400 font-normal">Gunakan Enter untuk poin baru</span>
                    </label>
                    <textarea name="requirements_text" x-model="formData.requirements_text" rows="4" placeholder="Pendidikan minimal D3 Keperawatan&#10;Memiliki STR aktif&#10;Memiliki sertifikat BTCLS aktif&#10;Bersedia bekerja shift" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] font-mono text-[11px]"></textarea>
                </div>

                <!-- TANGGUNG JAWAB PEKERJAAN (1 PER BARIS) -->
                <div class="space-y-1">
                    <label class="font-bold text-gray-700 flex items-center justify-between">
                        <span>Tanggung Jawab Pekerjaan (1 Baris 1 Poin)</span>
                        <span class="text-[10px] text-slate-400 font-normal">Gunakan Enter untuk poin baru</span>
                    </label>
                    <textarea name="responsibilities_text" x-model="formData.responsibilities_text" rows="3" placeholder="Memberikan asuhan keperawatan profesional&#10;Memantau tanda vital pasien&#10;Melakukan edukasi kesehatan pasien" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] font-mono text-[11px]"></textarea>
                </div>

                <!-- BENEFIT & FASILITAS (1 PER BARIS) -->
                <div class="space-y-1">
                    <label class="font-bold text-gray-700 flex items-center justify-between">
                        <span>Benefit & Fasilitas Kerja (1 Baris 1 Poin)</span>
                        <span class="text-[10px] text-slate-400 font-normal">Gunakan Enter untuk poin baru</span>
                    </label>
                    <textarea name="benefits_text" x-model="formData.benefits_text" rows="2" placeholder="Gaji Pokok & Tunjangan Medis&#10;BPJS Kesehatan & Ketenagakerjaan&#10;Pelatihan Berkelanjutan" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] font-mono text-[11px]"></textarea>
                </div>

                <!-- DESKRIPSI SINGKAT & LENGKAP -->
                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Ringkasan Singkat Posisi (Tampil di kartu)</label>
                    <textarea name="short_description_id" x-model="formData.short_description_id" rows="2" placeholder="Ringkasan tugas utama posisi ini..." class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]"></textarea>
                </div>

                <!-- STATUS BUKA/TUTUP & CHECKBOXES -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Status Pembukaan</label>
                        <select name="status" x-model="formData.status" class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-white">
                            <option value="open">🟢 Dibuka (Menerima Lamaran)</option>
                            <option value="closed">⚪ Ditutup (Tidak Menerima Lamaran)</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2 flex items-center gap-5 pt-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" x-model="formData.is_featured" class="rounded text-[#0e7c47] focus:ring-[#0e7c47]">
                            <span class="font-bold text-gray-700">Lowongan Unggulan / Spotlight</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" x-model="formData.is_active" class="rounded text-[#0e7c47] focus:ring-[#0e7c47]">
                            <span class="font-bold text-gray-700">Tampil Aktif di Website</span>
                        </label>
                    </div>
                </div>

                <!-- MODAL FOOTER BUTTONS -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-2.5">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" 
                            style="background-color: #0e7c47; color: #ffffff;"
                            class="px-5 py-2 rounded-xl font-bold shadow-md hover:bg-[#096237] transition-all cursor-pointer">
                        <span x-text="editMode ? 'Simpan Perubahan' : 'Terbitkan Lowongan'"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
