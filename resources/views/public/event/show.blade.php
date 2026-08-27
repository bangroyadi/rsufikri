@extends('layouts.app')

@section('title', $event->tr('title') . ' - RSU Fikri Medika')

@section('content')
@php
    $title      = $event->tr('title');
    $shortDesc  = $event->tr('short_description');
    $desc       = $event->tr('description');
    $speakers   = is_array($event->speakers) ? $event->speakers : [];
    $benefits   = is_array($event->benefits) ? $event->benefits : [];
    $gallery    = is_array($event->gallery_photos) ? $event->gallery_photos : [];
    $waText     = urlencode("Halo RSU Fikri Medika, saya ingin bertanya mengenai kegiatan: " . $title);
@endphp

<div class="bg-slate-50 min-h-screen" x-data="{ lightbox: false, activeImg: 0, imgs: {{ json_encode(array_map(fn($p) => str_starts_with($p, 'http') ? $p : asset('storage/' . ltrim(str_replace('storage/', '', $p), '/')), $gallery)) }} }">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-8">

        {{-- BREADCRUMB --}}
        <nav class="flex items-center gap-2 text-xs text-slate-400 font-medium">
            <a href="{{ route('home') }}" class="hover:text-[#0e7c47] transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <a href="{{ route('event.index') }}" class="hover:text-[#0e7c47] transition-colors">Galeri Kegiatan</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <span class="text-slate-600 font-semibold line-clamp-1">{{ $title }}</span>
        </nav>

        {{-- MAIN ARTICLE --}}
        <article class="bg-white rounded-3xl overflow-hidden shadow-xs border border-gray-100">

            {{-- HERO IMAGE --}}
            <div class="relative w-full aspect-video sm:aspect-[16/7] bg-slate-900 overflow-hidden">
                <img src="{{ $event->image_url }}" alt="{{ $title }}"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>

                {{-- STATUS BADGE --}}
                <div class="absolute top-4 left-4">
                    @if($event->status === 'completed')
                    <span class="px-3 py-1 rounded-full bg-slate-900/80 backdrop-blur-sm text-slate-200 font-bold text-xs">✅ Telah Dilaksanakan</span>
                    @elseif($event->status === 'ongoing')
                    <span class="px-3 py-1 rounded-full bg-amber-500/90 backdrop-blur-sm text-white font-bold text-xs">⏳ Sedang Berlangsung</span>
                    @else
                    <span class="px-3 py-1 rounded-full bg-emerald-600/90 backdrop-blur-sm text-white font-bold text-xs">📅 Akan Datang</span>
                    @endif
                </div>

                {{-- DATE BOTTOM --}}
                <div class="absolute bottom-4 left-5 text-white">
                    <div class="text-xs text-emerald-300 font-bold uppercase tracking-wider">{{ $event->category }}</div>
                    <div class="text-sm font-semibold mt-0.5 opacity-90">{{ $event->event_date_formatted }}</div>
                </div>
            </div>

            {{-- ARTICLE CONTENT --}}
            <div class="p-6 sm:p-10 space-y-6">

                {{-- TITLE --}}
                <div class="space-y-3">
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 leading-snug">
                        {{ $title }}
                    </h1>

                    {{-- META ROW --}}
                    <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-slate-500 font-semibold border-b border-gray-100 pb-4">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar text-slate-400"></i>
                            {{ $event->event_date_formatted }}
                        </span>
                        @if($event->start_time)
                        <span class="flex items-center gap-1.5">
                            <i class="fa-regular fa-clock text-slate-400"></i>
                            {{ $event->start_time }}{{ $event->end_time ? ' – ' . $event->end_time : '' }}
                        </span>
                        @endif
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-location-dot text-slate-400"></i>
                            {{ $event->location }}
                        </span>
                        @if($event->quota)
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-users text-slate-400"></i>
                            {{ $event->quota }} Peserta
                        </span>
                        @endif
                    </div>
                </div>

                {{-- LEAD / SHORT DESC --}}
                @if($shortDesc)
                <p class="text-base text-slate-700 leading-relaxed font-medium border-l-4 border-[#0e7c47] pl-4 italic">
                    {{ $shortDesc }}
                </p>
                @endif

                {{-- BODY DESCRIPTION --}}
                @if($desc)
                <div class="prose prose-sm sm:prose max-w-none text-slate-600 leading-relaxed">
                    {!! nl2br(e($desc)) !!}
                </div>
                @endif

                {{-- NARASUMBER --}}
                @if(!empty($speakers))
                <div class="pt-4 border-t border-gray-100 space-y-3">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-user-doctor text-[#0e7c47]"></i>
                        Narasumber / Dokter Pembicara
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($speakers as $sp)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0e7c47] flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-stethoscope text-sm"></i>
                            </div>
                            <div>
                                <div class="font-bold text-sm text-slate-900">{{ $sp['name'] ?? '' }}</div>
                                <div class="text-xs text-slate-500">{{ $sp['role'] ?? '' }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- HIGHLIGHT / BENEFITS --}}
                @if(!empty($benefits))
                <div class="pt-4 border-t border-gray-100 space-y-3">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-[#0e7c47]"></i>
                        Highlight Kegiatan
                    </h3>
                    <ul class="space-y-2">
                        @foreach($benefits as $ben)
                        <li class="flex items-start gap-2.5 text-sm text-slate-700">
                            <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 shrink-0"></i>
                            {{ $ben }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

            </div>
        </article>

        {{-- FOTO DOKUMENTASI GALERI --}}
        @if(!empty($gallery))
        <section class="bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-gray-100 space-y-5">
            <div class="flex items-center gap-2 border-b border-gray-100 pb-4">
                <i class="fa-solid fa-images text-[#0e7c47]"></i>
                <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Foto Dokumentasi</h2>
                <span class="ml-auto text-xs text-slate-400 font-semibold">{{ count($gallery) }} foto</span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                @foreach($gallery as $i => $photo)
                @php
                    $photoUrl = str_starts_with($photo, 'http') ? $photo : asset('storage/' . ltrim(str_replace('storage/', '', $photo), '/'));
                @endphp
                <div @click="activeImg = {{ $i }}; lightbox = true"
                     class="relative aspect-square rounded-xl overflow-hidden bg-slate-100 cursor-pointer group">
                    <img src="{{ $photoUrl }}" alt="Foto {{ $title }} {{ $i + 1 }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         loading="lazy">
                    <div class="absolute inset-0 bg-slate-950/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <div class="w-8 h-8 rounded-full bg-white/90 text-slate-800 flex items-center justify-center">
                            <i class="fa-solid fa-magnifying-glass-plus text-xs"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        {{-- KEGIATAN LAINNYA --}}
        @if($relatedEvents->count())
        <section class="space-y-4">
            <h2 class="text-base font-black text-slate-800 uppercase tracking-wide flex items-center gap-2">
                <i class="fa-solid fa-layer-group text-[#0e7c47]"></i>
                Kegiatan Lainnya
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($relatedEvents as $rel)
                <a href="{{ route('event.show', $rel->slug) }}"
                   class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-emerald-200 hover:shadow-md transition-all duration-300 flex flex-col group">
                    <div class="relative aspect-video bg-slate-100 overflow-hidden">
                        <img src="{{ $rel->image_url }}" alt="{{ $rel->tr('title') }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        <div class="absolute bottom-2 left-3 text-[10px] text-white font-bold flex items-center gap-1">
                            <i class="fa-regular fa-calendar text-emerald-300"></i>
                            {{ $rel->event_date_short['day'] }} {{ $rel->event_date_short['month'] }} {{ $rel->event_date_short['year'] }}
                        </div>
                    </div>
                    <div class="p-4 flex-1">
                        <span class="text-[10px] font-black uppercase tracking-wider text-[#0e7c47]">{{ $rel->category }}</span>
                        <h3 class="font-black text-slate-900 text-xs leading-snug mt-1 line-clamp-2 group-hover:text-[#0e7c47] transition-colors">
                            {{ $rel->tr('title') }}
                        </h3>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        {{-- BACK BUTTON --}}
        <div class="text-center pb-4">
            <a href="{{ route('event.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-slate-600 hover:border-[#0e7c47] hover:text-[#0e7c47] transition-all text-xs font-bold shadow-xs">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Kembali ke Galeri Kegiatan
            </a>
        </div>

    </div>

    {{-- LIGHTBOX --}}
    <div x-show="lightbox"
         x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="lightbox = false"
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/90 backdrop-blur-sm p-4"
         style="display:none">

        <button @click="lightbox = false"
                class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all cursor-pointer">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <button @click="activeImg = activeImg === 0 ? imgs.length - 1 : activeImg - 1"
                class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all cursor-pointer">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        <template x-for="(img, idx) in imgs" :key="idx">
            <img x-show="activeImg === idx" :src="img"
                 class="max-w-full max-h-[85vh] object-contain rounded-xl shadow-2xl"
                 alt="Foto dokumentasi">
        </template>

        <button @click="activeImg = activeImg === imgs.length - 1 ? 0 : activeImg + 1"
                class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all cursor-pointer">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

        <div class="absolute bottom-4 text-xs text-white/60 font-semibold">
            <span x-text="activeImg + 1"></span> / <span x-text="imgs.length"></span>
        </div>
    </div>

</div>
@endsection
