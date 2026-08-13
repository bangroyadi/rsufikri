@extends('layouts.admin')

@section('title', 'Manajemen Dokter Spesialis')

@section('content')
<div x-data="{ addModalOpen: false, editModalOpen: false, editDoc: {}, search: '', filterPoli: '' }" class="space-y-6">
    
    @if(session('success'))
    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #0e7c47;" class="p-4 rounded-2xl font-bold text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- PAGE HEADER WITH TOP ADD BUTTON -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="p-6 rounded-3xl shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-900">Kelola Dokter Spesialis</h2>
            <p class="text-xs text-slate-500 mt-0.5">Daftar dokter spesialis aktif di RSU Fikri Medika.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.schedules.index') }}" style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #0e7c47;" class="px-4 py-2.5 rounded-xl font-extrabold text-xs shadow-xs hover:bg-emerald-100 transition-all flex items-center justify-center gap-2">
                <i class="fa-regular fa-calendar-check text-sm"></i>
                <span>Lihat Jadwal Praktik</span>
            </a>

            <button @click="addModalOpen = true" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2.5 rounded-xl font-extrabold text-xs shadow-md hover:bg-[#096237] hover:shadow-lg transition-all flex items-center justify-center gap-2 shrink-0 cursor-pointer">
                <i class="fa-solid fa-plus text-sm"></i>
                <span>+ Tambah Dokter Baru</span>
            </button>
        </div>
    </div>

    <!-- TABLE & SEARCH FILTER CONTAINER -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl shadow-xs overflow-hidden">
        
        <!-- SEARCH & FILTER TOOLBAR -->
        <div style="border-bottom: 1px solid #f1f5f9; background-color: #f8fafc;" class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-filter text-emerald-600 text-sm"></i>
                <h3 class="font-black text-slate-900 text-sm">Filter & Pencarian Dokter</h3>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- INLINE CSS PERFECTLY CENTERED SEARCH INPUT -->
                <div style="position: relative; width: 100%; max-width: 240px;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px; pointer-events: none; z-index: 10;"></i>
                    <input type="text" x-model="search" placeholder="Cari nama dokter..." style="padding-left: 38px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; border-radius: 12px; border: 1px solid #cbd5e1; font-size: 12px; width: 100%; background-color: #ffffff; outline: none;" class="focus:ring-2 focus:ring-[#0e7c47]">
                </div>

                <!-- POLYCLINIC FILTER DROPDOWN -->
                <select x-model="filterPoli" class="px-3.5 py-2 rounded-xl border border-slate-300 bg-white text-xs font-semibold focus:ring-2 focus:ring-[#0e7c47] outline-none">
                    <option value="">Semua Poliklinik</option>
                    @foreach($polyclinics as $poli)
                    @php $pName = is_array($poli->name) ? ($poli->name['id'] ?? '') : $poli->name; @endphp
                    <option value="{{ $pName }}">{{ $pName }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead style="background-color: #f1f5f9; border-bottom: 1px solid #e2e8f0; color: #475569;" class="uppercase tracking-wider font-extrabold">
                    <tr>
                        <th class="p-4">Dokter</th>
                        <th class="p-4">Poliklinik</th>
                        <th class="p-4">Spesialisasi</th>
                        <th class="p-4">Jadwal Praktik</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                    @foreach($doctors as $doc)
                    @php
                        $specName = is_array($doc->specialty) ? ($doc->specialty['id'] ?? '') : ($doc->specialty ?? '');
                        $poliName = is_array($doc->polyclinic?->name) ? ($doc->polyclinic?->name['id'] ?? '') : ($doc->polyclinic?->name ?? '-');
                        $schedCount = $doc->schedules->count();
                    @endphp
                    <tr x-show="(search === '' || '{{ addslashes(strtolower($doc->name)) }}'.includes(search.toLowerCase())) && (filterPoli === '' || '{{ addslashes($poliName) }}' === filterPoli)" class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 flex items-center gap-3">
                            <div style="background-color: #d1fae5; border: 1px solid #a7f3d0; color: #0e7c47;" class="w-10 h-10 rounded-full flex items-center justify-center font-bold overflow-hidden shrink-0">
                                @if(!empty($doc->photo))
                                <img src="{{ \Illuminate\Support\Str::startsWith($doc->photo, ['http://', 'https://']) ? $doc->photo : asset($doc->photo) }}" alt="{{ $doc->name }}" class="w-full h-full object-cover">
                                @else
                                <i class="fa-solid fa-user-doctor text-sm"></i>
                                @endif
                            </div>
                            <div>
                                <div class="font-extrabold text-slate-900 text-sm">{{ $doc->name }}</div>
                                <div class="text-[11px] text-slate-400 font-semibold">{{ $doc->title_degree }}</div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #0e7c47;" class="px-3 py-1 rounded-lg font-bold">
                                {{ $poliName }}
                            </span>
                        </td>
                        <td class="p-4">
                            {{ $specName }}
                        </td>
                        <td class="p-4">
                            <a href="{{ route('admin.schedules.index') }}?doctor_id={{ $doc->id }}" style="background-color: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46;" class="px-3 py-1.5 rounded-xl text-xs font-extrabold inline-flex items-center gap-1.5 hover:bg-emerald-100 transition-colors" title="Kelola slot jadwal dokter ini">
                                <i class="fa-regular fa-calendar-days"></i>
                                <span>{{ $schedCount }} Slot Hari</span>
                            </a>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button @click="editDoc = { id: {{ $doc->id }}, name: '{{ addslashes($doc->name) }}', title_degree: '{{ addslashes($doc->title_degree) }}', polyclinic_id: {{ $doc->polyclinic_id }}, specialty_id: '{{ addslashes($specName) }}', photo: '{{ addslashes($doc->photo ?? '') }}' }; editModalOpen = true" style="background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a;" class="p-2 rounded-xl hover:bg-amber-100 transition-colors cursor-pointer" title="Edit Dokter">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <form action="{{ route('admin.doctors.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus data dokter ini beserta seluruh jadwalnya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca;" class="p-2 rounded-xl hover:bg-red-100 transition-colors cursor-pointer" title="Hapus Dokter">
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

    <!-- ADD DOCTOR MODAL -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="addModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-solid fa-user-plus text-[#0e7c47]"></i>
                    <span>Tambah Dokter Spesialis Baru</span>
                </h3>
                <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.doctors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Nama Dokter</label>
                    <input type="text" name="name" required placeholder="dr. Nama Lengkap, Sp.X" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Gelar Spesialis</label>
                    <input type="text" name="title_degree" placeholder="Sp.PD / Sp.A / Sp.OG" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Poliklinik</label>
                    <select name="polyclinic_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none bg-white">
                        @foreach($polyclinics as $poli)
                        <option value="{{ $poli->id }}">{{ is_array($poli->name) ? ($poli->name['id'] ?? '') : $poli->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Bidang Spesialisasi</label>
                    <input type="text" name="specialty_id" required placeholder="Spesialis Penyakit Dalam" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <!-- FILE UPLOAD OR URL -->
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0;" class="p-4 rounded-2xl space-y-3">
                    <label class="block text-xs font-extrabold text-slate-900 uppercase tracking-wider">Foto Dokter</label>
                    
                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">📷 Upload File Foto dari Komputer:</span>
                        <input type="file" name="photo_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-[#0e7c47] hover:file:bg-emerald-100 cursor-pointer">
                    </div>

                    <div class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">— ATAU —</div>

                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">🔗 Tempel Link / URL Foto:</span>
                        <input type="text" name="photo" placeholder="https://images.unsplash.com/..." class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none">
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold">
                        Batal
                    </button>
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2 rounded-xl text-xs font-extrabold shadow">
                        Simpan Dokter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT DOCTOR MODAL -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="editModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                    <span>Edit Data Dokter</span>
                </h3>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/doctors') }}/' + editDoc.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Nama Dokter</label>
                    <input type="text" name="name" x-model="editDoc.name" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Gelar Spesialis</label>
                    <input type="text" name="title_degree" x-model="editDoc.title_degree" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Poliklinik</label>
                    <select name="polyclinic_id" x-model="editDoc.polyclinic_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none bg-white">
                        @foreach($polyclinics as $poli)
                        <option value="{{ $poli->id }}">{{ is_array($poli->name) ? ($poli->name['id'] ?? '') : $poli->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Bidang Spesialisasi</label>
                    <input type="text" name="specialty_id" x-model="editDoc.specialty_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <!-- FILE UPLOAD OR URL -->
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0;" class="p-4 rounded-2xl space-y-3">
                    <label class="block text-xs font-extrabold text-slate-900 uppercase tracking-wider">Ubah Foto Dokter</label>
                    
                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">📷 Upload Foto Baru dari Komputer:</span>
                        <input type="file" name="photo_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-[#0e7c47] hover:file:bg-emerald-100 cursor-pointer">
                    </div>

                    <div class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">— ATAU —</div>

                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">🔗 Tempel Link / URL Foto:</span>
                        <input type="text" name="photo" x-model="editDoc.photo" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none">
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
