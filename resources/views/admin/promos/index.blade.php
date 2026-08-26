@extends('layouts.admin')

@section('title', 'Manajemen Penawaran Khusus & Promo')

@section('content')
<div x-data="{ 
    addModalOpen: false, 
    editModalOpen: false, 
    editPromo: {
        id: null,
        title_id: '',
        category: 'Umum',
        badge: '',
        original_price: '',
        promo_price: '',
        discount_percentage: '',
        image: '',
        short_description_id: '',
        description_id: '',
        features_text: '',
        terms_conditions_id: '',
        valid_until: '',
        whatsapp_number: '089678211575',
        is_featured: false,
        is_active: true
    }, 
    search: '',
    selectedCategory: 'all'
}" class="space-y-6">

    @if(session('success'))
    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #0e7c47;" class="p-4 rounded-2xl font-bold text-sm flex items-center gap-2 shadow-xs">
        <i class="fa-solid fa-circle-check text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(isset($errors) && $errors->any())
    <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #dc2626;" class="p-4 rounded-2xl font-bold text-sm space-y-1 shadow-xs">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation text-base"></i>
            <span>Gagal menyimpan data promo. Silakan periksa formulir Anda:</span>
        </div>
        <ul class="list-disc list-inside text-xs font-semibold pl-6">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- PAGE HEADER -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="p-6 rounded-3xl shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 font-extrabold text-[10px] uppercase tracking-wider border border-red-100">
                    <i class="fa-solid fa-tags"></i> Penawaran Khusus
                </span>
                <span class="text-xs text-slate-400 font-bold">•</span>
                <span class="text-xs text-slate-500 font-semibold">Total {{ $promos->count() }} Paket Promo</span>
            </div>
            <h2 class="text-xl font-black text-slate-900 mt-1">Kelola Penawaran Khusus & Promo RS</h2>
            <p class="text-xs text-slate-500 mt-0.5">Daftar paket promo kesehatan, diskon tindakan, dan penawaran spesial untuk pasien.</p>
        </div>

        <div class="flex items-center gap-2.5 shrink-0">
            <a href="{{ url('/informasi/penawaran-khusus') }}" target="_blank" style="background-color: #f8fafc; color: #0e7c47; border: 1px solid #cbd5e1;" class="px-4 py-2.5 rounded-xl font-extrabold text-xs hover:bg-emerald-50 transition-all flex items-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                <span>Lihat Frontend</span>
            </a>

            <button @click="addModalOpen = true" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2.5 rounded-xl font-extrabold text-xs shadow-md hover:bg-[#096237] hover:shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer">
                <i class="fa-solid fa-plus text-sm"></i>
                <span>+ Tambah Promo Baru</span>
            </button>
        </div>
    </div>

    <!-- TABLE & SEARCH FILTER CONTAINER -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl shadow-xs overflow-hidden">
        
        <!-- SEARCH & FILTER TOOLBAR -->
        <div style="border-bottom: 1px solid #f1f5f9; background-color: #f8fafc;" class="p-4 sm:p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <!-- CATEGORY PILLS -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0">
                <button type="button" 
                        @click="selectedCategory = 'all'" 
                        :class="selectedCategory === 'all' ? 'bg-[#0e7c47] text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold transition-all cursor-pointer whitespace-nowrap">
                    Semua ({{ $promos->count() }})
                </button>
                <button type="button" 
                        @click="selectedCategory = 'Ibu & Anak'" 
                        :class="selectedCategory === 'Ibu & Anak' ? 'bg-[#0e7c47] text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold transition-all cursor-pointer whitespace-nowrap">
                    👶 Ibu & Anak
                </button>
                <button type="button" 
                        @click="selectedCategory = 'Medical Check Up'" 
                        :class="selectedCategory === 'Medical Check Up' ? 'bg-[#0e7c47] text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold transition-all cursor-pointer whitespace-nowrap">
                    🩺 Medical Check Up
                </button>
                <button type="button" 
                        @click="selectedCategory = 'Poliklinik & Spesialis'" 
                        :class="selectedCategory === 'Poliklinik & Spesialis' ? 'bg-[#0e7c47] text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold transition-all cursor-pointer whitespace-nowrap">
                    🏥 Poliklinik & Gigi
                </button>
            </div>

            <!-- SEARCH INPUT -->
            <div style="position: relative; width: 100%; max-width: 280px;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px; pointer-events: none; z-index: 10;"></i>
                <input type="text" x-model="search" placeholder="Cari paket promo..." style="padding-left: 38px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; border-radius: 12px; border: 1px solid #cbd5e1; font-size: 12px; width: 100%; background-color: #ffffff; outline: none;" class="focus:ring-2 focus:ring-[#0e7c47]">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead style="background-color: #f1f5f9; border-bottom: 1px solid #e2e8f0; color: #475569;" class="uppercase tracking-wider font-extrabold">
                    <tr>
                        <th class="p-4">Brosur / Flyer</th>
                        <th class="p-4">Paket Promo & Kategori</th>
                        <th class="p-4">Harga & Diskon</th>
                        <th class="p-4">Masa Berlaku</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                    @forelse($promos as $promo)
                    @php
                        $pTitle = is_array($promo->title) ? ($promo->title['id'] ?? '') : $promo->title;
                        $pShortDesc = is_array($promo->short_description) ? ($promo->short_description['id'] ?? '') : ($promo->short_description ?? '');
                        $pDesc = is_array($promo->description) ? ($promo->description['id'] ?? '') : ($promo->description ?? '');
                        $pTerms = is_array($promo->terms_conditions) ? ($promo->terms_conditions['id'] ?? '') : ($promo->terms_conditions ?? '');
                        $pFeaturesText = is_array($promo->features) ? implode("\n", $promo->features) : '';
                    @endphp
                    <tr x-show="(selectedCategory === 'all' || '{{ addslashes($promo->category) }}' === selectedCategory) && (search === '' || '{{ addslashes(strtolower($pTitle)) }}'.includes(search.toLowerCase()))" class="hover:bg-slate-50/80 transition-colors">
                        
                        <!-- FLYER IMAGE -->
                        <td class="p-4">
                            <div class="w-16 h-20 rounded-xl overflow-hidden border border-slate-200 bg-slate-100 shadow-2xs relative group">
                                <img src="{{ $promo->image_url }}" alt="{{ $pTitle }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                @if($promo->badge)
                                <div class="absolute top-1 left-1 px-1 py-0.5 rounded bg-red-600 text-white font-black text-[8px]">
                                    {{ $promo->badge }}
                                </div>
                                @endif
                            </div>
                        </td>

                        <!-- TITLE & CATEGORY -->
                        <td class="p-4 max-w-sm">
                            <div class="space-y-1">
                                <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-[#0e7c47] font-extrabold text-[10px] border border-emerald-100 uppercase">
                                    {{ $promo->category }}
                                </span>
                                <div class="font-extrabold text-slate-900 text-sm leading-snug">
                                    {{ $pTitle }}
                                </div>
                                <div class="text-[11px] text-slate-500 line-clamp-1">
                                    {{ $pShortDesc }}
                                </div>
                            </div>
                        </td>

                        <!-- PRICE & DISCOUNT -->
                        <td class="p-4">
                            <div class="space-y-0.5">
                                @if($promo->original_price)
                                <div class="text-slate-400 line-through text-[11px]">
                                    {{ $promo->original_price }}
                                </div>
                                @endif
                                <div class="text-sm font-black text-[#0e7c47]">
                                    {{ $promo->promo_price ?: 'Hubungi Kami' }}
                                </div>
                                @if($promo->discount_percentage)
                                <span class="inline-block px-1.5 py-0.5 rounded bg-red-50 text-red-600 font-extrabold text-[10px]">
                                    Hemat {{ $promo->discount_percentage }}%
                                </span>
                                @endif
                            </div>
                        </td>

                        <!-- VALID UNTIL -->
                        <td class="p-4 text-xs font-semibold text-slate-600">
                            <div class="flex items-center gap-1.5">
                                <i class="fa-regular fa-calendar-check text-slate-400"></i>
                                <span>{{ $promo->valid_until_formatted }}</span>
                            </div>
                        </td>

                        <!-- STATUS -->
                        <td class="p-4 text-center">
                            <form action="{{ route('admin.promos.toggle_active', $promo->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="cursor-pointer" title="Klik untuk mengubah status aktif">
                                    @if($promo->is_active)
                                    <span style="background-color: #d1fae5; color: #065f46;" class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-circle-check text-[9px]"></i> Aktif
                                    </span>
                                    @else
                                    <span style="background-color: #fee2e2; color: #991b1b;" class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-circle-xmark text-[9px]"></i> Nonaktif
                                    </span>
                                    @endif
                                </button>
                            </form>
                        </td>

                        <!-- ACTIONS -->
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ url('/informasi/penawaran-khusus') }}" target="_blank" style="background-color: #f0fdf4; color: #0e7c47; border: 1px solid #bbf7d0;" class="p-2 rounded-xl hover:bg-emerald-100 transition-colors" title="Lihat di Frontend">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                </a>

                                <button @click="editPromo = {{ json_encode([
                                    'id' => $promo->id,
                                    'title_id' => (string)$pTitle,
                                    'category' => (string)$promo->category,
                                    'badge' => (string)($promo->badge ?? ''),
                                    'original_price' => (string)($promo->original_price ?? ''),
                                    'promo_price' => (string)($promo->promo_price ?? ''),
                                    'discount_percentage' => $promo->discount_percentage ?? '',
                                    'image' => (string)($promo->image ?? ''),
                                    'short_description_id' => (string)$pShortDesc,
                                    'description_id' => (string)$pDesc,
                                    'features_text' => (string)$pFeaturesText,
                                    'terms_conditions_id' => (string)$pTerms,
                                    'valid_until' => $promo->valid_until ? $promo->valid_until->format('Y-m-d') : '',
                                    'whatsapp_number' => (string)($promo->whatsapp_number ?? '089678211575'),
                                    'is_featured' => (bool)$promo->is_featured,
                                    'is_active' => (bool)$promo->is_active,
                                ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP) }}; editModalOpen = true" style="background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a;" class="p-2 rounded-xl hover:bg-amber-100 transition-colors cursor-pointer" title="Edit Promo">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>

                                <form action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST" onsubmit="return confirm('Hapus paket promo ini beserta gambarnya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca;" class="p-2 rounded-xl hover:bg-red-100 transition-colors cursor-pointer" title="Hapus Promo">
                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400 font-semibold">
                            Belum ada penawaran khusus atau promo yang dibuat. Klik tombol "+ Tambah Promo Baru" untuk mulai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ADD PROMO MODAL -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="addModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-2xl w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="space-y-0.5">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#0e7c47] flex items-center gap-1">
                        <i class="fa-solid fa-tags"></i> Paket Promo Kesehatan
                    </span>
                    <h3 class="font-black text-slate-900 text-lg">Tambah Penawaran Khusus Baru</h3>
                </div>
                <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl bg-slate-50 hover:bg-slate-100">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.promos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Judul Paket Promo <span class="text-red-500">*</span></label>
                        <input type="text" name="title_id" required placeholder="Contoh: Paket Melahirkan Kemilau Cinta" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="category" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none bg-white">
                            <option value="Ibu & Anak">👶 Ibu & Anak</option>
                            <option value="Medical Check Up">🩺 Medical Check Up</option>
                            <option value="Poliklinik & Spesialis">🏥 Poliklinik & Spesialis</option>
                            <option value="Penunjang Medis">🔬 Penunjang Medis</option>
                            <option value="Gigi & Mulut">🦷 Gigi & Mulut</option>
                            <option value="Umum" selected>✨ Umum</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Badge Ribbon (Opsional)</label>
                        <input type="text" name="badge" placeholder="HOT PROMO / HEMAT 30%" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Harga Normal (Coret)</label>
                        <input type="text" name="original_price" placeholder="Rp 1.500.000" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Harga Promo (Spesial)</label>
                        <input type="text" name="promo_price" placeholder="Rp 999.000" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none font-bold text-[#0e7c47]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Diskon (%)</label>
                        <input type="number" name="discount_percentage" min="0" max="100" placeholder="30" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Berlaku Sampai Tanggal</label>
                        <input type="date" name="valid_until" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none bg-white">
                    </div>
                </div>

                <!-- FILE UPLOAD OR URL -->
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0;" class="p-4 rounded-2xl space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-extrabold text-slate-900 uppercase tracking-wider">Gambar Flyer / Brosur Promo</label>
                        <span class="text-[11px] text-slate-500 font-medium">Maks. 30MB (JPG/PNG/WEBP)</span>
                    </div>
                    
                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">📷 Upload Brosur dari Komputer:</span>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-[#0e7c47] hover:file:bg-emerald-100 cursor-pointer">
                    </div>

                    <div class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">— ATAU —</div>

                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">🔗 Tempel Link / URL Gambar:</span>
                        <input type="text" name="image" placeholder="https://..." class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat / Ringkasan</label>
                    <input type="text" name="short_description_id" placeholder="Ringkasan 1-2 kalimat menarik..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Lengkap / Penjelasan Paket</label>
                    <textarea name="description_id" rows="3" placeholder="Penjelasan detail mengenai paket promo dan keunggulannya..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Daftar Benefit / Cakupan Pemeriksaan (1 baris per poin)</label>
                    <textarea name="features_text" rows="3" placeholder="Contoh:&#10;Free Newborn Photoshoot & Bingkai&#10;Free Senam Hamil & Edukasi Laktasi&#10;Free Antar Jemput Kepulangan" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none font-mono"></textarea>
                    <span class="text-[11px] text-slate-400 mt-0.5 block">Tulis tiap poin benefit di baris baru (enter).</span>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Syarat & Ketentuan Promo (Opsional)</label>
                    <textarea name="terms_conditions_id" rows="2" placeholder="1. Berlaku untuk pasien umum non-asuransi.&#10;2. Melakukan reservasi H-1." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Nomor WhatsApp Booking</label>
                        <input type="text" name="whatsapp_number" value="089678211575" placeholder="089678211575" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                    </div>
                    <div class="flex items-center gap-4 pt-5">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                            <input type="checkbox" name="is_active" value="1" checked class="rounded text-[#0e7c47] focus:ring-[#0e7c47] w-4 h-4">
                            <span>Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                            <input type="checkbox" name="is_featured" value="1" checked class="rounded text-[#0e7c47] focus:ring-[#0e7c47] w-4 h-4">
                            <span>Tampilkan di Beranda</span>
                        </label>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-6 py-2.5 rounded-xl text-xs font-extrabold shadow-sm hover:bg-[#096237] transition-all cursor-pointer">
                        Simpan Promo
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT PROMO MODAL -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="editModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-2xl w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="space-y-0.5">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-600 flex items-center gap-1">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Paket Promo
                    </span>
                    <h3 class="font-black text-slate-900 text-lg">Perbarui Penawaran Khusus</h3>
                </div>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl bg-slate-50 hover:bg-slate-100">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/promos') }}/' + editPromo.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Judul Paket Promo <span class="text-red-500">*</span></label>
                        <input type="text" name="title_id" x-model="editPromo.title_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="category" x-model="editPromo.category" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none bg-white">
                            <option value="Ibu & Anak">👶 Ibu & Anak</option>
                            <option value="Medical Check Up">🩺 Medical Check Up</option>
                            <option value="Poliklinik & Spesialis">🏥 Poliklinik & Spesialis</option>
                            <option value="Penunjang Medis">🔬 Penunjang Medis</option>
                            <option value="Gigi & Mulut">🦷 Gigi & Mulut</option>
                            <option value="Umum">✨ Umum</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Badge Ribbon</label>
                        <input type="text" name="badge" x-model="editPromo.badge" placeholder="HOT PROMO" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Harga Normal</label>
                        <input type="text" name="original_price" x-model="editPromo.original_price" placeholder="Rp 1.500.000" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Harga Promo</label>
                        <input type="text" name="promo_price" x-model="editPromo.promo_price" placeholder="Rp 999.000" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none font-bold text-[#0e7c47]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Diskon (%)</label>
                        <input type="number" name="discount_percentage" x-model="editPromo.discount_percentage" min="0" max="100" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Berlaku Sampai Tanggal</label>
                        <input type="date" name="valid_until" x-model="editPromo.valid_until" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none bg-white">
                    </div>
                </div>

                <!-- FILE UPLOAD OR URL -->
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0;" class="p-4 rounded-2xl space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-extrabold text-slate-900 uppercase tracking-wider">Ubah Brosur Promo</label>
                        <span class="text-[11px] text-slate-500 font-medium">Maks. 30MB</span>
                    </div>
                    
                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">📷 Upload Brosur Baru:</span>
                        <input type="file" name="image_file" accept="image/*" @change="if ($event.target.files.length) editPromo.image = ''" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-[#0e7c47] hover:file:bg-emerald-100 cursor-pointer">
                    </div>

                    <div class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">— ATAU —</div>

                    <div>
                        <span class="text-[11px] font-bold text-slate-600 block mb-1">🔗 Tempel Link / URL Gambar:</span>
                        <input type="text" name="image" x-model="editPromo.image" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat / Ringkasan</label>
                    <input type="text" name="short_description_id" x-model="editPromo.short_description_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Lengkap / Penjelasan Paket</label>
                    <textarea name="description_id" x-model="editPromo.description_id" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Daftar Benefit / Cakupan Pemeriksaan (1 baris per poin)</label>
                    <textarea name="features_text" x-model="editPromo.features_text" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none font-mono"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Syarat & Ketentuan Promo</label>
                    <textarea name="terms_conditions_id" x-model="editPromo.terms_conditions_id" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Nomor WhatsApp Booking</label>
                        <input type="text" name="whatsapp_number" x-model="editPromo.whatsapp_number" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0e7c47] outline-none">
                    </div>
                    <div class="flex items-center gap-4 pt-5">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                            <input type="checkbox" name="is_active" value="1" x-model="editPromo.is_active" class="rounded text-[#0e7c47] focus:ring-[#0e7c47] w-4 h-4">
                            <span>Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                            <input type="checkbox" name="is_featured" value="1" x-model="editPromo.is_featured" class="rounded text-[#0e7c47] focus:ring-[#0e7c47] w-4 h-4">
                            <span>Tampilkan di Beranda</span>
                        </label>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-6 py-2.5 rounded-xl text-xs font-extrabold shadow-sm hover:bg-[#096237] transition-all cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
