@extends('layouts.admin')

@section('title', 'Manajemen Poliklinik & Galeri Foto')

@section('content')
<div x-data="{ 
    addModalOpen: false, 
    editModalOpen: false, 
    galleryModalOpen: false,
    editPoli: {}, 
    selectedPoli: { id: null, name: '', slug: '', images: [] },
    search: '',
    openGalleryModal(poliData) {
        this.selectedPoli = poliData;
        this.galleryModalOpen = true;
    },
    deletePhoto(poliId, index, url) {
        if (!confirm('Hapus foto ini dari galeri ' + (this.selectedPoli.name || 'poliklinik') + '?')) return;
        const form = document.getElementById('deletePhotoActionForm');
        form.action = '{{ url('admin/polyclinics') }}/' + poliId + '/gallery/delete';
        document.getElementById('deletePhotoInputIndex').value = index;
        document.getElementById('deletePhotoInputUrl').value = url;
        form.submit();
    }
}" class="space-y-6">
    
    @if(session('success'))
    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #0e7c47;" class="p-4 rounded-2xl font-bold text-sm flex items-center gap-2 shadow-xs">
        <i class="fa-solid fa-circle-check text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(isset($errors) && $errors->any())
    <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #b91c1c;" class="p-4 rounded-2xl font-bold text-sm space-y-1 shadow-xs">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-base"></i>
            <span>Terdapat kesalahan pada formulir:</span>
        </div>
        <ul class="list-disc list-inside text-xs font-normal pl-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- PAGE HEADER WITH TOP ADD BUTTON -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="p-6 rounded-3xl shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-900 flex items-center gap-2">
                <span>Kelola Poliklinik & Galeri Foto</span>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-100 text-[#0e7c47] font-bold">19 Poliklinik</span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">Departemen spesialisasi medis RSU Fikri Medika & foto visualisasi fasilitas poliklinik untuk pengunjung website.</p>
        </div>

        <button @click="addModalOpen = true" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2.5 rounded-xl font-extrabold text-xs shadow-md hover:bg-[#096237] hover:shadow-lg transition-all flex items-center justify-center gap-2 shrink-0 cursor-pointer">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>+ Tambah Poliklinik Baru</span>
        </button>
    </div>

    <!-- TABLE & SEARCH FILTER CONTAINER -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl shadow-xs overflow-hidden">
        
        <!-- SEARCH & FILTER TOOLBAR -->
        <div style="border-bottom: 1px solid #f1f5f9; background-color: #f8fafc;" class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-filter text-emerald-600 text-sm"></i>
                <h3 class="font-black text-slate-900 text-sm">Pencarian & Filter Poliklinik</h3>
            </div>

            <!-- INLINE CSS PERFECTLY CENTERED SEARCH INPUT -->
            <div style="position: relative; width: 100%; max-width: 280px;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px; pointer-events: none; z-index: 10;"></i>
                <input type="text" x-model="search" placeholder="Cari nama poliklinik atau slug..." style="padding-left: 38px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; border-radius: 12px; border: 1px solid #cbd5e1; font-size: 12px; width: 100%; background-color: #ffffff; outline: none;" class="focus:ring-2 focus:ring-[#0e7c47]">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead style="background-color: #f1f5f9; border-bottom: 1px solid #e2e8f0; color: #475569;" class="uppercase tracking-wider font-extrabold">
                    <tr>
                        <th class="p-4 w-14 text-center">Icon</th>
                        <th class="p-4">Nama Poliklinik</th>
                        <th class="p-4">Slug</th>
                        <th class="p-4">Jumlah Dokter</th>
                        <th class="p-4">Galeri Foto</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                    @foreach($polyclinics as $poli)
                    @php
                        $pName = is_array($poli->name) ? ($poli->name['id'] ?? '') : $poli->name;
                        $pDesc = is_array($poli->description) ? ($poli->description['id'] ?? '') : ($poli->description ?? '');
                        $galleryImgs = $poli->gallery_images;
                        $rawGallery = is_array($poli->gallery) ? $poli->gallery : (json_decode($poli->gallery, true) ?? []);
                        $hasCustomGallery = !empty($rawGallery) && count($rawGallery) > 0;
                    @endphp
                    <tr x-show="search === '' || '{{ addslashes(strtolower($pName . ' ' . $poli->slug)) }}'.includes(search.toLowerCase())" class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 text-center">
                            <div style="background-color: #d1fae5; color: #0e7c47;" class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm mx-auto shadow-xs">
                                <i class="fa-solid fa-{{ str_replace(['fa-solid fa-', 'fa-regular fa-', 'fa-'], '', $poli->icon ?? 'stethoscope') }}"></i>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-slate-900 text-sm">
                                {{ $pName }}
                            </div>
                            @if(!empty($pDesc))
                            <div class="text-[11px] text-slate-400 font-normal line-clamp-1 max-w-xs mt-0.5" title="{{ $pDesc }}">
                                {{ $pDesc }}
                            </div>
                            @endif
                        </td>
                        <td class="p-4 font-mono text-slate-500 text-[11px]">
                            <span class="px-2 py-0.5 rounded-md bg-slate-100 border border-slate-200">{{ $poli->slug }}</span>
                        </td>
                        <td class="p-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-[#0e7c47] font-bold text-xs border border-emerald-100">
                                <i class="fa-solid fa-user-doctor text-[11px]"></i>
                                <span>{{ $poli->doctors_count }} Dokter</span>
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <!-- THUMBNAIL STACK -->
                                <div class="flex items-center -space-x-2 overflow-hidden">
                                    @foreach(array_slice($galleryImgs, 0, 3) as $imgUrl)
                                    <img src="{{ $imgUrl }}" alt="Galeri {{ $pName }}" class="inline-block h-8 w-8 rounded-lg object-cover ring-2 ring-white shadow-xs border border-slate-200">
                                    @endforeach
                                </div>

                                <div>
                                    @if($hasCustomGallery)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-100/80 text-[#0e7c47] font-extrabold text-[11px]">
                                        <i class="fa-solid fa-images text-[10px]"></i>
                                        <span>{{ count($rawGallery) }} Foto</span>
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 font-bold text-[11px] border border-amber-200/60">
                                        <i class="fa-regular fa-image text-[10px]"></i>
                                        <span>Default (2)</span>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <!-- KELOLA GALERI BUTTON -->
                                <button @click="openGalleryModal({
                                    id: {{ $poli->id }}, 
                                    name: '{{ addslashes($pName) }}', 
                                    slug: '{{ addslashes($poli->slug) }}',
                                    images: {{ json_encode($galleryImgs) }},
                                    rawCount: {{ count($rawGallery) }}
                                })" 
                                style="background-color: #ecfdf5; color: #0e7c47; border: 1px solid #a7f3d0;" 
                                class="px-2.5 py-1.5 rounded-xl hover:bg-emerald-100 transition-all font-bold text-xs flex items-center gap-1.5 cursor-pointer shadow-2xs" 
                                title="Kelola Galeri Foto">
                                    <i class="fa-solid fa-images text-xs"></i>
                                    <span class="hidden sm:inline">Galeri</span>
                                </button>

                                <!-- EDIT BUTTON -->
                                <button @click="editPoli = { 
                                    id: {{ $poli->id }}, 
                                    name_id: '{{ addslashes($pName) }}', 
                                    description_id: '{{ addslashes($pDesc) }}',
                                    icon: '{{ addslashes($poli->icon ?? '') }}' 
                                }; editModalOpen = true" 
                                style="background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a;" 
                                class="p-2 rounded-xl hover:bg-amber-100 transition-colors cursor-pointer" 
                                title="Edit Poliklinik">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>

                                <!-- DELETE BUTTON -->
                                <form action="{{ route('admin.polyclinics.destroy', $poli->id) }}" method="POST" onsubmit="return confirm('Hapus poliklinik ini beserta seluruh foto galerinya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca;" class="p-2 rounded-xl hover:bg-red-100 transition-colors cursor-pointer" title="Hapus Poliklinik">
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
                        <span>Galeri Foto Poliklinik</span>
                    </span>
                    <h3 class="font-black text-slate-900 text-lg sm:text-xl" x-text="selectedPoli.name"></h3>
                    <p class="text-xs text-slate-500 font-medium">Foto ini akan langsung tampil di galeri frontend (<span class="font-mono text-slate-700">/layanan/rawat-jalan</span>) saat pengunjung memilih poliklinik ini.</p>
                </div>
                <button @click="galleryModalOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl bg-slate-50 hover:bg-slate-100">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- UPLOAD NEW PHOTOS FORM -->
            <form :action="'{{ url('admin/polyclinics') }}/' + selectedPoli.id + '/gallery'" method="POST" enctype="multipart/form-data" class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                @csrf
                <div class="flex items-center justify-between">
                    <h4 class="font-extrabold text-slate-900 text-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-cloud-arrow-up text-[#0e7c47]"></i>
                        <span>Unggah Foto Baru ke Poliklinik Ini</span>
                    </h4>
                    <span class="text-[11px] text-slate-500 font-medium">Maks. 30MB per foto (JPG/PNG/WEBP)</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Pilih File Foto (Bisa Multiple Foto)</label>
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
                        <span>Upload ke Galeri</span>
                    </button>
                </div>
            </form>

            <!-- CURRENT GALLERY PHOTOS LIST -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h4 class="font-extrabold text-slate-900 text-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-images text-[#0e7c47]"></i>
                        <span>Daftar Foto Saat Ini (<span x-text="selectedPoli.images ? selectedPoli.images.length : 0"></span> Foto)</span>
                    </h4>
                    <span class="text-[11px] text-slate-400 font-medium">Klik tombol tempat sampah merah untuk menghapus</span>
                </div>

                <!-- EMPTY STATE -->
                <div x-show="!selectedPoli.images || selectedPoli.images.length === 0" class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-300 space-y-2">
                    <i class="fa-regular fa-image text-3xl text-slate-300"></i>
                    <p class="text-xs text-slate-500 font-medium">Belum ada foto galeri yang diunggah untuk poliklinik ini.</p>
                    <p class="text-[11px] text-slate-400">Silakan unggah foto ruangan atau fasilitas di atas.</p>
                </div>

                <!-- PHOTO GRID -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3.5">
                    <template x-for="(imgUrl, index) in selectedPoli.images" :key="index">
                        <div class="group relative rounded-2xl overflow-hidden border border-slate-200 bg-slate-900 aspect-video shadow-xs flex items-center justify-center">
                            <img :src="imgUrl" :alt="selectedPoli.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            <!-- BADGE INDEX -->
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-slate-950/70 text-white font-bold text-[10px] backdrop-blur-xs" x-text="'Foto #' + (index + 1)"></span>
                            
                            <!-- DELETE OVERLAY BUTTON -->
                            <div class="absolute inset-0 bg-slate-950/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 p-2">
                                <button type="button" 
                                        @click="deletePhoto(selectedPoli.id, index, imgUrl)" 
                                        class="px-3 py-1.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs flex items-center gap-1.5 shadow-md transition-all cursor-pointer">
                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                    <span>Hapus</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="button" @click="galleryModalOpen = false" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold cursor-pointer">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <!-- GLOBAL HIDDEN DELETE PHOTO FORM -->
    <form id="deletePhotoActionForm" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="photo_index" id="deletePhotoInputIndex" value="">
        <input type="hidden" name="photo_url" id="deletePhotoInputUrl" value="">
    </form>

    <!-- ADD POLYCLINIC MODAL -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="addModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-solid fa-square-plus text-[#0e7c47]"></i>
                    <span>Tambah Poliklinik Baru</span>
                </h3>
                <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.polyclinics.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Nama Poliklinik</label>
                    <input type="text" name="name_id" required placeholder="Contoh: Poli Onkologi" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">FontAwesome Icon Class</label>
                    <input type="text" name="icon" placeholder="brain / stethoscope / ear-listen / tooth" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat Poliklinik</label>
                    <textarea name="description_id" rows="2" placeholder="Pelayanan diagnostik dan konsultasi medis komprehensif..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Upload Galeri Foto (Multiple)</label>
                    <input type="file" name="gallery_files[]" multiple accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0e7c47] file:text-white hover:file:bg-[#096237] cursor-pointer bg-slate-50 border border-slate-300 rounded-xl p-1">
                    <p class="text-[11px] text-slate-400 mt-1">Dapat memilih lebih dari satu file foto ruangan/fasilitas poliklinik.</p>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold">
                        Batal
                    </button>
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2 rounded-xl text-xs font-extrabold shadow">
                        Simpan Poliklinik
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT POLYCLINIC MODAL -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="editModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                    <span>Edit Poliklinik</span>
                </h3>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/polyclinics') }}/' + editPoli.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Nama Poliklinik</label>
                    <input type="text" name="name_id" x-model="editPoli.name_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">FontAwesome Icon Class</label>
                    <input type="text" name="icon" x-model="editPoli.icon" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat Poliklinik</label>
                    <textarea name="description_id" x-model="editPoli.description_id" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Tambah Foto Galeri Baru (Opsional)</label>
                    <input type="file" name="gallery_files[]" multiple accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0e7c47] file:text-white hover:file:bg-[#096237] cursor-pointer bg-slate-50 border border-slate-300 rounded-xl p-1">
                    <p class="text-[11px] text-slate-400 mt-1">Foto baru akan ditambahkan ke koleksi galeri foto poliklinik ini.</p>
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
