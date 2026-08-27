@extends('layouts.admin')

@section('title', 'Database Pelamar Karir & CV - Admin RSU Fikri Medika')

@section('content')
<div x-data="{
    detailModalOpen: false,
    selectedApp: {
        id: null,
        full_name: '',
        email: '',
        phone: '',
        career_title: '',
        last_education: '',
        experience_years: '',
        str_number: '',
        cv_file_url: '',
        portfolio_url: '',
        cover_letter: '',
        status: 'pending',
        status_label: '',
        hrd_notes: '',
        created_at: ''
    },
    openDetail(item) {
        this.selectedApp = {
            id: item.id,
            full_name: item.full_name || '',
            email: item.email || '',
            phone: item.phone || '',
            career_title: item.career ? (item.career.title_id || item.career.title) : 'Posisi Umum',
            last_education: item.last_education || '-',
            experience_years: item.experience_years || '-',
            str_number: item.str_number || '-',
            cv_file_url: item.cv_file_url || '',
            portfolio_url: item.portfolio_url || '',
            cover_letter: item.cover_letter || '',
            status: item.status || 'pending',
            status_label: item.status_label || 'Baru',
            hrd_notes: item.hrd_notes || '',
            created_at: item.created_at_formatted || ''
        };
        this.detailModalOpen = true;
    }
}" class="space-y-6">

    <!-- TOP BAR -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-xs border border-gray-100">
        <div>
            <h1 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-users text-[#0e7c47]"></i>
                <span>Database Pelamar Karir & Berkas CV</span>
            </h1>
            <p class="text-xs text-gray-500 mt-1">Review berkas CV pelamar, perbarui status seleksi (Interview/Lolos/Ditolak), dan simpan catatan internal HRD.</p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.careers.index') }}" 
               class="px-4 py-2.5 rounded-xl border border-gray-200 hover:border-[#0e7c47] bg-white text-slate-700 hover:text-[#0e7c47] font-bold text-xs shadow-2xs transition-all flex items-center gap-2">
                <i class="fa-solid fa-briefcase text-xs"></i>
                <span>Kelola Posisi Lowongan</span>
            </a>
        </div>
    </div>

    <!-- STATS COUNTERS -->
    <div class="grid grid-cols-2 sm:grid-cols-6 gap-3">
        <a href="{{ route('admin.applications.index', ['status' => 'all']) }}" class="p-4 rounded-2xl bg-white border border-gray-100 shadow-2xs hover:border-slate-300 transition-all">
            <div class="text-[10px] font-bold text-slate-400 uppercase">Total Pelamar</div>
            <div class="text-xl font-black text-slate-900 mt-1">{{ $stats['total'] }}</div>
        </a>

        <a href="{{ route('admin.applications.index', ['status' => 'pending']) }}" class="p-4 rounded-2xl bg-white border {{ $status === 'pending' ? 'border-slate-400 ring-2 ring-slate-200' : 'border-gray-100' }} shadow-2xs hover:border-slate-300 transition-all">
            <div class="text-[10px] font-bold text-slate-500 uppercase">📥 Lamaran Baru</div>
            <div class="text-xl font-black text-slate-800 mt-1">{{ $stats['pending'] }}</div>
        </a>

        <a href="{{ route('admin.applications.index', ['status' => 'reviewed']) }}" class="p-4 rounded-2xl bg-white border {{ $status === 'reviewed' ? 'border-blue-400 ring-2 ring-blue-200' : 'border-gray-100' }} shadow-2xs hover:border-blue-300 transition-all">
            <div class="text-[10px] font-bold text-blue-600 uppercase">👀 Direview</div>
            <div class="text-xl font-black text-blue-700 mt-1">{{ $stats['reviewed'] }}</div>
        </a>

        <a href="{{ route('admin.applications.index', ['status' => 'interview']) }}" class="p-4 rounded-2xl bg-white border {{ $status === 'interview' ? 'border-amber-400 ring-2 ring-amber-200' : 'border-gray-100' }} shadow-2xs hover:border-amber-300 transition-all">
            <div class="text-[10px] font-bold text-amber-600 uppercase">🗣️ Panggilan Interview</div>
            <div class="text-xl font-black text-amber-700 mt-1">{{ $stats['interview'] }}</div>
        </a>

        <a href="{{ route('admin.applications.index', ['status' => 'accepted']) }}" class="p-4 rounded-2xl bg-white border {{ $status === 'accepted' ? 'border-emerald-400 ring-2 ring-emerald-200' : 'border-gray-100' }} shadow-2xs hover:border-emerald-300 transition-all">
            <div class="text-[10px] font-bold text-[#0e7c47] uppercase">✅ Lolos / Diterima</div>
            <div class="text-xl font-black text-[#0e7c47] mt-1">{{ $stats['accepted'] }}</div>
        </a>

        <a href="{{ route('admin.applications.index', ['status' => 'rejected']) }}" class="p-4 rounded-2xl bg-white border {{ $status === 'rejected' ? 'border-red-400 ring-2 ring-red-200' : 'border-gray-100' }} shadow-2xs hover:border-red-300 transition-all">
            <div class="text-[10px] font-bold text-red-600 uppercase">❌ Tidak Lolos</div>
            <div class="text-xl font-black text-red-700 mt-1">{{ $stats['rejected'] }}</div>
        </a>
    </div>

    <!-- FILTER & SEARCH BAR -->
    <form method="GET" action="{{ route('admin.applications.index') }}" class="bg-white p-4 rounded-2xl shadow-xs border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
        
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
            {{-- FILTER CAREER POSITION --}}
            <select name="career_id" onchange="this.form.submit()" class="w-full sm:w-60 px-3.5 py-2 text-xs rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] bg-white">
                <option value="all">-- Semua Posisi Lowongan --</option>
                @foreach($careers as $cr)
                <option value="{{ $cr->id }}" {{ $careerId == $cr->id ? 'selected' : '' }}>{{ $cr->tr('title') }}</option>
                @endforeach
            </select>

            {{-- FILTER STATUS --}}
            <select name="status" onchange="this.form.submit()" class="w-full sm:w-48 px-3.5 py-2 text-xs rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] bg-white">
                <option value="all" {{ $status === 'all' || empty($status) ? 'selected' : '' }}>-- Semua Status --</option>
                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>📥 Baru (Pending)</option>
                <option value="reviewed" {{ $status === 'reviewed' ? 'selected' : '' }}>👀 Sedang Direview</option>
                <option value="interview" {{ $status === 'interview' ? 'selected' : '' }}>🗣️ Panggilan Interview</option>
                <option value="accepted" {{ $status === 'accepted' ? 'selected' : '' }}>✅ Lolos / Diterima</option>
                <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>❌ Tidak Lolos</option>
            </select>
        </div>

        {{-- SEARCH INPUT --}}
        <div class="relative w-full md:w-72">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" 
                   name="search" 
                   value="{{ $search }}" 
                   placeholder="Cari nama, email, no HP..." 
                   class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
        </div>

    </form>

    <!-- APPLICANTS TABLE -->
    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50 text-gray-700 font-bold border-b border-gray-100 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Nama Pelamar & Kontak</th>
                        <th class="py-3.5 px-4">Posisi yang Dilamar</th>
                        <th class="py-3.5 px-4">Pendidikan & Pengalaman</th>
                        <th class="py-3.5 px-4 text-center">Berkas CV</th>
                        <th class="py-3.5 px-4 text-center">Status Seleksi</th>
                        <th class="py-3.5 px-4">Tanggal Lamar</th>
                        <th class="py-3.5 px-4 text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($applications as $index => $app)
                    @php
                        $badge = $app->status_badge;
                        $cleanPhone = preg_replace('/[^0-9]/', '', $app->phone);
                        if (str_starts_with($cleanPhone, '0')) {
                            $cleanPhone = '62' . substr($cleanPhone, 1);
                        }
                        $waText = urlencode("Halo {$app->full_name}, kami dari Tim HRD RSU Fikri Medika menghubungi Anda terkait lamaran posisi {$app->career?->tr('title')}.");

                        $jsonApp = [
                            'id' => $app->id,
                            'full_name' => $app->full_name,
                            'email' => $app->email,
                            'phone' => $app->phone,
                            'career' => [
                                'title_id' => $app->career?->tr('title'),
                            ],
                            'last_education' => $app->last_education,
                            'experience_years' => $app->experience_years,
                            'str_number' => $app->str_number,
                            'cv_file_url' => $app->cv_file_url,
                            'portfolio_url' => $app->portfolio_url,
                            'cover_letter' => $app->cover_letter,
                            'status' => $app->status,
                            'status_label' => $app->status_label,
                            'hrd_notes' => $app->hrd_notes,
                            'created_at_formatted' => $app->created_at->translatedFormat('d F Y, H:i') . ' WIB',
                        ];
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        
                        <td class="py-3.5 px-4 text-center font-bold text-gray-400">{{ $index + 1 }}</td>

                        <!-- NAMA & KONTAK -->
                        <td class="py-3.5 px-4">
                            <div class="space-y-1">
                                <div class="font-bold text-gray-900 text-sm">{{ $app->full_name }}</div>
                                <div class="text-[11px] text-gray-500 flex items-center gap-1">
                                    <i class="fa-regular fa-envelope text-slate-400"></i>
                                    <span>{{ $app->email }}</span>
                                </div>
                                <div class="text-[11px] text-gray-500 flex items-center gap-2">
                                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" 
                                       target="_blank"
                                       class="text-emerald-700 hover:text-emerald-800 font-bold flex items-center gap-1 hover:underline"
                                       title="Kirim WhatsApp ke Kandidat">
                                        <i class="fa-brands fa-whatsapp text-emerald-600"></i>
                                        <span>{{ $app->phone }}</span>
                                    </a>
                                </div>
                            </div>
                        </td>

                        <!-- POSISI LOKER -->
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-gray-900 text-xs leading-snug">
                                {{ $app->career?->tr('title') ?? 'Posisi Tidak Ditemukan' }}
                            </div>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-bold text-[10px]">
                                {{ $app->career?->department ?? 'Umum' }}
                            </span>
                        </td>

                        <!-- PENDIDIKAN & PENGALAMAN -->
                        <td class="py-3.5 px-4">
                            <div class="font-semibold text-gray-800">{{ $app->last_education ?: '-' }}</div>
                            <div class="text-[11px] text-gray-500 mt-0.5">{{ $app->experience_years ?: 'Fresh Graduate' }}</div>
                            @if($app->str_number)
                            <div class="text-[10px] text-emerald-700 font-mono mt-0.5">STR: {{ $app->str_number }}</div>
                            @endif
                        </td>

                        <!-- BERKAS CV DOWNLOAD / PREVIEW -->
                        <td class="py-3.5 px-4 text-center">
                            @if($app->cv_file_url)
                            <a href="{{ $app->cv_file_url }}" 
                               target="_blank"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-[#0e7c47] font-black text-xs border border-emerald-200 transition-all shadow-2xs">
                                <i class="fa-solid fa-file-pdf text-red-600 text-sm"></i>
                                <span>Buka CV</span>
                            </a>
                            @else
                            <span class="text-[11px] text-gray-400">Tidak ada file</span>
                            @endif
                        </td>

                        <!-- STATUS SELEKSI -->
                        <td class="py-3.5 px-4 text-center">
                            <button type="button"
                                    @click='openDetail({!! json_encode($jsonApp, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!})'
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black border {{ $badge['bg'] }} cursor-pointer hover:opacity-80 transition-all">
                                <i class="fa-solid {{ $badge['icon'] }} text-[10px]"></i>
                                <span>{{ $app->status_label }}</span>
                            </button>
                        </td>

                        <!-- TANGGAL LAMAR -->
                        <td class="py-3.5 px-4 text-[11px] text-gray-500">
                            <div>{{ $app->created_at->translatedFormat('d M Y') }}</div>
                            <div class="text-[10px] text-gray-400">{{ $app->created_at->format('H:i') }} WIB</div>
                        </td>

                        <!-- AKSI -->
                        <td class="py-3.5 px-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <button type="button" 
                                        @click='openDetail({!! json_encode($jsonApp, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!})' 
                                        class="w-7 h-7 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition-colors cursor-pointer" 
                                        title="Detail & Update Status">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </button>

                                <form action="{{ route('admin.applications.destroy', $app->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data lamaran pelamar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition-colors cursor-pointer" title="Hapus Pelamar">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-gray-400">
                            <i class="fa-solid fa-inbox text-3xl mb-2 text-gray-300"></i>
                            <p class="font-bold text-slate-700">Belum ada pelamar kerja pada filter ini.</p>
                            <p class="text-xs text-slate-400 mt-0.5">Lamaran yang dikirim pelamar dari website akan langsung tampil di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL DETAIL PELAMAR & UPDATE STATUS SELEKSI -->
    <div x-show="detailModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs" 
         style="display: none;">
        
        <div @click.away="detailModalOpen = false" 
             class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden relative flex flex-col max-h-[90vh]">
            
            <!-- HEADER -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-slate-50/80">
                <div>
                    <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-user-tie text-[#0e7c47]"></i>
                        <span>Detail Pelamar & Penilaian HRD</span>
                    </h3>
                    <p class="text-[11px] text-gray-500 mt-0.5">Dilamar pada <span x-text="selectedApp.created_at"></span></p>
                </div>
                <button type="button" @click="detailModalOpen = false" class="text-gray-400 hover:text-gray-600 cursor-pointer p-1.5 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <!-- MODAL BODY -->
            <div class="overflow-y-auto flex-1 p-6 space-y-5 text-xs">
                
                {{-- APPLICANT PROFILE SUMMARY --}}
                <div class="p-4 rounded-2xl bg-slate-50 border border-gray-100 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h4 class="font-black text-slate-900 text-base" x-text="selectedApp.full_name"></h4>
                            <div class="text-xs font-bold text-[#0e7c47] mt-0.5">
                                Posisi: <span x-text="selectedApp.career_title"></span>
                            </div>
                        </div>

                        <template x-if="selectedApp.cv_file_url">
                            <a :href="selectedApp.cv_file_url" 
                               target="_blank"
                               class="px-3.5 py-2 rounded-xl bg-[#0e7c47] text-white font-bold text-xs hover:bg-[#096237] transition-all flex items-center gap-1.5 shadow-xs shrink-0">
                                <i class="fa-solid fa-file-pdf"></i>
                                <span>Buka / Unduh CV</span>
                            </a>
                        </template>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 pt-2 border-t border-gray-200/60 text-slate-600">
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Email:</span>
                            <span class="font-bold text-slate-800" x-text="selectedApp.email"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">No. WhatsApp:</span>
                            <span class="font-bold text-slate-800" x-text="selectedApp.phone"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Pendidikan:</span>
                            <span class="font-bold text-slate-800" x-text="selectedApp.last_education"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Pengalaman:</span>
                            <span class="font-bold text-slate-800" x-text="selectedApp.experience_years"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">No. STR:</span>
                            <span class="font-bold text-slate-800" x-text="selectedApp.str_number"></span>
                        </div>
                    </div>
                </div>

                {{-- PORTFOLIO LINK --}}
                <template x-if="selectedApp.portfolio_url">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Link Portofolio / Berkas Pendukung:</label>
                        <a :href="selectedApp.portfolio_url" target="_blank" class="block p-2.5 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:underline truncate">
                            <i class="fa-solid fa-link mr-1"></i>
                            <span x-text="selectedApp.portfolio_url"></span>
                        </a>
                    </div>
                </template>

                {{-- COVER LETTER --}}
                <template x-if="selectedApp.cover_letter">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Surat Lamaran / Motivasi Kandidat:</label>
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-gray-100 text-slate-700 leading-relaxed italic" x-text="selectedApp.cover_letter"></div>
                    </div>
                </template>

                {{-- FORM UPDATE STATUS & CATATAN HRD --}}
                <form :action="'{{ url('admin/applications') }}/' + selectedApp.id + '/status'" method="POST" class="p-4 sm:p-5 rounded-2xl bg-emerald-50/50 border border-emerald-200 space-y-4">
                    @csrf
                    
                    <div class="space-y-1">
                        <label class="font-bold text-emerald-950 flex items-center gap-1.5">
                            <i class="fa-solid fa-stamp text-[#0e7c47]"></i>
                            <span>Update Status Seleksi Kandidat <span class="text-red-500">*</span></span>
                        </label>
                        <select name="status" x-model="selectedApp.status" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] bg-white text-xs font-bold">
                            <option value="pending">📥 Lamaran Baru (Belum Diproses)</option>
                            <option value="reviewed">👀 Sedang Direview Berkas</option>
                            <option value="interview">🗣️ Panggilan Wawancara / Interview</option>
                            <option value="accepted">✅ Lolos Seleksi / Diterima</option>
                            <option value="rejected">❌ Tidak Lolos Kualifikasi</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-emerald-950 flex items-center gap-1.5">
                            <i class="fa-solid fa-notes-medical text-[#0e7c47]"></i>
                            <span>Catatan Internal HRD & Timeline Seleksi</span>
                        </label>
                        <textarea name="hrd_notes" x-model="selectedApp.hrd_notes" rows="3" placeholder="Contoh: Jadwal interview tgl 2 September pk 10.00 di Ruang HRD / Nilai tes kompetensi memuaskan..." class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] bg-white"></textarea>
                    </div>

                    <div class="flex justify-end pt-1">
                        <button type="submit" 
                                style="background-color: #0e7c47; color: #ffffff;"
                                class="px-5 py-2.5 rounded-xl font-bold text-xs shadow-md hover:bg-[#096237] transition-all flex items-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                            <span>Simpan Status & Catatan HRD</span>
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>

</div>
@endsection
