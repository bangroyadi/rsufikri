@extends('layouts.admin')

@section('title', 'Manajemen Artikel Kesehatan')

@section('content')
@php
    $polyclinics = isset($polyclinics) ? $polyclinics : \App\Models\Polyclinic::where('is_active', true)->with(['doctors' => fn($q) => $q->where('is_active', true)])->get();
    $polyclinicsJsonData = $polyclinics->map(function($p) {
        return [
            'id' => (int)$p->id,
            'name' => is_array($p->name) ? ($p->name['id'] ?? '') : $p->name,
            'doctors' => $p->doctors->map(function($d) {
                return [
                    'id' => (int)$d->id,
                    'name' => $d->name,
                    'specialty' => $d->tr('specialty') ?: 'Dokter Spesialis',
                    'photo' => $d->photo ?: '',
                ];
            })->values()->all(),
        ];
    });
@endphp

<div x-data="articleManager()" class="space-y-6">
    
    @if(session('success'))
    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #0e7c47;" class="p-4 rounded-2xl font-bold text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(isset($errors) && $errors->any())
    <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #dc2626;" class="p-4 rounded-2xl font-bold text-sm space-y-1">
        @foreach($errors->all() as $err)
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span>{{ $err }}</span>
        </div>
        @endforeach
    </div>
    @endif

    <!-- PAGE HEADER WITH TOP ADD BUTTON -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="p-6 rounded-3xl shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-900">Kelola Artikel Edukasi Kesehatan</h2>
            <p class="text-xs text-slate-500 mt-0.5">Edukasi kesehatan, tips medis, dan pemetaan poliklinik & dokter spesialis RSU Fikri Medika.</p>
        </div>

        <button @click="openAdd()" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2.5 rounded-xl font-extrabold text-xs shadow-md hover:bg-[#096237] hover:shadow-lg transition-all flex items-center justify-center gap-2 shrink-0 cursor-pointer">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>+ Terbitkan Artikel Baru</span>
        </button>
    </div>

    <!-- TABLE & SEARCH FILTER CONTAINER -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl shadow-xs overflow-hidden">
        
        <!-- SEARCH & FILTER TOOLBAR -->
        <div style="border-bottom: 1px solid #f1f5f9; background-color: #f8fafc;" class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-filter text-emerald-600 text-sm"></i>
                <h3 class="font-black text-slate-900 text-sm">Filter & Pencarian Artikel</h3>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- SEARCH INPUT -->
                <div style="position: relative; width: 100%; max-width: 260px;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px; pointer-events: none; z-index: 10;"></i>
                    <input type="text" x-model="search" placeholder="Cari judul / poli / dokter..." style="padding-left: 38px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; border-radius: 12px; border: 1px solid #cbd5e1; font-size: 12px; width: 100%; background-color: #ffffff; outline: none;" class="focus:ring-2 focus:ring-[#0e7c47]">
                </div>

                <!-- CATEGORY FILTER DROPDOWN -->
                <select x-model="filterCat" class="px-3.5 py-2 rounded-xl border border-slate-300 bg-white text-xs font-semibold focus:ring-2 focus:ring-[#0e7c47] outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach($articles->pluck('category')->unique() as $cat)
                    @php $catName = is_array($cat) ? ($cat['id'] ?? '') : ($cat ?? 'Artikel'); @endphp
                    @if(!empty($catName))
                    <option value="{{ $catName }}">{{ $catName }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead style="background-color: #f1f5f9; border-bottom: 1px solid #e2e8f0; color: #475569;" class="uppercase tracking-wider font-extrabold">
                    <tr>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Judul Artikel</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Poli & Dokter Terkait</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                    @forelse($articles as $art)
                    @php
                        $aTitle = is_array($art->title) ? ($art->title['id'] ?? '') : $art->title;
                        $aCat = is_array($art->category) ? ($art->category['id'] ?? '') : ($art->category ?? 'Artikel');
                        $aExcerpt = is_array($art->excerpt) ? ($art->excerpt['id'] ?? '') : ($art->excerpt ?? '');
                        $aContent = is_array($art->content) ? ($art->content['id'] ?? '') : ($art->content ?? '');
                        $artDoctors = $art->doctors ?? collect();
                        $artPoliIds = $artDoctors->pluck('polyclinic_id')->filter()->unique()->values()->all();
                        $artPolis = $artDoctors->map(fn($d) => $d->polyclinic ? (is_array($d->polyclinic->name) ? ($d->polyclinic->name['id'] ?? '') : $d->polyclinic->name) : null)->filter()->unique()->values();
                        $artDocNames = $artDoctors->map(fn($d) => $d->name)->implode(', ');
                        $artPoliNames = $artPolis->implode(', ');
                    @endphp
                    <tr x-show="(search === '' || '{{ addslashes(strtolower($aTitle . ' ' . $artDocNames . ' ' . $artPoliNames)) }}'.includes(search.toLowerCase())) && (filterCat === '' || '{{ addslashes($aCat) }}' === filterCat)" class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 font-mono text-slate-400 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($art->published_at)->format('d M Y') }}
                        </td>
                        <td class="p-4 max-w-xs sm:max-w-md">
                            <div class="flex items-center gap-3">
                                @if($art->thumbnail)
                                <img src="{{ $art->thumbnail }}" alt="" class="w-10 h-10 rounded-xl object-cover shrink-0 border border-slate-100 bg-slate-100">
                                @else
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                                    <i class="fa-regular fa-newspaper"></i>
                                </div>
                                @endif
                                <div class="min-w-0">
                                    <div class="font-bold text-slate-900 text-sm leading-snug line-clamp-2">{{ $aTitle }}</div>
                                    <a href="{{ route('artikel.show', $art->slug) }}" target="_blank" class="text-[11px] text-[#0e7c47] hover:underline flex items-center gap-1 mt-0.5">
                                        <span>Lihat di Website</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <span style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #0e7c47;" class="px-3 py-1 rounded-lg font-bold">
                                {{ $aCat }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if($artPolis->isNotEmpty())
                            <div class="space-y-1 max-w-xs">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($artPolis as $pName)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-900 border border-emerald-300 text-[11px] font-extrabold">
                                        <i class="fa-solid fa-hospital text-[#0e7c47] text-[10px]"></i>
                                        <span>{{ $pName }}</span>
                                    </span>
                                    @endforeach
                                </div>
                                <div class="text-[10px] text-slate-500 font-normal">
                                    {{ $artDoctors->count() }} Dokter terhubung: {{ $artDoctors->pluck('name')->implode(', ') }}
                                </div>
                            </div>
                            @elseif($artDoctors->isNotEmpty())
                            <div class="text-xs text-emerald-800 font-bold">
                                {{ $artDoctors->pluck('name')->implode(', ') }}
                            </div>
                            @else
                            <span class="text-slate-400 text-xs italic">Belum ada poli/dokter terkait</span>
                            @endif
                        </td>
                        <td class="p-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <button @click="openEdit({ 
                                    id: {{ $art->id }}, 
                                    title_id: '{{ addslashes($aTitle) }}', 
                                    category_id: '{{ addslashes($aCat) }}', 
                                    excerpt_id: '{{ addslashes($aExcerpt) }}', 
                                    content_id: '{{ addslashes($aContent) }}', 
                                    thumbnail: '{{ addslashes($art->thumbnail ?? '') }}'
                                }, {{ json_encode($artPoliIds) }})" style="background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a;" class="p-2 rounded-xl hover:bg-amber-100 transition-colors cursor-pointer" title="Edit Artikel">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <form action="{{ route('admin.articles.destroy', $art->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca;" class="p-2 rounded-xl hover:bg-red-100 transition-colors cursor-pointer" title="Hapus Artikel">
                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400">Belum ada data artikel kesehatan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ==================== ADD ARTICLE MODAL ==================== -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/70 backdrop-blur-xs p-3 sm:p-6 flex items-start justify-center">
        <div @click.away="addModalOpen = false" class="relative bg-white rounded-3xl w-full max-w-2xl shadow-2xl overflow-hidden border border-slate-200 my-3 sm:my-6 flex flex-col max-h-[calc(100vh-2rem)] sm:max-h-[calc(100vh-3.5rem)]">
            
            <!-- STICKY HEADER -->
            <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between bg-white shrink-0">
                <h3 class="font-black text-slate-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fa-solid fa-file-medical text-[#0e7c47]"></i>
                    <span>Tulis Artikel Edukasi Kesehatan Baru</span>
                </h3>
                <button type="button" @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600 cursor-pointer p-1 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- FORM WITH SCROLLABLE BODY & STICKY FOOTER -->
            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
                @csrf

                <!-- HIDDEN SYNCED POLYCLINIC IDS -->
                <template x-for="pId in addSelectedPolis" :key="'add-p-input-' + pId">
                    <input type="hidden" name="polyclinic_ids[]" :value="pId">
                </template>

                <!-- SCROLLABLE FORM BODY -->
                <div class="p-5 sm:p-6 overflow-y-auto space-y-4 flex-1 overscroll-contain">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Judul Artikel <span class="text-red-500">*</span></label>
                        <input type="text" name="title_id" required placeholder="Contoh: Rekomendasi Dokter Penyakit Dalam di Karawang..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Kategori</label>
                            <input type="text" name="category_id" placeholder="Edukasi Kesehatan / Penyakit Dalam" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Ringkasan Singkat (Excerpt)</label>
                            <input type="text" name="excerpt_id" placeholder="Ringkasan atau poin penting artikel..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                        </div>
                    </div>

                    <!-- POLIKLINIK SELECTION BOX (AUTO-MAPS DOCTORS) -->
                    <div class="p-4 rounded-2xl border border-emerald-200 bg-gradient-to-b from-emerald-50/60 to-slate-50/60 space-y-3">
                        <div class="flex items-center justify-between flex-wrap gap-2">
                            <div>
                                <label class="block text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-hospital text-[#0e7c47]"></i>
                                    <span>Pilih Poliklinik Terkait (Bisa Lebih Dari 1)</span>
                                </label>
                                <p class="text-[11px] text-slate-500">Klik tombol poli, seluruh dokter di poli tersebut otomatis terhubung ke artikel ini.</p>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-emerald-600 text-white font-bold text-xs shadow-xs" x-text="addSelectedPolis.length + ' Poli Terpilih'"></span>
                        </div>

                        <!-- POLI BUTTONS GRID -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 max-h-48 overflow-y-auto p-1.5 border border-slate-200 rounded-2xl bg-white overscroll-contain">
                            <template x-for="poli in polyclinicsList" :key="'add-grid-poli-' + poli.id">
                                <button type="button" 
                                        @click="togglePoli(addSelectedPolis, poli.id)" 
                                        class="flex items-center justify-between p-2.5 rounded-xl border text-left cursor-pointer transition-all"
                                        :class="isPoliSelected(addSelectedPolis, poli.id) ? 'bg-emerald-50 border-emerald-500 shadow-xs ring-1 ring-[#0e7c47]' : 'bg-slate-50/60 border-slate-200 hover:bg-slate-100 hover:border-slate-300'">
                                    <div class="min-w-0 pr-1">
                                        <div class="font-bold text-xs leading-snug truncate" :class="isPoliSelected(addSelectedPolis, poli.id) ? 'text-emerald-900' : 'text-slate-800'" x-text="poli.name"></div>
                                        <div class="text-[10px] text-slate-500 mt-0.5" x-text="poli.doctors.length + ' Dokter'"></div>
                                    </div>
                                    <div class="w-5 h-5 rounded-full flex items-center justify-center shrink-0" :class="isPoliSelected(addSelectedPolis, poli.id) ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-400'">
                                        <i class="fa-solid fa-check text-[10px]" x-show="isPoliSelected(addSelectedPolis, poli.id)"></i>
                                        <i class="fa-solid fa-plus text-[9px]" x-show="!isPoliSelected(addSelectedPolis, poli.id)"></i>
                                    </div>
                                </button>
                            </template>
                        </div>

                        <!-- AUTO-MAPPED DOCTORS PREVIEW -->
                        <div x-show="getDoctorsFromPolis(addSelectedPolis).length > 0" class="p-3 bg-emerald-50/80 rounded-2xl border border-emerald-200 space-y-2">
                            <div class="flex items-center justify-between text-xs font-black text-emerald-900">
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-user-doctor text-[#0e7c47]"></i>
                                    <span>Dokter yang Otomatis Terhubung:</span>
                                </span>
                                <span class="px-2 py-0.5 rounded-full bg-emerald-600 text-white text-[11px]" x-text="getDoctorsFromPolis(addSelectedPolis).length + ' Dokter'"></span>
                            </div>
                            <div class="flex flex-wrap gap-1.5 max-h-32 overflow-y-auto">
                                <template x-for="doc in getDoctorsFromPolis(addSelectedPolis)" :key="'doc-add-auto-' + doc.id">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white text-emerald-900 border border-emerald-200 text-[11px] font-bold shadow-2xs">
                                        <i class="fa-solid fa-circle-check text-[#0e7c47] text-[10px]"></i>
                                        <span x-text="doc.name"></span>
                                    </span>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Konten Lengkap Artikel</label>
                        <textarea name="content_id" rows="5" placeholder="Tulis isi lengkap artikel edukasi kesehatan di sini..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none font-sans leading-relaxed"></textarea>
                    </div>

                    <!-- FILE UPLOAD OR URL -->
                    <div style="background-color: #f8fafc; border: 1px solid #e2e8f0;" class="p-4 rounded-2xl space-y-3">
                        <label class="block text-xs font-extrabold text-slate-900 uppercase tracking-wider">Thumbnail / Gambar Artikel</label>
                        
                        <div>
                            <span class="text-[11px] font-bold text-slate-600 block mb-1">📷 Upload File Gambar dari Komputer:</span>
                            <input type="file" name="thumbnail_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-[#0e7c47] hover:file:bg-emerald-100 cursor-pointer">
                        </div>

                        <div class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">— ATAU —</div>

                        <div>
                            <span class="text-[11px] font-bold text-slate-600 block mb-1">🔗 Tempel Link / URL Gambar:</span>
                            <input type="text" name="thumbnail" placeholder="https://images.unsplash.com/..." class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none">
                        </div>
                    </div>
                </div>

                <!-- STICKY FOOTER -->
                <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-2.5 shrink-0">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-extrabold cursor-pointer transition-colors">
                        Batal
                    </button>
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2 rounded-xl text-xs font-extrabold shadow cursor-pointer hover:bg-[#096237] transition-all">
                        Terbitkan Artikel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== EDIT ARTICLE MODAL ==================== -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/70 backdrop-blur-xs p-3 sm:p-6 flex items-start justify-center">
        <div @click.away="editModalOpen = false" class="relative bg-white rounded-3xl w-full max-w-2xl shadow-2xl overflow-hidden border border-slate-200 my-3 sm:my-6 flex flex-col max-h-[calc(100vh-2rem)] sm:max-h-[calc(100vh-3.5rem)]">
            
            <!-- STICKY HEADER -->
            <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between bg-white shrink-0">
                <h3 class="font-black text-slate-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                    <span>Edit Artikel & Pemetaan Poliklinik</span>
                </h3>
                <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 cursor-pointer p-1 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- FORM WITH SCROLLABLE BODY & STICKY FOOTER -->
            <form :action="'{{ url('admin/articles') }}/' + editArt.id" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                @method('PUT')

                <!-- HIDDEN SYNCED POLYCLINIC IDS (EDIT) -->
                <template x-for="pId in editArt.polyclinic_ids" :key="'edit-p-input-' + pId">
                    <input type="hidden" name="polyclinic_ids[]" :value="pId">
                </template>

                <!-- SCROLLABLE FORM BODY -->
                <div class="p-5 sm:p-6 overflow-y-auto space-y-4 flex-1 overscroll-contain">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Judul Artikel <span class="text-red-500">*</span></label>
                        <input type="text" name="title_id" x-model="editArt.title_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Kategori</label>
                            <input type="text" name="category_id" x-model="editArt.category_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Ringkasan Singkat (Excerpt)</label>
                            <input type="text" name="excerpt_id" x-model="editArt.excerpt_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                        </div>
                    </div>

                    <!-- POLIKLINIK SELECTION BOX (EDIT) -->
                    <div class="p-4 rounded-2xl border border-emerald-200 bg-gradient-to-b from-emerald-50/60 to-slate-50/60 space-y-3">
                        <div class="flex items-center justify-between flex-wrap gap-2">
                            <div>
                                <label class="block text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-hospital text-[#0e7c47]"></i>
                                    <span>Pilih Poliklinik Terkait (Bisa Lebih Dari 1)</span>
                                </label>
                                <p class="text-[11px] text-slate-500">Klik tombol poli untuk mengubah relasi dokter secara otomatis.</p>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-emerald-600 text-white font-bold text-xs shadow-xs" x-text="editArt.polyclinic_ids.length + ' Poli Terpilih'"></span>
                        </div>

                        <!-- POLI BUTTONS GRID (EDIT) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 max-h-48 overflow-y-auto p-1.5 border border-slate-200 rounded-2xl bg-white overscroll-contain">
                            <template x-for="poli in polyclinicsList" :key="'edit-grid-poli-' + poli.id">
                                <button type="button" 
                                        @click="togglePoli(editArt.polyclinic_ids, poli.id)" 
                                        class="flex items-center justify-between p-2.5 rounded-xl border text-left cursor-pointer transition-all"
                                        :class="isPoliSelected(editArt.polyclinic_ids, poli.id) ? 'bg-emerald-50 border-emerald-500 shadow-xs ring-1 ring-[#0e7c47]' : 'bg-slate-50/60 border-slate-200 hover:bg-slate-100 hover:border-slate-300'">
                                    <div class="min-w-0 pr-1">
                                        <div class="font-bold text-xs leading-snug truncate" :class="isPoliSelected(editArt.polyclinic_ids, poli.id) ? 'text-emerald-900' : 'text-slate-800'" x-text="poli.name"></div>
                                        <div class="text-[10px] text-slate-500 mt-0.5" x-text="poli.doctors.length + ' Dokter'"></div>
                                    </div>
                                    <div class="w-5 h-5 rounded-full flex items-center justify-center shrink-0" :class="isPoliSelected(editArt.polyclinic_ids, poli.id) ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-400'">
                                        <i class="fa-solid fa-check text-[10px]" x-show="isPoliSelected(editArt.polyclinic_ids, poli.id)"></i>
                                        <i class="fa-solid fa-plus text-[9px]" x-show="!isPoliSelected(editArt.polyclinic_ids, poli.id)"></i>
                                    </div>
                                </button>
                            </template>
                        </div>

                        <!-- AUTO-MAPPED DOCTORS PREVIEW (EDIT) -->
                        <div x-show="getDoctorsFromPolis(editArt.polyclinic_ids).length > 0" class="p-3 bg-emerald-50/80 rounded-2xl border border-emerald-200 space-y-2">
                            <div class="flex items-center justify-between text-xs font-black text-emerald-900">
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-user-doctor text-[#0e7c47]"></i>
                                    <span>Dokter yang Otomatis Terhubung:</span>
                                </span>
                                <span class="px-2 py-0.5 rounded-full bg-emerald-600 text-white text-[11px]" x-text="getDoctorsFromPolis(editArt.polyclinic_ids).length + ' Dokter'"></span>
                            </div>
                            <div class="flex flex-wrap gap-1.5 max-h-32 overflow-y-auto">
                                <template x-for="doc in getDoctorsFromPolis(editArt.polyclinic_ids)" :key="'doc-edit-auto-' + doc.id">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white text-emerald-900 border border-emerald-200 text-[11px] font-bold shadow-2xs">
                                        <i class="fa-solid fa-circle-check text-[#0e7c47] text-[10px]"></i>
                                        <span x-text="doc.name"></span>
                                    </span>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Konten Lengkap Artikel</label>
                        <textarea name="content_id" x-model="editArt.content_id" rows="5" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none font-sans leading-relaxed"></textarea>
                    </div>

                    <!-- FILE UPLOAD OR URL -->
                    <div style="background-color: #f8fafc; border: 1px solid #e2e8f0;" class="p-4 rounded-2xl space-y-3">
                        <label class="block text-xs font-extrabold text-slate-900 uppercase tracking-wider">Ubah Thumbnail / Gambar</label>
                        
                        <div>
                            <span class="text-[11px] font-bold text-slate-600 block mb-1">📷 Upload Gambar Baru dari Komputer:</span>
                            <input type="file" name="thumbnail_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-[#0e7c47] hover:file:bg-emerald-100 cursor-pointer">
                        </div>

                        <div class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">— ATAU —</div>

                        <div>
                            <span class="text-[11px] font-bold text-slate-600 block mb-1">🔗 Tempel Link / URL Gambar:</span>
                            <input type="text" name="thumbnail" x-model="editArt.thumbnail" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none">
                        </div>
                    </div>
                </div>

                <!-- STICKY FOOTER -->
                <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-2.5 shrink-0">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-extrabold cursor-pointer transition-colors">
                        Batal
                    </button>
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2 rounded-xl text-xs font-extrabold shadow cursor-pointer hover:bg-[#096237] transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function articleManager() {
    return {
        addModalOpen: false,
        editModalOpen: false,
        search: '',
        filterCat: '',
        
        // Polyclinics with their nested doctors
        polyclinicsList: @json($polyclinicsJsonData),
        
        addSelectedPolis: [],
        
        editArt: { 
            id: null, 
            title_id: '', 
            category_id: '', 
            excerpt_id: '', 
            content_id: '', 
            thumbnail: '', 
            polyclinic_ids: [] 
        },
        
        openAdd() {
            this.addSelectedPolis = [];
            this.addModalOpen = true;
        },
        
        openEdit(artData, poliIds) {
            this.editArt = { 
                ...artData, 
                polyclinic_ids: Array.isArray(poliIds) ? poliIds.map(Number) : [] 
            };
            this.editModalOpen = true;
        },
        
        togglePoli(targetArray, poliId) {
            let numId = Number(poliId);
            let idx = targetArray.indexOf(numId);
            if (idx > -1) {
                targetArray.splice(idx, 1);
            } else {
                targetArray.push(numId);
            }
        },
        
        isPoliSelected(targetArray, poliId) {
            return Array.isArray(targetArray) && targetArray.includes(Number(poliId));
        },
        
        getDoctorsFromPolis(poliIds) {
            let docs = [];
            if (!Array.isArray(poliIds)) return docs;
            this.polyclinicsList.forEach(p => {
                if (poliIds.includes(Number(p.id)) && p.doctors) {
                    docs.push(...p.doctors);
                }
            });
            return docs;
        }
    }
}
</script>
@endsection
