@extends('layouts.admin')

@section('title', 'Manajemen Dokumentasi & Galeri Kegiatan - Admin RSU Fikri Medika')

@section('content')
<div x-data="{
    search: '',
    categoryFilter: 'all',
    modalOpen: false,
    galleryModalOpen: false,
    editMode: false,
    editId: null,
    selectedEvent: { id: null, title: '', gallery: [] },
    formData: {
        title_id: '',
        title_en: '',
        category: 'Seminar & Webinar',
        event_date: '',
        start_time: '',
        end_time: '',
        location: 'RSU Fikri Medika, Karawang',
        quota: '',
        price_type: 'Gratis / Free',
        price: '',
        speakers_text: '',
        benefits_text: '',
        image: '',
        short_description_id: '',
        description_id: '',
        registration_link: '',
        whatsapp_contact: '089678211575',
        status: 'completed',
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
            event_date: '{{ date('Y-m-d') }}',
            start_time: '08:30 WIB',
            end_time: '12:00 WIB',
            location: 'Auditorium Lt. 3 RSU Fikri Medika',
            quota: '50 Peserta',
            price_type: 'Gratis / Free',
            price: '',
            speakers_text: '',
            benefits_text: '',
            image: '',
            short_description_id: '',
            description_id: '',
            registration_link: '',
            whatsapp_contact: '089678211575',
            status: 'completed',
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
            status: item.status || 'completed',
            is_featured: Boolean(item.is_featured),
            is_active: Boolean(item.is_active),
        };
        this.modalOpen = true;
    },
    openGalleryModal(item) {
        this.selectedEvent = {
            id: item.id,
            title: item.title_id || 'Dokumentasi Kegiatan',
            gallery: item.gallery || []
        };
        this.galleryModalOpen = true;
    }
}" class="space-y-6">

    <!-- TOP BAR -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-xs border border-gray-100">
        <div>
            <h1 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-photo-film text-[#0e7c47]"></i>
                <span>Manajemen Dokumentasi & Galeri Kegiatan RS</span>
            </h1>
            <p class="text-xs text-gray-500 mt-1">Kelola rilis berita pasca kegiatan, galeri foto dokumentasi seminar ilmiah, bakti sosial, donor darah, dan penyuluhan kesehatan.</p>
        </div>

        <button @click="openAddModal()" 
                type="button" 
                style="background-color: #0e7c47; color: #ffffff;"
                class="px-5 py-2.5 rounded-xl font-bold text-xs shadow-md hover:bg-[#096237] transition-all flex items-center justify-center gap-2 cursor-pointer shrink-0">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>Tambah Dokumentasi Kegiatan</span>
        </button>
    </div>

    <!-- FILTER & SEARCH -->
    <div class="bg-white p-4 rounded-2xl shadow-xs border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- SEARCH INPUT -->
        <div class="relative w-full md:w-80">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" 
                   x-model="search" 
                   placeholder="Cari judul kegiatan, lokasi, narasumber..." 
                   class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:ring-1 focus:ring-[#0e7c47]">
        </div>

        <!-- CATEGORY TABS -->
        <div class="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto pb-1 md:pb-0">
            <button type="button" 
                    @click="categoryFilter = 'all'" 
                    :class="categoryFilter === 'all' ? 'bg-[#0e7c47] text-white font-bold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    class="px-3.5 py-1.5 rounded-lg text-xs transition-all cursor-pointer whitespace-nowrap">
                Semua Kegiatan ({{ $events->count() }})
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
                        <th class="py-3.5 px-4 w-20">Foto Utama</th>
                        <th class="py-3.5 px-4">Judul & Kategori Kegiatan</th>
                        <th class="py-3.5 px-4">Tanggal Pelaksanaan</th>
                        <th class="py-3.5 px-4">Lokasi Kegiatan</th>
                        <th class="py-3.5 px-4">Status & Peserta</th>
                        <th class="py-3.5 px-4 text-center">Tampil di Web</th>
                        <th class="py-3.5 px-4 text-center w-32">Aksi & Galeri</th>
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
                            'gallery' => array_map(fn($p) => str_starts_with($p, 'http') ? $p : asset('storage/' . ltrim(str_replace('storage/', '', $p), '/')), (array)($event->gallery_photos ?? [])),
                            'raw_gallery' => (array)($event->gallery_photos ?? []),
                            'short_description_id' => $event->getTranslation('short_description', 'id') ?? '',
                            'description_id' => $event->getTranslation('description', 'id') ?? '',
                            'registration_link' => $event->registration_link ?? '',
                            'whatsapp_contact' => $event->whatsapp_contact ?? '089678211575',
                            'status' => $event->status ?? 'completed',
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
                                    ⭐ Headline
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
                            @if($event->start_time)
                            <div class="text-[11px] text-gray-500 mt-0.5 flex items-center gap-1">
                                <i class="fa-regular fa-clock text-gray-400"></i>
                                <span>{{ $event->start_time }} {{ $event->end_time ? ' - ' . $event->end_time : '' }}</span>
                            </div>
                            @endif
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
                                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold text-[10px] uppercase">
                                    ⏳ Sedang Berlangsung
                                </span>
                                @elseif($event->status === 'completed')
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 font-bold text-[10px] uppercase">
                                    ✅ Telah Dilaksanakan
                                </span>
                                @else
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px] uppercase">
                                    📅 Akan Datang
                                </span>
                                @endif

                                @if($event->quota)
                                <div class="text-[11px] text-gray-500 font-medium">
                                    Peserta: <strong>{{ $event->quota }}</strong>
                                </div>
                                @endif
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
                                        @click='openGalleryModal({!! json_encode($jsonItem, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!})' 
                                        class="relative p-1.5 px-2 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-[#0e7c47] flex items-center gap-1 transition-colors cursor-pointer text-xs font-bold" 
                                        title="Kelola Galeri Foto Dokumentasi">
                                    <i class="fa-solid fa-camera text-xs"></i>
                                    <span>{{ count((array)($event->gallery_photos ?? [])) }}</span>
                                </button>

                                <a href="{{ route('event.show', $event->slug) }}" 
                                   target="_blank"
                                   class="w-7 h-7 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-600 flex items-center justify-center transition-colors" 
                                   title="Lihat Halaman Publik">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                </a>

                                <button type="button" 
                                        @click='openEditModal({!! json_encode($jsonItem, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!})' 
                                        class="w-7 h-7 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition-colors cursor-pointer" 
                                        title="Edit Dokumentasi">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </button>

                                <form action="{{ route('admin.events.destroy', $event->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data dokumentasi kegiatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition-colors cursor-pointer" title="Hapus Dokumentasi">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-10 text-center text-gray-400">
                            <i class="fa-solid fa-photo-film text-3xl mb-2 text-gray-300"></i>
                            <p>Belum ada dokumentasi kegiatan yang ditambahkan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL FORM TAMBAH / EDIT DOKUMENTASI EVENT -->
    <div x-show="modalOpen" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs" 
         style="display: none;">
        
        <div @click.away="modalOpen = false" 
             class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden relative flex flex-col max-h-[90vh]">
            
            <!-- HEADER -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-slate-50/80">
                <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-photo-film text-[#0e7c47]"></i>
                    <span x-text="editMode ? 'Edit Dokumentasi Kegiatan' : 'Tambah Dokumentasi Kegiatan Baru'"></span>
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
                    <label class="font-bold text-gray-700">Judul Kegiatan / Berita Rilis <span class="text-red-500">*</span></label>
                    <input type="text" name="title_id" x-model="formData.title_id" required placeholder="Contoh: Senam Hamil & Screening USG Gratis: Langkah Sehat Ibu Hebat" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                </div>

                <!-- KATEGORI & STATUS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Kategori Kegiatan <span class="text-red-500">*</span></label>
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
                        <label class="font-bold text-gray-700">Status Pelaksanaan <span class="text-red-500">*</span></label>
                        <select name="status" x-model="formData.status" required class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47] bg-white">
                            <option value="completed">✅ Telah Dilaksanakan (Completed)</option>
                            <option value="ongoing">⏳ Sedang Berlangsung (Ongoing / Live)</option>
                            <option value="upcoming">📅 Akan Datang (Upcoming)</option>
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
                        <label class="font-bold text-gray-700">Waktu Mulai</label>
                        <input type="text" name="start_time" x-model="formData.start_time" placeholder="08:30 WIB" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Waktu Selesai</label>
                        <input type="text" name="end_time" x-model="formData.end_time" placeholder="12:00 WIB / Selesai" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                </div>

                <!-- LOKASI & PESERTA -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Lokasi / Tempat Penyelenggaraan <span class="text-red-500">*</span></label>
                        <input type="text" name="location" x-model="formData.location" required placeholder="Contoh: Auditorium Lt. 3 RSU Fikri Medika" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Jumlah Peserta Hadir</label>
                        <input type="text" name="quota" x-model="formData.quota" placeholder="Contoh: 50 Peserta / 85 Ibu Hamil" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                </div>

                <!-- DOKTER / NARASUMBER PEMBICARA -->
                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Narasumber / Dokter Pembicara (1 per baris: Nama | Spesialisasi)</label>
                    <textarea name="speakers_text" x-model="formData.speakers_text" rows="2" placeholder="dr. Rihi Nofiandi, Sp.OG, FICS | Dokter Spesialis Kebidanan & Kandungan&#10;Bdn. Siti Rahmawati, S.Tr.Keb | Instruktur Senam Hamil" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]"></textarea>
                </div>

                <!-- HIGHLIGHT / POIN KEGIATAN -->
                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Poin-Poin / Highlight Kegiatan (1 baris 1 poin)</label>
                    <textarea name="benefits_text" x-model="formData.benefits_text" rows="3" placeholder="Pemeriksaan USG Kehamilan Gratis&#10;Pembagian Buku Panduan Nutrisi Ibu Hamil&#10;Healthy Snack & Konsultasi Laktasi" class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]"></textarea>
                </div>

                <!-- RINGKASAN & NARASI LENGKAP -->
                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Ringkasan Singkat (Lead Berita)</label>
                    <textarea name="short_description_id" x-model="formData.short_description_id" rows="2" placeholder="Ringkasan 1-2 kalimat mengenai suksesnya pelaksanaan kegiatan..." class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]"></textarea>
                </div>

                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Ulasan & Narasi Lengkap Kegiatan (Press Release)</label>
                    <textarea name="description_id" x-model="formData.description_id" rows="5" placeholder="Tuliskan ulasan jalannya acara, kutipan narasumber/direktur, antusiasme peserta, dan hasil dari kegiatan..." class="w-full px-3.5 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0e7c47]"></textarea>
                </div>

                <!-- FOTO UTAMA / POSTER -->
                <div class="space-y-2 p-3.5 bg-slate-50 rounded-xl border border-gray-200">
                    <label class="font-bold text-gray-800 flex items-center gap-1.5">
                        <i class="fa-solid fa-image text-[#0e7c47]"></i>
                        <span>Foto Utama / Cover Headline Kegiatan (Maks. 30MB)</span>
                    </label>
                    <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-1.5 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0e7c47] hover:file:bg-emerald-100">
                    <input type="text" name="image" x-model="formData.image" placeholder="Atau masukkan path gambar (opsional)" class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-200 focus:outline-none">
                </div>

                <!-- DOKUMENTASI FOTO-FOTO EVENT -->
                <div class="space-y-2 p-3.5 bg-emerald-50/50 rounded-xl border border-emerald-200/70">
                    <label class="font-bold text-emerald-900 flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-images text-[#0e7c47]"></i>
                            <span>Upload Foto-foto Galeri Dokumentasi (Bisa Pilih Banyak Sekaligus)</span>
                        </span>
                        <span class="text-[10px] text-emerald-700 font-normal">Maks. 30MB/foto</span>
                    </label>
                    <input type="file" name="gallery_files[]" multiple accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-1.5 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-[#096237]">
                    <p class="text-[11px] text-gray-500">Pilih beberapa foto dokumentasi sekaligus dari komputer Anda untuk ditampilkan pada galeri interaktif.</p>
                </div>

                <!-- CHECKBOXES -->
                <div class="flex items-center gap-6 pt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" x-model="formData.is_featured" class="rounded text-[#0e7c47] focus:ring-[#0e7c47]">
                        <span class="font-bold text-gray-700">Jadikan Headline / Kegiatan Unggulan</span>
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
                        <span x-text="editMode ? 'Simpan Perubahan' : 'Terbitkan Dokumentasi Kegiatan'"></span>
                    </button>
                </div>
            </form>

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
                        <span>Galeri Foto Dokumentasi Kegiatan</span>
                    </span>
                    <h3 class="font-black text-slate-900 text-lg sm:text-xl" x-text="selectedEvent.title"></h3>
                    <p class="text-xs text-slate-500 font-medium">Foto ini akan langsung tampil di halaman detail press release event (<span class="font-mono text-slate-700">/informasi/event/...</span>).</p>
                </div>
                <button @click="galleryModalOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl bg-slate-50 hover:bg-slate-100 cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- UPLOAD NEW PHOTOS FORM -->
            <form :action="'{{ url('admin/events') }}/' + selectedEvent.id + '/gallery'" method="POST" enctype="multipart/form-data" class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                @csrf
                <div class="flex items-center justify-between">
                    <h4 class="font-extrabold text-slate-900 text-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-cloud-arrow-up text-[#0e7c47]"></i>
                        <span>Unggah Foto-foto Dokumentasi Tambahan</span>
                    </h4>
                    <span class="text-[11px] text-slate-500 font-medium">Maks. 30MB per foto</span>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Pilih File Foto (Bisa Pilih Banyak Sekaligus)</label>
                    <input type="file" name="gallery_files[]" multiple accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0e7c47] file:text-white hover:file:bg-[#096237] cursor-pointer bg-white border border-slate-200 rounded-xl p-1">
                </div>

                <div class="flex justify-end pt-1">
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2 rounded-xl text-xs font-extrabold shadow-sm hover:bg-[#096237] transition-all flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-upload text-xs"></i>
                        <span>Upload ke Galeri Foto</span>
                    </button>
                </div>
            </form>

            <!-- CURRENT GALLERY PHOTOS LIST -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h4 class="font-extrabold text-slate-900 text-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-images text-[#0e7c47]"></i>
                        <span>Daftar Foto Dokumentasi Saat Ini (<span x-text="selectedEvent.gallery ? selectedEvent.gallery.length : 0"></span> Foto)</span>
                    </h4>
                </div>

                <!-- PHOTO GRID -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <template x-for="(imgUrl, index) in selectedEvent.gallery" :key="index">
                        <div class="relative group rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 aspect-4/3 shadow-xs">
                            <img :src="imgUrl" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            <div class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-slate-900/70 text-white font-mono text-[10px] font-bold">
                                #<span x-text="index + 1"></span>
                            </div>

                            <!-- DELETE OVERLAY -->
                            <form :action="'{{ url('admin/events') }}/' + selectedEvent.id + '/gallery/delete'" method="POST" class="absolute inset-0 bg-slate-950/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                @csrf
                                <input type="hidden" name="photo_index" :value="index">
                                <input type="hidden" name="photo_url" :value="imgUrl">
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus foto dokumentasi ini?')" class="p-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold flex items-center gap-1.5 shadow-md active:scale-95 cursor-pointer">
                                    <i class="fa-regular fa-trash-can"></i>
                                    <span>Hapus Foto</span>
                                </button>
                            </form>
                        </div>
                    </template>

                    <template x-if="!selectedEvent.gallery || selectedEvent.gallery.length === 0">
                        <div class="col-span-full py-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200 text-slate-400 text-xs">
                            <i class="fa-solid fa-images text-2xl mb-1 text-slate-300"></i>
                            <p>Belum ada foto dokumentasi di event ini. Unggah foto pertama di atas.</p>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
