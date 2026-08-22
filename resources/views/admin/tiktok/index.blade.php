@extends('layouts.admin')

@section('title', 'Manajemen Postingan TikTok')

@section('content')
<div x-data="{ 
    addModalOpen: false, 
    editModalOpen: false, 
    editPost: {
        id: '',
        title: '',
        views_count: '',
        tag: '',
        tiktok_url: '',
        thumbnail_url: '',
        video_url: '',
        order: 1,
        is_active: true
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
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900 text-white text-xs font-bold mb-1.5">
                <i class="fa-brands fa-tiktok text-[#25f4ee]"></i>
                <span>TikTok Official Feed</span>
            </div>
            <h2 class="text-xl font-black text-slate-900">Kelola Postingan TikTok</h2>
            <p class="text-xs text-slate-500 mt-0.5">Atur 6 video postingan TikTok yang muncul di halaman utama website.</p>
        </div>

        <button @click="addModalOpen = true" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2.5 rounded-xl font-extrabold text-xs shadow-md hover:bg-[#096237] hover:shadow-lg transition-all flex items-center justify-center gap-2 shrink-0 cursor-pointer">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>+ Tambah Postingan TikTok</span>
        </button>
    </div>

    <!-- TIKTOK POSTS TABLE -->
    <div style="background-color: #ffffff; border: 1px solid #e2e8f0;" class="rounded-3xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-slate-900 text-sm flex items-center gap-2">
                <i class="fa-brands fa-tiktok text-[#fe2c55]"></i>
                <span>Daftar Postingan TikTok ({{ $posts->count() }})</span>
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; color: #475569;" class="uppercase tracking-wider font-extrabold">
                    <tr>
                        <th class="p-4">Urutan</th>
                        <th class="p-4">Thumbnail</th>
                        <th class="p-4">Judul Postingan</th>
                        <th class="p-4">Views & Tagar</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                    @forelse($posts as $p)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 font-mono font-bold text-slate-400">
                            #{{ $p->order }}
                        </td>
                        <td class="p-4">
                            <div class="w-12 h-16 rounded-xl overflow-hidden border border-slate-200 bg-slate-900 shrink-0 relative shadow-xs">
                                <img src="{{ $p->thumbnail_url }}" alt="Thumbnail" class="w-full h-full object-cover">
                                <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                                    <i class="fa-solid fa-play text-[10px] text-white"></i>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 font-bold text-slate-900 text-sm max-w-sm">
                            <div class="line-clamp-2">{{ $p->title }}</div>
                            @if($p->tiktok_url)
                            <a href="{{ $p->tiktok_url }}" target="_blank" class="text-[11px] text-slate-400 hover:text-[#fe2c55] inline-flex items-center gap-1 mt-0.5">
                                <span>Lihat di TikTok</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                            </a>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-[#0e7c47] text-xs flex items-center gap-1">
                                <i class="fa-solid fa-play text-[9px]"></i>
                                <span>{{ $p->views_count }} views</span>
                            </div>
                            <div class="text-[11px] text-pink-500 font-medium mt-0.5">
                                {{ $p->tag }}
                            </div>
                        </td>
                        <td class="p-4">
                            @if($p->is_active)
                            <span style="background-color: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46;" class="px-2.5 py-1 rounded-full text-[10.5px] font-bold">
                                Aktif (Tampil)
                            </span>
                            @else
                            <span style="background-color: #f1f5f9; border: 1px solid #cbd5e1; color: #64748b;" class="px-2.5 py-1 rounded-full text-[10.5px] font-bold">
                                Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button @click="editPost = {
                                    id: {{ $p->id }},
                                    title: '{{ addslashes($p->title) }}',
                                    views_count: '{{ addslashes($p->views_count) }}',
                                    tag: '{{ addslashes($p->tag) }}',
                                    tiktok_url: '{{ addslashes($p->tiktok_url) }}',
                                    thumbnail_url: '{{ addslashes($p->thumbnail) }}',
                                    video_url: '{{ addslashes($p->video_url) }}',
                                    order: {{ $p->order }},
                                    is_active: {{ $p->is_active ? 'true' : 'false' }}
                                }; editModalOpen = true" 
                                style="background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a;" 
                                class="p-2 rounded-xl hover:bg-amber-100 transition-colors cursor-pointer" 
                                title="Edit Postingan">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                
                                <form action="{{ route('admin.tiktok.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus postingan TikTok ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca;" class="p-2 rounded-xl hover:bg-red-100 transition-colors cursor-pointer" title="Hapus Postingan">
                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400">
                            Belum ada postingan TikTok. Klik tombol <strong>+ Tambah Postingan TikTok</strong> di atas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL TAMBAH POSTINGAN TIKTOK -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="addModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-brands fa-tiktok text-[#fe2c55]"></i>
                    <span>Tambah Postingan TikTok Baru</span>
                </h3>
                <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.tiktok.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Judul / Topik Edukasi <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required placeholder="Contoh: Tips Mengatasi Asam Lambung Kambuh" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-[#0e7c47]">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tagar (Hashtag)</label>
                        <input type="text" name="tag" placeholder="#TipsSehat #RSUFikri" value="#RSUFikriMedika #TipsSehat" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Perkiraan Views</label>
                        <input type="text" name="views_count" placeholder="Contoh: 25.4K" value="12.5K" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Link Postingan di TikTok (Opsional)</label>
                    <input type="url" name="tiktok_url" placeholder="https://www.tiktok.com/@rsu.fikrimedika/video/..." value="https://www.tiktok.com/@rsu.fikrimedika" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-[#0e7c47]">
                </div>

                <div class="border-t border-slate-100 pt-3">
                    <label class="block font-bold text-slate-700 mb-1">Upload Gambar Sampul / Poster</label>
                    <input type="file" name="thumbnail_file" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-slate-500">
                    <p class="text-[11px] text-slate-400 mt-1">Atau gunakan URL Gambar:</p>
                    <input type="text" name="thumbnail_url" placeholder="https://... atau biarkan kosong untuk poster gedung default" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs mt-1">
                </div>

                <div class="border-t border-slate-100 pt-3">
                    <label class="block font-bold text-slate-700 mb-1">Upload File Video Singkat (MP4)</label>
                    <input type="file" name="video_file" accept="video/mp4,video/webm" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-slate-500">
                    <p class="text-[11px] text-slate-400 mt-1">Atau gunakan URL Video MP4:</p>
                    <input type="text" name="video_url" placeholder="https://assets.mixkit.co/... (opsional)" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs mt-1">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 border-t border-slate-100 pt-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nomor Urutan Tampil</label>
                        <input type="number" name="order" value="{{ $posts->count() + 1 }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                    <div class="flex items-center pt-5">
                        <label class="inline-flex items-center gap-2 cursor-pointer font-bold text-slate-700">
                            <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-[#0e7c47] rounded">
                            <span>Tampilkan di Homepage</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-200 font-bold text-slate-600 hover:bg-slate-50 cursor-pointer">Batal</button>
                    <button type="submit" style="background-color: #0e7c47; color: #ffffff;" class="px-5 py-2 rounded-xl font-bold hover:bg-[#096237] cursor-pointer">Simpan Postingan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT POSTINGAN TIKTOK -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div @click.away="editModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                    <span>Edit Postingan TikTok</span>
                </h3>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/tiktok') }}/' + editPost.id" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Judul / Topik Edukasi <span class="text-red-500">*</span></label>
                    <input type="text" name="title" x-model="editPost.title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-[#0e7c47]">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tagar (Hashtag)</label>
                        <input type="text" name="tag" x-model="editPost.tag" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Perkiraan Views</label>
                        <input type="text" name="views_count" x-model="editPost.views_count" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Link Postingan di TikTok</label>
                    <input type="url" name="tiktok_url" x-model="editPost.tiktok_url" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-[#0e7c47]">
                </div>

                <div class="border-t border-slate-100 pt-3">
                    <label class="block font-bold text-slate-700 mb-1">Ganti Gambar Sampul (Opsional)</label>
                    <input type="file" name="thumbnail_file" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-slate-500">
                    <p class="text-[11px] text-slate-400 mt-1">Atau URL Gambar:</p>
                    <input type="text" name="thumbnail_url" x-model="editPost.thumbnail_url" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs mt-1">
                </div>

                <div class="border-t border-slate-100 pt-3">
                    <label class="block font-bold text-slate-700 mb-1">Ganti File Video (Opsional MP4)</label>
                    <input type="file" name="video_file" accept="video/mp4,video/webm" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-slate-500">
                    <p class="text-[11px] text-slate-400 mt-1">Atau URL Video MP4:</p>
                    <input type="text" name="video_url" x-model="editPost.video_url" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs mt-1">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 border-t border-slate-100 pt-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nomor Urutan Tampil</label>
                        <input type="number" name="order" x-model="editPost.order" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-[#0e7c47]">
                    </div>
                    <div class="flex items-center pt-5">
                        <label class="inline-flex items-center gap-2 cursor-pointer font-bold text-slate-700">
                            <input type="checkbox" name="is_active" value="1" :checked="editPost.is_active" class="w-4 h-4 text-[#0e7c47] rounded">
                            <span>Tampilkan di Homepage</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-200 font-bold text-slate-600 hover:bg-slate-50 cursor-pointer">Batal</button>
                    <button type="submit" style="background-color: #d97706; color: #ffffff;" class="px-5 py-2 rounded-xl font-bold hover:bg-amber-700 cursor-pointer">Perbarui Postingan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
