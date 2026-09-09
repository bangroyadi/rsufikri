@extends('layouts.app')

@section('title', 'Daftar & Buat Janji Temu Dokter Online | RSU Fikri Medika Karawang')
@section('meta_description', 'Pendaftaran online pasien rawat jalan dan buat janji temu dokter spesialis RSU Fikri Medika Karawang. Proses cepat, mudah, dan langsung terkonfirmasi via WhatsApp.')

@section('schema_jsonld')
<script type="application/ld+json">
{!! json_encode(app(\App\Services\SeoService::class)->generateBreadcrumbSchema([
    'Beranda' => url('/'),
    'Buat Janji Dokter' => url('/buat-janji')
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

@section('content')
<h1 class="sr-only">Daftar & Buat Janji Temu Dokter Online RSU Fikri Medika Karawang</h1>

<!-- MAIN CONTENT SECTION (MATCHING PROFIL.BLADE.PHP SPACING) -->
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">

    <!-- MAIN FORM & SIDEBAR GRID (12-COLUMNS MATCHING PROFIL.BLADE.PHP) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start" x-data="buatJanjiForm()">
        
        <!-- LEFT COLUMN: FORM & WHATSAPP PREVIEW (7 COLS) -->
        <div class="lg:col-span-7 space-y-8">
            
            <!-- FORM CARD CONTAINER -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
                
                <!-- CARD HEADER & STATUS TOGGLE -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-gray-100">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-extrabold border border-emerald-100">
                            <i class="fa-solid fa-clipboard-user"></i>
                        </div>
                        <div>
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-emerald-100 text-[#0e7c47] text-[11px] font-bold mb-0.5">
                                {{ __('Langkah Pendaftaran') }}
                            </span>
                            <h2 class="text-lg sm:text-xl font-bold text-gray-900">{{ __('Isi Data Pendaftaran Pasien') }}</h2>
                        </div>
                    </div>

                    <!-- PASIEN STATUS PILL TOGGLE -->
                    <div class="inline-flex bg-gray-100 p-1 rounded-xl text-xs font-bold border border-gray-200 shrink-0 self-start sm:self-auto">
                        <button type="button" @click="form.status_pasien = 'baru'" 
                                :class="form.status_pasien === 'baru' ? 'bg-[#0e7c47] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900'"
                                class="px-3.5 py-1.5 rounded-lg transition-all">
                            Pasien Baru
                        </button>
                        <button type="button" @click="form.status_pasien = 'lama'" 
                                :class="form.status_pasien === 'lama' ? 'bg-[#0e7c47] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900'"
                                class="px-3.5 py-1.5 rounded-lg transition-all">
                            Pasien Lama
                        </button>
                    </div>
                </div>

                <form @submit.prevent="submitToWhatsapp()" class="space-y-5">
                    
                    <!-- IF PASIEN LAMA SHOW NO RM FIELD -->
                    <div x-show="form.status_pasien === 'lama'" x-transition 
                         class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-100 space-y-1.5">
                        <label class="block text-xs font-bold text-[#0e7c47]">
                            <span>{{ __('Nomor Rekam Medis (No. RM)') }}</span>
                            <span class="text-gray-500 font-normal">({{ __('Opsional jika lupa') }})</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#0e7c47]">
                                <i class="fa-solid fa-hashtag text-xs"></i>
                            </div>
                            <input type="text" x-model="form.no_rm" placeholder="Contoh: RM-123456" 
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:ring-2 focus:ring-[#0e7c47]/20 text-xs sm:text-sm font-semibold text-gray-900 bg-white">
                        </div>
                    </div>

                    <!-- NAMA LENGKAP PASIEN -->
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-user text-[#0e7c47] text-xs"></i>
                                <span>{{ __('Nama Pasien') }}</span>
                            </span>
                            <span class="text-xs text-red-500 font-bold">* {{ __('Wajib') }}</span>
                        </label>
                        <input type="text" x-model="form.nama" placeholder="Masukkan nama pasien sesuai KTP / KK" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:ring-2 focus:ring-[#0e7c47]/20 text-xs sm:text-sm font-medium text-gray-900 placeholder-gray-400 bg-white transition-all shadow-xs">
                    </div>

                    <!-- TGL LAHIR & NIK -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- TGL LAHIR PASIEN -->
                        <div>
                            <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5 flex items-center justify-between">
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar text-[#0e7c47] text-xs"></i>
                                    <span>{{ __('Tgl Lahir Pasien') }}</span>
                                </span>
                                <span class="text-xs text-red-500 font-bold">* {{ __('Wajib') }}</span>
                            </label>
                            <input type="date" x-model="form.tgl_lahir" required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:ring-2 focus:ring-[#0e7c47]/20 text-xs sm:text-sm font-medium text-gray-900 bg-white transition-all shadow-xs">
                        </div>

                        <!-- NIK -->
                        <div>
                            <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5 flex items-center justify-between">
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-id-card text-[#0e7c47] text-xs"></i>
                                    <span>{{ __('NIK (Nomor Induk Kependudukan)') }}</span>
                                </span>
                                <span class="text-xs text-red-500 font-bold">* {{ __('Wajib') }}</span>
                            </label>
                            <input type="text" x-model="form.nik" placeholder="16 digit NIK KTP / KK" maxlength="16" required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:ring-2 focus:ring-[#0e7c47]/20 text-xs sm:text-sm font-medium text-gray-900 placeholder-gray-400 bg-white transition-all shadow-xs">
                        </div>
                    </div>

                    <!-- NAMA AYAH & NAMA IBU -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- NAMA AYAH -->
                        <div>
                            <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-user-tie text-[#0e7c47] text-xs"></i>
                                <span>{{ __('Nama Ayah') }}</span>
                            </label>
                            <input type="text" x-model="form.nama_ayah" placeholder="Masukkan nama ayah kandung"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:ring-2 focus:ring-[#0e7c47]/20 text-xs sm:text-sm font-medium text-gray-900 placeholder-gray-400 bg-white transition-all shadow-xs">
                        </div>

                        <!-- NAMA IBU -->
                        <div>
                            <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-person-dress text-[#0e7c47] text-xs"></i>
                                <span>{{ __('Nama Ibu') }}</span>
                            </label>
                            <input type="text" x-model="form.nama_ibu" placeholder="Masukkan nama ibu kandung"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:ring-2 focus:ring-[#0e7c47]/20 text-xs sm:text-sm font-medium text-gray-900 placeholder-gray-400 bg-white transition-all shadow-xs">
                        </div>
                    </div>

                    <!-- ALAMAT LENGKAP -->
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-[#0e7c47] text-xs"></i>
                                <span>{{ __('Alamat Lengkap') }}</span>
                            </span>
                            <span class="text-xs text-red-500 font-bold">* {{ __('Wajib') }}</span>
                        </label>
                        <textarea x-model="form.alamat" rows="2" placeholder="Masukkan alamat lengkap RT/RW, Dusun/Desa, Kecamatan, Kabupaten..." required
                                  class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:ring-2 focus:ring-[#0e7c47]/20 text-xs sm:text-sm font-medium text-gray-900 placeholder-gray-400 bg-white transition-all shadow-xs"></textarea>
                    </div>

                    <!-- NO HP AKTIF -->
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-brands fa-whatsapp text-emerald-600 text-xs"></i>
                                <span>{{ __('Nomor HP Aktif (WhatsApp)') }}</span>
                            </span>
                            <span class="text-xs text-red-500 font-bold">* {{ __('Wajib') }}</span>
                        </label>
                        <input type="tel" x-model="form.no_hp" placeholder="Contoh: 081234567890" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:ring-2 focus:ring-[#0e7c47]/20 text-xs sm:text-sm font-medium text-gray-900 placeholder-gray-400 bg-white transition-all shadow-xs">
                    </div>

                    <!-- HARI/TGL BEROBAT & JAM KEDATANGAN -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- HARI/TGL BEROBAT -->
                        <div>
                            <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5 flex items-center justify-between">
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar-check text-[#0e7c47] text-xs"></i>
                                    <span>{{ __('Hari / Tgl Berobat') }}</span>
                                </span>
                                <span class="text-xs text-red-500 font-bold">* {{ __('Wajib') }}</span>
                            </label>
                            <input type="date" x-model="form.tanggal" required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:ring-2 focus:ring-[#0e7c47]/20 text-xs sm:text-sm font-medium text-gray-900 bg-white transition-all shadow-xs">
                            <div class="text-[11px] text-emerald-700 font-semibold mt-1" x-show="formattedHariTanggal" x-text="'📅 ' + formattedHariTanggal"></div>
                        </div>

                        <!-- JAM KEDATANGAN KE RS -->
                        <div>
                            <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-regular fa-clock text-[#0e7c47] text-xs"></i>
                                <span>{{ __('Jam Kedatangan ke RS') }}</span>
                            </label>
                            <div class="relative">
                                <input type="text" x-model="form.jam_kedatangan" placeholder="Contoh: 09:00 WIB / Pagi"
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:ring-2 focus:ring-[#0e7c47]/20 text-xs sm:text-sm font-medium text-gray-900 placeholder-gray-400 bg-white transition-all shadow-xs">
                            </div>
                            <!-- Quick Time Picks -->
                            <div class="flex flex-wrap gap-1.5 mt-1.5">
                                <template x-for="timeSlot in ['08:00 WIB', '10:00 WIB', '13:00 WIB', '16:00 WIB', '18:00 WIB']" :key="timeSlot">
                                    <button type="button" @click="form.jam_kedatangan = timeSlot" 
                                            :class="form.jam_kedatangan === timeSlot ? 'bg-[#0e7c47] text-white' : 'bg-gray-100 text-gray-700 hover:bg-emerald-50'"
                                            class="text-[10px] px-2 py-0.5 rounded-md font-semibold transition-all" x-text="timeSlot"></button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- JENIS JAMINAN SELECTOR CARDS -->
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5">
                            <span>{{ __('Jaminan / Pembayaran Pasien') }}</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <!-- PASIEN UMUM -->
                            <button type="button" @click="form.jaminan = 'Umum / Mandiri'" 
                                    :class="form.jaminan === 'Umum / Mandiri' ? 'border-[#0e7c47] bg-emerald-50/80 text-[#0e7c47] font-bold ring-2 ring-[#0e7c47]/20' : 'border-gray-200 bg-white text-gray-700 hover:border-emerald-200'"
                                    class="p-3.5 rounded-2xl border text-left flex items-center gap-3 transition-all text-xs">
                                <div class="w-8 h-8 rounded-xl bg-yellow-400 text-slate-950 flex items-center justify-center text-sm font-bold shrink-0 shadow-xs">
                                    <i class="fa-solid fa-wallet"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ __('Pasien Umum') }}</div>
                                    <div class="text-[10px] text-gray-500 font-medium">{{ __('Bayar Mandiri') }}</div>
                                </div>
                            </button>

                            <!-- BPJS -->
                            <button type="button" @click="form.jaminan = 'BPJS Kesehatan'" 
                                    :class="form.jaminan === 'BPJS Kesehatan' ? 'border-[#0e7c47] bg-emerald-50/80 text-[#0e7c47] font-bold ring-2 ring-[#0e7c47]/20' : 'border-gray-200 bg-white text-gray-700 hover:border-emerald-200'"
                                    class="p-3.5 rounded-2xl border text-left flex items-center gap-3 transition-all text-xs">
                                <div class="w-8 h-8 rounded-xl bg-yellow-400 text-slate-950 flex items-center justify-center text-sm font-bold shrink-0 shadow-xs">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ __('BPJS Kesehatan') }}</div>
                                    <div class="text-[10px] text-gray-500 font-medium">{{ __('Rujukan Faskes') }}</div>
                                </div>
                            </button>

                            <!-- ASURANSI -->
                            <button type="button" @click="form.jaminan = 'Asuransi Swasta / Perusahaan'" 
                                    :class="form.jaminan === 'Asuransi Swasta / Perusahaan' ? 'border-[#0e7c47] bg-emerald-50/80 text-[#0e7c47] font-bold ring-2 ring-[#0e7c47]/20' : 'border-gray-200 bg-white text-gray-700 hover:border-emerald-200'"
                                    class="p-3.5 rounded-2xl border text-left flex items-center gap-3 transition-all text-xs">
                                <div class="w-8 h-8 rounded-xl bg-yellow-400 text-slate-950 flex items-center justify-center text-sm font-bold shrink-0 shadow-xs">
                                    <i class="fa-solid fa-building-columns"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ __('Asuransi Swasta') }}</div>
                                    <div class="text-[10px] text-gray-500 font-medium">{{ __('Kemitraan/Perusahaan') }}</div>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- TUJUAN POLI & DOKTER SELECTION -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-1">
                        <!-- POLIKLINIK (CUSTOM DROPDOWN) -->
                        <div x-data="{ openPoli: false, searchPoli: '' }" @click.outside="openPoli = false" class="relative">
                            <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-hospital-user text-[#0e7c47] text-xs"></i>
                                <span>{{ __('Tujuan Poli (Poliklinik)') }}</span>
                            </label>
                            
                            <!-- Trigger Button -->
                            <button type="button" 
                                    @click="openPoli = !openPoli" 
                                    class="w-full pl-9 pr-8 py-2.5 rounded-xl border border-gray-200 focus:border-[#0e7c47] focus:ring-1 focus:ring-[#0e7c47] text-xs sm:text-sm text-left bg-white outline-none transition-all flex items-center justify-between cursor-pointer relative"
                                    :class="form.poliklinik_id ? 'text-gray-900 font-semibold border-emerald-300' : 'text-gray-600'">
                                <i class="fa-solid fa-clinic-medical absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                                <span class="truncate pr-2" x-text="selectedPoliName || '-- Pilih Poliklinik --'"></span>
                                <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] transition-transform duration-200" :class="openPoli ? 'rotate-180 text-[#0e7c47]' : ''"></i>
                            </button>

                            <!-- Dropdown Menu List -->
                            <div x-show="openPoli" 
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-150 transform"
                                 x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-100 transform"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                                 class="absolute left-0 right-0 top-full mt-1.5 z-50 bg-white rounded-2xl shadow-2xl border border-emerald-100 p-2 max-h-60 overflow-y-auto w-full">
                                
                                <div class="px-1 pb-1.5 mb-1 border-b border-gray-100">
                                    <input type="text" 
                                           x-model="searchPoli" 
                                           placeholder="Cari poliklinik..." 
                                           @click.stop
                                           class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-gray-50 border border-gray-200 outline-none focus:border-[#0e7c47] focus:bg-white text-gray-800 placeholder-gray-400">
                                </div>

                                <div @click="form.poliklinik_id = ''; onPoliChange(); openPoli = false" 
                                     x-show="!searchPoli || 'semua poliklinik'.includes(searchPoli.toLowerCase())"
                                     class="px-3 py-2 rounded-xl text-xs font-semibold cursor-pointer transition-colors flex items-center justify-between"
                                     :class="!form.poliklinik_id ? 'bg-emerald-50 text-[#0e7c47]' : 'text-gray-700 hover:bg-gray-50'">
                                    <span>-- Tanpa Pilihan Poliklinik --</span>
                                    <i x-show="!form.poliklinik_id" class="fa-solid fa-check text-xs text-[#0e7c47]"></i>
                                </div>

                                <template x-for="poli in polyclinicsList.filter(p => !searchPoli || getPoliName(p).toLowerCase().includes(searchPoli.toLowerCase()))" :key="poli.id">
                                    <div @click="form.poliklinik_id = poli.id; onPoliChange(); openPoli = false" 
                                         class="px-3 py-2 rounded-xl text-xs font-semibold cursor-pointer transition-colors flex items-center justify-between"
                                         :class="form.poliklinik_id == poli.id ? 'bg-emerald-50 text-[#0e7c47]' : 'text-gray-700 hover:bg-gray-50'">
                                        <span class="truncate" x-text="getPoliName(poli)"></span>
                                        <i x-show="form.poliklinik_id == poli.id" class="fa-solid fa-check text-xs text-[#0e7c47]"></i>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- DOKTER SPESIALIS (CUSTOM DROPDOWN) -->
                        <div x-data="{ openDoc: false, searchDoc: '' }" @click.outside="openDoc = false" class="relative">
                            <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-user-doctor text-[#0e7c47] text-xs"></i>
                                <span>{{ __('Dokter Spesialis') }}</span>
                            </label>

                            <!-- Trigger Button -->
                            <button type="button" 
                                    @click="openDoc = !openDoc" 
                                    class="w-full pl-9 pr-8 py-2.5 rounded-xl border border-gray-200 focus:border-[#0e7c47] focus:ring-1 focus:ring-[#0e7c47] text-xs sm:text-sm text-left bg-white outline-none transition-all flex items-center justify-between cursor-pointer relative"
                                    :class="form.dokter_id ? 'text-gray-900 font-semibold border-emerald-300' : 'text-gray-600'">
                                <i class="fa-solid fa-user-md absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                                <span class="truncate pr-2" x-text="selectedDoctorName || '-- Pilih Dokter Spesialis --'"></span>
                                <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] transition-transform duration-200" :class="openDoc ? 'rotate-180 text-[#0e7c47]' : ''"></i>
                            </button>

                            <!-- Dropdown Menu List -->
                            <div x-show="openDoc" 
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-150 transform"
                                 x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-100 transform"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                                 class="absolute left-0 right-0 top-full mt-1.5 z-50 bg-white rounded-2xl shadow-2xl border border-emerald-100 p-2 max-h-60 overflow-y-auto w-full">
                                
                                <div class="px-1 pb-1.5 mb-1 border-b border-gray-100">
                                    <input type="text" 
                                           x-model="searchDoc" 
                                           placeholder="Cari dokter..." 
                                           @click.stop
                                           class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-gray-50 border border-gray-200 outline-none focus:border-[#0e7c47] focus:bg-white text-gray-800 placeholder-gray-400">
                                </div>

                                <div @click="form.dokter_id = ''; openDoc = false" 
                                     class="px-3 py-2 rounded-xl text-xs font-semibold cursor-pointer transition-colors flex items-center justify-between"
                                     :class="!form.dokter_id ? 'bg-emerald-50 text-[#0e7c47]' : 'text-gray-700 hover:bg-gray-50'">
                                    <span>-- Tanpa Pilihan Dokter --</span>
                                    <i x-show="!form.dokter_id" class="fa-solid fa-check text-xs text-[#0e7c47]"></i>
                                </div>

                                <template x-for="doc in filteredDoctors.filter(d => !searchDoc || (d.name + ' ' + (d.title_degree || '')).toLowerCase().includes(searchDoc.toLowerCase()))" :key="doc.id">
                                    <div @click="form.dokter_id = doc.id; if(doc.polyclinic_id) form.poliklinik_id = doc.polyclinic_id; openDoc = false" 
                                         class="px-3 py-2 rounded-xl text-xs font-semibold cursor-pointer transition-colors flex items-center justify-between"
                                         :class="form.dokter_id == doc.id ? 'bg-emerald-50 text-[#0e7c47]' : 'text-gray-700 hover:bg-gray-50'">
                                        <span class="truncate" x-text="doc.name + ((doc.title_degree || doc.degree) ? ', ' + (doc.title_degree || doc.degree) : '')"></span>
                                        <i x-show="form.dokter_id == doc.id" class="fa-solid fa-check text-xs text-[#0e7c47]"></i>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- KELUHAN UTAMA (OPSIONAL) -->
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-notes-medical text-[#0e7c47] text-xs"></i>
                                <span>{{ __('Keluhan Utama / Alasan Berobat') }}</span>
                            </span>
                            <span class="text-[11px] text-gray-500 font-normal">({{ __('Opsional') }})</span>
                        </label>
                        <textarea x-model="form.keluhan" rows="2" placeholder="Tuliskan keluhan medis atau gejala yang dirasakan (opsional)..."
                                  class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:ring-2 focus:ring-[#0e7c47]/20 text-xs sm:text-sm font-medium text-gray-900 placeholder-gray-400 bg-white transition-all shadow-xs"></textarea>
                    </div>

                </form>

            </div>

            <!-- WHATSAPP REALISTIC CHAT PREVIEW CARD -->
            <div class="rounded-3xl overflow-hidden shadow-md border border-gray-200 bg-slate-900">
                
                <!-- WHATSAPP CHAT HEADER -->
                <div class="bg-[#075e54] text-white p-3.5 px-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-white p-0.5 overflow-hidden shrink-0 border border-emerald-300 shadow-xs">
                            <img src="{{ asset('logodasboard.png') }}" alt="RSU Fikri Medika" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h3 class="font-extrabold text-xs sm:text-sm text-white flex items-center gap-1">
                                <span>Call Center RSU Fikri Medika</span>
                                <i class="fa-solid fa-circle-check text-emerald-300 text-xs"></i>
                            </h3>
                            <p class="text-[11px] text-emerald-100 font-normal">Online • Respon Pendaftaran 24 Jam</p>
                        </div>
                    </div>

                    <button type="button" @click="copyText()" class="px-3 py-1 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-bold text-emerald-100 transition-colors border border-white/15 flex items-center gap-1.5">
                        <i class="fa-solid" :class="copied ? 'fa-check text-yellow-300' : 'fa-copy'"></i>
                        <span x-text="copied ? 'Tersalin!' : 'Salin Teks'"></span>
                    </button>
                </div>

                <!-- CHAT WALLPAPER & LIVE PREVIEW BUBBLES -->
                <div class="p-4 sm:p-5 bg-[#efeae2] space-y-3.5 min-h-[200px] flex flex-col justify-end">
                    
                    <!-- INCOMING WELCOME CHAT BUBBLE -->
                    <div class="self-start max-w-[85%] bg-white p-3 rounded-2xl rounded-tl-xs shadow-xs text-xs text-gray-800 space-y-1">
                        <div class="font-bold text-[#075e54] text-[10px]">Call Center RSU Fikri Medika</div>
                        <p class="leading-relaxed font-medium">
                            Selamat datang di Call Center RSU Fikri Medika Karawang. Format pendaftaran resmi Anda tersusun otomatis pada pesan di bawah ini.
                        </p>
                    </div>

                    <!-- OUTGOING LIVE PREVIEW BUBBLE -->
                    <div class="self-end max-w-[90%] bg-[#dcf8c6] p-3.5 rounded-2xl rounded-tr-xs shadow-xs text-xs text-slate-900 space-y-1.5 border border-emerald-200">
                        <div class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider border-b border-emerald-200/60 pb-1 flex justify-between items-center">
                            <span>Format WA Resmi Pendaftaran</span>
                            <span class="text-emerald-700 font-semibold" x-text="copied ? '✓ Copied' : ''"></span>
                        </div>
                        
                        <div class="font-mono text-xs text-slate-900 whitespace-pre-wrap leading-relaxed select-all" x-text="generatedMessage"></div>

                        <div class="flex items-center justify-end gap-1 text-[9px] text-emerald-700 font-bold pt-0.5">
                            <span>Sekarang</span>
                            <i class="fa-solid fa-check-double text-emerald-600 text-xs"></i>
                        </div>
                    </div>

                </div>

                <!-- MAIN ACTION BUTTONS BAR -->
                <div class="p-4 bg-white border-t border-gray-200 flex flex-col sm:flex-row items-center gap-3">
                    <button type="button" @click="submitToWhatsapp()" 
                            class="w-full sm:flex-1 py-3.5 px-5 rounded-xl bg-[#0e7c47] hover:bg-[#084829] text-white font-extrabold text-xs sm:text-sm transition-all shadow-md flex items-center justify-center gap-2.5 active:scale-95">
                        <i class="fa-brands fa-whatsapp text-xl text-yellow-300"></i>
                        <span>{{ __('Kirim Pendaftaran ke WhatsApp Call Center') }}</span>
                    </button>

                    <a :href="blankWaUrl" 
                       target="_blank"
                       class="w-full sm:w-auto py-3.5 px-4 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold text-xs transition-colors border border-gray-200 flex items-center justify-center gap-1.5 text-center shrink-0">
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#0e7c47]"></i>
                        <span>{{ __('Format WA Kosong') }}</span>
                    </a>
                </div>

            </div>

        </div>

        <!-- RIGHT SIDEBAR: CONTACT, EMERGENCY & GUIDELINES (5 COLS MATCHING PROFIL.BLADE.PHP) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- DIRECT CALL CENTER CARD (MATCHING PROFIL CTA CARD BG & SHADOW) -->
            <div class="bg-gradient-to-br from-[#0a5c34] via-[#0e7c47] to-[#084b2a] p-6 rounded-3xl text-white shadow-xl space-y-4 border-2 border-emerald-500/20 relative overflow-hidden">
                <div class="flex items-center gap-3 border-b border-emerald-500/30 pb-3">
                    <div class="w-10 h-10 rounded-xl bg-yellow-400 text-slate-950 flex items-center justify-center text-xl font-bold">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <span class="text-[10px] text-yellow-300 font-bold uppercase tracking-wider">{{ __('WhatsApp Call Center') }}</span>
                        <h3 class="font-extrabold text-sm sm:text-base leading-tight text-white">{{ __('RSU Fikri Medika') }}</h3>
                    </div>
                </div>

                <p class="text-xs text-emerald-100 leading-relaxed font-medium">
                    {{ __('Ingin berkonsultasi atau mendaftar berobat secara langsung melalui tautan WhatsApp resmi Call Center?') }}
                </p>

                <div class="p-3.5 rounded-2xl bg-white/10 border border-white/15 text-xs font-bold text-yellow-300 flex items-center justify-between backdrop-blur-md">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-phone text-emerald-300"></i>
                        <span>0822-8074-9999</span>
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-600 text-white">24 Jam</span>
                </div>

                <a :href="blankWaUrl" 
                   target="_blank"
                   class="w-full py-3 px-4 rounded-xl bg-yellow-400 hover:bg-yellow-300 text-slate-950 font-black text-xs transition-colors shadow flex items-center justify-center gap-2">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>{{ __('Hubungi WhatsApp Sekarang') }}</span>
                </a>
            </div>

            <!-- EMERGENCY IGD 24 JAM -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-3.5">
                <h3 class="text-sm font-bold text-gray-900 pb-3 border-b border-gray-100 flex items-center gap-2">
                    <i class="fa-solid fa-truck-medical text-red-600"></i>
                    <span>{{ __('Kontak Darurat & Operasional') }}</span>
                </h3>

                <div class="space-y-3 text-xs">
                    <a href="tel:081287075555" class="p-3.5 rounded-2xl bg-red-50/80 border border-red-200/80 flex items-center justify-between text-red-900 font-bold hover:bg-red-100 transition-colors">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-phone-volume text-red-600"></i>
                            <span>IGD 24 Jam: 0812 8707 5555</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-red-400"></i>
                    </a>

                    <div class="p-3.5 rounded-2xl bg-emerald-50/50 border border-emerald-100 flex items-center gap-2.5 text-gray-700">
                        <i class="fa-solid fa-clock text-[#0e7c47]"></i>
                        <div>
                            <span class="font-bold block text-xs text-gray-900">Jam Praktik Poliklinik</span>
                            <span class="text-[11px] text-gray-600">Senin - Sabtu: 08:00 - 20:00 WIB</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PERSYARATAN BEROBAT -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-3.5">
                <h3 class="text-sm font-bold text-gray-900 pb-3 border-b border-gray-100 flex items-center gap-2">
                    <i class="fa-solid fa-clipboard-list text-[#0e7c47]"></i>
                    <span>{{ __('Persyaratan Pendaftaran') }}</span>
                </h3>

                <div class="space-y-3 text-xs text-gray-600 leading-relaxed font-medium">
                    <div class="border-b border-gray-100 pb-2.5">
                        <h4 class="font-bold text-gray-900 mb-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                            <span>{{ __('Pasien Umum') }}</span>
                        </h4>
                        <p class="pl-4 text-gray-600">Membawa kartu identitas (KTP/SIM/Kartu Keluarga) dan Kartu Berobat (jika pasien lama).</p>
                    </div>

                    <div>
                        <h4 class="font-bold text-gray-900 mb-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                            <span>{{ __('Pasien BPJS Kesehatan') }}</span>
                        </h4>
                        <p class="pl-4 text-gray-600">Membawa Kartu BPJS/JKN Digital, Surat Rujukan Faskes 1, dan KTP/KK Pasien.</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ALPINE.JS SCRIPT FOR FORM & WA GENERATOR -->
<script>
function buatJanjiForm() {
    const doctors = @json($doctors);
    const rawPolyclinics = @json($polyclinics);
    const selectedDoctorId = @json($selectedDoctorId);
    const selectedPoliId = @json($selectedPoliId);

    return {
        form: {
            status_pasien: 'baru',
            no_rm: '',
            nama: '',
            tgl_lahir: '',
            nik: '',
            alamat: '',
            nama_ayah: '',
            nama_ibu: '',
            poliklinik_id: selectedPoliId || '',
            dokter_id: selectedDoctorId || '',
            jaminan: 'Umum / Mandiri',
            tanggal: new Date().toISOString().split('T')[0],
            no_hp: '',
            jam_kedatangan: '',
            keluhan: ''
        },
        doctorsList: doctors,
        polyclinicsList: rawPolyclinics,
        copied: false,

        init() {
            if (this.form.dokter_id) {
                const foundDoc = this.doctorsList.find(d => d.id == this.form.dokter_id);
                if (foundDoc && foundDoc.polyclinic_id) {
                    this.form.poliklinik_id = foundDoc.polyclinic_id;
                }
            }
        },

        get filteredDoctors() {
            if (!this.form.poliklinik_id) {
                return this.doctorsList;
            }
            return this.doctorsList.filter(d => d.polyclinic_id == this.form.poliklinik_id);
        },

        onPoliChange() {
            if (this.form.dokter_id) {
                const currentDoc = this.doctorsList.find(d => d.id == this.form.dokter_id);
                if (currentDoc && currentDoc.polyclinic_id != this.form.poliklinik_id) {
                    this.form.dokter_id = '';
                }
            }
        },

        getPoliName(poli) {
            if (!poli || !poli.name) return '';
            if (typeof poli.name === 'string') return poli.name;
            if (typeof poli.name === 'object') {
                const locale = '{{ app()->getLocale() }}';
                return poli.name[locale] || poli.name['id'] || poli.name['en'] || Object.values(poli.name)[0] || '';
            }
            return '';
        },

        get selectedDoctorName() {
            if (!this.form.dokter_id) return '';
            const doc = this.doctorsList.find(d => d.id == this.form.dokter_id);
            if (!doc) return '';
            const degree = doc.title_degree || doc.degree || '';
            return doc.name + (degree ? ', ' + degree : '');
        },

        get selectedPoliName() {
            if (!this.form.poliklinik_id) return '';
            const poli = this.polyclinicsList.find(p => p.id == this.form.poliklinik_id);
            return this.getPoliName(poli);
        },

        get formattedTujuanPoliDokter() {
            let parts = [];
            if (this.selectedPoliName) parts.push(this.selectedPoliName);
            if (this.selectedDoctorName) parts.push(this.selectedDoctorName);
            return parts.join(' & ') || '';
        },

        get formattedTglLahir() {
            if (!this.form.tgl_lahir) return '';
            try {
                const d = new Date(this.form.tgl_lahir + 'T00:00:00');
                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                const dayNum = String(d.getDate()).padStart(2, '0');
                const monthName = months[d.getMonth()];
                const year = d.getFullYear();
                return `${dayNum} ${monthName} ${year}`;
            } catch(e) {
                return this.form.tgl_lahir;
            }
        },

        get formattedHariTanggal() {
            if (!this.form.tanggal) return '';
            try {
                const d = new Date(this.form.tanggal + 'T00:00:00');
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                const dayName = days[d.getDay()];
                const dayNum = String(d.getDate()).padStart(2, '0');
                const monthName = months[d.getMonth()];
                const year = d.getFullYear();
                return `${dayName}, ${dayNum} ${monthName} ${year}`;
            } catch(e) {
                return this.form.tanggal;
            }
        },

        get generatedMessage() {
            let msg = `Nama pasien : ${this.form.nama || ''}\n` +
                      `Tgl lahir pasien : ${this.formattedTglLahir || this.form.tgl_lahir || ''}\n` +
                      `NIK : ${this.form.nik || ''}\n` +
                      `Alamat Lengkap: ${this.form.alamat || ''}\n` +
                      `Nama Ayah : ${this.form.nama_ayah || ''}\n` +
                      `Nama Ibu : ${this.form.nama_ibu || ''}\n` +
                      `Tujuan Poli & dokter : ${this.formattedTujuanPoliDokter || ''}\n` +
                      `Jaminan : ${this.form.jaminan || ''}\n` +
                      `Hari/Tgl berobat : ${this.formattedHariTanggal || this.form.tanggal || ''}\n` +
                      `Nomor HP aktif : ${this.form.no_hp || ''}\n` +
                      `Jam kedatangan ke RS : ${this.form.jam_kedatangan || ''}`;

            let extras = [];
            if (this.form.status_pasien === 'lama') {
                extras.push(`Status Pasien: Pasien Lama (No. RM: ${this.form.no_rm || '-'})`);
            }
            if (this.form.keluhan) {
                extras.push(`Keluhan / Alasan Berobat: ${this.form.keluhan}`);
            }
            if (extras.length > 0) {
                msg += `\n\n--- Catatan Tambahan ---\n` + extras.join('\n');
            }

            return msg;
        },

        get blankWaUrl() {
            const blankTemplate = `Nama pasien :\nTgl lahir pasien :\nNIK :\nAlamat Lengkap:\nNama Ayah :\nNama Ibu :\nTujuan Poli & dokter :\nJaminan :\nHari/Tgl berobat : \nNomor HP aktif :\nJam kedatangan ke RS : `;
            const phone = '6282280749999';
            return `https://api.whatsapp.com/send/?phone=${phone}&text=${encodeURIComponent(blankTemplate)}&type=phone_number&app_absent=0`;
        },

        submitToWhatsapp() {
            const phone = '6282280749999';
            const encodedText = encodeURIComponent(this.generatedMessage);
            const waUrl = `https://api.whatsapp.com/send/?phone=${phone}&text=${encodedText}&type=phone_number&app_absent=0`;
            window.open(waUrl, '_blank');
        },

        copyText() {
            navigator.clipboard.writeText(this.generatedMessage).then(() => {
                this.copied = true;
                setTimeout(() => { this.copied = false; }, 2000);
            }).catch(err => {
                console.error('Gagal menyalin teks: ', err);
            });
        }
    };
}
</script>

@endsection
