@extends('layouts.admin')

@section('title', 'Manajemen Layanan Rumah Sakit')

@section('content')
<div x-data="{ 
    addModalOpen: false, 
    editModalOpen: false, 
    editServ: {}, 
    search: '',
    galleryModalOpen: false,
    selectedServ: { id: null, name: '', gallery: [] },
    deletePhoto(servId, index, imgUrl) {
        if (!confirm('Hapus foto ini dari galeri layanan?')) return;
        const form = document.getElementById('deleteServicePhotoActionForm');
        form.action = '{{ url('admin/services') }}/' + servId + '/gallery/delete';
        document.getElementById('servicePhotoIndexInput').value = index;
        document.getElementById('servicePhotoUrlInput').value = imgUrl;
        form.submit();
    }
}" class="space-y-6">
    
    <!-- HIDDEN FORM FOR DELETING A SINGLE PHOTO FROM SERVICE GALLERY -->
    <form id="deleteServicePhotoActionForm" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="photo_index" id="servicePhotoIndexInput" value="">
        <input type="hidden" name="photo_url" id="servicePhotoUrlInput" value="">
    </form>
    
    @if(session('success'))
    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #0e7c47;" class="p-4 rounded-2xl font-bold text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(isset($errors) && $errors->any())
    <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #dc2626;" class="p-4 rounded-2xl font-bold text-sm space-y-1">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation text-base"></i>
            <span>Gagal menyimpan data. Silakan periksa kembali input Anda:</span>
        </div>
        <ul class="list-disc list-inside text-xs font-semibold pl-6">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- PAGE HEADER WITH TOP ADD BUTTON -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="p-6 rounded-3xl shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-900">Kelola Layanan & Fasilitas RS</h2>
            <p class="text-xs text-slate-500 mt-0.5">Daftar instalasi medis, program unggulan, dan fasilitas promosi pasien.</p>
        </div>

        <button @click="addModalOpen = true" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2.5 rounded-xl font-extrabold text-xs shadow-md hover:bg-[#096237] hover:shadow-lg transition-all flex items-center justify-center gap-2 shrink-0 cursor-pointer">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>+ Tambah Layanan Baru</span>
        </button>
    </div>

    <!-- TABLE & SEARCH FILTER CONTAINER -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl shadow-xs overflow-hidden">
        
        <!-- SEARCH & FILTER TOOLBAR -->
        <div style="border-bottom: 1px solid #f1f5f9; background-color: #f8fafc;" class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-filter text-emerald-600 text-sm"></i>
                <h3 class="font-black text-slate-900 text-sm">Pencarian Layanan</h3>
            </div>

            <!-- INLINE CSS PERFECTLY CENTERED SEARCH INPUT -->
            <div style="position: relative; width: 100%; max-width: 280px;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px; pointer-events: none; z-index: 10;"></i>
                <input type="text" x-model="search" placeholder="Cari layanan..." style="padding-left: 38px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; border-radius: 12px; border: 1px solid #cbd5e1; font-size: 12px; width: 100%; background-color: #ffffff; outline: none;" class="focus:ring-2 focus:ring-[#0e7c47]">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead style="background-color: #f1f5f9; border-bottom: 1px solid #e2e8f0; color: #475569;" class="uppercase tracking-wider font-extrabold">
                    <tr>
                        <th class="p-4">Urutan</th>
                        <th class="p-4">Layanan</th>
                        <th class="p-4">Deskripsi Singkat</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                    @foreach($services as $serv)
                    @php
                        $sName = is_array($serv->name) ? ($serv->name['id'] ?? '') : $serv->name;
                        $sShortDesc = is_array($serv->short_description) ? ($serv->short_description['id'] ?? '') : ($serv->short_description ?? '');
                        $sDesc = is_array($serv->description) ? ($serv->description['id'] ?? '') : ($serv->description ?? '');
                    @endphp
                    <tr x-show="search === '' || '{{ addslashes(strtolower($sName)) }}'.includes(search.toLowerCase())" class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 font-mono font-bold text-slate-400">
                            #{{ $serv->order }}
                        </td>
                        <td class="p-4 flex items-center gap-3">
                            <div style="background-color: #d1fae5; color: #0e7c47;" class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm shrink-0 overflow-hidden">
                                @if(!empty($serv->image))
                                @php
                                    $servImg = \Illuminate\Support\Str::startsWith($serv->image, ['http://', 'https://']) ? $serv->image : asset($serv->image);
                                @endphp
                                <img src="{{ $servImg }}" alt="{{ $sName }}" class="w-full h-full object-cover">
                                @else
                                <i class="fa-solid fa-{{ $serv->icon ?? 'briefcase-medical' }}"></i>
                                @endif
                            </div>
                            <div>
                                <div class="font-bold text-slate-900 text-sm">
                                    {{ $sName }}
                                </div>
                                <div class="text-[10px] text-slate-400 font-mono">
                                    /layanan/{{ $serv->slug }}
                                </div>
                            </div>
                        </td>
                        <td class="p-4 max-w-xs truncate text-slate-500">
                            {{ $sShortDesc }}
                        </td>
                        <td class="p-4">
                            @if($serv->is_active)
                            <span style="background-color: #d1fae5; color: #065f46;" class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider">
                                Aktif
                            </span>
                            @else
                            <span style="background-color: #fee2e2; color: #991b1b;" class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider">
                                Non-aktif
                            </span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- GALLERY MANAGEMENT BUTTON -->
                                <button @click="selectedServ = { 
                                    id: {{ $serv->id }}, 
                                    name: '{{ addslashes($sName) }}', 
                                    gallery: {{ json_encode($serv->gallery_images ?? []) }} 
                                }; galleryModalOpen = true" 
                                style="background-color: #ecfdf5; color: #0e7c47; border: 1px solid #a7f3d0;" 
                                class="p-2 rounded-xl hover:bg-emerald-100 transition-colors cursor-pointer flex items-center gap-1.5" 
                                title="Kelola Galeri Foto Promosi Layanan">
                                    <i class="fa-solid fa-camera text-xs"></i>
                                    <span class="text-[11px] font-extrabold font-mono">({{ count($serv->gallery_images ?? []) }})</span>
                                </button>

                                <a href="{{ url('/layanan/' . $serv->slug) }}" target="_blank" style="background-color: #f0fdf4; color: #0e7c47; border: 1px solid #bbf7d0;" class="p-2 rounded-xl hover:bg-emerald-100 transition-colors" title="Lihat di Frontend">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                </a>
                                <button @click="editServ = {{ json_encode([
                                    'id' => $serv->id,
                                    'name_id' => $sName,
                                    'icon' => $serv->icon ?? '',
                                    'short_description_id' => $sShortDesc,
                                    'description_id' => $sDesc,
                                    'image' => $serv->image ?? '',
                                    'is_active' => (bool)$serv->is_active,
                                    'is_featured' => (bool)$serv->is_featured,
                                ]) }}; editModalOpen = true" style="background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a;" class="p-2 rounded-xl hover:bg-amber-100 transition-colors cursor-pointer" title="Edit Layanan">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <form action="{{ route('admin.services.destroy', $serv->id) }}" method="POST" onsubmit="return confirm('Hapus layanan ini beserta seluruh foto galerinya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca;" class="p-2 rounded-xl hover:bg-red-100 transition-colors cursor-pointer" title="Hapus Layanan">
                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- DEDICATED GALLERY MANAGEMENT MODAL -->
    <div x-show="galleryModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="galleryModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-2xl w-full shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
            
            <!-- MODAL HEADER -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="space-y-0.5">
                    <span class="text-[11px] font-extrabold uppercase tracking-wider text-[#0e7c47] flex items-center gap-1.5">
                        <i class="fa-solid fa-camera"></i>
                        <span>Galeri Foto Promosi Layanan</span>
                    </span>
                    <h3 class="font-black text-slate-900 text-lg sm:text-xl" x-text="selectedServ.name"></h3>
                    <p class="text-xs text-slate-500 font-medium">Foto ini akan langsung tampil di daftar foto pendukung pada halaman frontend (<span class="font-mono text-slate-700">/layanan/...</span>).</p>
                </div>
                <button @click="galleryModalOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl bg-slate-50 hover:bg-slate-100">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- UPLOAD NEW PHOTOS FORM -->
            <form :action="'{{ url('admin/services') }}/' + selectedServ.id + '/gallery'" method="POST" enctype="multipart/form-data" class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                @csrf
                <div class="flex items-center justify-between">
                    <h4 class="font-extrabold text-slate-900 text-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-cloud-arrow-up text-[#0e7c47]"></i>
                        <span>Unggah Foto Promosi Baru ke Layanan Ini</span>
                    </h4>
                    <span class="text-[11px] text-slate-500 font-medium">Maks. 30MB per foto (JPG/PNG/WEBP)</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Pilih File Foto (Bisa Multiple)</label>
                        <input type="file" name="gallery_files[]" multiple accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0e7c47] file:text-white hover:file:bg-[#096237] cursor-pointer bg-white border border-slate-200 rounded-xl p-1">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Atau Masukkan URL Gambar (Opsional)</label>
                        <input type="text" name="image_url" placeholder="https://example.com/foto.jpg" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none bg-white">
                    </div>
                </div>

                <div class="flex justify-end pt-1">
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2 rounded-xl text-xs font-extrabold shadow-sm hover:bg-[#096237] transition-all flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-upload text-xs"></i>
                        <span>Upload ke Galeri Promosi</span>
                    </button>
                </div>
            </form>

            <!-- CURRENT GALLERY PHOTOS LIST -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h4 class="font-extrabold text-slate-900 text-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-images text-[#0e7c47]"></i>
                        <span>Daftar Foto Saat Ini (<span x-text="selectedServ.gallery ? selectedServ.gallery.length : 0"></span> Foto)</span>
                    </h4>
                    <span class="text-[11px] text-slate-400">Arahkan kursor ke foto untuk menghapus</span>
                </div>

                <!-- PHOTO GRID -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <template x-for="(imgUrl, index) in selectedServ.gallery" :key="index">
                        <div class="relative group rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 aspect-4/3 shadow-xs">
                            <img :src="imgUrl" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            <div class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-slate-900/70 text-white font-mono text-[10px] font-bold">
                                #<span x-text="index + 1"></span>
                            </div>

                            <div class="absolute inset-0 bg-slate-950/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center p-2">
                                <button type="button" 
                                        @click="deletePhoto(selectedServ.id, index, imgUrl)" 
                                        style="background-color: #ef4444; color: #ffffff;" 
                                        class="px-3 py-1.5 rounded-xl font-bold text-xs shadow-lg hover:bg-red-700 transition-all flex items-center gap-1.5 cursor-pointer">
                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                    <span>Hapus</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <div x-show="!selectedServ.gallery || selectedServ.gallery.length === 0" class="p-8 text-center bg-slate-50 border border-dashed border-slate-200 rounded-2xl space-y-1">
                    <i class="fa-regular fa-images text-2xl text-slate-300"></i>
                    <p class="text-xs font-bold text-slate-500">Belum ada foto yang diunggah ke layanan ini.</p>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                <button type="button" @click="galleryModalOpen = false" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold cursor-pointer">
                    Selesai / Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- ADD SERVICE MODAL -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="addModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-solid fa-briefcase-medical text-[#0e7c47]"></i>
                    <span>Tambah Layanan RS Baru</span>
                </h3>
                <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Nama Layanan</label>
                    <input type="text" name="name_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Icon Class (FontAwesome)</label>
                    <input type="text" name="icon" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                    <input type="text" name="short_description_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Lengkap / Informasi Detail</label>
                    <textarea name="description_id" rows="4" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none"></textarea>
                </div>

                <div class="flex items-center gap-6 py-2">
                    <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded text-[#0e7c47] focus:ring-[#0e7c47] w-4 h-4">
                        <span>Aktifkan Layanan</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                        <input type="checkbox" name="is_featured" value="1" checked class="rounded text-[#0e7c47] focus:ring-[#0e7c47] w-4 h-4">
                        <span>Tampilkan di Beranda (Featured)</span>
                    </label>
                </div>

                <!-- FILE UPLOAD OR URL -->
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0;" class="p-4 rounded-2xl space-y-3">
                    <label class="block text-xs font-extrabold text-slate-900 uppercase tracking-wider">Gambar Utama Layanan</label>
                    
                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">📷 Upload Gambar dari Komputer:</span>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-[#0e7c47] hover:file:bg-emerald-100 cursor-pointer">
                    </div>

                    <div class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">— ATAU —</div>

                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">🔗 Tempel Link / URL Gambar:</span>
                        <input type="text" name="image" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none">
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold">
                        Batal
                    </button>
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2 rounded-xl text-xs font-extrabold shadow">
                        Simpan Layanan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT SERVICE MODAL -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="editModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                    <span>Edit Layanan RS</span>
                </h3>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/services') }}/' + editServ.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Nama Layanan</label>
                    <input type="text" name="name_id" x-model="editServ.name_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Icon Class (FontAwesome)</label>
                    <input type="text" name="icon" x-model="editServ.icon" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                    <input type="text" name="short_description_id" x-model="editServ.short_description_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Lengkap / Informasi Detail</label>
                    <textarea name="description_id" x-model="editServ.description_id" rows="4" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none"></textarea>
                </div>

                <div class="flex items-center gap-6 py-2">
                    <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                        <input type="checkbox" name="is_active" value="1" :checked="editServ.is_active" class="rounded text-[#0e7c47] focus:ring-[#0e7c47] w-4 h-4">
                        <span>Aktifkan Layanan</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                        <input type="checkbox" name="is_featured" value="1" :checked="editServ.is_featured" class="rounded text-[#0e7c47] focus:ring-[#0e7c47] w-4 h-4">
                        <span>Tampilkan di Beranda (Featured)</span>
                    </label>
                </div>

                <!-- FILE UPLOAD OR URL -->
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0;" class="p-4 rounded-2xl space-y-3">
                    <label class="block text-xs font-extrabold text-slate-900 uppercase tracking-wider">Ubah Gambar Layanan</label>
                    
                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">📷 Upload Gambar Baru dari Komputer:</span>
                        <input type="file" name="image_file" accept="image/*" @change="if ($event.target.files.length) editServ.image = ''" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-[#0e7c47] hover:file:bg-emerald-100 cursor-pointer">
                    </div>

                    <div class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">— ATAU —</div>

                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">🔗 Tempel Link / URL Gambar:</span>
                        <input type="text" name="image" x-model="editServ.image" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none">
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold">
                        Batal
                    </button>
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2 rounded-xl text-xs font-extrabold shadow">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
