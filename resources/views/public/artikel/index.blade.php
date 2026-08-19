@extends('layouts.app')

@section('title', __('Edukasi & Artikel Kesehatan') . ' - RSU Fikri Medika')

@section('content')
<!-- MAIN ARTICLES CONTAINER -->
<section class="py-8 sm:py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    
    <!-- CATEGORY PILLS FILTER & SEARCH ROW -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 mb-8 border-b border-gray-100">
        <!-- CATEGORY PILLS -->
        <div class="flex items-center gap-2 sm:gap-3 overflow-x-auto no-scrollbar py-1">
            <a href="{{ route('artikel.index') }}" 
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all shadow-sm {{ !request('kategori') ? 'bg-[#0e7c47] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Semua Topik
            </a>
            @php
                $categories = ['Edukasi Kesehatan', 'Kesehatan Anak', 'Kesehatan Wanita', "Men's Health", 'Tips Sehat', 'Penyakit Dalam'];
            @endphp
            @foreach($categories as $cat)
            <a href="{{ route('artikel.index', ['kategori' => $cat]) }}" 
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all shadow-sm {{ request('kategori') === $cat ? 'bg-[#0e7c47] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                {{ $cat }}
            </a>
            @endforeach
        </div>

        <!-- COMPACT SEARCH INPUT -->
        <div class="w-full md:w-64 shrink-0">
            <form action="{{ route('artikel.index') }}" method="GET" class="relative flex items-center">
                @if(request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <input type="text" 
                       name="q" 
                       value="{{ request('q') }}"
                       placeholder="Cari artikel kesehatan..." 
                       class="w-full pl-9 pr-8 py-2 rounded-full bg-gray-50 text-gray-800 placeholder-gray-400 text-xs border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#0e7c47] focus:bg-white transition-all">
                <i class="fa-solid fa-magnifying-glass absolute left-3 text-gray-400 text-xs"></i>
                @if(request('q'))
                <a href="{{ route('artikel.index', request()->only('kategori')) }}" class="absolute right-3 text-gray-400 hover:text-gray-600 text-xs">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                @endif
            </form>
        </div>
    </div>


    <!-- ARTICLES GRID -->
    @if($articles->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($articles as $art)
        @php
            $img = $art->thumbnail ? (Str::startsWith($art->thumbnail, ['http://', 'https://']) ? $art->thumbnail : asset($art->thumbnail)) : 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80';
        @endphp
        <a href="{{ route('artikel.show', $art->slug) }}" class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col justify-between">
            <div>
                <!-- THUMBNAIL -->
                <div class="relative aspect-[16/10] w-full overflow-hidden bg-gray-100">
                    <img src="{{ $img }}" alt="{{ $art->tr('title') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-[#0e7c47] text-[10px] font-extrabold uppercase px-3 py-1 rounded-full shadow-sm">
                        {{ $art->tr('category') ?: 'Edukasi' }}
                    </div>
                </div>

                <!-- CARD BODY -->
                <div class="p-6">
                    <div class="flex items-center gap-2 text-xs text-gray-400 mb-2">
                        <i class="fa-regular fa-calendar text-[#0e7c47]"></i>
                        <span>{{ $art->published_at ? $art->published_at->translatedFormat('d M Y') : $art->created_at->translatedFormat('d M Y') }}</span>
                    </div>

                    <h2 class="text-base sm:text-lg font-bold text-gray-900 group-hover:text-[#0e7c47] transition-colors leading-snug line-clamp-2 mb-2">
                        {{ $art->tr('title') }}
                    </h2>

                    <p class="text-xs sm:text-sm text-gray-500 line-clamp-3 leading-relaxed">
                        {{ $art->tr('excerpt') }}
                    </p>
                </div>
            </div>

            <!-- BOTTOM FOOTER -->
            <div class="px-6 pb-6 pt-0 flex items-center justify-between border-t border-gray-50 pt-4 text-xs font-bold text-[#0e7c47]">
                <span class="flex items-center gap-1.5">
                    <span>Baca Selengkapnya</span>
                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </span>
                <div class="w-7 h-7 rounded-full bg-emerald-50 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <!-- PAGINATION IF PAGINATED -->
    @if(method_exists($articles, 'links'))
    <div class="mt-12 flex justify-center">
        {{ $articles->links() }}
    </div>
    @endif

    @else
    <div class="text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm p-8 space-y-4">
        <div class="w-16 h-16 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto text-2xl">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800">Artikel Tidak Ditemukan</h3>
        <p class="text-xs text-gray-500 max-w-sm mx-auto">
            Maaf, tidak ada artikel yang cocok dengan pencarian atau kategori yang Anda pilih.
        </p>
        <a href="{{ route('artikel.index') }}" class="inline-block px-4 py-2 bg-[#0e7c47] text-white text-xs font-bold rounded-xl hover:bg-[#096237] transition-colors shadow">
            Reset Pencarian
        </a>
    </div>
    @endif

</section>
@endsection
