@extends('layouts.app')

@section('title', $article->tr('title') . ' - RSU Fikri Medika')

@section('content')
<!-- MAIN ARTICLE SECTION -->
<article class="py-8 sm:py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
        
        <!-- LEFT: MAIN ARTICLE CONTENT (8 COLS) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- HEADER CONTAINER -->
            <div class="space-y-4">
                <!-- CATEGORY BADGE -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-[#0e7c47] border border-emerald-200/60 text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-heart-pulse text-xs"></i>
                    <span>{{ $article->tr('category') ?: __('Edukasi Kesehatan') }}</span>
                </div>

                <!-- MAIN TITLE (H1) -->
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 leading-[1.25] tracking-tight">
                    {{ $article->tr('title') }}
                </h1>

                <!-- SUBTITLE / EXCERPT IF AVAILABLE -->
                @if($article->tr('excerpt'))
                <p class="text-base sm:text-lg text-gray-600 font-normal leading-relaxed">
                    {{ $article->tr('excerpt') }}
                </p>
                @endif

                <!-- META INFO & SOCIAL SHARE ROW -->
                <div class="flex flex-wrap items-center justify-between gap-4 pt-3 pb-4 border-y border-gray-100 text-xs text-gray-500">
                    <!-- LEFT META: AUTHOR & DATE -->
                    <div class="flex items-center gap-4 flex-wrap">
                        <div class="flex items-center gap-2 font-medium text-gray-700">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-[#0e7c47] flex items-center justify-center font-bold text-xs shadow-inner">
                                <i class="fa-solid fa-hospital-user"></i>
                            </div>
                            <div>
                                <span class="block text-gray-900 font-bold text-xs leading-tight">{{ $article->author->name ?? 'Tim Medis RSU Fikri Medika' }}</span>
                                <span class="text-[11px] text-gray-500">Ditinjau secara Medis</span>
                            </div>
                        </div>

                        <span class="text-gray-300 hidden sm:inline">•</span>

                        <div class="flex items-center gap-1.5 text-gray-600">
                            <i class="fa-regular fa-calendar text-[#0e7c47]"></i>
                            <span>{{ $article->published_at ? $article->published_at->translatedFormat('d M Y') : $article->created_at->translatedFormat('d M Y') }}</span>
                        </div>

                        <span class="text-gray-300 hidden sm:inline">•</span>

                        <div class="flex items-center gap-1.5 text-gray-600">
                            <i class="fa-regular fa-clock text-[#0e7c47]"></i>
                            <span>± 4 Menit Baca</span>
                        </div>
                    </div>

                    <!-- RIGHT SOCIAL SHARE BUTTONS -->
                    @php
                        $articleUrl = url()->current();
                        $shareTitle = urlencode($article->tr('title') . ' - RSU Fikri Medika');
                        $shareUrl = urlencode($articleUrl);
                    @endphp
                    <div x-data="{ copied: false }" class="flex items-center gap-2 shrink-0">
                        <span class="font-bold text-gray-600 hidden sm:inline mr-1 text-[11px] uppercase tracking-wider">Bagikan:</span>
                        
                        <!-- WA SHARE -->
                        <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20{{ $shareUrl }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           title="Bagikan ke WhatsApp"
                           class="w-8 h-8 rounded-full bg-[#25D366]/10 text-[#25D366] hover:bg-[#25D366] hover:text-white flex items-center justify-center transition-all">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </a>

                        <!-- FB SHARE -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           title="Bagikan ke Facebook"
                           class="w-8 h-8 rounded-full bg-[#1877F2]/10 text-[#1877F2] hover:bg-[#1877F2] hover:text-white flex items-center justify-center transition-all">
                            <i class="fa-brands fa-facebook-f text-xs"></i>
                        </a>

                        <!-- TWITTER / X SHARE -->
                        <a href="https://twitter.com/intent/tweet?text={{ $shareTitle }}&url={{ $shareUrl }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           title="Bagikan ke X (Twitter)"
                           class="w-8 h-8 rounded-full bg-black/10 text-gray-900 hover:bg-black hover:text-white flex items-center justify-center transition-all">
                            <i class="fa-brands fa-x-twitter text-xs"></i>
                        </a>

                        <!-- COPY LINK BUTTON -->
                        <button @click="navigator.clipboard.writeText('{{ $articleUrl }}'); copied = true; setTimeout(() => copied = false, 2500);" 
                                type="button"
                                title="Salin Tautan"
                                class="relative px-2.5 py-1.5 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 flex items-center gap-1.5 transition-all text-xs font-semibold">
                            <i class="fa-solid fa-link text-[11px]"></i>
                            <span class="hidden sm:inline">Salin</span>
                            
                            <!-- POPUP TOAST -->
                            <div x-show="copied" 
                                 x-transition
                                 class="absolute -top-8 right-0 bg-gray-900 text-white text-[10px] font-bold px-2 py-1 rounded shadow whitespace-nowrap z-30" 
                                 style="display: none;">
                                Tautan Tersalin!
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <!-- FEATURED IMAGE (MATCHING LIRA MEDIKA BANNER RATIO & STYLE) -->
            @php
                $thumbnailUrl = $article->thumbnail ? (Str::startsWith($article->thumbnail, ['http://', 'https://']) ? $article->thumbnail : asset($article->thumbnail)) : 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1200&q=80';
            @endphp
            <div class="relative w-full rounded-2xl overflow-hidden shadow-sm border border-gray-100 bg-gray-100 group">
                <img src="{{ $thumbnailUrl }}" 
                     alt="{{ $article->tr('title') }}" 
                     class="w-full aspect-[16/9] object-cover object-center group-hover:scale-[1.01] transition-transform duration-500">
            </div>

            <!-- ARTICLE BODY CONTENT (RICH PROSE TYPOGRAPHY) -->
            <div class="article-content bg-white rounded-2xl p-4 sm:p-8 border border-gray-100 shadow-sm text-gray-800 leading-relaxed space-y-6">
                
                <style>
                    .article-content {
                        font-size: 1.05rem;
                        line-height: 1.8;
                    }
                    .article-content p {
                        margin-bottom: 1.25rem;
                        color: #374151;
                    }
                    .article-content p.lead {
                        font-size: 1.15rem;
                        font-weight: 500;
                        color: #1f2937;
                        line-height: 1.75;
                        border-left: 3px solid #0e7c47;
                        padding-left: 1rem;
                        margin-bottom: 1.5rem;
                    }
                    .article-content h2 {
                        font-size: 1.45rem;
                        font-weight: 800;
                        color: #0f172a;
                        margin-top: 2rem;
                        margin-bottom: 0.85rem;
                        letter-spacing: -0.015em;
                        border-bottom: 2px solid #f1f5f9;
                        padding-bottom: 0.5rem;
                    }
                    .article-content h3 {
                        font-size: 1.25rem;
                        font-weight: 700;
                        color: #1e293b;
                        margin-top: 1.5rem;
                        margin-bottom: 0.75rem;
                    }
                    .article-content ul, .article-content ol {
                        margin-left: 1.25rem;
                        margin-bottom: 1.5rem;
                        space-y: 0.5rem;
                    }
                    .article-content ul {
                        list-style-type: disc;
                    }
                    .article-content ol {
                        list-style-type: decimal;
                    }
                    .article-content li {
                        margin-bottom: 0.5rem;
                        padding-left: 0.25rem;
                    }
                    .article-content strong {
                        color: #111827;
                        font-weight: 700;
                    }
                    .article-content blockquote {
                        border-left: 4px solid #0e7c47;
                        padding: 0.75rem 1.25rem;
                        background: #f0fdf4;
                        border-radius: 0 12px 12px 0;
                        font-style: italic;
                        color: #166534;
                        margin: 1.5rem 0;
                    }
                </style>

                {!! $article->tr('content') !!}

                <!-- TAGS BADGES -->
                <div class="pt-6 mt-8 border-t border-gray-100 flex flex-wrap items-center gap-2 text-xs">
                    <span class="font-bold text-gray-500 mr-1"><i class="fa-solid fa-tags mr-1"></i> Topik:</span>
                    <a href="{{ route('artikel.index') }}" class="px-3 py-1 bg-gray-100 hover:bg-emerald-50 hover:text-[#0e7c47] rounded-lg text-gray-700 font-medium transition-colors">
                        #EdukasiKesehatan
                    </a>
                    <a href="{{ route('artikel.index') }}" class="px-3 py-1 bg-gray-100 hover:bg-emerald-50 hover:text-[#0e7c47] rounded-lg text-gray-700 font-medium transition-colors">
                        #RSUFikriMedika
                    </a>
                    <a href="{{ route('artikel.index') }}" class="px-3 py-1 bg-gray-100 hover:bg-emerald-50 hover:text-[#0e7c47] rounded-lg text-gray-700 font-medium transition-colors">
                        #TipsSehat
                    </a>
                    <a href="{{ route('artikel.index') }}" class="px-3 py-1 bg-gray-100 hover:bg-emerald-50 hover:text-[#0e7c47] rounded-lg text-gray-700 font-medium transition-colors">
                        #Karawang
                    </a>
                </div>
            </div>

            <!-- MEDICAL DISCLAIMER BOX -->
            <div class="p-5 rounded-2xl bg-amber-50/70 border border-amber-200/80 text-amber-900 flex items-start gap-4">
                <div class="w-9 h-9 rounded-xl bg-amber-200/80 text-amber-800 flex items-center justify-center shrink-0 text-base">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div class="text-xs leading-relaxed">
                    <h5 class="font-bold text-amber-950 text-sm mb-1">{{ __('Disclaimer Medis') }}</h5>
                    <p class="text-amber-800">
                        {{ __('Informasi yang terdapat dalam artikel ini disusun semata-mata untuk tujuan edukasi kesehatan umum dan tidak dimaksudkan sebagai pengganti diagnosis medis profesional, konsultasi dokter, atau rencana pengobatan medis. Bila Anda mengalami gejala atau keluhan kesehatan, segera periksakan diri ke dokter spesialis RSU Fikri Medika.') }}
                    </p>
                </div>
            </div>

            <!-- DOKTER REVIEWER & CONSULTATION PROMPT CARD -->
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50/60 rounded-2xl p-6 border border-emerald-100 flex flex-col sm:flex-row items-center justify-between gap-5">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-white shadow-sm border border-emerald-100 flex items-center justify-center text-[#0e7c47] text-2xl font-bold shrink-0">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div>
                        <span class="text-[11px] uppercase tracking-wider text-[#0e7c47] font-bold">Konsultasi Medis Langsung</span>
                        <h4 class="text-base sm:text-lg font-extrabold text-gray-900">Ingin Konsultasi dengan Dokter Spesialis?</h4>
                        <p class="text-xs text-gray-600 mt-0.5">Jadwalkan temu dokter kami dengan mudah secara online.</p>
                    </div>
                </div>
                <a href="{{ route('buat.janji') }}" class="px-5 py-2.5 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white font-bold text-xs sm:text-sm shadow-md shadow-emerald-700/20 transition-all flex items-center gap-2 shrink-0">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span>Buat Janji Temu</span>
                </a>
            </div>

        </div>

        <!-- RIGHT: SIDEBAR (4 COLS - STICKY) -->
        <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
            
            <!-- SIDEBAR CARD 1: DOKTER SPESIALIS TERKAIT -->
            @php
                // Get relevant specialist doctor if any
                $specialistDoctor = \App\Models\Doctor::where('is_active', true)->with('polyclinic')->first();
                if (!$specialistDoctor) {
                    $specialistDoctor = \App\Models\Doctor::first();
                }
            @endphp
            @if($specialistDoctor)
            <div class="bg-white rounded-2xl p-5 sm:p-6 border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h3 class="font-extrabold text-sm sm:text-base text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-stethoscope text-[#0e7c47]"></i>
                        <span>Dokter Terkait</span>
                    </h3>
                    <span class="text-[11px] font-bold text-[#0e7c47] bg-emerald-50 px-2 py-0.5 rounded-full">Spesialis</span>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-100 border-2 border-emerald-500/20 shrink-0">
                        @php
                            $docPhoto = $specialistDoctor->photo ? (Str::startsWith($specialistDoctor->photo, ['http://', 'https://']) ? $specialistDoctor->photo : asset($specialistDoctor->photo)) : 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=300&q=80';
                        @endphp
                        <img src="{{ $docPhoto }}" alt="{{ $specialistDoctor->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="min-w-0">
                        <h4 class="font-bold text-gray-900 text-sm leading-snug truncate">{{ $specialistDoctor->name }}</h4>
                        <p class="text-xs text-[#0e7c47] font-medium mt-0.5">{{ $specialistDoctor->tr('specialty') ?: ($specialistDoctor->polyclinic ? $specialistDoctor->polyclinic->tr('name') : 'Dokter Spesialis') }}</p>
                        <p class="text-[11px] text-gray-500 mt-1">RSU Fikri Medika Karawang</p>
                    </div>

                </div>

                <div class="grid grid-cols-2 gap-2 pt-2">
                    <a href="{{ route('jadwal.dokter') }}" class="px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold text-center transition-colors">
                        Lihat Jadwal
                    </a>
                    <a href="{{ route('buat.janji', ['dokter_id' => $specialistDoctor->id]) }}" class="px-3 py-2 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white text-xs font-bold text-center shadow-sm transition-colors">
                        Buat Janji
                    </a>
                </div>
            </div>
            @endif

            <!-- SIDEBAR CARD 2: ARTIKEL TERKAIT (MATCHING LIRA MEDIKA LIST) -->
            @php
                $relatedArticles = \App\Models\Article::where('is_published', true)
                    ->where('id', '!=', $article->id)
                    ->orderBy('published_at', 'desc')
                    ->take(4)
                    ->get();
            @endphp
            @if($relatedArticles->count() > 0)
            <div class="bg-white rounded-2xl p-5 sm:p-6 border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h3 class="font-extrabold text-sm sm:text-base text-gray-900 flex items-center gap-2">
                        <i class="fa-regular fa-newspaper text-[#0e7c47]"></i>
                        <span>Artikel Terkait</span>
                    </h3>
                    <a href="{{ route('artikel.index') }}" class="text-xs font-bold text-[#0e7c47] hover:underline">Lihat Semua</a>
                </div>

                <div class="space-y-4">
                    @foreach($relatedArticles as $rel)
                    @php
                        $relImg = $rel->thumbnail ? (Str::startsWith($rel->thumbnail, ['http://', 'https://']) ? $rel->thumbnail : asset($rel->thumbnail)) : 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=400&q=80';
                    @endphp
                    <a href="{{ route('artikel.show', $rel->slug) }}" class="group flex gap-3 items-start pb-3.5 border-b border-gray-50 last:border-0 last:pb-0">
                        <!-- THUMBNAIL -->
                        <div class="w-20 h-16 rounded-xl overflow-hidden bg-gray-100 shrink-0 border border-gray-100 relative">
                            <img src="{{ $relImg }}" alt="{{ $rel->tr('title') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                        <!-- TITLE & DATE -->
                        <div class="min-w-0 flex-1">
                            <span class="text-[10px] font-bold text-[#0e7c47] uppercase tracking-wider block mb-0.5">
                                {{ $rel->tr('category') ?: 'Edukasi' }}
                            </span>
                            <h4 class="text-xs font-bold text-gray-900 group-hover:text-[#0e7c47] transition-colors line-clamp-2 leading-snug">
                                {{ $rel->tr('title') }}
                            </h4>
                            <span class="text-[10px] text-gray-400 mt-1 block">
                                {{ $rel->published_at ? $rel->published_at->translatedFormat('d M Y') : $rel->created_at->translatedFormat('d M Y') }}
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- SIDEBAR CARD 3: EMERGENCY & APPOINTMENT FAST CTA -->
            <div class="bg-gradient-to-br from-emerald-800 to-[#0e7c47] rounded-2xl p-6 text-white shadow-lg space-y-4 relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                
                <div class="space-y-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-200">Layanan Siaga 24 Jam</span>
                    <h3 class="text-lg font-black text-white">Butuh Bantuan Medis Cepat?</h3>
                    <p class="text-xs text-emerald-100 leading-relaxed">
                        Tim medis IGD RSU Fikri Medika selalu siap melayani Anda 24 jam setiap hari.
                    </p>
                </div>

                <div class="pt-2 space-y-2">
                    <a href="tel:02678454999" class="w-full py-2.5 px-4 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs flex items-center justify-center gap-2 shadow transition-colors">
                        <i class="fa-solid fa-phone-volume animate-pulse"></i>
                        <span>Call Center IGD: (0267) 8454999</span>
                    </a>
                    <a href="https://wa.me/6281234567890" target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-extrabold text-xs flex items-center justify-center gap-2 shadow transition-colors">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                        <span>WhatsApp: 0812-3456-7890</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

    <!-- BOTTOM SECTION: ARTIKEL EDUKASI LAINNYA GRID -->
    @php
        $moreArticles = \App\Models\Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->inRandomOrder()
            ->take(3)
            ->get();
    @endphp
    @if($moreArticles->count() > 0)
    <div class="mt-16 pt-12 border-t border-gray-200 space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#0e7c47]">Edukasi & Informasi</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900">Artikel Kesehatan Pilihan Lainnya</h2>
            </div>
            <a href="{{ route('artikel.index') }}" class="hidden sm:inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-[#0e7c47] hover:text-[#096237]">
                <span>Lihat Seluruh Artikel</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($moreArticles as $more)
            @php
                $moreImg = $more->thumbnail ? (Str::startsWith($more->thumbnail, ['http://', 'https://']) ? $more->thumbnail : asset($more->thumbnail)) : 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=600&q=80';
            @endphp
            <a href="{{ route('artikel.show', $more->slug) }}" class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="relative aspect-[16/10] w-full overflow-hidden bg-gray-100">
                        <img src="{{ $moreImg }}" alt="{{ $more->tr('title') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-[#0e7c47] text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full shadow-sm">
                            {{ $more->tr('category') ?: 'Edukasi' }}
                        </div>
                    </div>
                    <div class="p-5">
                        <span class="text-[11px] text-gray-400 block mb-1.5">
                            <i class="fa-regular fa-calendar mr-1"></i>
                            {{ $more->published_at ? $more->published_at->translatedFormat('d M Y') : $more->created_at->translatedFormat('d M Y') }}
                        </span>
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 group-hover:text-[#0e7c47] transition-colors line-clamp-2 leading-snug">
                            {{ $more->tr('title') }}
                        </h3>
                        <p class="text-xs text-gray-500 line-clamp-2 mt-2 leading-relaxed">
                            {{ $more->tr('excerpt') }}
                        </p>
                    </div>
                </div>
                <div class="px-5 pb-5 pt-0 flex items-center justify-between text-xs font-bold text-[#0e7c47]">
                    <span>Baca Selengkapnya</span>
                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</article>
@endsection
