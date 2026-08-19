@extends('layouts.admin')

@section('title', 'Knowledge Base & AI Chatbot Tanya Fikri')

@section('content')
<div x-data="{ 
    activeTab: 'kb', 
    addModalOpen: false, 
    editModalOpen: false, 
    editKb: {},
    newKb: { category: 'Umum', intent: '', question: '', keywords: '', synonyms: '', answer: '', priority: 10, is_active: 1, unrec_id: null },
    search: '{{ $search ?? '' }}',
    filterCat: '{{ $category ?? '' }}',
    openAddFromUnrec(query, id) {
        this.newKb.question = query;
        this.newKb.keywords = query.toLowerCase();
        this.newKb.intent = query.toLowerCase().replace(/[^a-z0-9]/g, '_').substring(0, 30);
        this.newKb.unrec_id = id;
        this.addModalOpen = true;
    }
}" class="space-y-6">
    
    @if(session('success'))
    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #0e7c47;" class="p-4 rounded-2xl font-bold text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- PAGE HEADER -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="p-6 rounded-3xl shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-900 flex items-center gap-2">
                <span>Knowledge Base "Tanya Kakak Fikri"</span>
                <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 text-[#0e7c47]">Rule-Based NLP</span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola data pengetahuan & pelajari pertanyaan pengunjung yang belum terjawab.</p>
        </div>

        <div class="flex items-center gap-2">
            <button @click="addModalOpen = true" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2.5 rounded-xl font-extrabold text-xs shadow-md hover:bg-[#096237] transition-all flex items-center justify-center gap-2 shrink-0 cursor-pointer">
                <i class="fa-solid fa-plus text-sm"></i>
                <span>+ Tambah Pengetahuan Baru</span>
            </button>
        </div>
    </div>

    <!-- TABS: KNOWLEDGE BASE VS UNRECOGNIZED QUESTIONS (LEARNING QUEUE) -->
    <div class="flex items-center gap-3 border-b border-slate-200">
        <button @click="activeTab = 'kb'" 
                :class="activeTab === 'kb' ? 'border-[#0e7c47] text-[#0e7c47] font-black' : 'border-transparent text-slate-500 hover:text-slate-700 font-bold'"
                class="py-3 px-4 text-sm border-b-2 transition-colors flex items-center gap-2 cursor-pointer">
            <i class="fa-solid fa-book-medical"></i>
            <span>Daftar Knowledge Base ({{ $knowledgeBases->total() }})</span>
        </button>

        <button @click="activeTab = 'unrec'" 
                :class="activeTab === 'unrec' ? 'border-[#0e7c47] text-[#0e7c47] font-black' : 'border-transparent text-slate-500 hover:text-slate-700 font-bold'"
                class="py-3 px-4 text-sm border-b-2 transition-colors flex items-center gap-2 cursor-pointer">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Pertanyaan Pengunjung Belum Terjawab</span>
            @if($unresolvedCount > 0)
            <span class="px-2 py-0.5 rounded-full bg-amber-500 text-white font-extrabold text-[10px]">{{ $unresolvedCount }} Baru</span>
            @endif
        </button>
    </div>

    <!-- TAB 1: KNOWLEDGE BASE LIST -->
    <div x-show="activeTab === 'kb'" class="space-y-4">
        
        <!-- TABLE & SEARCH FILTER CONTAINER -->
        <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl shadow-xs overflow-hidden">
            
            <!-- SEARCH & FILTER TOOLBAR -->
            <form method="GET" action="{{ route('admin.knowledge.index') }}" style="border-bottom: 1px solid #f1f5f9; background-color: #f8fafc;" class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-filter text-emerald-600 text-sm"></i>
                    <h3 class="font-black text-slate-900 text-sm">Filter Knowledge Base</h3>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div style="position: relative; width: 100%; max-width: 240px;">
                        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px; pointer-events: none; z-index: 10;"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari pertanyaan / kata kunci..." style="padding-left: 38px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; border-radius: 12px; border: 1px solid #cbd5e1; font-size: 12px; width: 100%; background-color: #ffffff; outline: none;" class="focus:ring-2 focus:ring-[#0e7c47]">
                    </div>

                    <select name="category" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl border border-slate-300 bg-white text-xs font-semibold focus:ring-2 focus:ring-[#0e7c47] outline-none">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-3.5 py-2 rounded-xl bg-slate-800 text-white text-xs font-bold hover:bg-slate-900 transition-colors">
                        Cari
                    </button>
                    @if($search || $category)
                    <a href="{{ route('admin.knowledge.index') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold hover:bg-slate-200 transition-colors">
                        Reset
                    </a>
                    @endif
                </div>
            </form>

            <!-- KNOWLEDGE BASE TABLE -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;" class="text-slate-500 font-extrabold uppercase tracking-wider text-[11px]">
                            <th class="p-4 w-12 text-center">No</th>
                            <th class="p-4">Pertanyaan & Intent</th>
                            <th class="p-4">Kategori</th>
                            <th class="p-4">Kata Kunci (Keywords)</th>
                            <th class="p-4">Status & Prioritas</th>
                            <th class="p-4 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($knowledgeBases as $index => $kb)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-4 text-center font-bold text-slate-400">
                                {{ $knowledgeBases->firstItem() + $index }}
                            </td>
                            <td class="p-4 space-y-1 max-w-xs">
                                <div class="font-extrabold text-slate-900 text-sm">{{ $kb->question }}</div>
                                <div class="text-[11px] font-mono text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-md inline-block border border-emerald-200">
                                    intent: {{ $kb->intent }}
                                </div>
                                <div class="text-[11px] text-slate-500 line-clamp-2 mt-1">
                                    {!! strip_tags($kb->answer) !!}
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-bold text-[11px]">
                                    {{ $kb->category }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-600 font-medium max-w-xs">
                                <div class="line-clamp-2">
                                    {{ $kb->keywords ?: '-' }}
                                </div>
                                @if(!empty($kb->synonyms))
                                <div class="text-[10px] text-slate-400 mt-0.5 line-clamp-1 italic">
                                    Synonyms: {{ $kb->synonyms }}
                                </div>
                                @endif
                            </td>
                            <td class="p-4 space-y-1">
                                <div>
                                    @if($kb->is_active)
                                    <span class="inline-flex items-center gap-1 text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full text-[11px] font-extrabold border border-emerald-200">
                                        <i class="fa-solid fa-circle text-[6px]"></i> Aktif
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full text-[11px] font-bold">
                                        Nonaktif
                                    </span>
                                    @endif
                                </div>
                                <div class="text-[11px] text-slate-400 font-semibold">
                                    Bobot: <strong class="text-slate-700">{{ $kb->priority }}</strong>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button @click="editKb = { 
                                        id: {{ $kb->id }}, 
                                        category: '{{ addslashes($kb->category) }}', 
                                        intent: '{{ addslashes($kb->intent) }}', 
                                        question: '{{ addslashes($kb->question) }}', 
                                        keywords: '{{ addslashes($kb->keywords ?? '') }}', 
                                        synonyms: '{{ addslashes($kb->synonyms ?? '') }}', 
                                        answer: `{{ addslashes($kb->answer) }}`, 
                                        priority: {{ $kb->priority }}, 
                                        is_active: {{ $kb->is_active ? 1 : 0 }} 
                                    }; editModalOpen = true" 
                                    style="background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a;" 
                                    class="p-2 rounded-xl hover:bg-amber-100 transition-colors cursor-pointer" 
                                    title="Edit Pengetahuan">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </button>

                                    <form action="{{ route('admin.knowledge.destroy', $kb->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus entri ini?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca;" class="p-2 rounded-xl hover:bg-red-100 transition-colors cursor-pointer" title="Hapus">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 font-medium">
                                <i class="fa-solid fa-inbox text-3xl mb-2 block text-slate-300"></i>
                                Belum ada data Knowledge Base yang cocok.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="p-4 border-t border-slate-100">
                {{ $knowledgeBases->appends(['search' => $search, 'category' => $category])->links() }}
            </div>
        </div>
    </div>

    <!-- TAB 2: UNRECOGNIZED QUESTIONS (LEARNING QUEUE) -->
    <div x-show="activeTab === 'unrec'" class="space-y-4" style="display: none;">
        <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="p-6 rounded-3xl shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base flex items-center gap-2">
                        <i class="fa-solid fa-brain text-emerald-600"></i>
                        <span>Pertanyaan Pengunjung yang Belum Dikenali (Learning Queue)</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Sistem dapat secara otomatis membersihkan teks acak (spam) dan memetakan kalimat baru ke Knowledge Base.</p>
                </div>

                <div>
                    <form action="{{ route('admin.knowledge.auto_process') }}" method="POST" onsubmit="return confirm('Jalankan proses otomatisasi sistem sekarang? (Sistem akan membersihkan spam dan mengasosiasikan sinonim secara otomatis)');">
                        @csrf
                        <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-4 py-2.5 rounded-xl font-extrabold text-xs shadow-md hover:bg-[#096237] transition-all flex items-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-bolt-lightning text-yellow-300"></i>
                            <span>⚡ Proses Otomatis Antrean (Auto-Learn)</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;" class="text-slate-500 font-extrabold uppercase tracking-wider text-[11px]">
                            <th class="p-4 w-12 text-center">No</th>
                            <th class="p-4">Pertanyaan Pengguna</th>
                            <th class="p-4">Confidence Score</th>
                            <th class="p-4">Waktu Bertanya</th>
                            <th class="p-4">Status & Catatan Sistem</th>
                            <th class="p-4 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($unrecognizedQueries as $uIndex => $unrec)
                        <tr class="hover:bg-slate-50/80 transition-colors {{ $unrec->is_resolved ? 'opacity-60' : '' }}">
                            <td class="p-4 text-center font-bold text-slate-400">
                                {{ $uIndex + 1 }}
                            </td>
                            <td class="p-4 space-y-1 max-w-sm">
                                <div class="font-bold text-slate-900 text-sm">"{{ $unrec->raw_query }}"</div>
                                @if(!empty($unrec->admin_notes))
                                <div class="text-[11px] text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-md inline-block border border-emerald-200">
                                    {{ $unrec->admin_notes }}
                                </div>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full font-mono text-[11px] font-extrabold {{ $unrec->confidence_score >= 40 ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-700' }}">
                                    {{ $unrec->confidence_score }}%
                                </span>
                            </td>
                            <td class="p-4 text-slate-500 font-medium">
                                {{ $unrec->created_at->format('d M Y, H:i') }} WIB
                            </td>
                            <td class="p-4">
                                @if($unrec->is_resolved)
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px] inline-flex items-center gap-1">
                                    <i class="fa-solid fa-check"></i> Selesai Diproses
                                </span>
                                @else
                                <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold text-[10px] inline-flex items-center gap-1">
                                    <i class="fa-solid fa-clock"></i> Belum Dikelola
                                </span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button @click="openAddFromUnrec('{{ addslashes($unrec->raw_query) }}', {{ $unrec->id }})" 
                                            class="px-3 py-1.5 rounded-xl bg-emerald-50 text-[#0e7c47] hover:bg-emerald-100 border border-emerald-200 font-bold text-xs flex items-center gap-1 shadow-2xs cursor-pointer">
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                        <span>Jadikan KB</span>
                                    </button>

                                    @if(!$unrec->is_resolved)
                                    <form action="{{ route('admin.knowledge.unrecognized.resolve', $unrec->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="p-1.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition-colors cursor-pointer" title="Tandai Selesai">
                                            <i class="fa-solid fa-check text-xs"></i>
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('admin.knowledge.unrecognized.destroy', $unrec->id) }}" method="POST" onsubmit="return confirm('Hapus log pertanyaan ini?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition-colors cursor-pointer" title="Hapus Log">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 font-medium">
                                <i class="fa-solid fa-check-circle text-3xl mb-2 block text-emerald-400"></i>
                                Hebat! Seluruh pertanyaan pengunjung sudah dikenali dengan baik.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="p-4 border-t border-slate-100">
                {{ $unrecognizedQueries->links() }}
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH KNOWLEDGE BASE -->
    <div x-show="addModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
        <div @click.away="addModalOpen = false" class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl p-6 sm:p-8 space-y-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-lg font-black text-slate-900">Tambah Pengetahuan Baru (Tanya Fikri)</h3>
                <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form action="{{ route('admin.knowledge.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="unrec_id" x-model="newKb.unrec_id">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kategori</label>
                        <select name="category" x-model="newKb.category" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none focus:ring-2 focus:ring-[#0e7c47]">
                            <option value="Umum">Umum</option>
                            <option value="Profil RS">Profil RS</option>
                            <option value="Kontak & Lokasi">Kontak & Lokasi</option>
                            <option value="Gawat Darurat">Gawat Darurat</option>
                            <option value="Pendaftaran & BPJS">Pendaftaran & BPJS</option>
                            <option value="Pendaftaran">Pendaftaran</option>
                            <option value="Dokter & Spesialis">Dokter & Spesialis</option>
                            <option value="Rawat Inap">Rawat Inap</option>
                            <option value="Fasilitas & Layanan">Fasilitas & Layanan</option>
                            <option value="Layanan Unggulan">Layanan Unggulan</option>
                            <option value="Penunjang Medis">Penunjang Medis</option>
                            <option value="Asuransi & Pembayaran">Asuransi & Pembayaran</option>
                            <option value="Bantuan & Customer Service">Bantuan & Customer Service</option>
                            <option value="Konsultasi Medis">Konsultasi Medis</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Intent Unik (Snake Case)</label>
                        <input type="text" name="intent" x-model="newKb.intent" placeholder="contoh: hospital_hours" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none focus:ring-2 focus:ring-[#0e7c47]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pertanyaan / Judul Topik</label>
                    <input type="text" name="question" x-model="newKb.question" placeholder="contoh: Jam Buka Rumah Sakit" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none focus:ring-2 focus:ring-[#0e7c47]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kata Kunci (Keywords dipisahkan koma)</label>
                    <input type="text" name="keywords" x-model="newKb.keywords" placeholder="jam buka, jam operasional, buka jam berapa, hari minggu buka" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none focus:ring-2 focus:ring-[#0e7c47]">
                    <span class="text-[10px] text-slate-400">Kata kunci utama yang dicocokkan oleh algoritma pencari.</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Sinonim / Variasi Kalimat (Opsional)</label>
                    <input type="text" name="synonyms" x-model="newKb.synonyms" placeholder="rs buka sampai malam, minggu ada dokter" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none focus:ring-2 focus:ring-[#0e7c47]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jawaban AI (Mendukung tag HTML & Emojis)</label>
                    <textarea name="answer" x-model="newKb.answer" rows="5" required placeholder="Tuliskan jawaban yang ramah, sopan, dan informatif..." class="w-full p-3 rounded-xl border border-slate-300 bg-white text-xs outline-none focus:ring-2 focus:ring-[#0e7c47] font-sans leading-relaxed"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Prioritas Skor (0 - 100)</label>
                        <input type="number" name="priority" x-model="newKb.priority" min="0" max="100" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none focus:ring-2 focus:ring-[#0e7c47]">
                    </div>

                    <div class="flex items-center gap-2 pt-6">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                            <input type="checkbox" name="is_active" value="1" x-model="newKb.is_active" class="w-4 h-4 rounded text-[#0e7c47] focus:ring-[#0e7c47]">
                            <span>Status Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-100 transition-colors cursor-pointer">Batal</button>
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2.5 rounded-xl font-bold text-xs hover:bg-[#096237] transition-colors cursor-pointer">Simpan Pengetahuan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT KNOWLEDGE BASE -->
    <div x-show="editModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
        <div @click.away="editModalOpen = false" class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl p-6 sm:p-8 space-y-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-lg font-black text-slate-900">Edit Pengetahuan (Tanya Fikri)</h3>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form :action="'/admin/knowledge-base/' + editKb.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kategori</label>
                        <select name="category" x-model="editKb.category" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none focus:ring-2 focus:ring-[#0e7c47]">
                            <option value="Umum">Umum</option>
                            <option value="Profil RS">Profil RS</option>
                            <option value="Kontak & Lokasi">Kontak & Lokasi</option>
                            <option value="Gawat Darurat">Gawat Darurat</option>
                            <option value="Pendaftaran & BPJS">Pendaftaran & BPJS</option>
                            <option value="Pendaftaran">Pendaftaran</option>
                            <option value="Dokter & Spesialis">Dokter & Spesialis</option>
                            <option value="Rawat Inap">Rawat Inap</option>
                            <option value="Fasilitas & Layanan">Fasilitas & Layanan</option>
                            <option value="Layanan Unggulan">Layanan Unggulan</option>
                            <option value="Penunjang Medis">Penunjang Medis</option>
                            <option value="Asuransi & Pembayaran">Asuransi & Pembayaran</option>
                            <option value="Bantuan & Customer Service">Bantuan & Customer Service</option>
                            <option value="Konsultasi Medis">Konsultasi Medis</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Intent Unik (Snake Case)</label>
                        <input type="text" name="intent" x-model="editKb.intent" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none focus:ring-2 focus:ring-[#0e7c47]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pertanyaan / Judul Topik</label>
                    <input type="text" name="question" x-model="editKb.question" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none focus:ring-2 focus:ring-[#0e7c47]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kata Kunci (Keywords dipisahkan koma)</label>
                    <input type="text" name="keywords" x-model="editKb.keywords" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none focus:ring-2 focus:ring-[#0e7c47]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Sinonim / Variasi Kalimat (Opsional)</label>
                    <input type="text" name="synonyms" x-model="editKb.synonyms" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none focus:ring-2 focus:ring-[#0e7c47]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jawaban AI (Mendukung tag HTML & Emojis)</label>
                    <textarea name="answer" x-model="editKb.answer" rows="5" required class="w-full p-3 rounded-xl border border-slate-300 bg-white text-xs outline-none focus:ring-2 focus:ring-[#0e7c47] font-sans leading-relaxed"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Prioritas Skor (0 - 100)</label>
                        <input type="number" name="priority" x-model="editKb.priority" min="0" max="100" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs outline-none focus:ring-2 focus:ring-[#0e7c47]">
                    </div>

                    <div class="flex items-center gap-2 pt-6">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                            <input type="checkbox" name="is_active" value="1" :checked="editKb.is_active == 1" class="w-4 h-4 rounded text-[#0e7c47] focus:ring-[#0e7c47]">
                            <span>Status Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-100 transition-colors cursor-pointer">Batal</button>
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2.5 rounded-xl font-bold text-xs hover:bg-[#096237] transition-colors cursor-pointer">Update Pengetahuan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
