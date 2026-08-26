@extends('layouts.admin')

@section('title', 'Manajemen Agenda & Event RS - Admin RSU Fikri Medika')

@section('content')
<div x-data="{
    search: '',
    categoryFilter: 'all',
    modalOpen: false,
    editMode: false,
    editId: null,
    formData: {
        title_id: '',
        title_en: '',
        category: 'Seminar & Webinar',
        event_date: '',
        start_time: '08:30 WIB',
        end_time: '12:00 WIB',
        location: 'Auditorium Lt. 3 RSU Fikri Medika',
        quota: '100 Peserta',
        price_type: 'Gratis / Free',
        price: 'Gratis',
        speakers_text: '',
        benefits_text: '',
        image: '',
        short_description_id: '',
        description_id: '',
        registration_link: '',
        whatsapp_contact: '089678211575',
        status: 'upcoming',
        is_featured: false,
        is_active: true,
    },
    openAddModal() {
        this.editMode = false;
        this.editId = null;
        this.formData = {
            title_id: '',
            title_en: '',
            category: 'Seminar & Webinar',
            event_date: '{{ date('Y-m-d', strtotime('+7 days')) }}',
            start_time: '08:30 WIB',
            end_time: '12:00 WIB',
            location: 'Auditorium Lt. 3 RSU Fikri Medika',
            quota: '100 Peserta',
            price_type: 'Gratis / Free',
            price: 'Gratis',
            speakers_text: 'dr. Nama Lengkap, Sp.XX | Dokter Spesialis ...',
            benefits_text: 'Sertifikat Resmi SKP\nSnack & Lunch Box\nGoodie Bag',
            image: '',
            short_description_id: '',
            description_id: '',
            registration_link: '',
            whatsapp_contact: '089678211575',
            status: 'upcoming',
            is_featured: false,
            is_active: true,
        };
        this.modalOpen = true;
    },
    openEditModal(item) {
        this.editMode = true;
        this.editId = item.id;
        
        let speakersFormatted = '';
        if (item.speakers && Array.isArray(item.speakers)) {
            speakersFormatted = item.speakers.map(s => (s.name || '') + (s.role ? ' | ' + s.role : '')).join('\n');
        }

        let benefitsFormatted = '';
        if (item.benefits && Array.isArray(item.benefits)) {
            benefitsFormatted = item.benefits.join('\n');
        }

        this.formData = {
            title_id: item.title_id || '',
            title_en: item.title_en || '',
            category: item.category || 'Seminar & Webinar',
            event_date: item.event_date || '',
            start_time: item.start_time || '',
            end_time: item.end_time || '',
            location: item.location || '',
            quota: item.quota || '',
            price_type: item.price_type || 'Gratis / Free',
            price: item.price || '',
            speakers_text: speakersFormatted,
            benefits_text: benefitsFormatted,
            image: item.image || '',
            short_description_id: item.short_description_id || '',
            description_id: item.description_id || '',
            registration_link: item.registration_link || '',
            whatsapp_contact: item.whatsapp_contact || '089678211575',
            status: item.status || 'upcoming',
            is_featured: Boolean(item.is_featured),
            is_active: Boolean(item.is_active),
        };
        this.modalOpen = true;
    }
}" class="space-y-6">

    <!-- TOP BAR -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-xs border border-gray-100">
        <div>
            <h1 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-calendar-days text-[#0e7c47]"></i>
                <span>Manajemen Agenda & Event Rumah Sakit</span>
            </h1>
            <p class="text-xs text-gray-500 mt-1">Kelola seminar ilmiah, bakti sosial, donor darah, senam hamil, dan pelatihan medis RSU Fikri Medika.</p>
        </div>

        <button @click="openAddModal()" 
                type="button" 
                style="background-color: #0e7c47; color: #ffffff;"
                class="px-5 py-2.5 rounded-xl font-bold text-xs shadow-md hover:bg-[#096237] transition-all flex items-center justify-center gap-2 cursor-pointer shrink-0">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>Tambah Agenda Event Baru</span>
        </button>
    </div>

    <!-- FILTER & SEARCH -->
    <div class="bg-white p-4 rounded-2xl shadow-xs border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- SEARCH INPUT -->
        <div class="relative w-full md:w-80">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" 
                   x-model="search" 
                   placeholder="Cari judul event, lokasi, narasumber..." 
                   class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:ring-1 focus:ring-[#0e7c47]">
        </div>

        <!-- CATEGORY TABS -->
        <div class="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto pb-1 md:pb-0">
            <button type="button" 
                    @click="categoryFilter = 'all'" 
                    :class="categoryFilter === 'all' ? 'bg-[#0e7c47] text-white font-bold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    class="px-3.5 py-1.5 rounded-lg text-xs transition-all cursor-pointer whitespace-nowrap">
                Semua Kategori ({{ $events->count() }})
            </button>
            <button type="button" 
                    @click="categoryFilter = 'Seminar & Webinar'" 
                    :class="categoryFilter === 'Seminar & Webinar' ? 'bg-[#0e7c47] text-white font-bold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    class="px-3.5 py-1.5 rounded-lg text-xs transition-all cursor-pointer whitespace-nowrap">
                Seminar & Webinar
            </button>
            <button type="button" 
                    @click="categoryFilter = 'Bakti Sosial & Donor Darah'" 
                    :class="categoryFilter === 'Bakti Sosial & Donor Darah' ? 'bg-[#0e7c47] text-white font-bold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    class="px-3.5 py-1.5 rounded-lg text-xs transition-all cursor-pointer whitespace-nowrap">
                Bakti Sosial & Donor
            </button>
            <button type="button" 
                    @click="categoryFilter = 'Senam & Edukasi Sehat'" 
                    :class="categoryFilter === 'Senam & Edukasi Sehat' ? 'bg-[#0e7c47] text-white font-bold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    class="px-3.5 py-1.5 rounded-lg text-xs transition-all cursor-pointer whitespace-nowrap">
                Senam & Edukasi
            </button>
            <button type="button" 
                    @click="categoryFilter = 'Workshop Medis'" 
                    :class="categoryFilter === 'Workshop Medis' ? 'bg-[#0e7c47] text-white font-bold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    class="px-3.5 py-1.5 rounded-lg text-xs transition-all cursor-pointer whitespace-nowrap">
                Workshop Medis
            </button>
        </div>
    </div>

    <!-- EVENTS TABLE -->
    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50 text-gray-700 font-bold border-b border-gray-100 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4 w-20">Poster</th>
                        <th class="py-3.5 px-4">Judul & Kategori Agenda</th>
                        <th class="py-3.5 px-4">Tanggal & Jam</th>
                        <th class="py-3.5 px-4">Lokasi Pelaksanaan</th>
                        <th class="py-3.5 px-4">Status & Kuota</th>
                        <th class="py-3.5 px-4 text-center">Aktif</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($events as $index => $event)
                    @php
                        $jsonItem = [
                            'id' => $event->id,
                            'title_id' => $event->getTranslation('title', 'id') ?? '',
                            'title_en' => $event->getTranslation('title', 'en') ?? '',
                            'category' => $event->category,
                            'event_date' => $event->event_date ? $event->event_date->format('Y-m-d') : '',
                            'start_time' => $event->start_time ?? '',
                            'end_time' => $event->end_time ?? '',
                            'location' => $event->location ?? '',
                            'quota' => $event->quota ?? '',
                            'price_type' => $event->price_type ?? 'Gratis / Free',
                            'price' => $event->price ?? '',
                            'speakers' => $event->speakers ?? [],
                            'benefits' => $event->benefits ?? [],
                            'image' => $event->image ?? '',
                            'short_description_id' => $event->getTranslation('short_description', 'id') ?? '',
                            'description_id' => $event->getTranslation('description', 'id') ?? '',
                            'registration_link' => $event->registration_link ?? '',
                            'whatsapp_contact' => $event->whatsapp_contact ?? '089678211575',
                            'status' => $event->status ?? 'upcoming',
                            'is_featured' => (bool)$event->is_featured,
                            'is_active' => (bool)$event->is_active,
                        ];
                    @endphp
                    <tr x-show="(categoryFilter === 'all' || categoryFilter === '{{ addslashes($event->category) }}') && (search === '' || '{{ addslashes(strtolower($event->tr('title') . ' ' . $event->location . ' ' . $event->category)) }}'.includes(search.toLowerCase()))"
                        class="hover:bg-slate-50/80 transition-colors">
                        
                        <td class="py-3.5 px-4 text-center font-bold text-gray-400">{{ $index + 1 }}</td>
                        
                        <!-- POSTER -->
                        <td class="py-3.5 px-4">
                            <img src="{{ $event->image_url }}" alt="{{ $event->tr('title') }}" class="w-14 h-14 object-cover rounded-xl border border-gray-200 shadow-2xs">
                        </td>

                        <!-- TITLE & CATEGORY -->
                        <td class="py-3.5 px-4">
                            <div class="space-y-1">
                                <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-[#0e7c47] font-bold text-[10px] uppercase">
                                    {{ $event->category }}
                                </span>
                                @if($event->is_featured)
                                <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 font-bold text-[10px] uppercase">
                                    ⭐ Featured
                                </span>
                                @endif
                                <div class="font-bold text-gray-900 line-clamp-2">{{ $event->tr('title') }}</div>
                                @if(!empty($event->speakers))
                                <div class="text-[11px] text-gray-500 flex items-center gap-1">
                                    <i class="fa-solid fa-user-doctor text-gray-400"></i>
                                    <span>{{ $event->speakers[0]['name'] ?? '' }}</span>
                                </div>
                                @endif
                            </div>
                        </td>

                        <!-- DATE & TIME -->
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-gray-800 flex items-center gap-1.5">
                                <i class="fa-regular fa-calendar-check text-[#0e7c47]"></i>
                                <span>{{ $event->event_date_formatted }}</span>
                            </div>
                            <div class="text-[11px] text-gray-500 mt-0.5 flex items-center gap-1">
                                <i class="fa-regular fa-clock text-gray-400"></i>
                                <span>{{ $event->start_time ?: '08:30 WIB' }} - {{ $event->end_time ?: 'Selesai' }}</span>
                            </div>
                        </td>

                        <!-- LOCATION -->
                        <td class="py-3.5 px-4">
                            <div class="font-semibold text-gray-800 line-clamp-2 flex items-start gap-1">
                                <i class="fa-solid fa-location-dot text-red-500 text-xs mt-0.5 shrink-0"></i>
                                <span>{{ $event->location }}</span>
                            </div>
                        </td>

                        <!-- STATUS & QUOTA -->
                        <td class="py-3.5 px-4">
                            <div class="space-y-1">
                                @if($event->status === 'ongoing')
                                <span class="px-2 py-0.5 rounded-full bg-red-100 text-red-700 font-bold text-[10px] uppercase">
                                    🔴 Berlangsung
                                </span>
                                @elseif($event->status === 'completed')
                                <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 font-bold text-[10px] uppercase">
                                    ⚪ Selesai
                                </span>
                                @else
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px] uppercase">
                                    🟢 Akan Datang
                                </span>
                                @endif

                                <div class="text-[11px] text-gray-500 font-medium">
                                    Kuota: <strong>{{ $event->quota ?: 'Terbuka' }}</strong>
                                </div>
                            </div>
                        </td>

                        <!-- TOGGLE ACTIVE -->
                        <td class="py-3.5 px-4 text-center">
                            <button type="button" 
                                    @click="
                                        fetch('{{ route('admin.events.toggleActive', $event->id) }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            }
                                        }).then(r => r.json()).then(data => {
                                            if(data.success) { location.reload(); }
                                        })
                                    "
                                    class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $event->is_active ? 'bg-[#0e7c47]' : 'bg-gray-200' }}">
                                <span class="sr-only">Toggle</span>
                                <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out {{ $event->is_active ? 'translate-x-4' : 'translate-x-0' }}"></span>
                            </button>
                        </td>

                        <!-- ACTIONS -->
                        <td class="py-3.5 px-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <button type="button" 
                                        @click='openEditModal({!! json_encode($jsonItem, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!})' 
                                        class="w-7 h-7 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition-colors cursor-pointer" 
                                        title="Edit Event">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </button>

                                <form action="{{ route('admin.events.destroy', $event->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda event ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition-colors cursor-pointer" title="Hapus Event">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-10 text-center text-gray-400">
                            <i class="fa-solid fa-calendar-xmark text-3xl mb-2"></i>
                            <p>Belum ada agenda event yang ditambahkan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL FORM TAMBAH / EDIT EVENT -->
    <div x-show="modalOpen" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs" 
         style="display: none;">
        
        <div @click.away="modalOpen = false" 
             class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden relative flex flex-col max-h-[90vh]">
            
            <!-- HEADER -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-slate-50/80">
                <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-calendar-plus text-[#0e7c47]"></i>
                    <span x-text="editMode ? 'Edit Agenda Event' : 'Tambah Agenda Event Baru'"></span>
                </h3>
                <button type="button" @click="modalOpen = false" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <!-- FORM BODY -->
            <form :action="editMode ? '{{ url('admin/events') }}/' + editId : '{{ route('admin.events.store') }}'" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="overflow-y-auto flex-1 p-6 space-y-4 text-xs">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <!-- JUDUL -->
                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Judul Agenda Event (Bahasa Indonesia) <span class="text-red-500">*</span></label>
                    <input type="text" name="title_id" x-model="formData.title_id" required placeholder="Contoh: Seminar Medis Deteksi Dini Penyakit Jantung Koroner" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                </div>

                <!-- KATEGORI & STATUS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Kategori Event <span class="text-red-500">*</span></label>
                        <select name="category" x-model="formData.category" required class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] bg-white">
                            <option value="Seminar & Webinar">Seminar & Webinar</option>
                            <option value="Bakti Sosial & Donor Darah">Bakti Sosial & Donor Darah</option>
                            <option value="Senam & Edukasi Sehat">Senam & Edukasi Sehat</option>
                            <option value="Workshop Medis">Workshop Medis</option>
                            <option value="Peringatan Hari Kesehatan">Peringatan Hari Kesehatan</option>
                            <option value="Umum">Umum / Komunitas</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Status Agenda <span class="text-red-500">*</span></label>
                        <select name="status" x-model="formData.status" required class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] bg-white">
                            <option value="upcoming">🟢 Akan Datang (Upcoming)</option>
                            <option value="ongoing">🔴 Sedang Berlangsung (Ongoing / Live)</option>
                            <option value="completed">⚪ Telah Selesai (Completed)</option>
                        </select>
                    </div>
                </div>

                <!-- TANGGAL & JAM -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Tanggal Pelaksanaan <span class="text-red-500">*</span></label>
                        <input type="date" name="event_date" x-model="formData.event_date" required class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Jam Mulai</label>
                        <input type="text" name="start_time" x-model="formData.start_time" placeholder="08:30 WIB" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Jam Selesai</label>
                        <input type="text" name="end_time" x-model="formData.end_time" placeholder="12:00 WIB / Selesai" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                </div>

                <!-- LOKASI & KUOTA -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Lokasi / Tempat Pelaksanaan <span class="text-red-500">*</span></label>
                        <input type="text" name="location" x-model="formData.location" required placeholder="Contoh: Auditorium Lt. 3 RSU Fikri Medika" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Kuota Peserta</label>
                        <input type="text" name="quota" x-model="formData.quota" placeholder="Contoh: 50 Peserta / Terbuka untuk Umum" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                </div>

                <!-- BIAYA / TIPE HARGA -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Tipe Biaya</label>
                        <input type="text" name="price_type" x-model="formData.price_type" placeholder="Gratis / Free" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Nomor WhatsApp Pendaftaran</label>
                        <input type="text" name="whatsapp_contact" x-model="formData.whatsapp_contact" placeholder="089678211575" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                </div>

                <!-- DOKTER / NARASUMBER PEMBICARA -->
                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Narasumber / Dokter Pembicara (1 per baris: Nama | Spesialisasi)</label>
                    <textarea name="speakers_text" x-model="formData.speakers_text" rows="2" placeholder="dr. Rihi Nofiandi, Sp.OG, FICS | Dokter Spesialis Kebidanan & Kandungan&#10;Bdn. Siti Rahmawati, S.Tr.Keb | Instruktur Senam Hamil" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]"></textarea>
                </div>

                <!-- FASILITAS / BENEFIT PESERTA -->
                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Fasilitas / Benefit Peserta (1 baris 1 poin)</label>
                    <textarea name="benefits_text" x-model="formData.benefits_text" rows="3" placeholder="Sertifikat Resmi SKP&#10;Free Screening USG&#10;Snack Box & Goodie Bag" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]"></textarea>
                </div>

                <!-- DESKRIPSI SINGKAT & LENGKAP -->
                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Ringkasan Singkat Event</label>
                    <textarea name="short_description_id" x-model="formData.short_description_id" rows="2" placeholder="Ringkasan penjelasan event yang memikat peserta..." class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]"></textarea>
                </div>

                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Rundown & Deskripsi Lengkap Agenda</label>
                    <textarea name="description_id" x-model="formData.description_id" rows="4" placeholder="Tuliskan susunan acara, tata cara pendaftaran, dan informasi penting lainnya..." class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]"></textarea>
                </div>

                <!-- POSTER / FLYER UPLOAD -->
                <div class="space-y-2 p-3.5 bg-slate-50 rounded-xl border border-gray-200">
                    <label class="font-bold text-gray-800 flex items-center gap-1.5">
                        <i class="fa-solid fa-image text-[#0e7c47]"></i>
                        <span>Upload Poster / Flyer Event (Maks. 30MB)</span>
                    </label>
                    <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-1.5 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0e7c47] hover:file:bg-emerald-100">
                    <input type="text" name="image" x-model="formData.image" placeholder="Atau masukkan path gambar (opsional)" class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-200 focus:outline-none">
                </div>

                <!-- CHECKBOXES -->
                <div class="flex items-center gap-6 pt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" x-model="formData.is_featured" class="rounded text-[#0e7c47] focus:ring-[#0e7c47]">
                        <span class="font-bold text-gray-700">Jadikan Spotlight / Featured Event</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" x-model="formData.is_active" class="rounded text-[#0e7c47] focus:ring-[#0e7c47]">
                        <span class="font-bold text-gray-700">Status Aktif & Tampil di Website</span>
                    </label>
                </div>

                <!-- MODAL FOOTER BUTTONS -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-2.5">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" 
                            style="background-color: #0e7c47; color: #ffffff;"
                            class="px-5 py-2 rounded-xl font-bold shadow-md hover:bg-[#096237] transition-all cursor-pointer">
                        <span x-text="editMode ? 'Simpan Perubahan' : 'Terbitkan Agenda Event'"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
