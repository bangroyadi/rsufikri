@extends('layouts.admin')

@section('title', 'Manajemen Banner Homepage')

@section('content')
<div x-data="{ addModalOpen: false, editModalOpen: false, editBan: {} }" class="space-y-6">
    
    @if(session('success'))
    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #0e7c47;" class="p-4 rounded-2xl font-bold text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- PAGE HEADER WITH TOP ADD BUTTON -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="p-6 rounded-3xl shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-900">Kelola Banner Homepage</h2>
            <p class="text-xs text-slate-500 mt-0.5">Slider banner hero & promo pendaftaran online.</p>
        </div>

        <button @click="addModalOpen = true" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2.5 rounded-xl font-extrabold text-xs shadow-md hover:bg-[#096237] hover:shadow-lg transition-all flex items-center justify-center gap-2 shrink-0 cursor-pointer">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>+ Tambah Banner Baru</span>
        </button>
    </div>

    <!-- BANNERS TABLE -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-slate-900 text-sm">Daftar Banner Slider ({{ $banners->count() }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; color: #475569;" class="uppercase tracking-wider font-extrabold">
                    <tr>
                        <th class="p-4">Urutan</th>
                        <th class="p-4">Gambar</th>
                        <th class="p-4">Judul Banner</th>
                        <th class="p-4">Tombol CTA</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                    @foreach($banners as $b)
                    @php
                        $bTitle = is_array($b->title) ? ($b->title['id'] ?? '') : $b->title;
                        $bBtn = is_array($b->button_text) ? ($b->button_text['id'] ?? '') : ($b->button_text ?? 'CTA');
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 font-mono font-bold text-slate-400">
                            #{{ $b->order }}
                        </td>
                        <td class="p-4">
                            <div class="w-14 h-10 rounded-lg overflow-hidden border border-slate-200 bg-slate-100 shrink-0">
                                <img src="{{ Str::startsWith($b->image, 'http') || Str::startsWith($b->image, '/') ? $b->image : asset($b->image) }}" alt="Banner" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="p-4 font-bold text-slate-900 text-sm max-w-xs truncate">
                            {{ $bTitle }}
                        </td>
                        <td class="p-4">
                            <span style="background-color: #fef3c7; border: 1px solid #fde68a; color: #92400e;" class="px-3 py-1 rounded-lg font-bold">
                                {{ $bBtn }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button @click="editBan = { id: {{ $b->id }}, title_id: '{{ addslashes($bTitle) }}', button_text_id: '{{ addslashes($bBtn) }}', button_link: '{{ addslashes($b->button_link ?? '') }}', image: '{{ addslashes($b->image) }}' }; editModalOpen = true" style="background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a;" class="p-2 rounded-xl hover:bg-amber-100 transition-colors cursor-pointer" title="Edit Banner">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <form action="{{ route('admin.banners.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Hapus banner ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca;" class="p-2 rounded-xl hover:bg-red-100 transition-colors cursor-pointer" title="Hapus Banner">
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

    <!-- ADD BANNER MODAL -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="addModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-[#0e7c47]"></i>
                    <span>Tambah Banner Hero Slide Baru</span>
                </h3>
                <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Judul Banner Slide</label>
                    <input type="text" name="title_id" required placeholder="Judul Banner Utama..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Teks Tombol CTA</label>
                    <input type="text" name="button_text_id" placeholder="Daftar Online" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Link Tombol CTA</label>
                    <input type="text" name="button_link" placeholder="#kontak / tel:02678454999" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <!-- FILE UPLOAD OR URL -->
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0;" class="p-4 rounded-2xl space-y-3">
                    <label class="block text-xs font-extrabold text-slate-900 uppercase tracking-wider">Gambar Banner</label>
                    
                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">📷 Upload Gambar dari Komputer:</span>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-[#0e7c47] hover:file:bg-emerald-100 cursor-pointer">
                    </div>

                    <div class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">— ATAU —</div>

                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">🔗 Tempel Link / URL Gambar:</span>
                        <input type="text" name="image" placeholder="hero-doctor.png / https://..." class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none">
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold">
                        Batal
                    </button>
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2 rounded-xl text-xs font-extrabold shadow">
                        Simpan Banner
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT BANNER MODAL -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="editModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                    <span>Edit Banner Homepage</span>
                </h3>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/banners') }}/' + editBan.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Judul Banner</label>
                    <input type="text" name="title_id" x-model="editBan.title_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Teks Tombol CTA</label>
                    <input type="text" name="button_text_id" x-model="editBan.button_text_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Link Tombol CTA</label>
                    <input type="text" name="button_link" x-model="editBan.button_link" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <!-- FILE UPLOAD OR URL -->
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0;" class="p-4 rounded-2xl space-y-3">
                    <label class="block text-xs font-extrabold text-slate-900 uppercase tracking-wider">Ubah Gambar Banner</label>
                    
                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">📷 Upload Gambar Baru dari Komputer:</span>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-[#0e7c47] hover:file:bg-emerald-100 cursor-pointer">
                    </div>

                    <div class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">— ATAU —</div>

                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">🔗 Tempel Link / URL Gambar:</span>
                        <input type="text" name="image" x-model="editBan.image" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none">
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
