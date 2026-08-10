@extends('layouts.admin')

@section('title', 'Manajemen Layanan Rumah Sakit')

@section('content')
<div x-data="{ addModalOpen: false, editModalOpen: false, editServ: {}, search: '' }" class="space-y-6">
    
    @if(session('success'))
    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #0e7c47;" class="p-4 rounded-2xl font-bold text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- PAGE HEADER WITH TOP ADD BUTTON -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="p-6 rounded-3xl shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-900">Kelola Layanan & Fasilitas RS</h2>
            <p class="text-xs text-slate-500 mt-0.5">Daftar instalasi medis dan fasilitas pasien.</p>
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
                        $sDesc = is_array($serv->short_description) ? ($serv->short_description['id'] ?? '') : ($serv->short_description ?? '');
                    @endphp
                    <tr x-show="search === '' || '{{ addslashes(strtolower($sName)) }}'.includes(search.toLowerCase())" class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 font-mono font-bold text-slate-400">
                            #{{ $serv->order }}
                        </td>
                        <td class="p-4 flex items-center gap-3">
                            <div style="background-color: #d1fae5; color: #0e7c47;" class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm shrink-0">
                                <i class="fa-solid fa-{{ $serv->icon ?? 'briefcase-medical' }}"></i>
                            </div>
                            <div class="font-bold text-slate-900 text-sm">
                                {{ $sName }}
                            </div>
                        </td>
                        <td class="p-4 max-w-xs truncate text-slate-500">
                            {{ $sDesc }}
                        </td>
                        <td class="p-4">
                            <span style="background-color: #d1fae5; color: #065f46;" class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider">
                                Aktif
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button @click="editServ = { id: {{ $serv->id }}, name_id: '{{ addslashes($sName) }}', icon: '{{ addslashes($serv->icon ?? '') }}', short_description_id: '{{ addslashes($sDesc) }}', image: '{{ addslashes($serv->image ?? '') }}' }; editModalOpen = true" style="background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a;" class="p-2 rounded-xl hover:bg-amber-100 transition-colors cursor-pointer" title="Edit Layanan">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <form action="{{ route('admin.services.destroy', $serv->id) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
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

    <!-- ADD SERVICE MODAL -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="addModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-solid fa-briefcase-medical text-[#0e7c47]"></i>
                    <span>Tambah Layanan RS Baru</span>
                </h3>
                <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Nama Layanan</label>
                    <input type="text" name="name_id" required placeholder="Instalasi Gawat Darurat (IGD)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Icon Class</label>
                    <input type="text" name="icon" placeholder="ambulance / bed / flask" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                    <input type="text" name="short_description_id" placeholder="Penanganan medis darurat 24 jam..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">URL Gambar Layanan (Opsional)</label>
                    <input type="text" name="image" placeholder="https://images.unsplash.com/..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
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
        <div @click.away="editModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                    <span>Edit Layanan RS</span>
                </h3>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/services') }}/' + editServ.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Nama Layanan</label>
                    <input type="text" name="name_id" x-model="editServ.name_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Icon Class</label>
                    <input type="text" name="icon" x-model="editServ.icon" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                    <input type="text" name="short_description_id" x-model="editServ.short_description_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">URL Gambar Layanan</label>
                    <input type="text" name="image" x-model="editServ.image" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
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
