@extends('layouts.app')

@section('title', 'Agenda, Event & Kegiatan | RSU Fikri Medika Karawang')
@section('meta_description', 'Ikuti berbagai agenda kesehatan, seminar medis, donor darah, senam sehat, dan kegiatan sosial resmi RSU Fikri Medika Karawang.')

@section('schema_jsonld')
<script type="application/ld+json">
{!! json_encode(app(\App\Services\SeoService::class)->generateBreadcrumbSchema([
    'Beranda' => url('/'),
    'Event & Kegiatan' => url('/informasi/event')
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

@section('content')
<h1 class="sr-only">Agenda, Event & Kegiatan RSU Fikri Medika Karawang</h1>
<div x-data="{
    selectedCategory: 'all',
    search: '{{ addslashes($query ?? '') }}'
}" class="bg-slate-50 min-h-screen">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-8">






        {{-- FILTER & SEARCH --}}
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-xs border border-gray-100">
            <div class="flex flex-col md:flex-row items-center justify-between gap-3">

                <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-1 md:pb-0">
                    <button type="button"
                            @click="selectedCategory = 'all'"
                            :class="selectedCategory === 'all' ? 'bg-[#0e7c47] text-white' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-gray-200'"
                            class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all cursor-pointer whitespace-nowrap">
                        Semua ({{ $events->count() }})
                    </button>
                    @foreach($categories as $cat)
                    <button type="button"
                            @click="selectedCategory = '{{ addslashes($cat) }}'"
                            :class="selectedCategory === '{{ addslashes($cat) }}' ? 'bg-[#0e7c47] text-white' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-gray-200'"
                            class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all cursor-pointer whitespace-nowrap">
                        {{ $cat }}
                    </button>
                    @endforeach
                </div>

                <div class="relative w-full md:w-64 shrink-0">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text"
                           x-model="search"
                           placeholder="Cari kegiatan..."
                           class="w-full pl-9 pr-4 py-2 text-xs rounded-xl bg-slate-50 border border-gray-200 focus:outline-none focus:border-[#0e7c47] focus:bg-white transition-all">
                </div>

            </div>
        </div>

        {{-- EVENTS GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($events as $event)
            @php
                $eTitle     = $event->tr('title');
                $eShortDesc = $event->tr('short_description');
            @endphp
            <a href="{{ route('event.show', $event->slug) }}"
                 x-show="(selectedCategory === 'all' || selectedCategory === '{{ addslashes($event->category) }}') && (search === '' || '{{ addslashes(strtolower($eTitle . ' ' . $eShortDesc . ' ' . $event->location . ' ' . $event->category)) }}'.includes(search.toLowerCase()))"
                 class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-emerald-200 hover:shadow-md transition-all duration-300 flex flex-col group">

                {{-- FOTO --}}
                <div class="relative w-full aspect-video bg-slate-100 overflow-hidden">
                    <img src="{{ $event->image_url }}" alt="{{ $eTitle }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>

                    {{-- TANGGAL --}}
                    <div class="absolute bottom-3 left-3 flex items-center gap-1.5 text-[11px] text-white font-bold">
                        <i class="fa-regular fa-calendar text-emerald-300"></i>
                        {{ $event->event_date_formatted }}
                    </div>

                    {{-- STATUS --}}
                    <div class="absolute top-3 right-3">
                        @if($event->status === 'completed')
                        <span class="px-2 py-0.5 rounded-md bg-slate-900/80 backdrop-blur-sm text-slate-300 font-bold text-[10px]">✅ Selesai</span>
                        @elseif($event->status === 'ongoing')
                        <span class="px-2 py-0.5 rounded-md bg-amber-500/90 backdrop-blur-sm text-white font-bold text-[10px]">⏳ Berlangsung</span>
                        @else
                        <span class="px-2 py-0.5 rounded-md bg-emerald-600/90 backdrop-blur-sm text-white font-bold text-[10px]">📅 Akan Datang</span>
                        @endif
                    </div>
                </div>

                {{-- BODY --}}
                <div class="p-5 flex-1 flex flex-col gap-3">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-[#0e7c47]">{{ $event->category }}</span>
                        <h3 class="font-black text-slate-900 text-sm leading-snug mt-1 group-hover:text-[#0e7c47] transition-colors line-clamp-2">
                            {{ $eTitle }}
                        </h3>
                    </div>

                    @if($eShortDesc)
                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed flex-1">
                        {{ $eShortDesc }}
                    </p>
                    @endif

                    <div class="flex items-center gap-2 pt-3 border-t border-gray-100 text-[11px] text-slate-500">
                        <i class="fa-solid fa-location-dot text-slate-300 shrink-0"></i>
                        <span class="truncate">{{ $event->location }}</span>
                        @if($event->quota)
                        <span class="ml-auto shrink-0 font-semibold">{{ $event->quota }} peserta</span>
                        @endif
                    </div>
                </div>

            </a>
            @empty
            <div class="col-span-full bg-white p-12 rounded-2xl border border-gray-100 text-center space-y-2">
                <i class="fa-solid fa-photo-film text-4xl text-slate-200"></i>
                <h3 class="font-black text-slate-700 text-base">Belum Ada Dokumentasi</h3>
                <p class="text-xs text-slate-400">Dokumentasi kegiatan akan segera hadir.</p>
            </div>
            @endforelse
        </div>

        {{-- KERJASAMA CTA --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-gray-100 space-y-5">
            <div class="border-b border-gray-100 pb-5">
                <span class="text-xs font-extrabold text-[#0e7c47] uppercase tracking-wider">Kemitraan Kegiatan</span>
                <h2 class="text-lg sm:text-xl font-black text-slate-900 mt-1">Ingin Bekerjasama dengan Kami?</h2>
                <p class="text-xs text-slate-500 mt-0.5 max-w-xl">Health Talk, pelatihan P3K/BLS, atau skrining kesehatan di instansi Anda — hubungi tim Marketing RSU Fikri Medika.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                @foreach([
                    ['name' => 'Ibu Ulfah',  'phone' => '6281316720656',  'display' => '0813-1672-0656'],
                    ['name' => 'Ibu Ai',     'phone' => '6281384656298',  'display' => '0813-8465-6298'],
                    ['name' => 'Ibu Rina',   'phone' => '628988965646',   'display' => '0898-8965-646'],
                    ['name' => 'Ibu Itje',   'phone' => '6281382895002',  'display' => '0813-8289-5002'],
                ] as $contact)
                <a href="https://wa.me/{{ $contact['phone'] }}?text=Halo%20{{ urlencode($contact['name']) }}%20(Marketing%20RSU%20Fikri%20Medika),%20kami%20ingin%20mengajukan%20kerjasama%20kegiatan%20kesehatan"
                   target="_blank"
                   class="flex items-center gap-3 p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-gray-100 hover:border-emerald-200 transition-all group">
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center shrink-0">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 text-xs group-hover:text-[#0e7c47] transition-colors">{{ $contact['name'] }}</div>
                        <div class="text-[11px] text-slate-400 font-mono">{{ $contact['display'] }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
