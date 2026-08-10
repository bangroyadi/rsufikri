@extends('layouts.admin')

@section('title', 'Manajemen Galeri Foto RS')

@section('content')
<div x-data="{ addModalOpen: false, editModalOpen: false, editGal: {} }" class="space-y-6">
    
    @if(session('success'))
    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #0e7c47;" class="p-4 rounded-2xl font-bold text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- PAGE HEADER WITH TOP ADD BUTTON -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="p-6 rounded-3xl shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-900">Kelola Galeri Foto RS</h2>
            <p class="text-xs text-slate-500 mt-0.5">Dokumentasi foto fasilitas dan kegiatan RSU Fikri Medika.</p>
        </div>

        <button @click="addModalOpen = true" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2.5 rounded-xl font-extrabold text-xs shadow-md hover:bg-[#096237] hover:shadow-lg transition-all flex items-center justify-center gap-2 shrink-0 cursor-pointer">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>+ Tambah Foto Galeri Baru</span>
        </button>
    </div>

    <!-- GALLERIES GRID -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl shadow-xs p-6 space-y-4">
        <h3 class="font-black text-slate-900 text-sm border-b border-slate-100 pb-3">Koleksi Galeri Foto ({{ $galleries->count() }})</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($galleries as $gal)
            @php
                $gTitle = is_array($gal->title) ? ($gal->title['id'] ?? '') : $gal->title;
                $gCat = is_array($gal->category) ? ($gal->category['id'] ?? '') : ($gal->category ?? 'Foto');
            @endphp
            <div class="rounded-2xl border border-slate-200 overflow-hidden shadow-xs flex flex-col justify-between group bg-white">
                <div class="h-44 overflow-hidden relative bg-slate-100">
                    <img src="{{ $gal->image }}" alt="{{ $gTitle }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <span style="background-color: rgba(15, 23, 42, 0.85); color: #fde047;" class="absolute top-2.5 left-2.5 px-3 py-1 rounded-full text-[10px] font-extrabold tracking-wider backdrop-blur-xs">
                        {{ $gCat }}
                    </span>
                </div>
                <div class="p-4 flex items-center justify-between bg-white">
                    <div class="font-extrabold text-xs text-slate-900 truncate max-w-[140px]">
                        {{ $gTitle }}
                    </div>
                    <div class="flex items-center gap-1.5">
                        <button @click="editGal = { id: {{ $gal->id }}, title_id: '{{ addslashes($gTitle) }}', category_id: '{{ addslashes($gCat) }}', image: '{{ addslashes($gal->image) }}' }; editModalOpen = true" style="background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a;" class="p-1.5 rounded-lg hover:bg-amber-100 transition-colors cursor-pointer" title="Edit Foto">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                        </button>
                        <form action="{{ route('admin.galleries.destroy', $gal->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca;" class="p-1.5 rounded-lg hover:bg-red-100 transition-colors cursor-pointer" title="Hapus Foto">
                                <i class="fa-regular fa-trash-can text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ADD GALLERY MODAL -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="addModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-solid fa-camera-retro text-[#0e7c47]"></i>
                    <span>Tambah Foto Galeri Baru</span>
                </h3>
                <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Judul Foto</label>
                    <input type="text" name="title_id" required placeholder="Gedung Utama RS / Ruang VIP..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Kategori</label>
                    <input type="text" name="category_id" placeholder="Fasilitas / Rawat Inap / Alkes" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <!-- FILE UPLOAD OR URL -->
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0;" class="p-4 rounded-2xl space-y-3">
                    <label class="block text-xs font-extrabold text-slate-900 uppercase tracking-wider">File Foto Gambar</label>
                    
                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">📷 Upload Foto dari Komputer:</span>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-[#0e7c47] hover:file:bg-emerald-100 cursor-pointer">
                    </div>

                    <div class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">— ATAU —</div>

                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">🔗 Tempel Link / URL Gambar:</span>
                        <input type="text" name="image" placeholder="https://images.unsplash.com/..." class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none">
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold">
                        Batal
                    </button>
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2 rounded-xl text-xs font-extrabold shadow">
                        Simpan Foto
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT GALLERY MODAL -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="editModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                    <span>Edit Foto Galeri</span>
                </h3>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/galleries') }}/' + editGal.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Judul Foto</label>
                    <input type="text" name="title_id" x-model="editGal.title_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Kategori</label>
                    <input type="text" name="category_id" x-model="editGal.category_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <!-- FILE UPLOAD OR URL -->
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0;" class="p-4 rounded-2xl space-y-3">
                    <label class="block text-xs font-extrabold text-slate-900 uppercase tracking-wider">Ubah File Foto Gambar</label>
                    
                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">📷 Upload Foto Baru dari Komputer:</span>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-[#0e7c47] hover:file:bg-emerald-100 cursor-pointer">
                    </div>

                    <div class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">— ATAU —</div>

                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">🔗 Tempel Link / URL Gambar:</span>
                        <input type="text" name="image" x-model="editGal.image" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none">
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
